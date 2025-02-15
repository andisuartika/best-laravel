<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\User;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AllVillageController extends Controller
{
    public function index(Request $request)
    {

        $districts = District::all();

        $villages = User::role('admin')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('superadmin.villages.index', compact('villages', 'districts'));
    }

    public function create()
    {
        $villages = Village::all();
        return view('superadmin.villages.form-villages', compact('villages'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'village' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'address' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'village_id' => $request->village,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('admin');

        return redirect()->route('villages.index')->with('success', 'Desa Wisata Berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $villages = Village::all();
        $user = User::findOrFail($id);
        return view('superadmin.villages.form-villages', compact('user', 'villages'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required',
            'address' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;


        $user->save();

        return redirect()->route('villages.index')->with('success', 'Desa Wisata Berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('villages.index')->with('success', 'Desa Wisata Berhasil dihapus.');
    }
}
