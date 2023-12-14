<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function store(Request $request, $userId)
    {
        // Get the authenticated user
        $currentUser = Auth::user();

        // Check if the user has already reviewed the specified user
        $existingReview = Review::where('user_id', $currentUser->id)
            ->where('reviewed_user_id', $userId)
            ->first();

        // If the review already exists, prevent submitting a new review
        if ($existingReview) {
            return response()->json(['status' => 'fail', 'message' => 'You have already reviewed this user'], 200);
        }

        $request->validate([
            'content' => 'required',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review = new Review();
        $review->content = $request->content;
        $review->rating = $request->rating;
        $review->user_id = auth()->user()->id; // Reviewer
        $review->reviewed_user_id = $userId;

        $review->save();

        return response()->json(['message' => 'Review submitted successfully']);
    }

    public function getRatingInfo($userId)
    {
        $user = User::findOrFail($userId);
        $averageRating = number_format(round($user->reviews()->avg('rating'), 1), 1);
        $ratingBreakdown = $user->reviews()->select('rating', DB::raw('count(*) as count'))->groupBy('rating')->pluck('count', 'rating')->toArray();
        $reviews = Review::where('reviewed_user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        $review = Review::where('reviewed_user_id', $userId)->get();
        $totalReviews = count($review);

        $averageRating = number_format(round($review->avg('rating'), 1), 1);
        // Calculate the rating breakdown
        $ratingBreakdown = [];
        foreach ($review as $review) {
            $rating = $review->rating;
            if (!isset($ratingBreakdown[$rating])) {
                $ratingBreakdown[$rating] = 1;
            } else {
                $ratingBreakdown[$rating]++;
            }
        }

        $ratingData = [];
        for ($i = 5; $i >= 1; $i--) {
            $ratingCount = $ratingBreakdown[$i] ?? 0;
            $ratingData[$i] = $totalReviews > 0 ? round(($ratingCount / $totalReviews) * 100) : 0;
        }

        $reviewData = [];
        foreach ($reviews as $review) {
            $reviewData[] = [
                'id' => $review->id,
                'name' => $review->reviewer->name,
                'user_id' => $review->user_id,
                'content' => $review->content,
                'rating' => $review->rating,
                'created_at' => $review->created_at,
            ];
        }

        return response()->json([
            'averageRating' => $averageRating,
            'ratingBreakdown' => $ratingBreakdown,
            'ratingData' => $ratingData,
            'totalReviews' => $totalReviews,
            'reviewsData' => $reviewData,
        ]);
    }

    public function userReviews()
    {
        $userReview = Review::with('reviewer')->latest()->get();

        return view('backend.users.user-reviews', compact('userReview'));
    }

    public function userRatings()
    {
        $usersWithAverageRatings = User::has('reviews')
            ->with(['reviews' => function ($query) {
                $query->selectRaw('reviewed_user_id, AVG(rating) as average_rating')
                    ->groupBy('reviewed_user_id');
            }])
            ->get();
        return view('backend.users.user-ratings', compact('usersWithAverageRatings'));
    }
}
