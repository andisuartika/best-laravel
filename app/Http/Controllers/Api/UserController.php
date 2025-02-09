<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Check unique email and Phone
    public function checkUnique(Request $request)
    {
        $emailExists = User::where('email', $request->email)->exists();
        $phoneExists = User::where('phone', $request->phone)->exists();

        return response()->json([
            'emailExists' => $emailExists,
            'phoneExists' => $phoneExists,
        ]);
    }
}
