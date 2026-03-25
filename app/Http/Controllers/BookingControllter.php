<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Passenger;
use App\Models\Booking;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingControllter extends Controller
{
    
    public function bookingList()
    {
    
        $query = Booking::query();
        if (request('id')) {
            $query->where('user_id', request('id'));
        }
        if (request('name')) {
            $query->where('name', 'like', '%' . request('name') . '%');
        }
        if (request('booked_date')) {
            $ex = explode('-',request('booked_date'));
            $booked_date = $ex[2].'-'.$ex[1].'-'.$ex[0];
            $query->where('booked_date', $booked_date);
        }
        if(request('status')) {
            $query->where('status', 'like', '%' . request('status') . '%');
        }
        
            $query->orderBy('id', 'desc');
        $perpage = request('perpage', Config::get('pagination.per_page', 10));

        $bookings = $query->latest()->paginate($perpage);
        return view('booking.booking-list', compact('bookings'));
       
    }

    public function booking()
    {
        $id = request()->query('id');
        $passengerData = Passenger::where('id', $id)->first();
        $pick_addresses = DB::table('passenger_addresses')->where('user_id', $passengerData->id)->where('address_type','PICK')->get();
        $drop_addresses = DB::table('passenger_addresses')->where('user_id', $passengerData->id)->where('address_type','DROP')->get();
        $pickdrop_addresses = DB::table('passenger_addresses')->where('user_id', $passengerData->id)->get();
        return view('booking.passenger-booking', compact('passengerData', 'pick_addresses', 'drop_addresses', 'pickdrop_addresses'));
    }

    public function shiftTime(Request $request)
    {
        $shift_name = $request->query('shift_name');
        $booking_dates = $request->query('booking_dates');
        $route_name = $request->query('city_name');
        $shift_status = strtolower($shift_name);
        $triger = 0;
        $current_userid = 1;
        $cut_date = '';
//return $booking_dates;
        foreach($booking_dates as $booked_date){
          $timecutCount = DB::table('booking_timecut')->where('datecut',$booked_date)->where($shift_status.'_status',1)->count();
         if($timecutCount == 1){
             $triger = 1;
             $cut_date = $booked_date;
         }
         }

         if($triger == 0){
            $shiftCount = DB::table('shifts')->where('shift_name',$shift_name)->where('route_name',$route_name)->orderBy('time_order', 'ASC')->count();
             
            if ($shiftCount > 0) {
                $shift = DB::table('shifts')->where('shift_name',$shift_name)->where('route_name',$route_name)->orderBy('time_order', 'ASC')->get();
                $status = 200;
            }else{
                $status = 400;
                $shift = array();
            }
        
         }else{
             $status = 300;
             $shift = $cut_date.'_'.$shift_status;
             
             
             if($current_userid == 1){
                 $shiftCount = DB::table('shifts')->where('shift_name',$shift_name)->where('route_name',$route_name)->orderBy('time_order', 'ASC')->count();
             
                if ($shiftCount > 0) {
                    $shift = DB::table('shifts')->where('shift_name',$shift_name)->where('route_name',$route_name)->orderBy('time_order', 'ASC')->get();
                    $status = 200;
                }else{
                    $status = 400;
                    $shift = array();
                }
             }
         }


       

        return response()->json([
            'status' => $status,
            'data' => $shift,
        ]);

    }
    public function bookingPost(Request $request){

    $subpoint = Helpers::getSubpointName($request->postal_code);
    if (!$subpoint) {
        $subpoint = 'Empty';
    }
    
    $dropsubpoint = Helpers::getSubpointName($request->droppostal_code);
    if (!$dropsubpoint) {
        $dropsubpoint = 'Empty';
    }

    if(!empty($request->selectgoingaddress)){

        $pickaddress = $request->selectgoingaddress;
    }else{
        $pickaddress = $request->goingpickupaddress;
        
            DB::table('passenger_addresses')->insert([
                'user_id' => $request->passenger_id,
                'address_type' => 'PICK',
                'typeset' => 'secondary',
                'address' => $pickaddress,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'subpoint' => $subpoint,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'status' => 1,
            ]);

    }

    if(!empty($request->selectaddress)){
        
        $dropaddress = $request->selectaddress;
    }else{
        $dropaddress = $request->goingdropupaddress;

        DB::table('passenger_addresses')->insert([
            'user_id' => $request->passenger_id,
            'address_type' => 'DROP',
            'typeset' => 'secondary',
            'address' => $dropaddress,
            'city' => $request->dropcity,
            'postal_code' => $request->droppostal_code,
            'subpoint' => $dropsubpoint,
            'latitude' => $request->droplatitude,
            'longitude' => $request->droplongitude,
            'status' => 1,
        ]);
    }

    

        $booking = new Booking();
        $booking->user_id = $request->passenger_id;
        $booking->name = $request->name;
        $booking->mobile = $request->contact;
        $booking->email = $request->email;
        $booking->booked_date = $request->booking_date;
        $booking->shift = $request->booking_shift;
        $booking->booked_time = $request->booking_time;
        $ex = explode(' ',$request->booking_time);
        $booking->time_order = str_replace(':','',$ex[0]);

        $booking->pickup_location = $pickaddress;
        $booking->pickup_subpoint = $subpoint;
        $booking->pickup_city = $request->city;
        
        $booking->pickup_postal_code = $request->postal_code;
        $booking->pickup_lat = $request->latitude;
        $booking->pickup_long = $request->longitude;

        $booking->dropup_location = $dropaddress;
        $booking->dropup_subpoint = $dropsubpoint;
        $booking->dropup_city = $request->dropcity;
        $booking->dropup_postal_code = $request->droppostal_code;
        $booking->dropup_lat = $request->droplatitude;
        $booking->dropup_long = $request->droplongitude;
        $booking->status = 1;

        $booking->save();


        // Drop off Booking

        $subpoint = Helpers::getSubpointName($request->return_pickuppostal_code);
    if (!$subpoint) {
        $subpoint = 'Empty';
    }
    
    $dropsubpoint = Helpers::getSubpointName($request->return_droppostal_code);
    if (!$dropsubpoint) {
        $dropsubpoint = 'Empty';
    }

    if(!empty($request->returnpickupselectaddress)){

        $pickaddress = $request->returnpickupselectaddress;
    }else{
        $pickaddress = $request->returnpickupaddress;
        
            DB::table('passenger_addresses')->insert([
                'user_id' => $request->passenger_id,
                'address_type' => 'DROP',
                'typeset' => 'secondary',
                'address' => $pickaddress,
                'city' => $request->return_pickupcity,
                'postal_code' => $request->return_pickuppostal_code,
                'subpoint' => $subpoint,
                'latitude' => $request->return_pickuplatitude,
                'longitude' => $request->return_pickuplongitude,
                'status' => 1,
            ]);

    }

    if(!empty($request->returndropselectaddress)){
        
        $dropaddress = $request->returndropselectaddress;
    }else{
        $dropaddress = $request->return_dropaddress;

        DB::table('passenger_addresses')->insert([
            'user_id' => $request->passenger_id,
            'address_type' => 'PICK',
            'typeset' => 'secondary',
            'address' => $dropaddress,
            'city' => $request->dropcity,
            'postal_code' => $request->droppostal_code,
            'subpoint' => $dropsubpoint,
            'latitude' => $request->droplatitude,
            'longitude' => $request->droplongitude,
            'status' => 1,
        ]);
    }

    

        $booking = new Booking();
        $booking->user_id = $request->passenger_id;
        $booking->name = $request->name;
        $booking->mobile = $request->contact;
        $booking->email = $request->email;
        $booking->booked_date = $request->return_booking_date;
        $booking->shift = $request->return_booking_shift;
        $booking->booked_time = $request->return_booking_time;
        $ex = explode(' ',$request->return_booking_time);
        $booking->time_order = str_replace(':','',$ex[0]);

        $booking->pickup_location = $dropaddress;
        $booking->pickup_subpoint = $subpoint;
        $booking->pickup_city = $request->city;
        
        $booking->pickup_postal_code = $request->postal_code;
        $booking->pickup_lat = $request->latitude;
        $booking->pickup_long = $request->longitude;

        $booking->dropup_location = $dropaddress;
        $booking->dropup_subpoint = $dropsubpoint;
        $booking->dropup_city = $request->dropcity;
        $booking->dropup_postal_code = $request->droppostal_code;
        $booking->dropup_lat = $request->droplatitude;
        $booking->dropup_long = $request->droplongitude;
        $booking->status = 1;

        $booking->save();

        $passenger = Passenger::findOrFail($request->passenger_id);

        return redirect()->route('booking.list')->with('message', 'Your Booking Successfully Submitted.');
      

    }
    public function singleStore(Request $request){
     

    $subpoint = Helpers::getSubpointName($request->single_pickuppostal_code);
    if (!$subpoint) {
        $subpoint = 'Empty';
    }
    
    $dropsubpoint = Helpers::getSubpointName($request->droppostal_code);
    if (!$dropsubpoint) {
        $dropsubpoint = 'Empty';
    }

    if(!empty($request->selectgoingaddress)){

        $pickaddress = $request->selectgoingaddress;
    }else{
        $pickaddress = $request->goingpickupaddress;
        
            DB::table('passenger_addresses')->insert([
                'user_id' => $request->passenger_id,
                'address_type' => 'PICK',
                'typeset' => 'secondary',
                'address' => $pickaddress,
                'city' => $request->single_pickupcity,
                'postal_code' => $request->single_pickuppostal_code,
                'subpoint' => $subpoint,
                'latitude' => $request->single_pickuplatitude,
                'longitude' => $request->single_pickuplongitude,
                'status' => 1,
            ]);

    }

    if(!empty($request->selectaddress)){
        
        $dropaddress = $request->selectaddress;
    }else{
        $dropaddress = $request->single_dropupaddress;

        DB::table('passenger_addresses')->insert([
            'user_id' => $request->passenger_id,
            'address_type' => 'DROP',
            'typeset' => 'secondary',
            'address' => $dropaddress,
            'city' => $request->dropcity,
            'postal_code' => $request->droppostal_code,
            'subpoint' => $dropsubpoint,
            'latitude' => $request->droplatitude,
            'longitude' => $request->droplongitude,
            'status' => 1,
        ]);
    }

    

        $booking = new Booking();
        $booking->user_id = $request->passenger_id;
        $booking->name = $request->name;
        $booking->mobile = $request->contact;
        $booking->email = $request->email;
        $booking->booked_date = $request->booking_date;
        $booking->shift = $request->booking_shift;
        $booking->booked_time = $request->booking_time;
        $ex = explode(' ',$request->booking_time);
        $booking->time_order = str_replace(':','',$ex[0]);

        $booking->pickup_location = $pickaddress;
        $booking->pickup_subpoint = $subpoint;
        $booking->pickup_city = $request->single_pickupcity;
        
        $booking->pickup_postal_code = $request->single_pickuppostal_code;
        $booking->pickup_lat = $request->single_pickuplatitude;
        $booking->pickup_long = $request->single_pickuplongitude;

        $booking->dropup_location = $dropaddress;
        $booking->dropup_subpoint = $dropsubpoint;
        $booking->dropup_city = $request->dropcity;
        $booking->dropup_postal_code = $request->droppostal_code;
        $booking->dropup_lat = $request->droplatitude;
        $booking->dropup_long = $request->droplongitude;
        $booking->status = 1;

        $booking->save();
    
        return redirect()->route('booking.list')->with('message', 'Your Booking Successfully Submitted.');

    }

    public function bookingEdit(Request $request){
        $id = $request->query('id');
        $bookingData = Booking::where('id', $id)->first();
        $pick_addresses = DB::table('passenger_addresses')->where('user_id', $bookingData->user_id)->where('address_type','PICK')->get();
        $drop_addresses = DB::table('passenger_addresses')->where('user_id', $bookingData->user_id)->where('address_type','DROP')->get();
        return view('booking.booking-edit', compact('bookingData','pick_addresses','drop_addresses'));
    }

    public function bookingUpdate(Request $request){

        $id = $request->query('id');
        $booking = Booking::findOrFail($id);
        
        $subpoint = Helpers::getSubpointName($request->single_pickuppostal_code);
    if (!$subpoint) {
        $subpoint = 'Empty';
    }
    
    $dropsubpoint = Helpers::getSubpointName($request->droppostal_code);
    if (!$dropsubpoint) {
        $dropsubpoint = 'Empty';
    }

    if(!empty($request->selectgoingaddress)){

        $pickaddress = $request->selectgoingaddress;
    }else{
        $pickaddress = $request->goingpickupaddress;
        
            DB::table('passenger_addresses')->insert([
                'user_id' => $request->passenger_id,
                'address_type' => 'PICK',
                'typeset' => 'secondary',
                'address' => $pickaddress,
                'city' => $request->single_pickupcity,
                'postal_code' => $request->single_pickuppostal_code,
                'subpoint' => $subpoint,
                'latitude' => $request->single_pickuplatitude,
                'longitude' => $request->single_pickuplongitude,
                'status' => 1,
            ]);

    }

    if(!empty($request->selectaddress)){
        
        $dropaddress = $request->selectaddress;
    }else{
        $dropaddress = $request->single_dropupaddress;

        DB::table('passenger_addresses')->insert([
            'user_id' => $request->passenger_id,
            'address_type' => 'DROP',
            'typeset' => 'secondary',
            'address' => $dropaddress,
            'city' => $request->dropcity,
            'postal_code' => $request->droppostal_code,
            'subpoint' => $dropsubpoint,
            'latitude' => $request->droplatitude,
            'longitude' => $request->droplongitude,
            'status' => 1,
        ]);
    }

    
        $booking->user_id = $request->passenger_id;
        $booking->name = $request->name;
        $booking->mobile = $request->contact;
        $booking->email = $request->email;
        $booking->booked_date = $request->booking_date;
        $booking->shift = $request->booking_shift;
        $booking->booked_time = $request->booking_time;
        $ex = explode(' ',$request->booking_time);
        $booking->time_order = str_replace(':','',$ex[0]);

        $booking->pickup_location = $pickaddress;
        $booking->pickup_subpoint = $subpoint;
        $booking->pickup_city = $request->single_pickupcity;
        
        $booking->pickup_postal_code = $request->single_pickuppostal_code;
        $booking->pickup_lat = $request->single_pickuplatitude;
        $booking->pickup_long = $request->single_pickuplongitude;

        $booking->dropup_location = $dropaddress;
        $booking->dropup_subpoint = $dropsubpoint;
        $booking->dropup_city = $request->dropcity;
        $booking->dropup_postal_code = $request->droppostal_code;
        $booking->dropup_lat = $request->droplatitude;
        $booking->dropup_long = $request->droplongitude;

        $booking->save();

        return redirect()->back()->with('message', 'Booking Successfully Updated.');

    }
    public function bookingDelete(Request $request){

        $id = $request->query('booking_id');

        Booking::where('id', $id)->update(['status' => 0]);
        return 200;

    }

   

    public function bookingTimecut(Request $request){

        $bookingg['datecut'] = $request->cut_date;
        $bookingg['morning_status'] = $request->morning_status;
        $bookingg['afternoon_status'] = $request->afternoon_status;
        $bookingg['evening_status'] = $request->evening_status;
        $bookingg['night_status'] = $request->night_status;
        DB::table('booking_timecut')->where('id', 1)->update($bookingg);
        return 200;
    }

    public function shiftTimeAll($shift_name){
        $data = array();
      
         $shiftCount = DB::table('shifts')->where('shift_name',$shift_name)->where('status',1)->orderBy('time_order', 'ASC')->count();
         if($shiftCount > 0){
         $shifts = DB::table('shifts')->where('shift_name',$shift_name)->where('status',1)->orderBy('time_order', 'ASC')->get();
         foreach($shifts as $shift){
             $row = $shift->timing.' '.$shift->time_format;
             if(!in_array($row, $data)){
                 $data[] = $row;
             }
         }
         $status = 200;
         }else{
             $status = 400;
         }

        return response()->json([
            'data' => $data,
            'status' => $status
         ]);
    }

     

    public function bookingExport(Request $request){

        $startdate = $request->startdate;
        $dropupshift = $request->bookingshift;
        $dropupshifttime = $request->bookingshifttime;
        $bookingsuppoint = $request->suppoint;
        $pickup_city = ($request->going_city) ? $request->going_city : array();
        $dropup_city = ($request->return_city) ? $request->return_city : array();

        $query = Booking::query();
        $query->where('status',1);
        if($startdate){
            $ex = explode('-',$startdate);
            $booked_date = $ex[2].'-'.$ex[1].'-'.$ex[0];
            $query->where('booked_date', $booked_date);
        }
        if($dropupshift){
            $query->where('shift', $dropupshift);
        }
        if($dropupshifttime){
            $query->where('shift_time', $dropupshifttime);
        }
        if(!empty($pickup_city) && !empty($dropup_city)){
            $query->whereIn('pickup_city', $pickup_city)->whereIn('dropup_city', $dropup_city);
        }
        if(!empty($pickup_city)){
            $query->whereIn('pickup_city', $pickup_city);
        }
        if(!empty($dropup_city)){
            $query->whereIn('dropup_city', $dropup_city);
        }

        $query->orderBy('id', 'desc');
        
        $bookings = $query->get();
        $timecut = DB::table('booking_timecut')->where('id', 1)->first();
        $cities = DB::table('cities')->where('status', 1)->get();
        return view('booking.booking-export', compact('bookings', 'timecut', 'cities'));
    }

    public function exportListCSV(Request $request){
        $startdate = $request->startdate;
        $dropupshift = $request->bookingshift;
        $dropupshifttime = $request->bookingshifttime;
        $bookingsuppoint = $request->suppoint;
        $pickup_city = ($request->going_city) ? $request->going_city : array();
        $dropup_city = ($request->return_city) ? $request->return_city : array();

        $query = Booking::query();
        $query->where('status',1);
        if($startdate){
            $ex = explode('-',$startdate);
            $booked_date = $ex[2].'-'.$ex[1].'-'.$ex[0];
            $query->where('booked_date', $booked_date);
        }
        if($dropupshift){
            $query->where('shift', $dropupshift);
        }
        if($dropupshifttime){
            $query->where('shift_time', $dropupshifttime);
        }
        if(!empty($pickup_city) && !empty($dropup_city)){
            $query->whereIn('pickup_city', $pickup_city)->whereIn('dropup_city', $dropup_city);
        }
        if(!empty($pickup_city)){
            $query->whereIn('pickup_city', $pickup_city);
        }
        if(!empty($dropup_city)){
            $query->whereIn('dropup_city', $dropup_city);
        }

        $query->orderBy('id', 'desc');
        
        $bookings = $query->latest()->get();

        $filename = 'bookings_' . date('dmY') . '.xls';
        ///$handle = fopen($filename, 'w+');
        //fputcsv($handle, ['#','Name','Mobile', 'Date',  'Subpoint', 'PostalCode', 'PickupAddress', 'City', 'DropCity', 'DropAddress', 'DropPostalCode', 'DropSubpoint']);

        // Start HTML table
    $html = '<table border="1">';
    $html .= '<tr>';
    $html .= '<th>#</th><th>Name</th><th>Mobile</th><th>Date</th><th>Subpoint</th><th>PostalCode</th><th>PickupAddress</th><th>City</th><th>DropCity</th><th>DropAddress</th><th>DropPostalCode</th><th>DropSubpoint</th>';
    $html .= '</tr>';

    foreach ($bookings as $key => $booking) {
        if (strtoupper($booking->pickup_city) == 'KITCHENER') {
            $color = '#fce4d6'; // Light Blue
        } elseif (strtoupper($booking->pickup_city) == 'CAMBRIDGE') {
            $color = '#c6e0b4'; // Light Green
        } elseif (strtoupper($booking->pickup_city) == 'WATERLOO') {
            $color = '#ddebf7'; // Light Pink
        } elseif (strtoupper($booking->pickup_city) == 'BRESLAU') {
            $color = '#F54927'; // Light Green
        } elseif (strtoupper($booking->pickup_city) == 'CONESTOGO') {
            $color = '#FFFFFF'; // Light Pink
        }elseif (strtoupper($booking->pickup_city) == 'ARISS') {
            $color = '#FFFFFF'; // Light Green
        } elseif (strtoupper($booking->pickup_city) == 'GUELPH') {
            $color = '#FFFFFF'; // Light Pink
        }elseif (strtoupper($booking->pickup_city) == 'MARYHILL') {
            $color = '#FFFFFF'; // Light Green
        } elseif (strtoupper($booking->pickup_city) == 'DUNDEE') {
            $color = '#FFFFFF'; // Light Pink
        }else {
            $color = '#FFFFFF'; // Default White
        }

        $html .= '<tr style="background-color:' . $color . ';">';
        $html .= '<td>' . ($key + 1) . '</td>';
        $html .= '<td>' . $booking->name.'-'.$booking->user_id.' ('.$booking->pickup_subpoint.') ('.$booking->dropup_subpoint.')' . '</td>';
        $html .= '<td>' . $booking->mobile . '</td>';
        $html .= '<td>' . $booking->booked_date . '</td>';
        $html .= '<td>' . $booking->pickup_subpoint . '</td>';
        $html .= '<td>' . $booking->pickup_postal_code . '</td>';
        $html .= '<td>' . $booking->pickup_location . '</td>';
        $html .= '<td>' . $booking->pickup_city . '</td>';
        $html .= '<td>' . $booking->dropup_city . '</td>';
        $html .= '<td>' . $booking->dropup_location . '</td>';
        $html .= '<td>' . $booking->dropup_postal_code . '</td>';
        $html .= '<td>' . $booking->dropup_subpoint . '</td>';
        $html .= '</tr>';
    }

    $html .= '</table>';

    // Output headers to force download as Excel
    return response($html)
        ->header('Content-Type', 'application/vnd.ms-excel')
        ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
