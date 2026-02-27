<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Rider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RiderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        $query = Rider::query();
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

        $riders = $query->latest()->paginate($perpage);
        return view('rider.rider-list', compact('riders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function show(Request $request)
    {
        $rider = Rider::findOrFail($request->input('id'));
        $addresses = DB::table('rider_addresses')->where('rider_id', $rider->id)->get();
        $shiftsAll = DB::table('shifts')->where('status', 1)->get();
        $slotAddress = DB::table('rider_shifts')->where('rider_id', $rider->id)->where('shift_date',date('Y-m-d'))->first();
        if(!$slotAddress){
            $slot = [];
            $addressSlot = [];
            $slotAddress2 = [];
        }else{
            $slotAddress->going_slot = json_decode($slotAddress->going_slot, true);
            $slotAddress->return_slot = json_decode($slotAddress->return_slot, true);
            $addressSlot = DB::table('rider_addresses')->where('rider_id', $rider->id)->where('id', $slotAddress->address_id)->first();

            
        }
      
		//$shiftAvaility = DB::table('driver_shift')->where('status', 1)->get();
		$shifts = array();
		$shiftArr = array();
		foreach($shiftsAll as $shift){
             $row = $shift->timing.' '.$shift->time_format;
             if(!in_array($row, $shiftArr)){
                 $shiftArr[] = $row;
                 $shifts[$shift->shift_name][] = $row;
             }
         } 


        return view('rider.rider-view', compact('rider', 'addresses', 'shifts','slotAddress','addressSlot'));
    }

    public function riderAdd()
    {
        return view('rider.rider-add');
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
            $existingRider = Rider::where('email', $request->input('email'))->first();
            if ($existingRider) {
                return redirect()->back()->withInput()->with('error', 'Email already exists. Please use a different email address.');
            }
        }
        if($request->input('contact')){
            $existingRiderContact = Rider::where('contact', $request->input('contact'))->first();
            if ($existingRiderContact) {
                return redirect()->back()->withInput()->with('error', 'Contact number already exists. Please use a different contact number.');
            }
        }

        $table = new Rider();
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
   
        if ($request->hasFile('user_image')) {
            $table->user_image = $request->file('user_image')->store('riders', 'public');
        }
      
         if ($request->hasFile('license_photo')) {
            $table->license_photo = $request->file('license_photo')->store('riders', 'public');
        }
        $table->save();

        if($table->id){
            DB::table('rider_addresses')->insert([
                'rider_id' => $table->id,
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
        return redirect()->route('rider-add')->with('success', 'Rider added successfully');
    }
    

    public function pendingList()
    {
        $query = Rider::query();
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
        $riders = $query->latest()->paginate($perpage);
        return view('rider.rider-pendinglist', compact('riders'));
    }
    public function inactiveList()
    {
        $query = Rider::query();
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
        $riders = $query->latest()->paginate($perpage);
        return view('rider.rider-inactivelist', compact('riders'));
    }

    public function exportList()
    {
        $subpoints = [];
        $query = Rider::query();

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
        $riders = $query->latest()->paginate($perpage);
        
        return view('rider.rider-exportlist', compact('riders', 'cities', 'subpoints'));
    }

    public function exportListCSV()
    {
        $query = Rider::query();

        if (request('city') ) {
            $query->where('city', request('city'));
        }
        if (request('subpoint')) {
            $query->where('subpoint', request('subpoint'));
        }

        $riders = $query->latest()->get();

        $filename = 'riders_' . date('Ymd') . '.csv';
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['ID', 'Full Name', 'Email', 'Contact', 'Address', 'City', 'Subpoint', 'Status']);

        foreach ($riders as $rider) {
            fputcsv($handle, [
                $rider->id,
                $rider->fullname,
                $rider->email,
                $rider->contact,
                $rider->address,
                $rider->city,
                $rider->subpoint,
                $rider->status == 1 ? 'Active' : ($rider->status == 0 ? 'Inactive' : 'Pending'),
            ]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }   

    public function bulkActivate(Request $request)
    {
        $ids = $request->input('ids', []);
        Rider::whereIn('id', $ids)->update(['status' => 1]);
        return response()->json(['message' => 'Selected riders have been activated.']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {   $id = $request->query('id');
        $rider = Rider::findOrFail($id);
        return view('rider.rider-edit', compact('rider'));
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
                $existingRider = Rider::where('email', $request->input('email'))->where('id', '!=', $request->input('id'))->first();
                if ($existingRider) {
                    return redirect()->back()->withInput()->with('error', 'Email already exists. Please use a different email address.');
                }
            }
            if($request->input('contact')){
                $existingRiderContact = Rider::where('contact', $request->input('contact'))->where('id', '!=', $request->input('id'))->first();
                if ($existingRiderContact) {
                    return redirect()->back()->withInput()->with('error', 'Contact number already exists. Please use a different contact number.');
                }
            }
        $id = $request->input('id');
        $rider = Rider::findOrFail($id);
        $rider->fullname = $request->input('fullname');
        $rider->email = $request->input('email');
        $rider->country_code = $request->input('country_code');
        $rider->contact = $request->input('contact');
        $rider->address = $request->input('address');
        $rider->city = $request->input('city');
        $rider->postal_code = $request->input('postal_code');
        $rider->subpoint = $subpoint;
        $rider->latitude = $request->input('latitude');
        $rider->longitude = $request->input('longitude');
    
        $rider->status = $request->input('status');

        if ($request->hasFile('user_image')) {
            // Delete old image if exists
            if ($rider->user_image) {
                Storage::disk('public')->delete($rider->user_image);
            }
            $rider->user_image = $request->file('user_image')->store('riders', 'public');
        }
        $rider->save();
        if($rider->id){
            DB::table('rider_addresses')->where('rider_id', $rider->id)->where('typeset', 'primary')->update([
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'postal_code' => $request->input('postal_code'),
                'subpoint' => $subpoint,
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'status' => 1,
            ]);
        }
        return redirect()->back()->with('success', 'Rider updated successfully');
    }

        public function updateRiderView(Request $request)
        {
            $id = $request->input('rider_id');
            $rider = DB::table('riders')->find($id);
            if (!$rider) {
                return redirect()->back()->with('error', 'Rider not found.');
            }

            if($request->input('selectaddress')){
                $address_id = $request->input('selectaddress');
            } else {
                
            if ($request->input('city') && $request->input('postal_code')) {
                $subpoint = Helpers::getSubpointName($request->input('postal_code'));
                if (!$subpoint) {
                    $subpoint = 'Empty';
                }
            } 
            if(!empty($request->input('address'))){

                    DB::table('rider_addresses')->insert([
                    'rider_id' => $id,
                    'typeset' => 'secondary',
                    'address' => $request->input('address'),
                    'city' => $request->input('city'),
                    'postal_code' => $request->input('postal_code'),
                    'subpoint' => $subpoint,
                    'latitude' => $request->input('latitude'),
                    'longitude' => $request->input('longitude'),
                    'status' => 1,
                    ]);  

                    $address_id = DB::getPdo()->lastInsertId();
            }
                


            
            }          
            
            $shiftDate = date('Y-m-d');
            $shiftDay = date('l', strtotime($shiftDate));
            $goingTime = $request->input('going_time.' . $shiftDate, []);
            $returnTime = $request->input('return_time.' . $shiftDate, []);
            $slotDate = DB::table('rider_shifts')->where('rider_id', $id)->where('shift_date', $shiftDate)->count();
            if($slotDate > 0){
                DB::table('rider_shifts')->where('rider_id', $id)->where('shift_date', $shiftDate)->update([
                    'address_id' => $address_id,
                    'going_slot' => json_encode($goingTime),
                    'return_slot' => json_encode($returnTime),
                    'status' => 1,
                ]);
            } else {
                DB::table('rider_shifts')->updateOrInsert(
                    ['rider_id' => $id, 'address_id' => $address_id, 'shift_date' => $shiftDate],
                    [
                        'shift_day' => $shiftDay,
                        'going_slot' => json_encode($goingTime),
                    'return_slot' => json_encode($returnTime),
                    'status' => 1,
                ]
            );
            
            }
            
            return redirect()->back()->with('success', 'Rider availability updated successfully');
        }

        public function getAddressDetails($addressId)
        {
            $address = DB::table('rider_addresses')->where('id', $addressId)->first();
            if ($address) {
                return response()->json([
                    'success' => true,
                    'data' => $address
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Address not found'
                ], 404);
            }
        }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
