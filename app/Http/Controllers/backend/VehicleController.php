<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    // Display a list of vehicles
    public function index()
    {
        $vehicles = Vehicle::all();
        return view('vehicles.index', compact('vehicles'));
    }

    // Show the form for creating a new vehicle
    public function create()
    {
        $type_options = [
            "",
            "SUV",
            "Sedan",
            "Hatchback",
            "Minivan",
            "Crossover",
            "Station Wagon",
            "Coupe",
            "Convertible",
            "Pickup truck",
            "Truck",
            "Sports car",
            "Motorcycle",
            "Compact car",
            "Car",
            "Compact sport utility vehicle",
            "Roadster",
            "Recreational vehicle",
            "Muscle car",
            "Full-size car",
            "Electric vehicle",
            "Moped",
            "Mid-size car",
            "Luxury",
            "Subcompact",
        ];

        $brand_options = [
            "",
            "Audi",
            "BMW",
            "Ford",
            "Honda",
            "Hyundai",
            "Kia",
            "Mazda",
            "Mercedes",
            "Mitsubishi",
            "Nissan",
            "Perodua",
            "Proton",
            "TOYOTA",
            "Volkswagen",
        ];

        return view('vehicles.create', compact('type_options', 'brand_options'));
    }

    // Store a newly created vehicle in the database
    public function store(Request $request)
    {
        $user = auth()->user();
        // Validate the input data
        $validatedData = $request->validate([
            'vehicle_type' => 'nullable',
            'brand' => 'nullable',
            'model' => 'nullable',
            'color' => 'nullable',
            'number_plate' => 'nullable',
            'available_seats' => 'nullable|integer',
            // Add validation rules for other columns as needed
        ]);

        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);

        $jsonData = [
            'image' => $imageName,
            'path' => public_path('images'),
        ];


        // Create a new vehicle instance with the validated data
        // $vehicle = Vehicle::create($validatedData);
        $vehicle = new Vehicle();
        $vehicle->user_id = $user->id;
        $vehicle->vehicle_type = $validatedData['vehicle_type'];
        $vehicle->brand = $validatedData['brand'];
        $vehicle->model = $validatedData['model'];
        $vehicle->color = $validatedData['color'];
        $vehicle->number_plate = $validatedData['number_plate'];
        $vehicle->available_seats = $validatedData['available_seats'];
        $vehicle->images = $jsonData;
        $vehicle->save();

        // Redirect to the vehicle's detail page or any other desired action
        return redirect()->route('vehicles.show', $vehicle->id);
    }

    public function storeData(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'nullable',
                'vehicle_type' => 'nullable',
                'brand' => 'nullable',
                'model' => 'nullable',
                'color' => 'nullable',
                'number_plate' => 'nullable',
                'available_seats' => 'nullable|integer',
            ]);
            $user = auth()->user();
            $vehicle = new Vehicle();
            $vehicle->user_id = $user->id;
            $vehicle->name = $validatedData['name'];
            $vehicle->vehicle_type = $validatedData['vehicle_type'];
            $vehicle->brand = $validatedData['brand'];
            $vehicle->model = $validatedData['model'];
            $vehicle->color = $validatedData['color'];
            $vehicle->number_plate = $validatedData['number_plate'];
            $vehicle->available_seats = $validatedData['available_seats'];
            $vehicle->save();

            return response()->json(['status' => "success", 'vehicle_id' => $vehicle->id, 'success' => 'Vehicle Added Successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function storeImage(Request $request)
    {
        $user = auth()->user();
        //here we are geeting userid alogn with an image
        $vehicleId = $request->vehicle_id;
        $vehicle = Vehicle::findOrFail($vehicleId);

        $imageData = $vehicle->images;

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
            $imageName = $user->name . '_' . $user->id . '_' . $vehicle->name . '_' . $vehicle->id . '_' . now()->format('Ymd_His') . '.' . $image->getClientOriginalExtension();

            // Move the uploaded file to a designated storage location
            $image->storeAs('vehicle_images', $imageName);

            // $request->file('file')->move(public_path() . '/uploads/images/', $imageName);

            // Get the existing image data from the database
            $existingImages = $vehicle->images ?? [];
            $path = 'storage/vehicle_images/' . $imageName;
            // Create a new image data array
            $newImageData = [
                'image' => $imageName,
                // 'path' => public_path('images'),
                'path' => $path,
            ];

            // Add the new image data to the existing images
            $updatedImages = array_merge($existingImages, [$newImageData]);

            // Update the images column with the updated image data
            $vehicle->where('id', $vehicleId)->update(['images' => $updatedImages]);

            return response()->json(['status' => "success", 'imgdata' => $imageName, 'vehicle_id' => $vehicleId]);
        }
        // Handle the case where no file was uploaded
        return response()->json(['status' => 'error', 'message' => 'No image file uploaded.']);
    }

    // Display the specified vehicle
    public function show($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return view('vehicles.show', compact('vehicle'));
    }

    // Show the form for editing the specified vehicle
    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $type_options = [
            "",
            "SUV",
            "Sedan",
            "Hatchback",
            "Minivan",
            "Crossover",
            "Station Wagon",
            "Coupe",
            "Convertible",
            "Pickup truck",
            "Truck",
            "Sports car",
            "Motorcycle",
            "Compact car",
            "Car",
            "Compact sport utility vehicle",
            "Roadster",
            "Recreational vehicle",
            "Muscle car",
            "Full-size car",
            "Electric vehicle",
            "Moped",
            "Mid-size car",
            "Luxury",
            "Subcompact",
        ];

        $brand_options = [
            "",
            "Audi",
            "BMW",
            "Ford",
            "Honda",
            "Hyundai",
            "Kia",
            "Mazda",
            "Mercedes",
            "Mitsubishi",
            "Nissan",
            "Perodua",
            "Proton",
            "TOYOTA",
            "Volkswagen",
        ];
        return view('vehicles.edit', compact('vehicle', 'type_options', 'brand_options'));
    }

    // Update the specified vehicle in the database
    public function update_vehicle(Request $request, $id)
    {
        // Validate the input data

        $validatedData = $request->validate([
            'name' => 'nullable',
            'vehicle_type' => 'nullable',
            'brand' => 'nullable',
            'model' => 'nullable',
            'color' => 'nullable',
            'number_plate' => 'nullable',
            'available_seats' => 'nullable|integer',
        ]);
        $user = auth()->user();
        $vehicle = new Vehicle();
        $vehicle->user_id = $user->id;
        $vehicle->name = $validatedData['name'];
        $vehicle->vehicle_type = $validatedData['vehicle_type'];
        $vehicle->brand = $validatedData['brand'];
        $vehicle->model = $validatedData['model'];
        $vehicle->color = $validatedData['color'];
        $vehicle->number_plate = $validatedData['number_plate'];
        $vehicle->available_seats = $validatedData['available_seats'];
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update($validatedData);

        // // Redirect to the vehicle's detail page or any other desired action
        // return redirect()->route('vehicles.show', $vehicle->id);
        return response()->json(['status' => "success", 'message' => 'Vehicle Updated Successfully']);
    }

    function updateImage(Request $request){
        $user = auth()->user();
        //here we are geeting userid alogn with an image
        $vehicleId = $request->vehicle_id;

        $vehicle = Vehicle::findOrFail($vehicleId);

        $imageData = $vehicle->images;

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
            $imageName = $user->name . '_' . $user->id . '_' . $vehicle->name . '_' . $vehicle->id . '_' . now()->format('Ymd_His') . '.' . $image->getClientOriginalExtension();

            // Move the uploaded file to a designated storage location
            $image->storeAs('vehicle_images', $imageName);

            // $request->file('file')->move(public_path() . '/uploads/images/', $imageName);

            // Get the existing image data from the database
            $existingImages = $vehicle->images ?? [];
            $path = 'storage/vehicle_images/' . $imageName;
            // Create a new image data array
            $newImageData = [
                'image' => $imageName,
                // 'path' => public_path('images'),
                'path' => $path,
            ];

            // Add the new image data to the existing images
            $updatedImages = array_merge($existingImages, [$newImageData]);

            // Update the images column with the updated image data
            $vehicle->where('id', $vehicleId)->update(['images' => $updatedImages]);

            return response()->json(['status' => "success", 'message' => 'Image uploaded successfully', 'imgdata' => $imageName, 'vehicle_id' => $vehicleId]);
        }
        // Handle the case where no file was uploaded
        return response()->json(['status' => 'error', 'message' => 'No image file uploaded.']);
    }

    function deleteImage(Request $request)
    {
        $imageData = $request->image;
        $vehicle_id = $request->id;
        // Get the image path from the database

        $imagePath = Vehicle::where('id', $vehicle_id)->value('images');

        if (empty($imagePath)) {
            return response()->json(['status' => "success", 'message' => 'No image found']);
        }

        // Decode the JSON string to an array
        $imageArray = $imagePath;

        // Search for the image and remove it from the array
        $updatedImages = array_filter($imageArray, function ($item) use ($imageData) {
            return $item['path'] !== $imageData;
        });

        // If the image was not found in the array, return an error response
        if (count($imageArray) === count($updatedImages)) {
            return response()->json(['status' => 'error', 'message' => 'Image not found']);
        }

        // Encode the updated array back to JSON
        $updatedImagePath = array_values($updatedImages);

        // Update the image path in the database
        Vehicle::where('id', $vehicle_id)->update(['images' => $updatedImagePath]);
        return response()->json(['status' => "success", 'message' => 'Image deleted successfully', 'imagePath' => $imagePath, 'vehicle_id' => $vehicle_id, 'imageData' => $imageData, 'updatedImages' => $updatedImages, 'updatedImagePath' => $updatedImagePath]);

        // // Delete the image file from the storage folder
        // if (file_exists(public_path($imagePath))) {
        //     unlink(public_path($imagePath));
        // }

        // // Delete the image record from the database
        // // Assuming you have a model called Image for the image table
        // $image = Image::where('path', $imagePath)->first();
        // if ($image) {
        //     $image->delete();
        // }
    }


    // Remove the specified vehicle from the database
    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();

        // Redirect to the vehicle list or any other desired action
        return redirect()->route('vehicles.index');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
        ]);

        $imageName = time() . '.' . $request->image->extension();

        $request->image->move(public_path('images'), $imageName);

        return response()->json(['success' => true, 'image' => $imageName]);
    }

    public function upload()
    {
        return view('multiupload');
    }

    public function fileStore(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'file' => 'required',
        ]);
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);

        // $imageUpload = new Vehicle();
        // $imageUpload->user_id = $user->id;
        // $jsonData = [
        //     'image' => $imageName,
        //     'path' => public_path('images'),
        // ];
        // $imageUpload->images = $jsonData;
        // $imageUpload->save();
        return response()->json(['success' => $imageName]);
    }

    public function list(Request $request)
    {
        $user = auth()->user();
        $vehicles = Vehicle::where('user_id', $user->id)->get();
        return view('vehicles.list', compact('vehicles'));
    }
}
