<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Tour;
use App\Models\User;
use App\Models\Village;
use App\Models\Destination;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\TourDestination;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\TourRate;
use Illuminate\Support\Facades\Auth;

class TourController extends Controller
{
    public function index(Request $request)
    {
        $villages = Village::orderBy('name', 'asc')->get();
        $managers = User::where('village_id', Auth::user()->village_id)->role('pengelola')->get();
        $destinations = Destination::where('village_id', Auth::user()->village_id)->latest()->get();
        $tours = Tour::with('rates')->where('village_id', Auth::user()->village_id)
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

            $tours = Tour::with('rates')->where('manager', Auth::user()->id)
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
            $tours = Tour::with('rates')->when($request->search, function ($query, $search) {
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

        try {
            DB::beginTransaction();

            $village_id = Auth::user()->village_id;
            $rawDestinations = $request->destination;
            $included = json_encode($request->included);
            $destinations = json_encode($rawDestinations);
            $code = $this->getCode($request->manager);
            $path = $this->uploadImg($request, $code);

            $tour = Tour::create([
                'code' => $code,
                'slug' => Str::slug($request->name),
                'village_id' => $village_id,
                'manager' => $request->manager,
                'name' => $request->name,
                'description' => $request->description,
                'destination' => $destinations,
                'included' => $included,
                'status' => 'AVAILABLE',
                'thumbnail' => $path,
            ]);



            // Simpan destinasi tur
            foreach ($rawDestinations as $destination) {
                TourDestination::create([
                    'tour' => $tour->code,
                    'destination' => $destination,
                ]);
            }

            // Simpan rate tur
            foreach ($request->rates as $rate) {
                $cleanPrice = str_replace('.', '', $rate['price']);
                $code = $this->code($tour->code);
                TourRate::create([
                    'tour' => $tour->code,
                    'code' => $code,
                    'name' => $rate['name'],
                    'price' => $cleanPrice,
                    'valid_from' => $rate['valid_from'],
                    'valid_to' => $rate['valid_to'],
                ]);
            }

            DB::commit();

            return redirect()->route('tours.index')->with('success', 'Paket Tour Berhasil ditambahkan!');
        } catch (Exception $e) {
            DB::rollBack();

            // Debug
            // dd($e->getMessage());

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
        try {
            DB::beginTransaction();
            // Set up data
            $tour = Tour::findOrFail($id);
            $destinations = json_encode($request->destination);
            $included = json_encode($request->included);

            // Update Paket Tour
            $tour->update([
                'slug' => Str::slug($request->name),
                'name' => $request->name,
                'description' => $request->description,
                'destination' => $destinations,
                'included' => $included,
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

            // Hapus tour destinasi sebelumnya
            TourDestination::where('tour', $tour->code)->delete();

            // Insert or update tour destinasi
            foreach ($request->destination as $destination) {
                TourDestination::updateOrCreate(
                    ['tour' => $tour->code, 'destination' => $destination],
                    ['tour' => $tour->code, 'destination' => $destination]
                );
            }

            // Hapus semua rate lama
            TourRate::where('tour', $tour->code)->delete();

            // Loop untuk simpan Tour Rates
            foreach ($request->rates as $rate) {
                $cleanPrice = str_replace('.', '', $rate['price']);
                $code = $this->code($tour->code);
                TourRate::create([
                    'tour' => $tour->code,
                    'code' => $code,
                    'name' => $rate['name'],
                    'price' => $cleanPrice,
                    'valid_from' => $rate['valid_from'],
                    'valid_to' => $rate['valid_to'],
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
            // Hapus tour destinasi sebelumnya
            TourDestination::where('tour', $tour->code)->delete();
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
        $destination = Tour::where('manager', $manager)->latest()->first();
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

    private function code($tour)
    {

        // Membuat Code Manager Dengan Village ID
        $ticket = TourRate::where('tour', $tour)->latest()->first();
        $lastCode = $ticket ? $ticket->code : null;

        if ($lastCode) {
            // Mendapatkan angka setelah kode terakhir
            $lastIncrement = intval(substr($lastCode, -3));
            $nextIncrement = $lastIncrement + 1;
        } else {
            // Jika belum ada pengguna di desa ini
            $nextIncrement = 1;
        }
        // Format kode pengguna dengan padding 3 digit
        $code = sprintf("%s%03d", $tour, $nextIncrement);
        return $code;
    }

    private function uploadImg(Request $request, $code)
    {
        $village_id = Auth::user()->village_id;
        if ($request->hasFile('thumbnail')) {
            // Dapatkan file gambar
            $image = $request->file('thumbnail');

            // Buat nama file yang unik
            $originalName = $image->getClientOriginalName();

            // Gantikan spasi dengan tanda hubung
            $name = $code . '-' . preg_replace('/\s+/', '-', $originalName);

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
