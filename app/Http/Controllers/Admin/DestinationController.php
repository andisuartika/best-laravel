<?php

namespace App\Http\Controllers\Admin;

use App\Models\Destination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DestinationController extends Controller
{
    public function index()
    {

        $destinations = Destination::where('village_id', Auth::user()->village_id)->get();

        return view('admin.destination.wisata.index', compact('destinations'));
    }
}
