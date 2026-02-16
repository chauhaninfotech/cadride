<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PassengerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $passengers = Passenger::latest()->paginate(10);
        return response()->json($passengers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('passengers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'distributor' => 'nullable|string|max:255',
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:passengers,email',
            'country_code' => 'nullable|string|max:10',
            'contact' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'subpoint' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'passenger_type' => 'nullable|string|max:255',
            'tag' => 'nullable|string|max:255',
            'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role' => 'nullable|string|max:255',
            'otp_key' => 'nullable|string|max:255',
            'verify' => 'nullable|boolean',
            'status' => 'nullable|boolean',
            'fcm_token' => 'nullable|string|max:255',
            'is_first_booking' => 'nullable|boolean',
        ]);

        // Hash the password
        $validated['password'] = Hash::make($validated['password']);

        // Handle file upload
        if ($request->hasFile('user_image')) {
            $validated['user_image'] = $request->file('user_image')->store('passengers', 'public');
        }

        $passenger = Passenger::create($validated);

        return response()->json([
            'message' => 'Passenger created successfully',
            'data' => $passenger
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $passenger = Passenger::findOrFail($id);
        return response()->json($passenger);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $passenger = Passenger::findOrFail($id);
        return view('passengers.edit', compact('passenger'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $passenger = Passenger::findOrFail($id);

        $validated = $request->validate([
            'distributor' => 'nullable|string|max:255',
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|unique:passengers,email,' . $id,
            'country_code' => 'nullable|string|max:10',
            'contact' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'subpoint' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'passenger_type' => 'nullable|string|max:255',
            'tag' => 'nullable|string|max:255',
            'user_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role' => 'nullable|string|max:255',
            'otp_key' => 'nullable|string|max:255',
            'verify' => 'nullable|boolean',
            'status' => 'nullable|boolean',
            'fcm_token' => 'nullable|string|max:255',
            'is_first_booking' => 'nullable|boolean',
        ]);

        // Hash the password if provided
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Handle file upload
        if ($request->hasFile('user_image')) {
            // Delete old image if exists
            if ($passenger->user_image) {
                Storage::disk('public')->delete($passenger->user_image);
            }
            $validated['user_image'] = $request->file('user_image')->store('passengers', 'public');
        }

        $passenger->update($validated);

        return response()->json([
            'message' => 'Passenger updated successfully',
            'data' => $passenger
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $passenger = Passenger::findOrFail($id);

        // Delete user image if exists
        if ($passenger->user_image) {
            Storage::disk('public')->delete($passenger->user_image);
        }

        $passenger->delete();

        return response()->json([
            'message' => 'Passenger deleted successfully'
        ]);
    }
}
