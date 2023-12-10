<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // Assuming you have a user_id field in the withdrawal requests table
        'amount',
        'status',
        // Add other fields as needed
    ];

    // Define relationships if any (for example, if a withdrawal request belongs to a User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
