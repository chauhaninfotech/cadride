<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Helpers\Helpers;
use App\Models\Passenger;
use App\Models\Rider;
use App\Models\Booking;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function subpoint_check($potalcode, $city)
    {
        if(!empty($potalcode)){
            
            $cityCount = DB::table('cities')->where('name',$city)->count();
            if($cityCount > 0){
                $cityDtata = DB::table('cities')->where('name',$city)->first();
                $dataCount = DB::table('postal_codes')->where('name',$potalcode)->where('city_id',$cityDtata->id)->count();
                if($dataCount == 0){
                    $potalcode = substr($potalcode,0,3);
                    $dataCount = DB::table('postal_codes')->where('name',$potalcode)->where('city_id',$cityDtata->id)->count();
                }
                
                if($dataCount == 0){
                    $subpoint = 'Empty';
                }else{
                    $data = DB::table('postal_codes')->where('name',$potalcode)->where('city_id',$cityDtata->id)->first();
                    $subpoint = $data->subpoint;
                }
            }else{
                $subpoint = 'Empty';
            }
        }else{
            $subpoint = 'Empty';
        }

        return $subpoint;
    }

    public function checkBookingSlot($pid, $shift, $date, $time){
    
        $bookingCount = DB::table('bookings')
                            ->where('user_id','=',$pid)
                            ->where('booked_date','=',$date)
                            ->where('shift','=',$shift)
                            ->where('booked_time','=',$time)
                            ->where('status','=',1)->count();
            return $bookingCount;
            
    }
    public function subpoint_check_id($potalcode, $city)
    {
        if(!empty($potalcode)){
            
            $cityCount = DB::table('cities')->where('name',$city)->count();
            if($cityCount > 0){
            $cityDtata = DB::table('cities')->where('name',$city)->first();
            $dataCount = DB::table('postal_codes')->where('name',$potalcode)->where('city_id',$cityDtata->id)->count();
            if($dataCount == 0){
                $potalcode = substr($potalcode,0,3);
                $dataCount = DB::table('postal_codes')->where('name',$potalcode)->where('city_id',$cityDtata->id)->count();
            }
          
            if($dataCount == 0){
                $subpoint = 'Empty';
            }else{
                $data = DB::table('postal_codes')->where('name',$potalcode)->where('city_id',$cityDtata->id)->first();
                $subpoint = $data->id;
            }
        }else{
            $subpoint = 'Empty';
        }
    }else{
            $subpoint = 'Empty';
        }

        return $subpoint;
    }
   
    public function apiLoginuser(Request $request)
    {
    $table = $request->role == 'passenger' ? 'passengers' : 'riders';
    $table2 = $request->role == 'passenger' ? 'passenger_addresses' : 'rider_addresses';
    $token = Str::random(30);
    
    $loginCount = DB::table($table)->where('email', $request->email)->orWhere('contact', $request->mobile)->count();
    if($loginCount > 0){
        
    $count = DB::table($table)->where('email', $request->email)->count();
    if($count > 0){
        $user = DB::table($table)->where('email', $request->email)->first();
    //return $request->password.'==='.$user->password;
        if($user->email == $request->email && Hash::check($request->password, $user->password)) {
        
            // Authentication successful
            if($user->status == '1' || ($user->status == '2' && $request->role == 'passenger') || ($user->status == '1' && $request->role == 'rider' && $user->status == '1')){
             
                DB::table($table)->where('id', $user->id)->update([
                    'otp_key' => $token
                ]);
                
                
                $userData = DB::table($table)->where('id', $user->id)->first();
                $address = DB::table($table2)->where('user_id', $user->id)->where('typeset', 'primary')->first();
        
                
                $data['id'] = $userData->id;
                $data['fullname'] = $userData->fullname;
                $data['email'] = $userData->email;
                $data['country_code'] = $userData->country_code;
                $data['contact'] = $userData->contact;
                $data['address'] = $address;
                $data['user_image'] = $userData->user_image;
                $data['status'] = $userData->status;
                $data['role'] = $userData->role;
                if($request->role == 'rider'){
                    $data['age'] = $userData->age;
                    $data['gender'] = $userData->age;
                    $data['vehicle_number'] = $userData->vehicle_number;
                    $data['vehicle_color'] = $userData->vehicle_color;
                    $data['vehicle_rc'] = $userData->vehicle_rc;
                    $data['vehicle_make'] = $userData->vehicle_make;
                    $data['vehicle_model'] = $userData->vehicle_model;
                    $data['license_number'] = $userData->license_number;
                    $data['license_photo'] = $userData->license_photo;
                }
                
                return response()->json(['data' => $data, 'message' => 'Login successful', 'access_token' => $token, 'token_type' => 'Bearer'], 200);
            }else{
                return response()->json(['message' => 'Your account is not active. Please contact support.'], 403);
            }
        }else{
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }
    $count = DB::table($table)->where('contact', $request->mobile)->count();
    if($count > 0){
        $user = DB::table($table)->where('contact', $request->mobile)->first();
        if($user->contact == $request->mobile) {
        
            // Authentication successful
            if($user->status == '1' || ($user->status == '2' && $request->role == 'passenger')){
                Helpers::updateFCMToken($table, $user->id, $request->input('fcm_token'));
                
                DB::table($table)->where('id', $user->id)->update([
                    'otp_key' => $token
                ]);
                
                $userData = DB::table($table)->where('id', $user->id)->first();
                $address = DB::table($table2)->where('user_id', $user->id)->where('typeset', 'primary')->first();
        
                
                $data['id'] = $userData->id;
                $data['fullname'] = $userData->fullname;
                $data['email'] = $userData->email;
                $data['country_code'] = $userData->country_code;
                $data['contact'] = $userData->contact;
                $data['address'] = $address;
                $data['user_image'] = $userData->user_image;
                $data['status'] = $userData->status;
                $data['role'] = $userData->role;
                if($request->role == 'rider'){
                    $data['age'] = $userData->age;
                    $data['gender'] = $userData->age;
                    $data['vehicle_number'] = $userData->vehicle_number;
                    $data['vehicle_color'] = $userData->vehicle_color;
                    $data['vehicle_rc'] = $userData->vehicle_rc;
                    $data['vehicle_make'] = $userData->vehicle_make;
                    $data['vehicle_model'] = $userData->vehicle_model;
                    $data['license_number'] = $userData->license_number;
                    $data['license_photo'] = $userData->license_photo;
                }
                
                return response()->json(['data' => $data, 'message' => 'Login successful', 'access_token' => $token, 'token_type' => 'Bearer'], 200);
            }else{
                return response()->json(['message' => 'Your account is not active. Please contact support.'], 403);
            }
        }
    }
    }else{
        return response()->json(['message' => 'Invalid credentials'], 401);
    }
  
    }

    public function apiRegistrationuser(Request $request)
    {

        $table = $request->role == 'passenger' ? 'passengers' : 'riders';
        $table2 = $request->role == 'passenger' ? 'passenger_addresses' : 'rider_addresses';
        
        if (DB::table($table)->where('email', $request->email)->exists()) {
            return response()->json([
                'message' => 'Email already exists'
            ],401);
        } 
        if (DB::table($table)->where('contact', $request->mobile)->exists()) {
            return response()->json([
                'message' => 'Mobile number already exists'
            ],401);
        }
         if ($request->input('city') && $request->input('postal_code')) {
            $subpoint = Helpers::getSubpointName($request->input('postal_code'));
            if (!$subpoint) {
                $subpoint = 'Empty';
            }
        }
        if(!$request->input('latitude') || !$request->input('longitude')){
            return response()->json([
                'message' => 'No proper location provided. Please change your location and try again.'
            ],401);
        }
        
        $token = Str::random(30);
        $table = $request->role == 'passenger' ? new Passenger() : new Rider();
        
        $table->fullname = $request->input('fullname');
        $table->email = $request->input('email');
        $table->role = $request->input('role');
        $table->country_code = $request->input('country_code');
        $table->contact = $request->input('mobile');
        $table->password = Hash::make(12345678);
        $table->address = $request->input('address');   
        $table->city = $request->input('city');
        $table->subpoint = $subpoint;
        $table->postal_code = $request->input('postal_code');
        $table->otp_key = $token;
        $table->latitude = $request->input('latitude');
        $table->longitude = $request->input('longitude');
        $table->fcm_token = $request->input('fcm_token');
        
        
    if($request->role == 'passenger'){
        $table->is_first_booking =  0;
        
    }

        $table->status = 2;
        
        $table->user_image = '';
        $table->save();

            if($table->id){
            
                //if($request->role == 'passenger'){
                    DB::table($table2)->insert([
                        'user_id' => $table->id,
                        'typeset' => 'primary',
                        'address' => $request->input('address'),
                        'city' => $request->input('city'),
                        'postal_code' => $request->input('postal_code'),
                        'subpoint' => $subpoint,
                        'latitude' => $request->input('latitude'),
                        'longitude' => $request->input('longitude'),
                        
                        'status' => 1,
                ]);
            //}

            if($request->role == 'passenger'){
                
                $passenger = Passenger::where('id', $table->id)->first();
                $address = DB::table($table2)->where('user_id', $table->id)->where('typeset', 'primary')->first();
        
                
                $data['id'] = $passenger->id;
                $data['fullname'] = $passenger->fullname;
                $data['email'] = $passenger->email;
                $data['country_code'] = $passenger->country_code;
                $data['contact'] = $passenger->contact;
                $data['address'] = $address;
                $data['status'] = 2;
                $data['user_image'] = $passenger->user_image;
        
                
            return response()->json([
                'data' => $data,
                'message' => 'Registration successful',
                'access_token' => $token,
                'token_type' => 'Bearer'
                
            ], 200);
            }else{
               
                return response()->json([
                    'message' => 'Registration successful! Please wait for admin approval.',
                ], 200);
            }
        }
    
    
}
public function forgetPassword($tb, $user_email){
        $emailCount = DB::table($tb)->where('email',$user_email)->where('status',1)->count();
        if($emailCount){
            $pGenerate = '12345678';
    	    $password = Hash::make($pGenerate);
    	    $passenger['password'] = $password;
            DB::table($tb)->where('email', $user_email)->update($passenger);
            $msg2['Your New Password '] = $pGenerate;
            //Mail::to($user_email)->send(new \App\Mail\NewUserInfomationMail($msg2));
            //Mail::to($user_email)->send(new \App\Mail\PasswordInfomationMail($msg2));
            $message = 'New password sent registered email address';
            $status = 200;
        }else{
            $message = 'Invalid Email Address';
            $status = 403;
        }
        return response()->json([
            'message' => $message
            ],$status);
    }
public function changePassword(Request $request){
        $tb = $request->role == 'passenger' ? 'passengers' : 'riders';
        $user_id = $request->user_id;
        $old_password = Hash::make($request->password);
       
        $new_password = Hash::make($request->new_password);
        
        $emailCount = DB::table($tb)->where('id',$user_id)->where('password',$old_password)->count();
        //if($emailCount){
              
    	    $passenger['password'] = $new_password;
            DB::table($tb)->where('id',$user_id)->update($passenger);
            $msg2['Your New Password '] = $request->new_password;
            
            $user = DB::table($tb)->where('id',$user_id)->first();
        
           // Mail::to($user->email)->send(new \App\Mail\PasswordInfomationMail($msg2));
            $status = 200;
            $message = 'Your password successfully changed';
        // }else{
        //     $status = 403;
        //     $message = 'Old password not matched!';
        // }
        return response()->json([
            'status' => $status,
            'message' => $message
            ]);
    }
    
public function apiSlider(Request $request){
    $status = 200;
    $sliders[] = '';
    $role = $request->input('role');
    $sliderCount = DB::table('carousels')->where('type',strtoupper($role))->where('status',1)->orderBy('sort','asc')->count();
    if($sliderCount > 0){
        $sliders = DB::table('carousels')->where('type',strtoupper($role))->where('status',1)->orderBy('sort','asc')->get();
    }else{
        $status = 300;
    }
    return response()->json([
            'data' => $sliders,
            'status' => $status
            ]);
}
public function apiLogoutuser(Request $request)
    {
        
        $table = $request->role == 'passenger' ? 'passengers' : 'riders';
        DB::table($table)->where('otp_key', $request->input('access_token'))->update([
            'otp_key' => null,
            'fcm_token' => null
        ]);
        return response()->json(['message' => 'Logout successful'], 200);
    }

public function apiPolicy(){
    
    $policy = DB::table('policies')->orderBy('id','desc')->first();
    $term = DB::table('termservices')->orderBy('id','desc')->first();
    $alert = DB::table('alerts')->orderBy('id','desc')->first();
    $bookingterm = DB::table('booking_terms')->orderBy('id','desc')->first();
    $homenote = DB::table('homenotes')->orderBy('id','desc')->first();
    
    $data['passenger']['policy'] = $policy->passenger_message;
    $data['passenger']['term'] = $term->passenger_message;
    $data['passenger']['alert'] = $alert->passenger_message;
    $data['passenger']['booking_term'] = $bookingterm->passenger_message;
    $data['passenger']['homenote'] = $homenote->passenger_message;
    
    $data['driver']['policy'] = $policy->driver_message;
    $data['driver']['term'] = $term->driver_message;
    $data['driver']['alert'] = $alert->driver_message;
    $data['driver']['booking_term'] = $bookingterm->driver_message;
    $data['driver']['homenote'] = $homenote->driver_message;
    
    return response()->json([
            'data' => $data,
            'status' => 200
         ]);
}
public function apiPassengerInactive($user_id){
        
        $passenger['status'] = 0;
        DB::table('passengers')->where('id', $user_id)->update($passenger);
       

        return response()->json([

            'status' => 200
         ]);
    }
public function apiDriverInactive($user_id){
        
        $driver['status'] = 0;
        DB::table('drivers')->where('id', $user_id)->update($driver);
       

        return response()->json([

            'status' => 200
         ]);
    }

public function apiBookingStore(Request $request){


$request = json_decode($request->getContent()); 

		
        $user_id = $request->user_id;
        $pickupdate = '';
        $dropdate = '';
        $booking = '';
        $status = 400;
	
		$passenger = DB::table('passengers')->where('contact','=',$request->mobile)->first();    
		
		if($passenger->is_first_booking == 0){
		    $msg2['Passenger Name'] = $passenger->fullname;
               $msg2['Mobile'] = $passenger->contact;
               $msg2['Date/Time'] = date('d-m-Y H:s');
               $msg2['Address'] = $passenger->address;
               $msg2['City'] = $passenger->city;
               $msg2['Subpoint'] = $passenger->subpoint;
               $msg2['Postal Code'] = $passenger->postal_code;
               //Mail::to('pickanddropcare@gmail.com')->send(new \App\Mail\NewUserInfomationMail($msg2));
               
               $is_first_booking = array('is_first_booking' => 1);
				DB::table('passengers')->where('id', $passenger->id)->update($is_first_booking); 
		}

if(isset($request->pickup_date)){         
if(is_array($request->pickup_date)){ 
	

	$pickup_postal_code = '';
	$address = '';
	$pickup_location = '';
	$drop_postal_code = '';
	$pickup_droplocation = '';
	$drop_city = '';
	$droptag = '';
	$tag = '';
	
	$droplat = '';
	$droplong = '';
	$picklat = '';
	$picklong = '';
	

			   
	foreach($request->pickup_date as $key => $value){
		
	    foreach($request->address as $key => $val){
	        if($key == 'postal_code'){
	            $pickup_postal_code = $val;
	        }
	        if($key == 'address'){
	            $address = $val;
	        }
	        if($key == 'city'){
	            $pickup_location = $val;
	        }
	       
	        if($key == 'latitude'){
	            $picklat = $val;
	        }
	        if($key == 'longitude'){
	            $picklong = $val;
	        }
	    }
	    
	    foreach($request->pickup_droplocation as $key => $val){
	        if($key == 'postal_code'){
	            $drop_postal_code = $val;
	        }
	        if($key == 'address'){
	            $pickup_droplocation = $val;
	        }
	        if($key == 'city'){
	            $drop_city = $val;
	        }

	        if($key == 'latitude'){
	            $droplat = $val;
	        }
	        if($key == 'longitude'){
	            $droplong = $val;
	        }
	    }


		$pickup_subpoint = $this->subpoint_check($pickup_postal_code, $pickup_location);
		$dropup_subpoint = $this->subpoint_check($drop_postal_code, $drop_city);
		if($pickup_subpoint != 'Empty' || $dropup_subpoint != 'Empty'){
		    $notavailable = DB::table('subpoints')->where('name',$pickup_subpoint)->where('is_available',0)->count();
		    $notavailable1 = DB::table('subpoints')->where('name',$dropup_subpoint)->where('is_available',0)->count();
		    if($notavailable > 0 || $notavailable1 > 0){
		        
		        $status = 100;
		        $msg = '';
		        if($notavailable){
		            $msg = 'Yet for '.$address.' ride not provide we will be start soon and will confirm also.';
		        }else if($notavailable1){
		            $msg = 'Yet for '.$pickup_droplocation.' ride not provide we will be start soon and will confirm also.';
		        }
                return response()->json([
                    'status' => $status,
                    'message' => $msg,
                ]);
            
		    }
		}
		
        $pdate = trim($value->value);
        $pd = explode('-',$pdate);
        $pickupdate = $pdate; //$pd[2].'-'.$pd[1].'-'.$pd[0];
		
        $countRow = $this->checkBookingSlot($user_id, $request->pickup_shift, $pickupdate, $request->pickup_shift_time);

                if($countRow == 0){
					$booking = new Booking();

					

					$booking->booking_type = $request->booking_pickup_type;
					$booking->user_id = $user_id;
					$booking->name = $request->name;
					$booking->mobile = $request->mobile;
					$booking->email = $request->email;
					$booking->status = 1;
					$booking->note = $request->note;
					$booking->pickup_location = $address;
					$booking->pickup_city = $pickup_location;
					$booking->pickup_subpoint = $pickup_subpoint;
					$booking->pickup_postal_code = $pickup_postal_code;
					$booking->pickup_lat = $picklat;
					$booking->pickup_long = $picklong;
					$booking->shift = $request->pickup_shift;
					$booking->booked_date = $pickupdate;
					$booking->booked_time = $request->pickup_shift_time;
					$ex = explode(' ',$request->pickup_shift_time);
					$booking->time_order = str_replace(':','',$ex[0]);
					$booking->dropup_location = $pickup_droplocation;
					$booking->dropup_city = $drop_city;
					$booking->dropup_subpoint = $dropup_subpoint;
					$booking->dropup_postal_code = $drop_postal_code;
					$booking->dropup_lat = $droplat;
					$booking->newuser = $passenger->verify;
					$booking->dropup_long = $droplong;
					


					$booking->save();
                }
				
				
				
	}

	$pickup_address_count = DB::table('passenger_addresses')->where('user_id',$passenger->id)->where('address','=',$address)->count();    
	$pickup_drop_address_count = DB::table('passenger_addresses')->where('user_id',$passenger->id)->where('address','=',$pickup_droplocation)->count(); 
	
	if($pickup_address_count == 0){
		
	
		$pickup_subpoint = $this->subpoint_check_id($pickup_postal_code, $pickup_location);
		
		$pickup_values = array('user_id' => $passenger->id,'type' => 'pickup','address' => $address,'typeset' => 'secondary' ,'city' => $pickup_location,'subpoint' => $pickup_subpoint,'postal_code' => $pickup_postal_code, 'latitude' => $picklat, 'longitude' => $picklong, 'status' => 1);
		DB::table('passenger_addresses')->insert($pickup_values); 
	}
	if($pickup_drop_address_count == 0){
	

	$dropup_subpoint = $this->subpoint_check_id($drop_postal_code, $drop_city);
		
		$dropup_values = array('user_id' => $passenger->id,'type' => 'dropup','address' => $pickup_droplocation,'typeset' => 'secondary' ,'city' => $drop_city,'subpoint' => $dropup_subpoint, 'postal_code' => $drop_postal_code, 'latitude' => $droplat, 'longitude' => $droplong,'status' => 1);
		DB::table('passenger_addresses')->insert($dropup_values); 
	}

			
}
}

if(isset($request->dropup_date)){    
if(is_array($request->dropup_date)){
	
	$pickup_postal_code = '';
	$address = '';
	$pickup_location = '';
	$drop_postal_code = '';
	$pickup_droplocation = '';
	$drop_city = '';
	$droptag = '';
	$tag = '';
	$droplat = '';
	$droplong = '';
	$picklat = '';
	$picklong = '';
	

			   
	foreach($request->pickup_date as $key => $value){
		
	    foreach($request->dropup_pickuplocation as $key => $val){
	        if($key == 'postal_code'){
	            $pickup_postal_code = $val;
	        }
	        if($key == 'address'){
	            $address = $val;
	        }
	        if($key == 'city'){
	            $pickup_location = $val;
	        }
	        
	        if($key == 'longitude'){
	            $picklat = $val;
	        }
	        if($key == 'longitude'){
	            $picklong = $val;
	        }
	    }
	    
	    foreach($request->dropup_dropaddress as $key => $val){
	        if($key == 'postal_code'){
	            $drop_postal_code = $val;
	        }
	        if($key == 'address'){
	            $pickup_droplocation = $val;
	        }
	        if($key == 'city'){
	            $drop_city = $val;
	        }
	        
	        if($key == 'longitude'){
	            $droplat = $val;
	        }
	        if($key == 'longitude'){
	            $droplong = $val;
	        }
	    }
	


foreach($request->dropup_date as $key => $value){

$pickup_subpoint = $this->subpoint_check($pickup_postal_code, $pickup_location);
$dropup_subpoint = $this->subpoint_check($drop_postal_code, $drop_city);

$dropd = trim($value->value);
 $dd = explode('-',$dropd);
$dropdate = $dropd; //$dd[2].'-'.$dd[1].'-'.$dd[0];
$countRow = $this->checkBookingSlot($user_id, $request->dropup_shift, $dropdate, $request->dropup_shift_time);

                if($countRow == 0){

				$booking = new Booking();
          
                

                $booking->booking_type = $request->booking_pickup_type;
				$booking->user_id = $user_id;
				$booking->name = $request->name;
				$booking->mobile = $request->mobile;
				$booking->email = $request->email;
                $booking->note = $request->dropup_note;
				$booking->status = 1;
				$booking->pickup_location = $address;
				$booking->pickup_city = $pickup_location;
				$booking->pickup_subpoint = $pickup_subpoint;
				$booking->pickup_postal_code = $pickup_postal_code;
				$booking->pickup_lat = $picklat;
				$booking->pickup_long = $picklong;
				$booking->shift = $request->dropup_shift;
				$booking->booked_date = $dropdate;
				$booking->booked_time = $request->dropup_shift_time;
				$ex = explode(' ',$request->dropup_shift_time);
				$booking->time_order = str_replace(':','',$ex[0]);
                
				$booking->dropup_location = $pickup_droplocation;
				$booking->dropup_city = $drop_city;
				$booking->dropup_subpoint = $dropup_subpoint;
				$booking->dropup_postal_code = $drop_postal_code;
				$booking->dropup_lat = $droplat;
				$booking->dropup_long = $droplong;
				$booking->newuser = $passenger->verify;
					
					
                
				
                $booking->save();
            }
                
            }
            
        }
    }
    
}
		$status = 200;
		
            return response()->json([
                'status' => $status,
                'booking' => $booking,
            ]);
         
}

public function apiRangedateFilter($user_id,$startDate,$endDate){

        $booking2 = array();
		
        $st = explode('-',$startDate);
        $startDate = $st[2].'-'.$st[1].'-'.$st[0];

        $dd = explode('-',$endDate);
        $endDate = $dd[2].'-'.$dd[1].'-'.$dd[0];

        $bookingsCount = DB::table('bookings')->where('user_id', $user_id)->whereBetween('booked_date', [$startDate, $endDate])->count();
        if ($bookingsCount == 0) {
             $status = 400;
             $message = 'Booking Not Found';
            
        }else{
            $bookings = DB::table('bookings')->where('user_id', $user_id)->whereBetween('booked_date', [$startDate, $endDate])->orderBy('booked_date', 'ASC')->get();    
            $i = 0;
		        foreach($bookings as $booking){
		    
		    $pickup_address = DB::table('passenger_addresses')->where('user_id',$booking->user_id)->where('address',$booking->pickup_location)->first(); 
		    $dropup_address = DB::table('passenger_addresses')->where('user_id',$booking->user_id)->where('address',$booking->dropup_location)->first(); 
		    
                    if($booking->status == 2){
                        $driver = DB::table('booking_assigns')
                        ->join('riders', 'riders.id', '=', 'booking_assigns.driver_id')
                        ->where('booking_assigns.booking_id', $booking->id)->first();
                        
                        $driverName = $driver->name;
                        $driverMobile = $driver->mobile;
                        $driverColor = $driver->vehicle_color;
                        $driverNumber = $driver->vehicle_number;
                        $driverModel = $driver->vehicle_model;
                        $driverMake = $driver->vehicle_make;
                        $driverPhoto = $driver->photo;
                        $driverId = $driver->id;
                        
                    }else{
                        $driverName = '';
                        $driverMobile = '';
                        $driverColor = '';                        
                        $driverNumber = ''; 
                        $driverModel = ''; 
                        $driverMake = ''; 
                        $driverPhoto = ''; 
                        $driverId = '';
                    }
                    $passengerData = DB::table('passengers')->where('id',$booking->user_id)->first(); 
                    
                    $booking2[$i]['booking_id'] = $booking->id;
                    $booking2[$i]['name'] = $booking->name;
                    $booking2[$i]['country_code'] = $passengerData->country_code;
                    $booking2[$i]['mobile'] = $booking->mobile;
                    $booking2[$i]['booked_date'] = $booking->booked_date;
                    $booking2[$i]['pickup_shift'] = $booking->shift;
                    $booking2[$i]['pickup_shift_time'] = $booking->booked_time;
                    $booking2[$i]['status'] = $booking->status;
                    $booking2[$i]['driver_name'] = $driverName;
                    $booking2[$i]['driver_mobile'] = $driverMobile;
                    $booking2[$i]['vehicle_color'] = $driverColor;
                    $booking2[$i]['vehicle_number'] = $driverNumber;
                    $booking2[$i]['vehicle_model'] = $driverModel;
                    $booking2[$i]['vehicle_make'] = $driverMake;
                    $booking2[$i]['photo'] = $driverPhoto;
                    $booking2[$i]['note'] = $booking->note;
                    $booking2[$i]['driver_id'] = $driverId;
                    $booking2[$i]['created_at'] = $booking->updated_at;
                    $booking2[$i]['pickup_location'] =$booking->pickup_location;
                    $booking2[$i]['dropup_location'] = $booking->dropup_location;
                    $booking2[$i]['address'] = $pickup_address;
                    $booking2[$i]['pickup_droplocation'] = $dropup_address;
                    
                    
                    $i++;
            }
                  
         
                $status = 200;
                $message = '';
        }

        return response()->json([
            'data' => $booking2,
            'status' => $status,
            'message' => $message
         ]);

}

public function apiBookingUpdate(Request $request){
    
        
        $request = json_decode($request->getContent()); 
        
            $id = $request->booking_id;
            $passenger = DB::table('passengers')->where('contact','=',$request->mobile)->first();
            if($passenger->is_first_booking == 0){
		    $msg2['Passenger Name'] = $passenger->fullname;
               $msg2['Mobile'] = $passenger->contact;
               $msg2['Date/Time'] = date('d-m-Y H:s');
               $msg2['Address'] = $passenger->address;
               $msg2['City'] = $passenger->city;
               $msg2['Subpoint'] = $passenger->subpoint;
               $msg2['Postal Code'] = $passenger->postal_code;
               //Mail::to('pickanddropcare@gmail.com')->send(new \App\Mail\NewUserInfomationMail($msg2));
               
               $is_first_booking = array('is_first_booking' => 1);
				DB::table('passengers')->where('id', $passenger->id)->update($is_first_booking); 
		}
		

foreach($request->pickup_date as $key => $value){
    
    foreach($request->address as $key => $val){
	        if($key == 'postal_code'){
	            $pickup_postal_code = $val;
	        }
	        if($key == 'address'){
	            $address = $val;
	        }
	        if($key == 'city'){
	            $pickup_location = $val;
	        }
	      
	        if($key == 'latitude'){
	            $picklat = $val;
	        }
	        if($key == 'longitude'){
	            $picklong = $val;
	        }
	    }
	    
	    foreach($request->pickup_droplocation as $key => $val){
	        if($key == 'postal_code'){
	            $drop_postal_code = $val;
	        }
	        if($key == 'address'){
	            $pickup_droplocation = $val;
	        }
	        if($key == 'city'){
	            $drop_city = $val;
	        }
	       
	        if($key == 'latitude'){
	            $droplat = $val;
	        }
	        if($key == 'longitude'){
	            $droplong = $val;
	        }
	    }
	  
        $pickup_subpoint = $this->subpoint_check($pickup_postal_code, $pickup_location);
		$dropup_subpoint = $this->subpoint_check($drop_postal_code, $drop_city);
		
			if($pickup_subpoint != 'Empty' || $dropup_subpoint != 'Empty'){
		    $notavailable = DB::table('subpoints')->where('name',$pickup_subpoint)->where('is_available',0)->count();
		    $notavailable1 = DB::table('subpoints')->where('name',$dropup_subpoint)->where('is_available',0)->count();
		    if($notavailable > 0 || $notavailable1 > 0){
		        
		        $status = 100;
		        $msg = '';
		        if($notavailable){
		            $msg = 'Yet for '.$address.' ride not provide we will be start soon and will confirm also.';
		        }else if($notavailable1){
		            $msg = 'Yet for '.$pickup_droplocation.' ride not provide we will be start soon and will confirm also.';
		        }
                return response()->json([
                    'status' => $status,
                    'message' => $msg,
                ]);
            
		    }
		}
		
        $pdate = trim($value->value);
 
        $pd = explode('-',$pdate);
        $pickupdate = $pd[2].'-'.$pd[1].'-'.$pd[0];

        

	$booking111['pickup_location'] = $address;
	$booking111['pickup_city'] = $pickup_location;
	$booking111['pickup_subpoint'] = $pickup_subpoint;
	$booking111['pickup_postal_code'] = $pickup_postal_code;
	$booking111['pickup_lat'] = $picklat;
	$booking111['note'] = $request->note;
	$booking111['pickup_long'] = $picklong;
	$booking111['pickup_postal_code'] = $pickup_postal_code;
	$booking111['dropup_location'] = $pickup_droplocation;
	$booking111['dropup_city'] = $drop_city;
	$booking111['dropup_subpoint'] = $dropup_subpoint;
	$booking111['dropup_postal_code'] = $drop_postal_code;
	$booking111['dropup_lat'] = $droplat;
	$booking111['dropup_long'] = $droplong;
	$booking111['shift'] = $request->pickup_shift;
	$booking111['booked_date'] = $pickupdate;
	$booking111['booked_time'] = $request->pickup_shift_time;
	$ex = explode(' ',$request->pickup_shift_time);
	$booking111['time_order']  = str_replace(':','',$ex[0]);
	$booking111['updated_at'] = date('Y-m-d h:i:s');

	DB::table('bookings')->where('id', $id)->update($booking111);
	
	$pickup_address_count = DB::table('passenger_addresses')->where('user_id',$request->user_id)->where('address','=',$address)->count();    
	$pickup_drop_address_count = DB::table('passenger_addresses')->where('user_id',$request->user_id)->where('address','=',$pickup_droplocation)->count(); 
	
	if($pickup_address_count == 0){
		
	
		$pickup_subpoint = $this->subpoint_check_id($pickup_postal_code, $pickup_location);
		
		$pickup_values = array('user_id' => $request->user_id,'type' => 'pickup','address' => $address,'typeset' => 'secondary' ,'city' => $pickup_location,'subpoint' => $pickup_subpoint,'postal_code' => $pickup_postal_code, 'lat' => $picklat, 'long' => $picklong,'status' => 1);
		DB::table('passenger_addresses')->insert($pickup_values); 
	}
	if($pickup_drop_address_count == 0){
	

	$dropup_subpoint = $this->subpoint_check_id($drop_postal_code, $drop_city);
		
		$dropup_values = array('user_id' => $request->user_id,'type' => 'dropup','address' => $pickup_droplocation,'typeset' => 'secondary' ,'city' => $drop_city,'subpoint' => $dropup_subpoint, 'factory' => $request->factory, 'postal_code' => $drop_postal_code, 'latitude' => $droplat, 'longitude' => $droplong,'status' => 1);
		DB::table('passenger_addresses')->insert($dropup_values); 
	}
	
	
}
			
    return response()->json([
        'data' => $booking111,
        'status' => 200
    ]);

}

public function apiBookingAssignSingle($booking_id){
    

    $booking = DB::table('booking_assigns')
    ->join('bookings', 'bookings.id', '=', 'booking_assigns.booking_id')
    ->join('drivers', 'drivers.id', '=', 'booking_assigns.driver_id')
    ->select('*', 'drivers.name as driverName','drivers.mobile as driverMobile', 'bookings.name as passengerName','bookings.status as bookingStatus')
    ->where('bookings.id', $booking_id)->first();

        if ($booking === null) {

            $status = 400;
            $data = '';
        }else{
            $status = 200;
            $data = $booking;
        }

        return response()->json([
            'booking' => $data,
            'status' => $status
         ]);
    
}
public function apiBookingAssign($user_id){

    $booking = DB::table('booking_assigns')
    ->join('bookings', 'bookings.id', '=', 'booking_assigns.booking_id')
    ->join('drivers', 'drivers.id', '=', 'booking_assigns.driver_id')
    ->select('*', 'drivers.name as driverName','drivers.mobile as driverMobile', 'bookings.name as passengerName','bookings.status as bookingStatus', 'bookings.address as passengerAddress')
    ->where('bookings.user_id', $user_id)->get();

        if ($booking === null) {
            $status = 400;
            $data = '';
        }else{
            $status = 200;
            $data = $booking;
        }

        return response()->json([
            'booking' => $data,
            'status' => $status
         ]);


}

public function apiBookingCancel($booking_id){
		

		$booking['status'] = 0;
		DB::table('bookings')->where('id', $booking_id)->update($booking);
		return response()->json([
            'data' => $booking_id,
            'status' => 200,
            'message' => 'Your booking has been cancelled'
         ]);
	}
public function apiShiftingData(){
        
        $shift = DB::table('shifts')->get();
        if ($shift === null) {

            $status = 400;
        }else{
            $status = 200;
        }
        return response()->json([
            'data' => $shift,
            'status' => $status
         ]);
    }
    
public function apiShifttimeData($shift_name){
        
        $ex = explode('_',$shift_name);
         $shift_name = $ex[0];
         $route_name = $ex[1];
         $dates = $ex[2];
         $triger = 0;
         $cut_date = '';
         $message = '';
         $dateEx = explode('&',$dates); 
         $shift_status = strtolower($shift_name);
         foreach($dateEx as $booked_date){
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
                $message = 'Not vailable for booking on this '.$shift_name;
            }
        
         }else{
             $status = 300;
             $shift = $cut_date.'_'.$shift_status;
             $message = 'Not vailable for booking '.$cut_date;
         }
         
        
        return response()->json([
            'data' => $shift,
            'status' => $status,
            'message' => $message
         ]);
         
    }
    

public function apiSupport(){
        
        $data = DB::table('support_availability')->first();
        return response()->json([
            'data' => $data,
            'status' => 200,
            ]);
    }

public function getNotification(Request $request, $email)
{
    $noti = array();
     $notificationCount = DB::table('notification_emails')->where('email',$email)->where('status',1)->count();
     
   
     return response()->json([
            'total' => $notificationCount,
            ]);
}
public function changeNotification(Request $request, $email)
{
    $notificationCount = DB::table('notification_emails')->where('email',$email)->count();
        
        $type = $request->input('role');
        if($notificationCount > 0){
            
            $notification['status'] = 2;
            DB::table('notification_emails')->where('email', $email)->update($notification);
        
             $notifications = DB::table('notification_emails')->where('email',$email)->orderBy('id', 'DESC')->get();
             $i = 0;
             foreach($notifications as $notification){
                 
                 $ntiCount = DB::table('notifications')->where('type',$type)->where('id',$notification->noti_id)->count();
                 if($ntiCount > 0){
                     $nti = DB::table('notifications')->where('type',$type)->where('id',$notification->noti_id)->first();
                     $noti[$i]['title'] = $nti->title;
                     $noti[$i]['message'] = $nti->message;
                     $noti[$i]['status'] = $notification->status;
                     $noti[$i]['created'] = $nti->created_at;
                     $noti[$i]['updated'] = $nti->updated_at;
                     $i++;
                 }
             }
             $status = 200;
         }else{
             $status = 200;
             $noti = array();
         }
     return response()->json([
            'data' => $noti,
            'status' => $status,
            ]);
            
            
        
}

public function getAddress(){
    
        $user_id = $_POST['user_id'];
        $address = $_POST['address'];
        $tb = $_POST['tb'];
        $addressData = DB::table($tb)->where('address',$address)->where('user_id',$user_id)->first();
        return response()->json([
            'city' => $addressData->city,
            'postal_code' => $addressData->postal_code,
         ]);
}
public function getAddressses($user_id, $type){
    
    $addressData = array();
    $status = 400;
    if($type == 'all'){
        $addressDataCount = DB::table('passenger_addresses')->where('user_id',$user_id)->count();
       if($addressDataCount > 0){
        $addressData = DB::table('passenger_addresses')->where('user_id',$user_id)->get();
        $status = 200;
       }
    }else{
       $addressDatatypeCount = DB::table('passenger_addresses')->where('type',$type)->where('user_id',$user_id)->count();
       if($addressDatatypeCount > 0){
        $addressData = DB::table('passenger_addresses')->where('type',$type)->where('user_id',$user_id)->get();
        $status = 200;
       }
    }
        return response()->json([
            'addresses' => $addressData,
            'status' => $status
         ]);
}
public function deleteAddress(Request $request){
    

    $tb = $request->role == 'passenger' ? 'passenger_addresses' : 'rider_addresses';
    
    $user_id = $request->user_id;
    $rowid = $request->address_id;
   
    $res = DB::table($tb)->where('id',$rowid)->where('user_id',$user_id)->delete();
   return response()->json([
            'status' =>200,
         ]);
}

public function apiProfileUpdate(Request $request){
        
        $checkemail= DB::table('passengers')->where('email',$request->email)->whereNotIn('id',[$request->user_id])->count(); 
        $checkmobile= DB::table('passengers')->where('contact',$request->contact)->whereNotIn('id',[$request->user_id])->count(); 
        
 
        if($checkemail > 0){
            return response()->json([
                'msg' => 'Email Already Exists',
                'status' => 400
             ]);
        }else if($checkmobile > 0){
            return response()->json([
                'msg' => 'Mobile Number Already Exists',
                'status' => 400
             ]);
        }else{
        
        foreach($request->address as $key => $val){
            
	        if($key == 'postal_code'){
	            $pickup_postal_code = $val;
	        }
	        if($key == 'address'){
	            $address = $val;
	        }
	        if($key == 'city'){
	            $pickup_location = $val;
	        }
	        
			if($key == 'lat'){
    	            $pickuplat = $val;
    	        }
			if($key == 'long'){
				$pickuplong = $val;
			}
	    }
	    $pickup_subpoint = $this->subpoint_check($pickup_postal_code, $pickup_location);
	    

        $passenger['fullname'] = $request->fullname;
		$passenger['country_code'] = $request->country_code;
        $passenger['contact'] = $request->mobile;
        $passenger['email'] = $request->email;
        
        $passenger['address'] = $address;
        $passenger['city'] = $pickup_location;
        $passenger['subpoint'] = $pickup_subpoint;
        $passenger['postal_code'] = $pickup_postal_code;
        

        DB::table('passengers')->where('id', $request->user_id)->update($passenger);

        $pickup_address_count = DB::table('passenger_addresses')->where('user_id',$request->user_id)->where('address','=',$address)->count();
        DB::table('passenger_addresses')->where('user_id', $request->user_id)->update(array('typeset' => 'secondary'));
        if($pickup_address_count == 0){

		$pickup_subpoint = $this->subpoint_check_id($pickup_postal_code, $pickup_location);
		
		$pickup_values = array('user_id' => $request->user_id,'type' => 'pickup','address' => $address,'typeset' => 'primary' ,'city' => $pickup_location,'subpoint' => $pickup_subpoint,'postal_code' => $pickup_postal_code, 'latitude' => $pickuplat,'longitude' => $pickuplong, 'status' => 1);
		DB::table('passenger_addresses')->insert($pickup_values); 
		
	    }else{
	        
	       
            DB::table('passenger_addresses')->where('user_id', $request->user_id)->where('address', $address)->update(array('typeset' => 'primary'));

	    }
	    
	    $passenger = Passenger::where('id', $request->user_id)->first();
        $address = DB::table('passenger_addresses')->where('user_id', $request->user_id)->where('typeset', 'primary')->first();
        
        $data['id'] = $passenger->id;
        $data['fullname'] = $passenger->fullname;
        $data['email'] = $passenger->email;
        $data['country_code'] = $passenger->country_code;
        $data['contact'] = $passenger->contact;
        $data['user_image'] = $passenger->user_image;;
        $data['address'] = $address;
        
            return response()->json([
                'data' => $data,
                'status' => 200
             ]);
        }
    }   
    
public function apiProfileUpdateImage(Request $request){
        
       $fileName = time().'.'.$request->file->extension();  
       $fullpath = 'https://pickanddrop.app/backend/public/images/'.$request->type.'/'.$fileName;
       $fullpath = '';
       $request->file->move(public_path('images/'.$request->type), $fileName);
       $status = 300;
       $tb = $request->type.'s';
       if($request->type == 'passenger'){
           $status = 200;
           $target['user_image'] = $fullpath;
           DB::table($tb)->where('id', $request->id)->update($target);
       }else{
           $status = 200;
           $target['photo'] = $fullpath;
           DB::table($tb)->where('id', $request->id)->update($target);
       }
        return response()->json([
            'status' => $status,
            'photo_path' => $fullpath
            ]);
    }

public function apiBookingdays(){

date_default_timezone_set("America/Toronto");   //India time (GMT+5:30)

$date = date('d-m-Y'); //today date
$dates[] = array('label'=>date('d-m-Y - l', strtotime($date)),'value'=>date('d-m-Y', strtotime($date)), 'msg'=>'');
$holidayArr = array();
$holidayCount = DB::table('holidays')->count();
if($holidayCount > 0){
    $holidays = DB::table('holidays')->orderBy('holiday_date','asc')->get();
    foreach($holidays as $holiday){
        $holidayArr[] = $holiday->holiday_date;
    }
}

  for($i =1; $i <= 7; $i++){
    $date = date('Y-m-d', strtotime('+1 day', strtotime($date)));
    if(count($holidayArr) > 0){
        if(in_array($date, $holidayArr)){
            $h = DB::table('holidays')->where('holiday_date',$date)->first();
            $msg = $h->holiday_message;
        }else{
            $msg = '';
        }
    }
    //$dates[date('Y-m-d', strtotime($date))] = date('Y-m-d - l', strtotime($date));
    
    $dates[] = array('label'=>date('d-m-Y - l', strtotime($date)),'value'=>date('d-m-Y', strtotime($date)), 'msg'=>$msg);
  }
  
return response()->json([
            'days' => $dates
         ]);

}
public function apiTimecut(){

    $timecut = DB::table('booking_timecut')->first();
    return response()->json([
            'data' => $timecut,
            'status' => 200,
            'message' => 'Start Time Cut Counter',
            ]);
    
}   

public function apiShifttimeDataAll($shift_name){
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


public function apiDriverAssignBookingFilter($driver_id, $startDate, $endDate){
      
        $bookings = array();
        $bookingData = array();
        if($startDate != 'null' && $endDate != 'null'){
             $st = explode('-',$startDate);
            $startDate = $st[2].'-'.$st[1].'-'.$st[0];
            $dd = explode('-',$endDate);
            $endDate = $dd[2].'-'.$dd[1].'-'.$dd[0];
        }
        $bookingCount = DB::table('booking_assigns')
        ->select("bookings.*",'riders.fullname as drivername','bookings.name as passengername')
        ->join('riders', 'booking_assigns.driver_id', '=', 'riders.id')
        ->join('bookings', 'booking_assigns.booking_id', '=', 'bookings.id')
        ->where('riders.id',$driver_id)
        ->whereBetween('bookings.booked_date', [$startDate, $endDate])
        ->orderBy('bookings.id' , 'DESC')
        ->count();
        if($bookingCount > 0){
            
             $bookings = DB::table('booking_assigns')
        ->select("bookings.*",'bookings.id as booking_id','booking_assigns.slot as driverslot','booking_assigns.is_confirm as isConfirm',"riders.*",'riders.fullname as drivername','bookings.name as passengername')
        ->join('riders', 'booking_assigns.driver_id', '=', 'riders.id')
        ->join('bookings', 'booking_assigns.booking_id', '=', 'bookings.id')
        ->whereBetween('booked_date', [$startDate, $endDate])
        ->where('riders.id',$driver_id)
        //->orderBy('bookings.booked_date' , 'ASC')
        ->orderBy('booking_assigns.sorting' , 'ASC')
        ->get();
$cnnt = 0;
       foreach($bookings as $booking){
            //$bookingSingle = DB::table('bookings')->where('id',$booking->booking_id)->get()->toArray();
            $type = 'going';
            $routeSubCount = DB::table('sub_routes')->where('route_id','37')->where('subpoint',$booking->pickup_subpoint)->count();
            if($routeSubCount > 0){
                $type = 'return';
            }
            $bookingSingle = DB::table('bookings')->where('id',$booking->booking_id)->first();
            //$bookingData[$booking->booked_date][$booking->shift][$booking->driverslot][] = $bookingSingle;
            if($booking->booked_date){
                $bookedDateEx = explode('-',$booking->booked_date);
                
                $bookedDate = $bookedDateEx[2].'-'.$bookedDateEx[1].'-'.$bookedDateEx[0];

            }
           $bookingData[$bookedDate][$booking->shift][$booking->driverslot]['bookings'][] = $bookingSingle;
           $bookingData[$bookedDate][$booking->shift][$booking->driverslot]['isConfirm'][] = $booking->isConfirm;
            $cnnt++;
        }
        
        
        //$bookingData[] = array('date'=>$booking->booked_date, 'day'=>array('shift'=>$booking->shift, 'slot'=>array('type'=>$booking->booking_type, 'booking'=>$bookingSingle))) ;
            
            $status = 200;
        }else{
            $status = 300;
        }
        return response()->json([
            'data' => $bookingData,
            'status' => $status
        ]);
                    
}

}