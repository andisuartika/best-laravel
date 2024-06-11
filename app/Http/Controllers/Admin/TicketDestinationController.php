<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Carbon\Carbon;
use App\Models\Destination;
use Illuminate\Http\Request;
use App\Models\TicketDestination;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Attributes\Ticket;

class TicketDestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $village_id = Auth::user()->village_id;


        $destinations = Destination::Where('village_id', $village_id)->latest()->get();
        $tickets = TicketDestination::where('village_id', $village_id)
            ->when($request->search, function ($query, $search) {
                $query->where('type', 'like', '%' . $search . '%');
            })
            ->when($request->destination, function ($query, $destination) {
                $query->whereHas('destination', function ($query) use ($destination) {
                    $query->where('destination', $destination);
                });
            })
            ->latest()
            ->paginate(10);

        if ($request->destination) {
            $tickets = TicketDestination::Where('destination', $request->destination)->latest()->get();
        }


        return view('admin.destination.ticket.index', compact('tickets', 'destinations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $village_id = Auth::user()->village_id;

        $destinations = Destination::Where('village_id', $village_id)->latest()->get();

        return view('admin.destination.ticket.form-ticket', compact('destinations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $village_id = Auth::user()->village_id;
        $valid_from = null;
        $valid_to = null;

        DB::beginTransaction();
        try {
            $request->validate([
                'destination' => 'required',
                'description' => 'required',
                'type' => 'required',
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
            $code =  $this->code($request->destination);

            // Create Tiket
            TicketDestination::create([
                'village_id' => $village_id,
                'destination' => $request->destination,
                'code' => $code,
                'type' => $request->type,
                'description' => $request->description,
                'valid_from' => $valid_from,
                'valid_to' => $valid_to,
                'price' => $price,
            ]);

            // Commit transaction
            DB::commit();

            return redirect()->route('ticket.index')->with('success', 'Ticket created successfully.');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
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
        $village_id = Auth::user()->village_id;
        $ticket = TicketDestination::findOrFail($id);

        $destinations = Destination::Where('village_id', $village_id)->latest()->get();
        return view('admin.destination.ticket.form-ticket', compact('ticket', 'destinations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $valid_from = null;
        $valid_to = null;

        DB::beginTransaction();
        try {
            $request->validate([
                'destination' => 'required',
                'description' => 'required',
                'type' => 'required',
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
            $ticket = TicketDestination::findOrFail($id);
            $ticket->update([
                'destination' => $request->destination,
                'type' => $request->type,
                'description' => $request->description,
                'valid_from' => $valid_from,
                'valid_to' => $valid_to,
                'price' => $price,
            ]);

            // Commit transaction
            DB::commit();

            return redirect()->route('ticket.index')->with('success', 'Ticket updated successfully.');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();
            dd($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {

            $ticket = TicketDestination::findOrFail($id);

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
        $ticket = TicketDestination::where('destination', $destination)->latest()->first();
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
