<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Trip;
use App\Models\TripRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Vehicle;
use App\Notifications\TripRequestNotification;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all trips from the database and pass them to the view
        $trips = Trip::whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            // ->where('status','=','pending')
            ->get();
        return view('trips.index', compact('trips'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return vehicle
        $vehicles = Vehicle::where('user_id', auth()->user()->id)->get();

        return view('trips.create', compact('vehicles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate the form data
            $validatedData = $request->validate([
                'eta' => 'required',
                'from' => 'required',
                'to' => 'required',
                'departure_time' => ['required', 'date', 'after_or_equal:' . now()->subMinutes(5)],
                'vehicle_id' => 'required',
                'available_seats' => 'required|integer',
            ]);

            $driverId = auth()->user() ? auth()->user()->id : null;
            // Create a new trip with the validated data and save it to the database
            $trip = new Trip();
            $trip->driver_id = $driverId;
            $trip->eta = $validatedData['eta'];
            $trip->pickup_location = $validatedData['from'];
            $trip->destination_location = $validatedData['to'];
            $trip->departure_time = $validatedData['departure_time'];
            $trip->vehicle_id = $validatedData['vehicle_id'];
            $trip->available_seats = $validatedData['available_seats'];

            // Add the latitude and longitude values to the trip model
            $trip->origin_lat = $request->input('originLat');
            $trip->origin_lng = $request->input('originLng');
            $trip->destination_lat = $request->input('destinationLat');
            $trip->destination_lng = $request->input('destinationLng');
            $trip->pricing = $request->input('pricing');
            $trip->status = 'pending';

            DB::beginTransaction();
            $trip->save();
            DB::commit();

            // Redirect the user to the trips index page with a success message
            // return redirect()->route('trips.index')->with('success', 'Trip created successfully!');
            return response()->json(['success' => 'Trip created successfully!']);
        } catch (\Exception $e) {
            // Rollback the transaction if any error occurs
            DB::rollBack();
            // return redirect()->back()->with('error', 'Failed to create trip: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create trip: ' . $e->getMessage()]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // return view('trips.show', ['edit' => $trips]);

        $trips = Trip::with('requests')->where('id', $id)->whereNull('deleted_at')->first();

        if (!$trips) {
            return redirect()->route('trips.index')->with('error', 'Trip with trip id ' . $id . ' not found');
        } else {
            return view('trips.show', compact('trips'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // $user = User::find($id);
        $trip = Trip::where('id', $id)->whereNull('deleted_at')->first();
        // Return vehicle
        $vehicles = Vehicle::where('user_id', auth()->user()->id)->get();
        if (!$trip) {
            return redirect()->route('trips.index')->with('error', 'Trip with trip id ' . $id . ' not found');
        } else {
            // return view('trips.edit', ['edit' => $user]);
            return view('trips.edit', compact('trip', 'vehicles'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $id)
    {

        try {
            $validatedData = $request->validate([
                'eta' => 'required',
                'from' => 'required',
                'to' => 'required',
                'origin_lat' => 'required',
                'origin_lng' => 'required',
                'destination_lat' => 'required',
                'destination_lng' => 'required',
                'departure_time' => ['required', 'date', 'after_or_equal:' . now()->subMinutes(5)],
                'vehicle_id' => 'required',
                'available_seats' => 'required|integer',
                'pricing' => 'required',
            ]);

            $trips = Trip::findOrFail($id);
            DB::beginTransaction();
            $trips->update($validatedData);
            DB::commit();

            return response()->json(['success' => 'Trip updated successfully.']);
            // return redirect()->route('trips.show', ['trip' => $trips])->with('success', 'Trip updated successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction if any error occurs
            DB::rollBack();
            return response()->json(['error' => 'Failed to edit trip: ' . $e->getMessage()]);
            // return redirect()->back()->with('error', 'Failed to edit user: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $trip = Trip::findOrFail($id);
            if (!$trip) {
                return redirect()->back()->with('error', 'Trip not found.');
            }
            DB::beginTransaction();
            $trip->delete();
            DB::commit();
            // Redirect the user to the trips index page with a success message
            return redirect()->route('trips.index')->with('success', 'Trip ' . $trip->id . ' soft deleted succesfully.');
        } catch (\Exception $e) {
            // Rollback the transaction if any error occurs
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete the user: ' . $e->getMessage());
        }
    }


    public function search(Request $request)
    {
        return view('trips.search');
    }

    // public function searchResults(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'pickup_location' => 'required|string|max:255',
    //         'destination_location' => 'required|string|max:255',
    //     ]);

    //     $trips = Trip::where('pickup_location', 'LIKE', '%' . $validatedData['pickup_location'] . '%')
    //         ->where('destination_location', 'LIKE', '%' . $validatedData['destination_location'] . '%')
    //         ->where('departure_time', '>=', now())
    //         ->get();

    //     return view('trips.searchResults')->with('trips', $trips);

    // }

    public function searchResults(Request $request)
    {
        $originLatitude = $request->input('originlat');
        $originLongitude = $request->input('originlng');
        $destinationLongitude = $request->input('destinationlat');
        $destinatioLongitude = $request->input('destinationlng');


        // Calculate the bounding box coordinates
        $boundingBox_origin = $this->calculateBoundingBox($originLatitude, $originLongitude, 5);
        $boundingBox_destination = $this->calculateBoundingBox($destinationLongitude, $destinatioLongitude, 5);

        // Search trips within the bounding box
        $trips = Trip::selectRaw("trips.id,users.id as user_id,trips.available_seats, DATE_FORMAT(trips.departure_time, '%d-%M-%Y') as departure_date, 
        DATE_FORMAT(trips.departure_time, '%h:%i %p') as departure_time_formatted, trips.pickup_location, 
            trips.destination_location, users.name as driver_name")
            ->join('users', 'trips.driver_id', '=', 'users.id')
            ->whereBetween('origin_lat', [$boundingBox_origin['min_lat'], $boundingBox_origin['max_lat']])
            ->whereBetween('origin_lng', [$boundingBox_origin['min_lng'], $boundingBox_origin['max_lng']])
            ->whereBetween('destination_lat', [$boundingBox_destination['min_lat'], $boundingBox_destination['max_lat']])
            ->whereBetween('destination_lng', [$boundingBox_destination['min_lng'], $boundingBox_destination['max_lng']])
            ->where('departure_time', '>=', now())
            ->get();
        return response()->json(["data" => $trips]);
    }

    private function calculateBoundingBox($latitude, $longitude, $distance)
    {
        $earthRadius = 6371; // Earth's radius in kilometers
        $angularDistance = $distance / $earthRadius; // Convert distance to angular distance

        // Convert origin coordinates to radians
        $latitude = deg2rad($latitude);
        $longitude = deg2rad($longitude);

        // Calculate the minimum and maximum latitude
        $minLat = $latitude - $angularDistance;
        $maxLat = $latitude + $angularDistance;

        // Calculate the minimum and maximum longitude
        $deltaLongitude = asin(sin($angularDistance) / cos($latitude));
        $minLng = $longitude - $deltaLongitude;
        $maxLng = $longitude + $deltaLongitude;

        // Convert back to degrees
        $minLat = rad2deg($minLat);
        $maxLat = rad2deg($maxLat);
        $minLng = rad2deg($minLng);
        $maxLng = rad2deg($maxLng);

        // Return the bounding box coordinates
        return [
            'min_lat' => $minLat,
            'max_lat' => $maxLat,
            'min_lng' => $minLng,
            'max_lng' => $maxLng,
        ];
    }

    public function joinTrip(Request $request, $id)
    {
        $trip = Trip::find($id);

        // Check if the trip was found
        if (!$trip) {
            return redirect()->route('trips.search')->with('error', 'Trip not found!');
        }

        // Check if the user has already joined the trip
        if ($trip->riders()->where('user_id', auth()->id())->exists()) {
            return redirect()->route('trips.search')->with('error', 'You have already joined this trip!');
        }

        // Check if the user has created the trip
        if ($trip->user_id === auth()->id()) {
            return redirect()->route('trips.search')->with('error', 'You cannot join the trip that you have created!');
        }

        $validatedData = $request->validate([
            'pickup_location' => 'required|string|max:255',
            'destination_location' => 'required|string|max:255',
        ]);

        if ($trip->available_seats > 0) {
            $trip->riders()->attach(
                Auth::user()->id,
                [
                    'pickup_location' => $validatedData['pickup_location'],
                    'destination_location' => $validatedData['destination_location'],
                    'status' => 'pending', // set the initial status to "pending"
                ]
            );
            $trip->available_seats--;
            $trip->save();
            return redirect()->route('trips.show', $trip->id)->with('success', 'You have joined the trip!');
        } else {
            return redirect()->route('trips.search', 'No available seats on this trip.');
        }
    }

    // public function  (Request $request)
    // {
    //     $tripId = $request->input('trip_id');
    //     $trip = Trip::findOrFail($tripId);
    //     $trip->addRider(Auth::user(), $request->input('pickup_location'), $request->input('destination_location'));

    //     return redirect()->route('trips.search')->with('success', 'You have joined the trip successfully!');
    // }

    public function selectPoints(Request $request)
    {
        $tripId = $request->input('trip_id');
        $trip = Trip::findOrFail($tripId);
        $trip->setRiderPickupLocation(Auth::user(), $request->input('pickup_location'));
        $trip->setRiderDestinationLocation(Auth::user(), $request->input('destination_location'));

        return redirect()->route('trips.search')->with('success', 'Your pickup and destination points have been set successfully!');
    }

    public function myTrips()
    {
        $userId = auth()->user()->id;
        // $createdTrips = $user->trips()->get();
        // $joinedTrips = $user->joinedTrips()->get();
        $createdTrips = Trip::where('trips.driver_id', $userId)->get();
        $joinedTrips = Trip::whereHas('tripRequests', function ($query) use ($userId) {
            $query->where('user_id', $userId)
                ->where('status', 'approved');
        })->get();
        $trips = $createdTrips->merge($joinedTrips);

        return view('trips.myTrips')->with('trips', $trips);
    }

    public function respondToJoinRequest(Request $request, $trip_id, $rider_id, $response)
    {
        $trip = Trip::find($trip_id);
        $rider = $trip->riders()->where('user_id', $rider_id)->first();

        if ($response == 'accept') {
            // Check if there are still available seats
            if ($trip->available_seats > 0) {
                // Update the rider's status to accepted
                $rider->pivot->status = 'accepted';
                $rider->pivot->save();

                // Decrement the available seats and save the trip
                $trip->available_seats--;
                $trip->save();

                return redirect()->route('trips.show', $trip_id)->with('success', 'Request accepted successfully!');
            } else {
                return redirect()->route('trips.show', $trip_id)->with('error', 'There are no available seats on this trip.');
            }
        } elseif ($response == 'reject') {
            // Remove the rider from the trip
            $trip->riders()->detach($rider_id);

            return redirect()->route('trips.show', $trip_id)->with('success', 'Request rejected successfully!');
        }
    }

    public function showPendingJoinRequests($tripId)
    {
        $trip = Trip::findOrFail($tripId);
        $joinRequests = $trip->joinRequests()->with('user')->get();

        return view('trips.pending-join-requests', [
            'trip' => $trip,
            'joinRequests' => $joinRequests,
        ]);
    }

    public function requestTrip(Request $request, $id)
    {
        $trip = Trip::find($id);

        // Check if the trip was found
        if (!$trip) {
            return redirect()->route('trips.search')->with('error', 'Trip not found!');
        }

        // Check if the user has already requested to join the trip
        if ($trip->requests()->where('user_id', auth()->id())->exists()) {
            return redirect()->route('trips.search')->with('error', 'You have already requested to join this trip!');
        }

        // Check if the user has created the trip
        if ($trip->user_id === auth()->id()) {
            return redirect()->route('trips.search')->with('error', 'You cannot request to join the trip that you have created!');
        }

        $validatedData = $request->validate([
            'pickup_location' => 'required|string|max:255',
            'destination_location' => 'required|string|max:255',
            'seats_requested' => 'required|integer|min:1',
        ]);

        $tripRequest = new TripRequest();
        $tripRequest->user_id = Auth::user()->id;
        $tripRequest->trip_id = $trip->id;
        $tripRequest->pickup_location = $validatedData['pickup_location'];
        $tripRequest->destination_location = $validatedData['destination_location'];
        $tripRequest->seats_requested = $validatedData['seats_requested'];
        // Add the latitude and longitude values to the trip model
        $tripRequest->origin_lat = $request->input('originLat');
        $tripRequest->origin_lng = $request->input('originLng');
        $tripRequest->destination_lat = $request->input('destinationLat');
        $tripRequest->destination_lng = $request->input('destinationLng');
        $tripRequest->status = 'pending'; // set the initial status to "pending"
        $tripRequest->save();

        // Create and send the notification
        $user = User::find($trip->driver_id);
        if ($user) {
            $notification = new TripRequestNotification();
            // Save the notification for the user
            $data = [
                'message' => $tripRequest->user->name . ' requested to join your trip.',
                'trip_id' => $trip->id,
                // Add any additional data you want to include in the notification
            ];
            $user->notifications()->create([
                // 'id' => Str::uuid(), // Generate a UUID for the id field
                'type' => get_class($notification),
                'data' => $notification->toDatabase($data),
                'read_at' => null,
            ]);
        }

        return redirect()->route('trips.show', $trip->id)->with('success', 'You have requested to join the trip!');
        // return redirect()->route('trips.show', $trip->id)->with('success', 'You have requested to join the trip!');
    }

    public function updateTripRequest(TripRequest $request)
    {
        $data = request()->validate([
            'status' => ['required', Rule::in(['approved', 'rejected'])],
        ]);

        $request->status = $data['status'];
        $request->save();

        // Decrement the available_seats column in the Trips table by 1
        Trip::where('id', $request->trip_id)->decrement('available_seats');

        $message = $data['status'] == 'approved' ? 'Trip request approved' : 'Trip request rejected';

        toastr()->success($message);
        return back()->with('success', $message);
    }
}
