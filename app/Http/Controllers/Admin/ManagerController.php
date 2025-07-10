<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;

class ManagerController extends Controller
{
    public function index()
    {

        $managers = User::where('village_id', Auth::user()->village_id)->role('pengelola')->get();

        return view('admin.manager', compact('managers'));
    }

    public function store(Request $request)
    {
        $village_id = Auth::user()->village_id;
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'address' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        DB::beginTransaction();
        try {


            $user =  User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'village_id' => $village_id,
                'address' => $request->address,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole('pengelola');

            //create wallet
            Wallet::firstOrCreate(['user_id' => $user->id], [
                'balance' => 0,
            ]);

            DB::commit();
            return back()->with('success', 'Pengelola Berhasil ditambahkan!');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            return back()->with('error', $th);
        }
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);
        DB::beginTransaction();
        try {

            //update user
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'password' => Hash::make($request->password),
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
        $manager = User::find($request->id);
        $manager->delete();
        return back()->with('success', 'Pengelola Berhasil dihapus!');
    }
}
