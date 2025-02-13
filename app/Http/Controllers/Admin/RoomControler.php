<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Room;
use App\Models\Homestay;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoomControler extends Controller
{
    public function index(Request $request)
    {
        $homestays = Homestay::where('village_id', Auth::user()->village_id)->get();

        $allRoom = Room::whereHas('homestay', function ($query) {
            $query->where('village_id', Auth::user()->village_id);
        })
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->when($request->homestay, function ($query, $homestay) {
                $query->whereHas('homestay', function ($query) use ($homestay) {
                    $query->where('homestay', $homestay);
                });
            })
            ->paginate(10);

        //If Pengelola
        if (Auth::user()->hasRole('pengelola')) {
            $homestays = Homestay::where('manager', Auth::user()->id)->get();

            $allRoom = Room::whereHas('homestay', function ($query) {
                $query->where('manager', Auth::user()->id);
            })
                ->when($request->search, function ($query, $search) {
                    $query->where('name', 'like', '%' . $search . '%');
                })
                ->when($request->homestay, function ($query, $homestay) {
                    $query->whereHas('homestay', function ($query) use ($homestay) {
                        $query->where('homestay', $homestay);
                    });
                })
                ->paginate(10);
        }

        return view('admin.accomodation.room.room-index', compact('allRoom', 'homestays'));
    }

    public function create()
    {
        $homestays = Homestay::where('village_id', Auth::user()->village_id)->get();
        if (Auth::user()->hasRole('pengelola')) {
            $homestays = Homestay::where('manager', Auth::user()->id)->get();
        }
        return view('admin.accomodation.room.form-room', compact('homestays'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'homestay' => 'required',
                'roomtype' => 'required',
                'room_number' => 'required',
            ]);

            // Get Manager id in homestay
            $homestay = Homestay::where('code', $request->homestay)->first();

            // Create Room
            Room::create([
                'manager' => $homestay->manager,
                'homestay' => $request->homestay,
                'room_type' => $request->roomtype,
                'room_number' => $request->room_number,
                'status' => 'AVAILABLE',
            ]);

            // Commit transaction
            DB::commit();

            return redirect()->route('room.index')->with('success', 'Room created successfully.');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $room = Room::findOrFail($id);
            $request->validate([
                'room_number' => 'required',
            ]);

            // Upate Room
            $room->update([
                'room_number' => $request->room_number,
            ]);

            // Commit transaction
            DB::commit();

            return redirect()->route('room.index')->with('success', 'Room updated successfully.');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();
            dd($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $room = Room::findOrFail($id);
            $room->delete();

            // Commit transaction
            DB::commit();
            return redirect()->route('room.index')->with('success', 'Room deleted successfully.');
        } catch (Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getRoomTypes(Request $request)
    {
        $roomTypes = RoomType::where('homestay', $request->code)->pluck('name', 'code');
        return response()->json($roomTypes);
    }
}
