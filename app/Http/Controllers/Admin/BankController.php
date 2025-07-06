<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BankController extends Controller
{
    public function index()
    {
        $id = Auth::user()->id;

        $banks = Bank::where('user_id', $id)->get();

        return view('admin.bank', compact('banks'));
    }

    // Add new bank
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bank_name'   => 'required|string|max:255',
            'acc_number'  => 'required|string|max:255',
            'acc_holder'  => 'required|string|max:255',
            'status'      => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $bank = Bank::create([
            'user_id'     => Auth::user()->id,
            'bank_name'   => $request->bank_name,
            'acc_number'  => $request->acc_number,
            'acc_holder'  => $request->acc_holder,
            'status'      => $request->status,
        ]);

        return response()->json(['message' => 'Bank created successfully', 'data' => $bank], 201);
    }

    // Edit existing bank
    public function update(Request $request, $id)
    {
        $bank = Bank::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'bank_name'   => 'sometimes|required|string|max:255',
            'acc_number'  => 'sometimes|required|string|max:255',
            'acc_holder'  => 'sometimes|required|string|max:255',
            'status'      => 'sometimes|required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $bank->update($request->only([
            'bank_name',
            'acc_number',
            'acc_holder',
            'status'
        ]));

        return response()->json(['message' => 'Bank updated successfully', 'data' => $bank], 200);
    }

    // Delete bank
    public function destroy($id)
    {
        $bank = Bank::findOrFail($id);
        $bank->delete();

        return response()->json(['message' => 'Bank deleted successfully'], 200);
    }
}
