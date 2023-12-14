<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reviewed_user_id',
        'content',
        'rating',
    ];

    // Define the relationship with the reviewer (User model)
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Define the relationship with the user being reviewed (User model)
    public function reviewedUser()
    {
        return $this->belongsTo(User::class, 'reviewed_user_id');
    }
}
