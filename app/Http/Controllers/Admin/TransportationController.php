<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Models\Manager;
use Illuminate\Http\Request;
use App\Models\Transportations;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\StoreTransportationRequest;
use App\Models\Village;

class TransportationController extends Controller
{
    public function index(Request $request)
    {
        $villages = Village::orderBy('name', 'asc')->get();
        $managers = User::where('village_id', Auth::user()->village_id)->role('pengelola')->get();
        $transportations = Transportations::where('village_id', Auth::user()->village_id)
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

            $transportations = Transportations::where('manager', Auth::user()->id)
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
            $transportations = Transportations::when($request->search, function ($query, $search) {
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
        return view('admin.accomodation.transportation.index', compact('transportations', 'managers', 'villages'));
    }

    public function create()
    {
        $managers = User::where('village_id', Auth::user()->village_id)->role('pengelola')->get();

        return view('admin.accomodation.transportation.form-transportation', compact('managers'));
    }

    public function store(StoreTransportationRequest $request)
    {
        DB::beginTransaction();

        try {
            // Set up data
            $village_id = Auth::user()->village_id;
            $code = $this->getCode($request->manager);
            $path = $this->uploadImg($request, $code);
            // Konversi Price
            $price = str_replace('.', '', $request->price);
            $extra_price = str_replace('.', '', $request->extra_price);

            // Create Transportations
            Transportations::create([
                'village_id' => $village_id,
                'manager' => $request->manager,
                'code' => $code,
                'name' => $request->name,
                'description' => $request->description,
                'price' => $price,
                'extra_price' => $extra_price,
                'image' => $path,
                'status' => 'AVAILABLE',
            ]);

            // Commit transaction
            DB::commit();

            return redirect()->route('transportations.index')->with('success', 'Transportasi berhasil ditambahkan!');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $transportation = Transportations::find($id);
        $managers = Manager::where('village_id', Auth::user()->village_id)->latest()->get();

        return view('admin.accomodation.transportation.form-transportation', compact('managers', 'transportation'));
    }

    public function update(StoreTransportationRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            // Set up data
            $transportation = Transportations::findOrFail($id);
            $code = $this->getCode($request->manager);
            $path = $this->uploadImg($request, $code);
            // Konversi Price
            $price = str_replace('.', '', $request->price);
            $extra_price = str_replace('.', '', $request->extra_price);

            // Update Transportations
            $transportation->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $price,
                'extra_price' => $extra_price,
            ]);

            if ($request->hasFile('image')) {
                $this->deleteImg($transportation->image);
                $path = $this->uploadImg($request, $transportation->code);
                $transportation->update([
                    'image' => $path,
                ]);
            }

            // Commit transaction
            DB::commit();

            return redirect()->route('transportations.edit', $transportation)->with('success', 'Transportasi berhasil diubah!');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();
            dd($e);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $transportation = Transportations::findOrFail($id);
            $this->deleteImg($transportation->image);
            $transportation->delete();

            // Commit transaction
            DB::commit();

            return back()->with('success', 'Transportasi Berhasil dihapus!');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    private function getCode($manager)
    {
        $village_id = Auth::user()->village_id;
        // Membuat Code Transportasi Dengan Manager code
        $transportation = Transportations::where('manager', $manager)->latest()->first();
        $lastCode = $transportation ? $transportation->code : null;

        if ($lastCode) {
            // Mendapatkan angka setelah kode terakhir
            $lastIncrement = intval(substr($lastCode, -3));
            $nextIncrement = $lastIncrement + 1;
        } else {
            // Jika belum ada pengguna di desa ini
            $nextIncrement = 1;
        }

        // Format kode pengguna dengan padding 3 digit
        // 03 untuk transportasi
        $format = 'TR' .   $village_id . '-' . $manager . '-';
        $code = sprintf("%s%03d", $format, $nextIncrement);
        return $code;
    }

    private function uploadImg(Request $request, $code)
    {
        $village_id = Auth::user()->village_id;
        if ($request->hasFile('image')) {
            // Dapatkan file gambar
            $image = $request->file('image');
            // Buat nama file yang unik
            $name = $code . '-' . $image->getClientOriginalName();
            // Tentukan path penyimpanan
            $path = $image->storeAs('public/uploads/village/' . $village_id . '/transportations', $name);
            $url = 'storage/uploads/village/' . $village_id . '/transportations' . '/' . $name;
            return $url;
        }

        return null;
    }

    private function deleteImg($url)
    {
        unlink(public_path($url));
    }
}
