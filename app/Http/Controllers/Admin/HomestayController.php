<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Manager;
use App\Models\Facility;
use App\Models\Homestay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\StoreHomestayRequest;

class HomestayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $managers = Manager::where('village_id', Auth::user()->village_id)->get();
        $homestays = Homestay::where('village_id', Auth::user()->village_id)
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->when($request->manager, function ($query, $manager) {
                $query->whereHas('manager', function ($query) use ($manager) {
                    $query->where('manager', $manager);
                });
            })
            ->latest()
            ->paginate(10);

        return view('admin.accomodation.homestay.index', compact('homestays', 'managers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $managers = Manager::where('village_id', Auth::user()->village_id)->get();
        $facilities = Facility::all();

        return view('admin.accomodation.homestay.form-homestay', compact('managers', 'facilities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHomestayRequest $request)
    {
        DB::beginTransaction();

        try {
            // Set up data
            $village_id = Auth::user()->village_id;
            $code = $this->getCode($request->manager);
            $path = $this->uploadImg($request, $code);
            $facilities = json_encode($request->facilities);

            // Create Homestay
            Homestay::create([
                'village_id' => $village_id,
                'code' => $code,
                'name' => $request->name,
                'description' => $request->description,
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'manager' => $request->manager,
                'facilities' => $facilities,
                'thumbnail' => $path,
                'status' => 'OPEN'
            ]);

            // Commit transaction
            DB::commit();

            return redirect()->route('homestay.index')->with('success', 'Homestay created successfully.');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $homestay = Homestay::findOrFail($id);
        $managers = Manager::where('village_id', Auth::user()->village_id)->get();
        $facilities = Facility::all();

        return view('admin.accomodation.homestay.edit-homestay', compact('homestay', 'managers', 'facilities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreHomestayRequest $request, string $id)
    {
        DB::beginTransaction();

        try {
            // Set up data
            $homestay = Homestay::findOrFail($id);
            $facilities = json_encode($request->facilities);

            // Update Homestay
            $homestay->update([
                'name' => $request->name,
                'description' => $request->description,
                'address' => $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'manager' => $request->manager,
                'facilities' => $facilities,
            ]);

            if ($request->hasFile('thumbnail')) {
                $this->deleteImg($homestay->thumbnail);
                $path = $this->uploadImg($request, $homestay->code);
                $homestay->update([
                    'thumbnail' => $path,
                ]);
            }

            // Commit transaction
            DB::commit();

            return redirect()->route('homestays.edit', $homestay)->with('success', 'Homestay updated successfully.');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function updateStatus(Homestay $homestay, Request $request)
    {
        DB::beginTransaction();
        try {
            // Update Status
            $homestay->update(['status' => $request->status]);

            // Commit transaction
            DB::commit();

            return redirect()->route('homestay.index')->with('success', 'Homestay status updated!.');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $homestay = Homestay::findOrFail($id);

            // Hapus thubmnail dan destinasi
            $this->deleteImg($homestay->thumbnail);
            $homestay->delete();

            // Commit transaction
            DB::commit();

            return back()->with('success', 'Penginapan Berhasil dihapus!');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function getCode($manager)
    {
        $village_id = Auth::user()->village_id;
        // Membuat Code Homestay Dengan Manager Code
        $homestay = Homestay::where('manager', $manager)->latest()->first();
        $lastCode = $homestay ? $homestay->code : null;

        if ($lastCode) {
            // Mendapatkan angka setelah kode terakhir
            $lastIncrement = intval(substr($lastCode, -3));
            $nextIncrement = $lastIncrement + 1;
        } else {
            // Jika belum ada pengguna di desa ini
            $nextIncrement = 1;
        }

        // Format kode pengguna dengan padding 3 digit
        // 01 untuk homestay
        $format = $manager . '-02-';
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
            $path = $image->storeAs('public/uploads/village/' . $village_id . '/homestays', $name);
            $url = 'storage/uploads/village/' . $village_id . '/homestays' . '/' . $name;
            return $url;
        }

        return null;
    }

    private function deleteImg($url)
    {
        unlink(public_path($url));
    }
}
