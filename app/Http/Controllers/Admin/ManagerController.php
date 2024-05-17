<?php

namespace App\Http\Controllers\Admin;

use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class ManagerController extends Controller
{
    public function index()
    {
        $managers = Manager::all();

        return view('admin.destination.manager', compact('managers'));
    }

    public function store(Request $request)
    {
        $village_id = Auth::user()->village_id;

        DB::beginTransaction();
        try {
            // Membuat Code Manager Dengan Village ID
            $latestManager = Manager::where('village_id', $village_id)->latest()->first();
            $lastCode = $latestManager ? $latestManager->code : null;

            if ($lastCode) {
                // Mendapatkan angka setelah kode terakhir
                $lastIncrement = intval(substr($lastCode, -3));
                $nextIncrement = $lastIncrement + 1;
            } else {
                // Jika belum ada pengguna di desa ini
                $nextIncrement = 1;
            }

            // Format kode pengguna dengan padding 3 digit
            $code = sprintf("%s%03d", $village_id, $nextIncrement);

            Manager::create([
                'village_id' => $village_id,
                'code' => $code,
                'name' => $request->name,
                'position' => $request->position,
                'phone' => $request->phone,
                'wa' => $request->wa,
                'email' => $request->email,
                'website' => $request->website,
            ]);

            DB::commit();
            return back()->with('success', 'Pengelola Berhasil ditambahkan!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th);
        }
    }

    public function update(Request $request)
    {
        $village_id = Auth::user()->village_id;
        $manager = Manager::find($request->id);
        DB::beginTransaction();
        try {
            $manager->update([
                'name' => $request->name,
                'position' => $request->position,
                'phone' => $request->phone,
                'wa' => $request->wa,
                'email' => $request->email,
                'website' => $request->website,
            ]);

            DB::commit();
            return back()->with('success', 'Pengelola Berhasil diupdate!');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', $th);
        }
    }

    public function delete(Request $request)
    {
        $manager = Manager::find($request->id);
        $manager->delete();
        return back()->with('success', 'Pengelola Berhasil dihapus!');
    }
}
