<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Tour;
use App\Models\User;
use App\Models\Village;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TourController extends Controller
{
    public function index(Request $request)
    {
        $villages = Village::orderBy('name', 'asc')->get();
        $managers = User::where('village_id', Auth::user()->village_id)->role('pengelola')->get();
        $destinations = Destination::where('village_id', Auth::user()->village_id)->latest()->get();
        $tours = Tour::where('village_id', Auth::user()->village_id)
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

            $tours = Tour::where('manager', Auth::user()->id)
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
            $tours = Tour::when($request->search, function ($query, $search) {
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
        return view('admin.tours.index', compact('destinations', 'managers', 'tours', 'villages'));
    }

    public function create()
    {
        $managers = User::where('village_id', Auth::user()->village_id)->role('pengelola')->get();
        $destinations = Destination::where('village_id', Auth::user()->village_id)->latest()->get();

        if (Auth::user()->hasRole('pengelola')) {
            $destinations = Destination::where('manager', Auth::user()->id)->latest()->get();
        }

        return view('admin.tours.form-tour', compact('managers', 'destinations'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Set up data
            $village_id = Auth::user()->village_id;
            $destinations = json_encode($request->destination);
            $included = json_encode($request->included);
            $price = str_replace('.', '', $request->price);
            $code = $this->getCode($request->manager);
            $path = $this->uploadImg($request, $code);

            // Create Paket Tour
            Tour::create([
                'code' => $code,
                'village_id' => $village_id,
                'manager' => $request->manager,
                'name' => $request->name,
                'description' => $request->description,
                'destination' => $destinations,
                'included' => $included,
                'price' => $price,
                'status' => 'AVAILABLE',
                'thumbnail' => $path,
            ]);
            // Commit transaction
            DB::commit();

            return redirect()->route('tours.index')->with('success', 'Paket Tour Berhasil ditambahkan!');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function edit($id)
    {
        $tour = Tour::find($id);
        $managers = User::where('village_id', Auth::user()->village_id)->role('pengelola')->get();
        $destinations = Destination::where('village_id', Auth::user()->village_id)->latest()->get();

        return view('admin.tours.form-tour', compact('managers', 'destinations', 'tour'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            // Set up data
            $tour = Tour::findOrFail($id);
            $destinations = json_encode($request->destination);
            $included = json_encode($request->included);
            $price = str_replace('.', '', $request->price);


            // Update Paket Tour
            $tour->update([
                'name' => $request->name,
                'description' => $request->description,
                'destination' => $destinations,
                'included' => $included,
                'price' => $price,
                'status' => 'AVAILABLE',
            ]);

            // Update Thumbnail
            if ($request->hasFile('thumbnail')) {
                $this->deleteImg($tour->thumbnail);
                $path = $this->uploadImg($request, $tour->code);
                $tour->update([
                    'thumbnail' => $path,
                ]);
            }

            // Commit transaction
            DB::commit();

            return redirect()->route('tours.edit', $tour)->with('success', 'Paket Tour Berhasil diubah!');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        DB::beginTransaction();
        try {
            $tour = Tour::findOrFail($request->id);
            // Update Status
            $tour->update(['status' => $request->status]);

            // Commit transaction
            DB::commit();

            return redirect()->route('tours.index')->with('success', 'Status updated successfully.');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            // Hapus thubmnail dan tour
            $tour = Tour::findOrFail($id);
            $this->deleteImg($tour->thumbnail);
            $tour->delete();

            // Commit transaction
            DB::commit();

            return back()->with('success', 'Paket Tour Berhasil dihapus!');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function getCode($manager)
    {
        $village_id = Auth::user()->village_id;
        // Membuat Code Paket dengan manager code
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
        $format = 'PKG' .   $village_id . '-' . $manager . '-';
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
            $path = $image->storeAs('public/uploads/village/' . $village_id . '/tours', $name);
            $url = 'storage/uploads/village/' . $village_id . '/tours' . '/' . $name;
            return $url;
        }

        return null;
    }

    private function deleteImg($url)
    {
        unlink(public_path($url));
    }
}
