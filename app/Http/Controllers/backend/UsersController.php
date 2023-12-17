<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function AllUsers()
    {
        $all = DB::table('users')->whereNull('deleted_at')->get();
        return view('backend.users.all-users', compact('all'));
    }


    public function AddUsers()
    {
        $all = DB::table('users')->whereNull('deleted_at')->get();
        return view('backend.users.add-users', compact('all'));
    }

    public function InsertUsers(Request $request)
    {
        try {
            // Validate the form data
            $validatedData = $request->validate([
                'name' => 'required|unique:users|max:255',
                'email' => 'required|email|unique:users|max:255',
                'password' => 'required|min:8|max:255',
            ]);

            // Use the model to create a new user instance
            $user = new User();
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->password = Hash::make($validatedData['password']);
            $user->role = $request->input('role') ? $request->input('role') : 'Customer';

            // Save the user to the database
            DB::beginTransaction();
            $user->save();
            DB::commit();

            // Redirect back to the same page
            return redirect()->back()->with('success', 'User added successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction if any error occurs
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to add user: ' . $e->getMessage());
        }
    }

    public function EditUsers($id)
    {
        // $user = User::find($id);
        $user = User::where('id', $id)->whereNull('deleted_at')->first();
        if (!$user) {
            return redirect()->route('all-users')->with('error', 'User with user id ' . $id . ' not found');
        } else {
            return view('backend.users.edit-users', ['edit' => $user]);
        }
    }

    public function UpdateUsers(Request $request, $id)
    {

        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|max:255',
            'status' => 'required',
            'verification'  => 'required',
        ]);

        try {
            // if (
            //     $user->name == $validatedData['name'] && $user->email == $validatedData['email'] && empty($validatedData['password']) &&
            //     $user->role == $request->input('role')
            // )
            if (
                $user->name == $validatedData['name'] &&
                $user->email == $validatedData['email'] &&
                empty($validatedData['password']) &&
                $user->status == $validatedData['status'] &&
                $user->verified_by_admin == $validatedData['verification']
            ) {
                return redirect()->back()->with('error', 'No changes made to user ' . $user->name);
            }

            if (!empty($validatedData['password'])) {
                $user->password = Hash::make($request['password']);
            }

            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->status = $validatedData['status'];
            // $user->role = $request->input('role');
            $user->verified_by_admin = $validatedData['verification'];

            DB::beginTransaction();
            // Update all request except password
            // $user->update($request->except('password'));

            // Update the updated_at timestamp
            // $user->touch();

            // Alternative way to update all
            $user->save();

            DB::commit();
            return redirect()->back()->with('success', 'User ' . $user->name . ' successfully edited.');
            // return response()->json(['message' => $user->password]);

        } catch (\Exception $e) {
            // Rollback the transaction if any error occurs
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to edit user: ' . $e->getMessage());
        }
    }

    public function DeleteUsers($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return redirect()->back()->with('error', 'User not found.');
            }
            DB::beginTransaction();
            $user->delete();
            DB::commit();
            return redirect()->back()->with('success', 'User ' . $user->name . ' soft deleted.');
        } catch (\Exception $e) {
            // Rollback the transaction if any error occurs
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }

    public function myProfile()
    {
        // Retrieve the authenticated user
        $user = auth()->user();

        // Retrieve the social media data as an array
        if (empty($user->social_media)) {
            $user->social_media = [
                'instagram' => '',
                'facebook' => '',
            ];
        }
        $socialMedia = $user->social_media;
        $instagramUsername = $socialMedia['instagram'];
        $instagramProfileUrl = 'https://www.instagram.com/' . $instagramUsername;

        return view('backend.users.my-profile', compact('user'), ['instagramUsername' => $instagramUsername, 'instagramProfileUrl' => $instagramProfileUrl]);
    }

    public function userProfile($userId)
    {
        // Retrieve the authenticated user
        $user = User::find($userId);

        // Retrieve the social media data as an array
        if (empty($user->social_media)) {
            $user->social_media = [
                'instagram' => '',
                'facebook' => '',
            ];
        }
        $socialMedia = $user->social_media;
        $instagramUsername = $socialMedia['instagram'];
        $instagramProfileUrl = 'https://www.instagram.com/' . $instagramUsername;
        // $reviews = $user->reviews()->orderBy('created_at', 'desc')->get();
        // $reviews = $user->reviews()->with('reviewedUser')->get();
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

        $percentages = [];
        for ($i = 5; $i >= 1; $i--) {
            $ratingCount = $ratingBreakdown[$i] ?? 0;
            $percentages[$i] = $totalReviews > 0 ? round(($ratingCount / $totalReviews) * 100) : 0;
        }


        return view('backend.users.user-profile', compact('user'), [
            'instagramUsername' => $instagramUsername,
            'instagramProfileUrl' => $instagramProfileUrl,
            'reviews' => $reviews,
            'averageRating' => $averageRating,
            'ratingBreakdown' => $ratingBreakdown,
            'totalReviews' => $totalReviews,
            'percentages' => $percentages,
        ]);
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');
            $userId = Auth::id();
            $userName = Auth::user()->name;
            $imageName = $userName . '_' . $userId . '.' . $image->getClientOriginalExtension();

            // Move the uploaded file to a designated storage location
            $image->storeAs('images', $imageName);

            // Save the image path in the database
            $path = 'storage/images/' . $imageName;
            $user = Auth::user();
            $user->image_path = $path;
            $user->save();

            return back()->with('success', 'Image uploaded successfully.');
        }

        return back()->with('error', 'Invalid image file.');
    }

    public function uploadSocialMedia(Request $request)
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        // Validate the form input
        $instagram = $request->input('instagram');
        $facebook = $request->input('facebook');
        // Add the rest of your inputs here

        $jsonData = [
            'instagram' => $instagram,
            'facebook' => $facebook,
            // Add the rest of your inputs here
        ];

        // Update the social media handles for the user
        $user->social_media = $jsonData;
        $user->save();

        // Redirect back to the profile page with a success message
        return redirect()->back()->with('success', 'Social media handles updated successfully.');
    }

    public function updatePersonalDetails(Request $request)
    {
        // Retrieve the authenticated user
        $user = Auth::user();

        try {
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|max:255',
                'phone_no' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:13',
                'bio' => 'nullable|max:255',
                'location' => 'nullable|max:255',
                'education' => 'nullable|max:255',
                'occupation' => 'nullable|max:255',
                'ic_document' => 'nullable|mimes:pdf|max:2048', // PDF file, max 2MB
                'driving_license_document' => 'nullable|mimes:pdf|max:2048', // PDF file, max 2MB
            ]);

            // Validate the form input
            $name = $request->input('name');
            $email = $request->input('email');
            $phone_no = $request->input('phone_no');
            $bio = $request->input('bio');
            $location = $request->input('location');
            $education = $request->input('education');
            $occupation = $request->input('occupation');

            // Update the user's name and email
            $user->name = $name;
            $user->email = $email;
            $user->phone_no = $phone_no;
            $user->bio = $bio;
            $user->location = $location;
            $user->education = $education;
            $user->occupation = $occupation;

            if ($request->hasFile('ic_document')) {
                $icOriginalFilename = pathinfo($request->file('ic_document')->getClientOriginalName(), PATHINFO_FILENAME);
                $ic_document_name = $icOriginalFilename . '_' . now()->format('Ymd_His') . '.' . $request->file('ic_document')->getClientOriginalExtension();
                $ic_document_path = $request->file('ic_document')->storeAs('users/' . $user->id . '/ic', $ic_document_name);
                $user->ic_document = $ic_document_path;
            }

            if ($request->hasFile('driving_license_document')) {
                $originalFilename = pathinfo($request->file('driving_license_document')->getClientOriginalName(), PATHINFO_FILENAME);
                $driving_license_document_name = $originalFilename . '_' . now()->format('Ymd_His') . '.' . $request->file('driving_license_document')->getClientOriginalExtension();
                $driving_license_document_path = $request->file('driving_license_document')->storeAs('users/' . $user->id . '/driving_license', $driving_license_document_name);
                $user->driving_license_document = $driving_license_document_path;
            }

            if($request->hasFile('ic_document') && $request->hasFile('driving_license_document')){
                $user->verified_by_admin = 0;
            }
            $user->save();

            // Redirect back to the profile page with a success message
            return redirect()->back()->with('success', 'Personal details updated successfully.');
        } catch (\Exception $e) {
            // Rollback the transaction if any error occurs
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update personal details: ' . $e->getMessage());
        }
    }

    public function account()
    {
        // Retrieve the authenticated user
        $user = auth()->user();

        // Retrieve the social media data as an array
        if (empty($user->social_media)) {
            $user->social_media = [
                'instagram' => '',
                'facebook' => '',
            ];
        }
        $socialMedia = $user->social_media;
        $instagramUsername = $socialMedia['instagram'];
        $instagramProfileUrl = 'https://www.instagram.com/' . $instagramUsername;

        return view('auth.settings.account', compact('user'), ['instagramUsername' => $instagramUsername, 'instagramProfileUrl' => $instagramProfileUrl]);
    }

    public function usersAwaitingVerification()
    {
        $usersAwaitingVerification = User::where('verified_by_admin', false)->get();

        return view('backend.users.awaiting_verification', compact('usersAwaitingVerification'));
    }

    public function verifyUser($id)
    {
        $user = User::find($id);
        $user->verified_by_admin = true;
        $user->save();

        return redirect()->back()->with('success', 'User ' . $user->name . ' successfully verified.');
    }

    public function rejectUser($id)
    {
        $user = User::find($id);
        $user->verified_by_admin = 2;
        $user->save();

        return redirect()->back()->with('success', 'User ' . $user->name . ' successfully rejected.');
    }
}
