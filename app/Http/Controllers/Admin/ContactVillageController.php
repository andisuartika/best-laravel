<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContactVillage;
use Illuminate\Support\Facades\Auth;

class ContactVillageController extends Controller
{
    public function index()
    {
        $village_id = Auth::user()->village_id;
        $contacts = ContactVillage::where('village_id', $village_id)->get();
        return view('admin.desa.contact', compact('contacts'));
    }

    public function store(Request $request)
    {
        $village_id = Auth::user()->village_id;

        ContactVillage::create([
            'village_id' => $village_id,
            'name' => $request->name,
            'contact' => $request->contact,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Kontak Berhasil ditambahkan!');
    }

    public function update(Request $request)
    {

        $contact = ContactVillage::find($request->id);
        $contact->update([
            'name' => $request->name,
            'contact' => $request->contact,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Kontak Berhasil diupdate!');
    }

    public function delete(Request $request)
    {
        $contact = ContactVillage::find($request->id);
        $contact->delete();
        return back()->with('success', 'Kontak Berhasil dihapus!');
    }
}
