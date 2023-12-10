<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $announcements = Announcement::all();
        return view('announcements.index', compact('announcements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('announcements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,gif',
            'file' => 'nullable|mimes:pdf',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('announcments/images', 'public');
            $validatedData['image'] = $imagePath;
        }

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('announcments/files', 'public');
            $validatedData['file'] = $filePath;
        }

        Announcement::create($validatedData);

        return redirect()->route('announcements.create')->with('success', 'Announcement created successfully!');
    }

    public function storeData(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required',
                'content' => 'required',
                'file' => 'nullable|mimes:pdf,doc,docx,txt',
            ]);
            $announcement = new Announcement();
            $announcement->title = $validatedData['title']; 
            $announcement->content = $validatedData['content'];
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $originalName = $file->getClientOriginalName(); // Get the original file name
                $fileName = pathinfo($originalName, PATHINFO_FILENAME); // Extract the file name without extension
                $extension = $file->getClientOriginalExtension(); // Get the file extension
                $timestamp = now()->format('Ymd_His'); // Generate a timestamp

                // Concatenate the original filename, timestamp, and extension to create a unique filename
                $uniqueFileName = $fileName . '_' . $timestamp . '.' . $extension;

                // Store the file in the specified directory with the unique filename
                $filePath = $file->storeAs('storage/announcements/files/', $uniqueFileName); // Adjust the storage path as needed

                $validatedData['file'] = $filePath; // Save the file path in your validated data
            } else {
                $announcement->file = null; // Set the 'file' attribute to null when no file is uploaded
            }

            $announcement->save();

            return response()->json(['status' => "success", 'announcement_id' => $announcement->id, 'success' => 'Announcement Created Successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => "error", 'message' => $e->getMessage()]);
        }
    }

    public function storeImage(Request $request)
    {
        $user = auth()->user();
        //here we are geeting userid alogn with an image
        $announcement_id = $request->announcement_id;
        $announcement = Announcement::findOrFail($announcement_id);

        $imageData = $announcement->images;

        if (empty($imageData)) {
            // If it's the first image, set the count to 0
            $imageCount = 0;
        } else {
            $imageCount = count($imageData);
        }

        if ($request->file('file')) {
            $request->validate([
                'file' => 'required',
            ]);
            $image = $request->file('file');
            // $imageName = $user->name . '_' . $user->id . '_' . $vehicle->name . '_' . $vehicle->id . '_(' . ($imageCount + 1) . ').' . $image->getClientOriginalExtension();
            $imageName = $announcement->title . '_' . $announcement->id . '_' . now()->format('Ymd_His') . '.' . $image->getClientOriginalExtension();

            // Move the uploaded file to a designated storage location
            $image->storeAs('/announcements/images/', $imageName);

            // $request->file('file')->move(public_path() . '/uploads/images/', $imageName);

            // Get the existing image data from the database
            $existingImages = $announcement->images ?? [];
            $path = 'storage/announcements/images/' . $imageName;
            // Create a new image data array
            $newImageData = [
                'image' => $imageName,
                // 'path' => public_path('images'),
                'path' => $path,
            ];

            // Add the new image data to the existing images
            $updatedImages = array_merge($existingImages, [$newImageData]);

            // Update the images column with the updated image data
            $announcement->where('id', $announcement_id)->update(['images' => $updatedImages]);

            return response()->json(['status' => "success", 'imgdata' => $imageName, 'announcement_id' => $announcement_id]);
        }
        // Handle the case where no file was uploaded
        return response()->json(['status' => 'error', 'message' => 'No image file uploaded.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            return redirect()->route('announcements.index')->with('error', 'Announcement not found!');
        }

        $images = $announcement->images;
        return view('announcements.show', compact('announcement', 'images'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            return redirect()->route('announcements.index')->with('error', 'Announcement not found!');
        }

        $images = $announcement->images;

        return view('announcements.edit', compact('announcement', 'images'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $announcement = Announcement::findOrFail($id);

        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,gif',
            'file' => 'nullable|mimes:pdf,doc,docx,txt',
        ]);

        $announcement->title = $validatedData['title'];
        $announcement->content = $validatedData['content'];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('announcements/images', 'public');
            $announcement->image = $imagePath;
        }

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('announcements/files', 'public');
            $announcement->file = $filePath;
        }

        $announcement->save();

        return redirect()->route('announcements.index')->with('success', 'Announcement updated successfully!');
    }

    public function updateData(Request $request, $announcement_id)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required',
                'content' => 'required',
                'file' => 'nullable|mimes:pdf',
            ]);

            $announcement = Announcement::findOrFail($announcement_id);
            $announcement->title = $validatedData['title'];
            $announcement->content = $validatedData['content'];

            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('announcements/files', 'public');
                $announcement->file = $filePath;
            } else {
                $announcement->file = null; // Set the 'file' attribute to null when no file is uploaded
            }

            $announcement->save();

            return response()->json(['status' => "success", 'announcement_id' => $announcement->id, 'message' => 'Announcement Updated Successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => "error", 'message' => $e->getMessage()]);
        }
    }

    public function updateImage(Request $request, $announcement_id)
    {
        $user = auth()->user();

        $announcement = Announcement::findOrFail($announcement_id);
        $imageData = $announcement->images;

        if (empty($imageData)) {
            $imageCount = 0;
        } else {
            $imageCount = count($imageData);
        }

        if ($request->file('file')) {
            $request->validate([
                'file' => 'required',
            ]);
            $image = $request->file('file');
            $imageName = $announcement->title . '_' . $announcement->id . '_' . now()->format('Ymd_His') . '.' . $image->getClientOriginalExtension();

            $image->storeAs('/announcements/images/', $imageName);

            $existingImages = $announcement->images ?? [];
            $path = 'storage/announcements/images/' . $imageName;
            $newImageData = [
                'image' => $imageName,
                'path' => $path,
            ];

            $updatedImages = array_merge($existingImages, [$newImageData]);

            $announcement->where('id', $announcement_id)->update(['images' => $updatedImages]);

            return response()->json(['status' => "success", 'imgdata' => $imageName, 'announcement_id' => $announcement_id]);
        }
        return response()->json(['status' => 'error', 'message' => 'No image file uploaded.']);
    }

    function deleteImage(Request $request)
    {
        $imageData = $request->image;
        $announcement_id = $request->id;

        // Get the image path from the database
        $imagePath = Announcement::where('id', $announcement_id)->value('images');

        if (empty($imagePath)) {
            return response()->json(['status' => "success", 'message' => 'No image found']);
        }

        // Decode the JSON string to an array
        $imageArray = json_decode($imagePath, true);

        // Search for the image and remove it from the array
        $updatedImages = array_filter($imageArray, function ($item) use ($imageData) {
            return $item['path'] !== $imageData;
        });

        // If the image was not found in the array, return an error response
        if (count($imageArray) === count($updatedImages)) {
            return response()->json(['status' => 'error', 'message' => 'Image not found']);
        }

        // Encode the updated array back to JSON
        $updatedImagePath = json_encode(array_values($updatedImages));

        // Update the image path in the database
        Announcement::where('id', $announcement_id)->update(['images' => $updatedImagePath]);

        return response()->json([
            'status' => "success",
            'message' => 'Image deleted successfully',
            'imagePath' => $imagePath,
            'announcement_id' => $announcement_id,
            'imageData' => $imageData,
            'updatedImages' => $updatedImages,
            'updatedImagePath' => $updatedImagePath
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $announcement = Announcement::findOrFail($id);

        // Delete associated files if they exist in storage
        if ($announcement->image) {
            Storage::disk('public')->delete($announcement->image);
        }

        if ($announcement->file) {
            Storage::disk('public')->delete($announcement->file);
        }

        $announcement->delete();

        return redirect()->route('announcements.index')->with('success', 'Announcement deleted successfully!');
    }
}
