<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'driver_id',
        'pickup_location',
        'destination_location',
        'departure_time',
        'available_seats',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'departure_time' => 'datetime',
    ];

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function requests()
    {
        return $this->hasMany(TripRequest::class);
    }

    public function tripRequests()
    {
        return $this->hasMany(TripRequest::class, 'trip_id');
    }
    
    public function riders()
    {
        return $this->belongsToMany(User::class, 'trip_rider', 'trip_id', 'user_id')->withPivot('pickup_location', 'destination_location', 'status');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function scopeAvailable($query, $pickupLocation, $destinationLocation)
    {
        return $query->where('available_seats', '>', 0)
            ->where('pickup_location', 'like', '%' . $pickupLocation . '%')
            ->where('destination_location', 'like', '%' . $destinationLocation . '%')
            ->where('departure_time', '>', now());
    }

    public function addRider(User $rider, $pickupLocation, $destinationLocation)
    {
        $this->riders()->attach($rider, ['pickup_location' => $pickupLocation, 'destination_location' => $destinationLocation]);
        $this->available_seats--;
        $this->save();
    }

    public function setRiderPickupLocation(User $rider, $pickupLocation)
    {
        $this->riders()->updateExistingPivot($rider->id, ['pickup_location' => $pickupLocation]);
    }

    public function setRiderDestinationLocation(User $rider, $destinationLocation)
    {
        $this->riders()->updateExistingPivot($rider->id, ['destination_location' => $destinationLocation]);
    }
}
