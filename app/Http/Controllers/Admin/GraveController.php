<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grave;
use Illuminate\Support\Facades\Storage;

class GraveController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()?->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        $query = $request->input('search'); // Get the search query from the request
        

        $graves = Grave::when($query, function ($q) use ($query) {
        $q->where('name', 'like', '%' . $query . '%') // Search by name
          ->orWhere('ic_number', 'like', '%' . $query . '%') // Search by IC number
          ->orWhere('plot_number', 'like', '%' . $query . '%') // Search by plot number
          ->orWhere('date_of_death', 'like', '%' . $query . '%'); // Search by date of death
    })->get();
        //$graves = Grave::all();
        return view('admin.graves.index', compact('graves'));
    }

    public function create()
    {
        return view('admin.graves.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'ic_number' => 'nullable|string|max:255',
            'date_of_death' => 'required|date',
            'plot_number' => 'required',
            'gps_lat' => 'required|string|max:255',
            'gps_lng' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10000', // Validate the image
        ]);

        $photoPath = null;

       
       // Check if a photo is uploaded
    if ($request->hasFile('photo')) {
        // Store the uploaded file in the 'public/photos' directory
        $photoPath = $request->file('photo')->store('photos', 'public');
        // Debugging: Check the file path
        //dd($photoPath);
    }  

        // Save the grave record with the photo path
    Grave::create([
        'name' => $request->input('name'),
        'ic_number' => $request->input('ic_number'),
        'date_of_death' => $request->input('date_of_death'),
        'plot_number' => $request->input('plot_number'),
        'gps_lat' => $request->input('gps_lat'),
        'gps_lng' => $request->input('gps_lng'),
        'photo' => $photoPath, // Save the file path
        
    ]);
        return redirect()->route('graves.index')->with('success', 'Grave added successfully');
    }

    public function edit(Grave $grave)
    {
        return view('admin.graves.edit', compact('grave'));
    }

    public function update(Request $request, Grave $grave)
    {
        // Validate the form inputs
    $request->validate([
        'name' => 'required|string|max:255',
        'ic_number' => 'nullable|string|max:255',
        'date_of_death' => 'required|date',
        'plot_number' => 'required|string|max:255',
        'gps_lat' => 'required|string|max:255',
        'gps_lng' => 'required|string|max:255',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the image
    ]);

    // Handle the photo upload
    $photoPath = $grave->photo; // Keep the existing photo path

    if ($request->hasFile('photo')) {
        // Delete the old photo if it exists
        if ($photoPath) {
            Storage::disk('public')->delete($photoPath);
        }

        // Store the new photo
        $photoPath = $request->file('photo')->store('photos', 'public');
    }

    // Update the grave record
    $grave->update([
        'name' => $request->input('name'),
        'ic_number' => $request->input('ic_number'),
        'date_of_death' => $request->input('date_of_death'),
        'plot_number' => $request->input('plot_number'),
        'gps_lat' => $request->input('gps_lat'),
        'gps_lng' => $request->input('gps_lng'),
        'photo' => $photoPath, // Save the new or existing photo path
    ]);
        return redirect()->route('graves.index')->with('success', 'Grave updated');
    }

    public function destroy(Grave $grave)
    {
        // Check if the grave has a photo
        

        $grave->delete();
        return redirect()->route('graves.index')->with('success', 'Grave deleted');
    }

    
}