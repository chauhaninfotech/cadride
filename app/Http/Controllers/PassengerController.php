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
        $perpage = request('perpage', Config::get('pagination.per_page', 10));

        $passengers = $query->latest()->paginate($perpage);
        return view('user.passenger-list', compact('passengers'));
    }
    public function pendingList()
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
        
            $query->where('status', 2);
        $perpage = request('perpage', Config::get('pagination.per_page', 10));
        $passengers = $query->latest()->paginate($perpage);
        return view('user.passenger-pendinglist', compact('passengers'));
    }
    public function inactiveList()
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
        
            $query->where('status', 0);
        $perpage = request('perpage', Config::get('pagination.per_page', 10));
        $passengers = $query->latest()->paginate($perpage);
        return view('user.passenger-inactivelist', compact('passengers'));
    }

    public function getSubpoints($cityId)
    {
        $subpoints = DB::table('subpoints')->where('city_id', $cityId)->pluck('name', 'id');
        return response()->json($subpoints);
    }

    public function exportList()
    {
        $subpoints = [];
        $query = Passenger::query();

        $cities = DB::table('cities')->where('status', 1)->get();
        if (request('city') ) {
            $query->where('city', request('city'));
        }
        if (request('subpoint')) {
            $query->where('subpoint', request('subpoint'));
            $cityId = DB::table('cities')->where('name', request('city'))->value('id');
            $subpoints = DB::table('subpoints')->where('city_id', $cityId)->get();  
        }
        $perpage = request('perpage', Config::get('pagination.per_page', 10));
        $passengers = $query->latest()->paginate($perpage);
        
        return view('user.passenger-exportlist', compact('passengers', 'cities', 'subpoints'));
    }

    public function exportListCSV()
    {
        $query = Passenger::query();

        if (request('city') ) {
            $query->where('city', request('city'));
        }
        if (request('subpoint')) {
            $query->where('subpoint', request('subpoint'));
        }

        $passengers = $query->latest()->get();

        $filename = 'passengers_' . date('Ymd') . '.csv';
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['ID', 'Full Name', 'Email', 'Contact', 'Address', 'City', 'Subpoint', 'Status']);

        foreach ($passengers as $passenger) {
            fputcsv($handle, [
                $passenger->id,
                $passenger->fullname,
                $passenger->email,
                $passenger->contact,
                $passenger->address,
                $passenger->city,
                $passenger->subpoint,
                $passenger->status == 1 ? 'Active' : ($passenger->status == 0 ? 'Inactive' : 'Pending'),
            ]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
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
                $subpoint = 'Empty';
            }
        } 
        if($request->input('email')){
            $existingPassenger = Passenger::where('email', $request->input('email'))->first();
            if ($existingPassenger) {
                return redirect()->back()->withInput()->with('error', 'Email already exists. Please use a different email address.');
            }
        }
        if($request->input('contact')){
            $existingPassengerContact = Passenger::where('contact', $request->input('contact'))->first();
            if ($existingPassengerContact) {
                return redirect()->back()->withInput()->with('error', 'Contact number already exists. Please use a different contact number.');
            }
        }
        
        $table = new Passenger();
        $table->fullname = $request->input('fullname');
        $table->email = $request->input('email');
        $table->country_code = $request->input('country_code');
        $table->contact = $request->input('contact');
        $table->password = Hash::make(12345678);
        $table->address = $request->input('address');   
        $table->city = $request->input('city');
        $table->subpoint = $subpoint;
        $table->postal_code = $request->input('postal_code');
        $table->latitude = $request->input('latitude');
        $table->longitude = $request->input('longitude');

     
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


    public function bulkActivate(Request $request)
    {
        $ids = $request->input('ids', []);
        Passenger::whereIn('id', $ids)->update(['status' => 1]);
        return response()->json(['message' => 'Selected passengers have been activated.']);
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
    public function show(Request $request)
    {
        $id = $request->query('id');
        $passenger = Passenger::findOrFail($id);
        return view('user.passenger-view', compact('passenger'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if ($request->input('city') && $request->input('postal_code')) {
            $subpoint = Helpers::getSubpointName($request->input('postal_code'));
            if (!$subpoint) {
               $subpoint = 'Empty';
            }
        } 
            if($request->input('email')){
                $existingPassenger = Passenger::where('email', $request->input('email'))->where('id', '!=', $request->input('id'))->first();
                if ($existingPassenger) {
                    return redirect()->back()->withInput()->with('error', 'Email already exists. Please use a different email address.');
                }
            }
            if($request->input('contact')){
                $existingPassengerContact = Passenger::where('contact', $request->input('contact'))->where('id', '!=', $request->input('id'))->first();
                if ($existingPassengerContact) {
                    return redirect()->back()->withInput()->with('error', 'Contact number already exists. Please use a different contact number.');
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
