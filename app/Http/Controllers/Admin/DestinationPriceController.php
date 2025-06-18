<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Carbon\Carbon;
use App\Models\Destination;
use Illuminate\Http\Request;
use App\Models\DestinationPrice;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DestinationPriceController extends Controller
{
    public function index(Request $request)
    {

        $village_id = Auth::user()->village_id;


        $destinations = Destination::Where('village_id', $village_id)->latest()->get();
        $tickets = DestinationPrice::where('village_id', $village_id)
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->when($request->destination, function ($query, $destination) {
                $query->whereHas('destination', function ($query) use ($destination) {
                    $query->where('destination_id', $destination);
                });
            })
            ->latest()
            ->paginate(10);

        if ($request->destination) {
            $tickets = DestinationPrice::Where('destination_id', $request->destination)->latest()->get();
        }

        if (Auth::user()->hasRole('pengelola')) {

            $tickets = DestinationPrice::where('manager', Auth::user()->id)
                ->when($request->search, function ($query, $search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->when($request->destination, function ($query, $destination) {
                    $query->whereHas('destination', function ($query) use ($destination) {
                        $query->where('destination_id', $destination);
                    });
                })
                ->latest()
                ->paginate(10);
        }



        return view('admin.destination.ticket.index', compact('tickets', 'destinations'));
    }

    public function create()
    {
        $village_id = Auth::user()->village_id;

        $destinations = Destination::Where('village_id', $village_id)->latest()->get();

        if (Auth::user()->hasRole('pengelola')) {
            $destinations = Destination::Where('manager', Auth::user()->id)->latest()->get();
        }


        return view('admin.destination.ticket.form-ticket', compact('destinations'));
    }

    public function store(Request $request)
    {
        $village_id = Auth::user()->village_id;
        $valid_from = null;
        $valid_to = null;

        DB::beginTransaction();
        try {
            $request->validate([
                'destination_id' => 'required',
                'description' => 'required',
                'name' => 'required',
                'price' => 'required',
            ]);

            // Konversi Price
            $price = str_replace('.', '', $request->price);

            // Date Range
            if ($request->range != 'Rentan Waktu Tiket') {
                list($valid_from, $valid_to) = explode(" to ", $request->range);
                $valid_from = Carbon::parse($valid_from);
                $valid_to = Carbon::parse($valid_to);
            }
            $code =  $this->code($request->destination_id);

            // Create Tiket
            DestinationPrice::create([
                'village_id' => $village_id,
                'destination_id' => $request->destination_id,
                'manager' => Auth::user()->id,
                'code' => $code,
                'name' => $request->name,
                'description' => $request->description,
                'valid_from' => $valid_from,
                'valid_to' => $valid_to,
                'price' => $price,
            ]);

            // Commit transaction
            DB::commit();

            return redirect()->route('ticket.index')->with('success', 'Tiket berhasil ditambahkan');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();
            dd($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $village_id = Auth::user()->village_id;
        $ticket = DestinationPrice::findOrFail($id);

        $destinations = Destination::Where('village_id', $village_id)->latest()->get();
        return view('admin.destination.ticket.form-ticket', compact('ticket', 'destinations'));
    }

    public function update(Request $request, string $id)
    {
        $valid_from = null;
        $valid_to = null;


        DB::beginTransaction();
        try {
            $request->validate([
                'description' => 'required',
                'name' => 'required',
                'price' => 'required',
            ]);

            // Konversi Price
            $price = str_replace('.', '', $request->price);

            // Date Range
            if ($request->range != '-') {
                list($valid_from, $valid_to) = explode(" to ", $request->range);
                $valid_from = Carbon::parse($valid_from);
                $valid_to = Carbon::parse($valid_to);
            }

            // Update Tiket
            $ticket = DestinationPrice::findOrFail($id);
            $ticket->update([
                'name' => $request->name,
                'description' => $request->description,
                'valid_from' => $valid_from,
                'valid_to' => $valid_to,
                'price' => $price,
            ]);

            // Commit transaction
            DB::commit();

            return redirect()->route('ticket.index')->with('success', 'Tiket berhasil diubah!');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();
            dd($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {

            $ticket = DestinationPrice::findOrFail($id);

            $ticket->delete();

            // Commit transaction
            DB::commit();

            return back()->with('success', 'Tiket Berhasil dihapus!');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function code($destination)
    {
        $village_id = Auth::user()->village_id;
        // Membuat Code Manager Dengan Village ID
        $ticket = DestinationPrice::where('destination_id', $destination)->latest()->first();
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
        $code = sprintf("%s%03d", $destination, $nextIncrement);
        return $code;
    }
}
