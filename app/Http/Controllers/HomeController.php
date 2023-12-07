<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\TripRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $this->updateTripStatus(); // Call the function to update the trip status
        // $userlogin = auth()->user();
        // $upcomingTrip = Trip::where('trips.departure_time', '>', Carbon::now())
        //     ->join('trip_requests', 'trips.id', '=', 'trip_requests.trip_id')
        //     ->where(function ($query) use ($userlogin) {
        //         $query->where('trips.driver_id', $userlogin->id)
        //             ->orWhere(function ($subquery) use ($userlogin) {
        //                 $subquery->where('trip_requests.user_id', $userlogin->id)
        //                     ->where('trip_requests.status', 'approved');
        //             });
        //     })
        //     ->orderBy('trips.departure_time', 'asc')
        //     ->first();

        // $existingTrip = Trip::where('trips.departure_time', '<', Carbon::now())
        //     ->join('trip_requests', 'trips.id', '=', 'trip_requests.trip_id')
        //     ->where('trips.status', 'ongoing')
        //     ->where(function ($query) use ($userlogin) {
        //         $query->where('trips.driver_id', $userlogin->id)
        //             ->orWhere(function ($subquery) use ($userlogin) {
        //                 $subquery->where('trip_requests.user_id', $userlogin->id)
        //                     ->where('trip_requests.status', 'approved');
        //             });
        //     })
        //     ->orderBy('trips.departure_time', 'desc')
        //     ->first();

        return view('backend.layouts.dashboardv1');
    }

    public function updateTripStatus()
    {
        Trip::where('departure_time', '<', Carbon::now())
            ->where('status', 'pending')
            ->update(['status' => 'ongoing']);
    }
}
