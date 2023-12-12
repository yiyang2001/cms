<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
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
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|unique:users|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:8|max:255',
            'role' => 'required',
        ]);

        try {
            // Use the model to create a new user instance
            $user = new User();
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->password = Hash::make($validatedData['password']);
            $user->role = $validatedData['role'];

            // Save the user to the database
            DB::beginTransaction();
            $user->save();
            DB::commit();

            // Redirect back to the same page
            return redirect()->back()->with('success', 'User added successfully.');

            // Redirect to user list page 
            // return redirect()->route('all-users')->with('success', 'User added successfully.');
            // return redirect(URL::to('/add-users'))->with('success', 'User added successfully.');

            // Return Json Message
            // return response()->json([
            //     'message' => 'Data retrieved successfully',
            //     'data' => 'Success'
            // ]);
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
        ]);

        try {
            // if (
            //     $user->name == $validatedData['name'] && $user->email == $validatedData['email'] && empty($validatedData['password']) &&
            //     $user->role == $request->input('role')
            // )
            if (
                $user->name == $validatedData['name'] && $user->email == $validatedData['email'] && empty($validatedData['password']) && empty($validatedData['status'])
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

        return view('backend.users.user-profile', compact('user'), ['instagramUsername' => $instagramUsername, 'instagramProfileUrl' => $instagramProfileUrl]);
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
        $user->save();

        // Redirect back to the profile page with a success message
        return redirect()->back()->with('success', 'Personal details updated successfully.');
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
}
