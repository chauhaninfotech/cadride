<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Helper\Helper;

class PassengerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Passenger::query();
        if (request('id')) {
            $query->where('id', request('id'));
        }
        if (request('name')) {
            $query->where('fullname', 'like', '%' . request('name') . '%');
        }
        if (request('contact')) {
            $query->where('contact', 'like', '%' . request('contact') . '%');
        }
        
            $query->where('status', 1);
        
        $passengers = $query->latest()->paginate(Config::get('pagination.per_page'));
        return view('user.passenger-list', compact('passengers'));
    }

    public function passengerAdd()
    {
        return view('user.passenger-add');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->input('city') && $request->input('postal_code')) {
            $subpoint = Helpers::getSubpointName($request->input('postal_code'));
            if (!$subpoint) {
                return redirect()->back()->with('error', 'Subpoint Not Found. Please check the city and postal code.');
            }
        } 
        
        $table = new Passenger();
        $table->fullname = $request->input('fullname');
        $table->email = $request->input('email');
        $table->country_code = $request->input('country_code');
        $table->contact = $request->input('contact');
        $table->password = Hash::make($request->input('password'));
        $table->address = $request->input('address');   
        $table->city = $request->input('city');
        $table->subpoint = $subpoint;
        $table->postal_code = $request->input('postal_code');
        $table->latitude = $request->input('latitude');
        $table->longitude = $request->input('longitude');

        $table->verify = 0;
        $table->status = 1;
        $table->is_first_booking =  0;
        if ($request->hasFile('user_image')) {
            $table->user_image = $request->file('user_image')->store('passengers', 'public');
        }
        $table->save();

        if($table->id){
            DB::table('passenger_addresses')->insert([
                'passenger_id' => $table->id,
                'typeset' => 'primary',
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'postal_code' => $request->input('postal_code'),
                'subpoint' => $subpoint,
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'status' => 1,
            ]);
        }
        return redirect()->route('passenger-add')->with('success', 'Passenger added successfully');
    }

    public function toggleVerify(Request $request)
    {
        $passenger = Passenger::findOrFail($request->id);
        $passenger->verify = !$passenger->verify;
        $passenger->save();
        

        return response()->json(['success' => true, 'message' => 'Passenger verification status updated successfully']);
    }

    public function toggleStatus(Request $request)
    {
        $passenger = Passenger::findOrFail($request->id);
        $passenger->status = !$passenger->status;
        $passenger->save();

        return response()->json(['success' => true, 'message' => 'Passenger status updated successfully']);
    }

    public function edit(Request $request)
    {   $id = $request->query('id');
        $passenger = Passenger::findOrFail($id);
        return view('user.passenger-edit', compact('passenger'));
    }

    public function bookings(Request $request, string $id)
    {
        $passenger = Passenger::findOrFail($id);
        $bookings = $passenger->bookings()->latest()->get();
        return view('user.passenger-bookings', compact('passenger', 'bookings'));
    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $passenger = Passenger::findOrFail($id);
        return response()->json($passenger);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if ($request->input('city') && $request->input('postal_code')) {
            $subpoint = Helpers::getSubpointName($request->input('postal_code'));
            if (!$subpoint) {
                return redirect()->back()->with('error', 'Subpoint Not Found. Please check the city and postal code.');
            }
        } 
        $id = $request->input('id');
        $passenger = Passenger::findOrFail($id);
        $passenger->fullname = $request->input('fullname');
        $passenger->email = $request->input('email');
        $passenger->country_code = $request->input('country_code');
        $passenger->contact = $request->input('contact');
        $passenger->address = $request->input('address');
        $passenger->city = $request->input('city');
        $passenger->postal_code = $request->input('postal_code');
        $passenger->subpoint = $subpoint;
        $passenger->latitude = $request->input('latitude');
        $passenger->longitude = $request->input('longitude');
    
        $passenger->status = $request->input('status');

        if ($request->hasFile('user_image')) {
            // Delete old image if exists
            if ($passenger->user_image) {
                Storage::disk('public')->delete($passenger->user_image);
            }
            $passenger->user_image = $request->file('user_image')->store('passengers', 'public');
        }
        $passenger->save();
        if($passenger->id){
            DB::table('passenger_addresses')->where('passenger_id', $passenger->id)->where('typeset', 'primary')->update([
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'postal_code' => $request->input('postal_code'),
                'subpoint' => $subpoint,
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'status' => 1,
            ]);
        }
        return redirect()->back()->with('success', 'Passenger updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
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
