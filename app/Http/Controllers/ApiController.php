<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use App\Helpers\Helpers;
use App\Models\Passenger;
use App\Models\Rider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
   
    public function apiLoginuser(Request $request)
    {
    $table = $request->role == 'passenger' ? 'passengers' : 'riders';

    $loginCount = DB::table($table)->where('email', $request->email)->orWhere('contact', $request->mobile)->count();
    if($loginCount > 0){
        
    $count = DB::table($table)->where('email', $request->email)->count();
    if($count > 0){
        $user = DB::table($table)->where('email', $request->email)->first();
    //return $request->password.'==='.$user->password;
        if($user->email == $request->email && Hash::check($request->password, $user->password)) {
        
            // Authentication successful
            if($user->status == '1'){
                $token = $token = Str::random(30);
                DB::table($table)->where('id', $user->id)->update([
                    'otp_key' => $token
                ]);
                return response()->json(['user' => $user, 'message' => 'Login successful', 'access_token' => $token, 'token_type' => 'Bearer'], 200);
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
            if($user->status == '1'){
                Helpers::updateFCMToken($table, $user->id, $request->input('fcm_token'));
                $token = Str::random(30);
                DB::table($table)->where('id', $user->id)->update([
                    'otp_key' => $token
                ]);
                return response()->json(['user' => $user, 'message' => 'Login successful', 'access_token' => $token, 'token_type' => 'Bearer'], 200);
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
                return response()->json(['message' => 'Subpoint Not Found. Please check your address.'], 400);
            }
        }
         
        $token = Str::random(30);
        $table = $request->role == 'passenger' ? new Passenger() : new Rider();
        $table->fullname = $request->input('fullname');
        $table->email = $request->input('email');
        $table->country_code = $request->input('country_code');
        $table->contact = $request->input('contact');
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
        $table->verify = 0;
    }

        $table->status = 2;
        
        $table->user_image = '';
        $table->save();

            if($table->id){
            
                if($request->role == 'passenger'){
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

            return response()->json([
                'user' => $table,
                'message' => 'Registration successful',
                'access_token' => $token,
                'token_type' => 'Bearer'
                
            ], 201);
        }
    
    
}



}
