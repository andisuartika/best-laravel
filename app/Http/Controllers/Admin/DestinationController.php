<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Models\Manager;
use App\Models\Village;
use App\Models\Category;
use App\Models\Facility;
use App\Models\Destination;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DestinationImage;
use Illuminate\Support\Facades\DB;
use App\Models\CategoryDestination;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\StoreDestinationRequest;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        $villages = Village::orderBy('name', 'asc')->get();
        $managers = User::where('village_id', Auth::user()->village_id)->role('pengelola')->get();
        $destinations = Destination::where('village_id', Auth::user()->village_id)
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->when($request->manager, function ($query, $manager) {
                $query->whereHas('user', function ($query) use ($manager) {
                    $query->where('manager', $manager);
                });
            })
            ->latest()
            ->paginate(10);

        if (Auth::user()->hasRole('pengelola')) {

            $destinations = Destination::where('manager', Auth::user()->id)
                ->when($request->search, function ($query, $search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->when($request->manager, function ($query, $manager) {
                    $query->whereHas('user', function ($query) use ($manager) {
                        $query->where('manager', $manager);
                    });
                })
                ->latest()
                ->paginate(10);
        }

        if (Auth::user()->hasRole('super admin')) {
            $villages = Village::orderBy('name', 'asc')->get();
            $destinations = Destination::when($request->search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
                ->when($request->village, function ($query, $village) {
                    $query->whereHas('user', function ($query) use ($village) {
                        $query->where('village_id', $village);
                    });
                })
                ->latest()
                ->paginate(10);
        }

        return view('admin.destination.wisata.index', compact('destinations', 'managers', 'villages'));
    }

    public function create()
    {
        $managers = User::where('village_id', Auth::user()->village_id)->role('pengelola')->get();
        $categories = SubCategory::all();
        $facilities = Facility::all();

        return view('admin.destination.wisata.form-wisata', compact('managers', 'categories', 'facilities'));
    }

    public function store(StoreDestinationRequest $request)
    {
        DB::beginTransaction();

        try {

            // Set up data
            $village_id = Auth::user()->village_id;
            $code = $this->getCode($request->manager);
            $path = $this->uploadImg($request, $code);
            $categories = json_encode($request->categories);
            $facilities = json_encode($request->facilities);

            // Create Destination
            $destination = Destination::create([
                'village_id' => $village_id,
                'code' => $code,
                'slug' => Str::slug($request->name),
                'name' => $request->name,
                'description' => $request->description,
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'manager' => $request->manager,
                'category' => $categories,
                'facilities' => $facilities,
                'thumbnail' => $path,
                'status' => 'OPEN'
            ]);


            // category_destination
            foreach ($request->categories as $category) {
                CategoryDestination::create([
                    'destination' => $destination->code,
                    'category' => $category,
                ]);
            }

            // Commit transaction
            DB::commit();

            return redirect()->route('destination.index')->with('success', 'Destinasi berhasil ditambah!');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit(Destination $destination)
    {
        $managers = User::where('village_id', Auth::user()->village_id)->role('pengelola')->get();
        $categories = SubCategory::all();
        $facilities = Facility::all();
        $destination = Destination::with('categories')->findOrFail($destination->id);


        return view('admin.destination.wisata.edit-wisata', compact('destination', 'managers', 'categories', 'facilities'));
    }

    public function update(Destination $destination, StoreDestinationRequest $request)
    {
        DB::beginTransaction();

        try {
            // Set up data
            $categories = json_encode($request->categories);
            $facilities = json_encode($request->facilities);

            // Update Destination
            $destination->update([
                'slug' => Str::slug($request->name),
                'name' => $request->name,
                'description' => $request->description,
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'manager' => $request->manager,
                'category' => $categories,
                'facilities' => $facilities,
            ]);

            if ($request->hasFile('thumbnail')) {
                $this->deleteImg($destination->thumbnail);
                $path = $this->uploadImg($request, $destination->code);
                $destination->update([
                    'thumbnail' => $path,
                ]);
            }

            // Hapus kategori destinasi sebelumnya
            CategoryDestination::where('destination', $destination->code)->delete();

            // Insert or update kategori destinasi
            foreach ($request->categories as $category) {
                CategoryDestination::updateOrCreate(
                    ['destination' => $destination->code, 'category' => $category],
                    ['destination' => $destination->code, 'category' => $category]
                );
            }

            // Commit transaction
            DB::commit();

            return redirect()->route('destination.edit', $destination)->with('success', 'Destinasi berhasil diubah!');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateStatus(Destination $destination, Request $request)
    {
        DB::beginTransaction();
        try {
            // Update Status
            $destination->update(['status' => $request->status]);

            // Commit transaction
            DB::commit();

            return redirect()->route('destination.index')->with('success', 'Status destinasi berhasil diubah!');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Destination $destination)
    {
        DB::beginTransaction();
        try {
            // Hapus destinasi gallery
            $images = DestinationImage::where('destination', $destination->code)->get();
            foreach ($images as $image) {
                $this->deleteImg($image->url);
                // Delete Image
                $image->delete();
            }
            // Hapus thubmnail dan destinasi
            $this->deleteImg($destination->thumbnail);
            $destination->delete();

            // Commit transaction
            DB::commit();

            return back()->with('success', 'Destinasi Berhasil dihapus!');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    private function getCode($manager)
    {
        $village_id = Auth::user()->village_id;
        // Membuat Code Manager Dengan Village ID
        $destination = Destination::where('manager', $manager)->latest()->first();
        $lastCode = $destination ? $destination->code : null;

        if ($lastCode) {
            // Mendapatkan angka setelah kode terakhir
            $lastIncrement = intval(substr($lastCode, -3));
            $nextIncrement = $lastIncrement + 1;
        } else {
            // Jika belum ada pengguna di desa ini
            $nextIncrement = 1;
        }

        // Format kode pengguna dengan padding 3 digit
        // 01 untuk destination
        $format = 'DST' .   $village_id . '-' . $manager . '-';
        $code = sprintf("%s%03d", $format, $nextIncrement);
        return $code;
    }

    private function uploadImg(Request $request, $code)
    {
        $village_id = Auth::user()->village_id;
        if ($request->hasFile('thumbnail')) {
            // Dapatkan file gambar
            $image = $request->file('thumbnail');
            // Buat nama file yang unik
            $name = $code . '-' . $image->getClientOriginalName();
            // Tentukan path penyimpanan
            $path = $image->storeAs('public/uploads/village/' . $village_id . '/destinations', $name);
            $url = 'storage/uploads/village/' . $village_id . '/destinations' . '/' . $name;
            return $url;
        }

        return null;
    }

    private function deleteImg($url)
    {
        unlink(public_path($url));
    }
}
