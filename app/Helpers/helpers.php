<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Helpers
{

public static function subpointsByCity($cityId) {
    $subpoints = DB::table('subpoints')
        ->where('city_id', $cityId)
        ->where('status', '1')
        ->orderBy('name', 'asc')
        ->get();
    return $subpoints;
}

public static function postalCodesBySubpoint($cityId, $subpoint) {
    $postalCodes = DB::table('postal_codes')
        ->where('subpoint', $subpoint)->where('city_id', $cityId)
        ->where('status', '1')
        ->orderBy('id', 'asc')
        ->get();
    return $postalCodes;
}

public static function getCityName($cityId) {
    $city = DB::table('cities')->where('id', $cityId)->first();
    return $city ? $city->name : null;
}

public static function getSubpointName($postalCode) {


    if(strlen($postalCode) > 5){
        $postalCode = substr($postalCode, 0, 3);
    }
    $subpoint= DB::table('postal_codes')
        ->where('name', $postalCode)->select('subpoint')->first();

    return $subpoint ? $subpoint->subpoint : null;
}

public static function updateFCMToken($table, $userId, $fcmToken) {
    $count = DB::table($table)->where('id', $userId)->count();
    if($count > 0){
        DB::table($table)->where('id', $userId)->update(['fcm_token' => $fcmToken]);
        return true;
    }else{
        return false;
    }
}

    public static function getAddressDetails($tb, $addressId) {
        $address = DB::table($tb)->where('id', $addressId)->first();
        return $address;
    }

}

