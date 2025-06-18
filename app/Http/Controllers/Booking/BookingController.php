<?php

namespace App\Http\Controllers\Booking;


use Carbon\Carbon;
use App\Models\Homestay;
use App\Models\RoomType;
use App\Models\Destination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\DestinationPrice;
use App\Models\Tour;
use App\Models\TourRate;
use Illuminate\Support\Facades\File;


class BookingController extends Controller
{
    public function homestay(Request $request)
    {
        $json = File::get(resource_path('data/country_codes.json'));
        $countries = json_decode($json, true);

        $today = Carbon::today();

        $roomtypes = RoomType::where('code', $request->query('code'))->with(['imageRoom',  'rates' => function ($query) use ($today) {
            $query->whereDate('valid_from', '<=', $today)
                ->whereDate('valid_to', '>=', $today)
                ->orderByDesc('valid_from') // ambil yang terbaru
                ->limit(1); // hanya 1 harga aktif
        }])
            ->first();


        $homestay = Homestay::where('code', $roomtypes->homestay)->withCount('ratings')->with('ratings')->first();

        $bookingType = $request->query('type');
        $prefillData = [];

        $checkin = Carbon::parse($request->query('checkIn'));
        $checkout = Carbon::parse($request->query('checkOut'));

        $diffInNights = $checkin->diffInDays($checkout);
        $quantity = (int) $request->query('quantity', 1); // Default quantity to 1 if not provided
        $roomPrice = $roomtypes->rates[0]->price ?? 0;
        $total = $roomtypes->rates[0]->price * $diffInNights * $quantity; // Total price calculation
        $tax = $total * 0.15; // Tax 15%

        $prefillData = [
            'code' => $request->query('code'),
            'quantity' => $quantity,
            'checkIn' => $checkin,
            'checkOut' => $checkout,
            'diffInNight' => $diffInNights,
            'roomPrice' => $roomPrice,
            'total' => $total,
            'tax' => $tax,
            'total_price' => $total + $tax,
        ];



        return view("booking.homestay-booking", compact("countries", "prefillData", "homestay", "roomtypes"));
    }

    public function destination(Request $request)
    {
        $json = File::get(resource_path('data/country_codes.json'));
        $countries = json_decode($json, true);
        $prefillData = [];


        $ticketTypes = $request->input('ticket_type');
        $quantities = $request->input('quantity');

        if (count($ticketTypes) !== count($quantities)) {
            return response()->json(['error' => 'Invalid ticket data.'], 422);
        }

        $tickets = DestinationPrice::whereIn('code', $ticketTypes)->get();


        $total = 0;
        $pax = 0;
        $details = [];

        foreach ($ticketTypes as $index => $code) {
            $ticket = $tickets->firstWhere('code', $code);
            $qty = (int) $quantities[$index];

            if ($ticket && $qty > 0) {
                $subtotal = $ticket->price * $qty;
                $details[] = [
                    'code' => $ticket->code,
                    'name' => $ticket->name,
                    'price' => $ticket->price,
                    'quantity' => $qty,
                    'subtotal' => $subtotal,
                ];
                $total += $subtotal;
                $pax += $qty;
            }
        }

        // Tax 15%
        $tax = $total * 0.15;

        $prefillData = [
            'slug' => $request->query('slug'),
            'ticket' => $details,
            'ticket_date' => $request->query('date'),
            'total' => $total,
            "tax" => $tax,
            "pax" => $pax,
            "total_price" => $total + $tax,
        ];



        $destination = Destination::where('slug', $request->query('slug'))->withCount('ratings')->with('images', 'ratings')->first();
        return view("booking.destination-booking", compact("countries", "prefillData", "destination"));
    }

    public function tour(Request $request)
    {
        $json = File::get(resource_path('data/country_codes.json'));
        $countries = json_decode($json, true);
        $prefillData = [];


        $ticketTypes = $request->input('ticket_type');
        $quantities = $request->input('quantity');

        if (count($ticketTypes) !== count($quantities)) {
            return response()->json(['error' => 'Invalid ticket data.'], 422);
        }

        $tickets = TourRate::whereIn('id', $ticketTypes)->get();


        $total = 0;
        $pax = 0;
        $details = [];

        foreach ($ticketTypes as $index => $id) {
            $ticket = $tickets->firstWhere('id', $id);
            $qty = (int) $quantities[$index];

            if ($ticket && $qty > 0) {
                $subtotal = $ticket->price * $qty;
                $details[] = [
                    'id' => $ticket->id,
                    'name' => $ticket->name,
                    'price' => $ticket->price,
                    'quantity' => $qty,
                    'subtotal' => $subtotal,
                ];
                $total += $subtotal;
                $pax += $qty;
            }
        }

        // Tax 15%
        $tax = $total * 0.15;

        $prefillData = [
            'slug' => $request->query('slug'),
            'ticket' => $details,
            'ticket_date' => $request->query('date'),
            'total' => $total,
            "tax" => $tax,
            "pax" => $pax,
            "total_price" => $total + $tax,
        ];


        $tour = Tour::where('slug', $request->query('slug'))->withCount('ratings')->with('ratings')->first();
        return view("booking.tour-booking", compact("countries", "prefillData", "tour"));
    }
}
