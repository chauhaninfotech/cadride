<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;


class AdminCoontroller extends Controller
{
   public function query(){
    return view('query');
   }
   public function privacyPolicy(){
      $data = DB::table('policies')->orderBy('id', 'desc')->first();
      return view('policy.privacy-policy', compact('data'));
   }
   public function bookingPolicy(){
       $data = DB::table('booking_terms')->orderBy('id', 'desc')->first();
       return view('policy.booking-policy', compact('data'));
   }
   public function termServices(){
    $data = DB::table('termservices')->orderBy('id', 'desc')->first();
    return view('policy.term-services', compact('data'));
   }
   public function homeAlerts(){
    $data = DB::table('alerts')->orderBy('id', 'desc')->first();
    return view('policy.home-alert', compact('data'));
   }
   public function holiday(){
    return view('holiday');
   }
   public function postPrivacyPolicy(Request $request){
      $passengerMessage = $request->input('passenger_message');
      $driverMessage = $request->input('driver_message');
      if($request->input('action') == 'add'){
         DB::table('policies')->insert(
            ['passenger_message' => $passengerMessage, 'driver_message' => $driverMessage, 'status' => 1]  
         );
         return back()->with('success', 'Privacy policy has been added successfully!');
      }else{
         DB::table('policies')->where('id', $request->input('id'))->update(
            ['passenger_message' => $passengerMessage, 'driver_message' => $driverMessage, 'status' => 1]  
         );

         return back()->with('success', 'Privacy policy has been updated successfully!');
      }
      
      
      }
   public function postBookingPolicy(Request $request){

      $passengerMessage = $request->input('passenger_message');
      $driverMessage = $request->input('driver_message');
      if($request->input('action') == 'add'){
         DB::table('booking_terms')->insert(
            ['passenger_message' => $passengerMessage, 'driver_message' => $driverMessage, 'status' => 1]  
         );
         return back()->with('success', 'Booking policy has been added successfully!');
      }else{
         DB::table('booking_terms')->where('id', $request->input('id'))->update(
            ['passenger_message' => $passengerMessage, 'driver_message' => $driverMessage, 'status' => 1]  
         );

         return back()->with('success', 'Booking policy has been updated successfully!');
      }
   }
   public function postTermServices(Request $request){
      $passengerMessage = $request->input('passenger_message');
      $driverMessage = $request->input('driver_message');
      if($request->input('action') == 'add'){
         DB::table('termservices')->insert(
            ['passenger_message' => $passengerMessage, 'driver_message' => $driverMessage, 'status' => 1]  
         );
         return back()->with('success', 'Term services has been added successfully!');
      }else{
         DB::table('termservices')->where('id', $request->input('id'))->update(
            ['passenger_message' => $passengerMessage, 'driver_message' => $driverMessage, 'status' => 1]  
         );

         return back()->with('success', 'Term services has been updated successfully!');
      }
   }
   public function postHomeAlerts(Request $request){
      $passengerMessage = $request->input('passenger_message');
      $driverMessage = $request->input('driver_message');
      if($request->input('action') == 'add'){
         DB::table('alerts')->insert(
            ['passenger_message' => $passengerMessage, 'driver_message' => $driverMessage, 'status' => 1]  
         );
         return back()->with('success', 'Home alert has been added successfully!');
      }else{
         DB::table('alerts')->where('id', $request->input('id'))->update(
            ['passenger_message' => $passengerMessage, 'driver_message' => $driverMessage, 'status' => 1]  
         );

         return back()->with('success', 'Home alert has been updated successfully!');
      }
   }

   public function postHoliday(Request $request){

      $holiday_date = $request->input('holiday_date');
      $holiday_shift = $request->input('holiday_shift');
      $description = $request->input('holiday_message');

         foreach ($holiday_shift as $shift) {
            DB::table('holidays')->insert([
               'holiday_date' => $holiday_date,
               'holiday_shift' => $shift, // Insert one shift at a time
               'holiday_message' => $description
            ]);
         }
         return back()->with('success', 'Holiday has been added successfully!');
      
   }

   public function holidayList(Request $request) {

    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $query = DB::table('holidays')->orderBy('id', 'desc');
    
   
    if ($startDate && $endDate) {
        $query->whereBetween('holiday_date', [$startDate, $endDate]);
    }


    $holidays = $query->paginate(Config::get('pagination.per_page')); 
    return view('holiday-list', compact('holidays'));
}
   public function deleteHoliday($id){
      DB::table('holidays')->where('id', $id)->delete();
      return back()->with('success', 'Holiday has been deleted successfully!');
   }
  
   public function passengerList(){
    return view('user.passenger-list');
   }

   public function checkQuery(Request $request){

      $pickup_available_status = 0;
      $pickup_available_message = '';
		$dropup_available_status = 0;
		$dropup_available_message = '';

      if($request->pickup_city != ''){
        $pickup_city = $request->pickup_city;    
		$pickup_postal_code = $request->pickup_postal_code;
      
        $pickupcityCount = DB::table('cities')->where('name',$pickup_city)->where('status',1)->count();


        if($pickupcityCount > 0){
            $pickupcity = DB::table('cities')->where('name',$pickup_city)->where('status',1)->first();
            $pickupsubpointCount =  DB::table('postal_codes')->where('name',$pickup_postal_code)->where('city_id',$pickupcity->id)->where('status','1')->count();
            if($pickupsubpointCount == 0){
				$pickup_postal_code = substr($pickup_postal_code,0,3);
				$pickupsubpointCount =  DB::table('postal_codes')->where('name',$pickup_postal_code)->where('city_id',$pickupcity->id)->where('status','1')->count();
			}
       
            if($pickupsubpointCount > 0){
                $pickupzipcode =  DB::table('postal_codes')->where('name',$pickup_postal_code)->where('city_id',$pickupcity->id)->where('status','1')->first();
				$pickupsubpoint =  DB::table('subpoints')->where('name',$pickupzipcode->subpoint)->where('status','1')->first();
                $pickup_available = ($pickupsubpoint->is_available == 1) ? 'Yes' : 'No' ;
                $pickup_available_status = ($pickupsubpoint->is_available == 1) ? 1 : 0 ;
                
                $pickup_subpoint = $pickupsubpoint->name;
                $pickup_available_message = $pickup_available."! we are provide pickup service on ".$pickup_city." City and ".$pickup_subpoint." Subpoint.";
                 
            }else{
                $pickup_available_message = "No! because subpoint not found.";
            }
        }else{
            $pickup_available_message = "No! because ".$pickup_city." city have not added.";
        }
		}
        if($request->dropup_city != ''){
	
		$dropup_city = $request->dropup_city;
        $dropup_postal_code = $request->dropup_postal_code;
        $dropupcityCount = DB::table('cities')->where('name',$dropup_city)->where('status',1)->count();
		
		
			
        if($dropupcityCount > 0){
			
			$dropupcity = DB::table('cities')->where('name',$dropup_city)->where('status',1)->first();
			$dropupsubpointCount =  DB::table('postal_codes')->where('name',$dropup_postal_code)->where('city_id',$dropupcity->id)->where('status','1')->count();		
			if($dropupsubpointCount == 0){
				$dropup_postal_code = substr($dropup_postal_code,0,3);
				$dropupsubpointCount =  DB::table('postal_codes')->where('name',$dropup_postal_code)->where('city_id',$dropupcity->id)->where('status','1')->count();
			}
		
            
            
            if($dropupsubpointCount > 0){
				
				$dropupzipcode =  DB::table('postal_codes')->where('name',$dropup_postal_code)->where('city_id',$dropupcity->id)->where('status','1')->first();
				
                $dropupsubpoint =  DB::table('subpoints')->where('name',$dropupzipcode->subpoint)->where('status','1')->first();
                $dropup_available = ($dropupsubpoint->is_available == 1) ? 'Yes' : 'No' ;
                $dropup_available_status = ($dropupsubpoint->is_available == 1) ? 1 : 0 ;
                $dropup_subpoint = $dropupsubpoint->name;
                $dropup_available_message = $dropup_available."! we are provide dropup service on ".$dropup_city." City and ".$dropup_subpoint." Subpoint.";
    
            }else{
                $dropup_available_message = "No! because subpoint not found.";
            }
        }else{
            $dropup_available_message = "No! because ".$dropup_city." City have not added.";
        }
		}
        
   
      return redirect()->back()->withInput()->with([
         'pickup_available_message' => $pickup_available_message,
         'pickup_available_status' => $pickup_available_status,
         'dropup_available_message' => $dropup_available_message,
         'dropup_available_status' => $dropup_available_status
      ]);
   }



   public function passengerAdd(){
    return view('user.passenger-add');
   }

   /*-- City management functions --*/

   public function cities(){
      $query = filter_var(request('search')) ? request('search') : '';
      $query = DB::table('cities')->where('name', 'like', '%' . $query . '%')->orderBy('id', 'desc');
      $cities = $query->paginate(Config::get('pagination.per_page'));
      return view('city.cities', compact('cities'));
   }

   public function postCity(Request $request){
      $cityName = $request->input('city_name');
      DB::table('cities')->insert(
         ['name' => strtoupper($cityName), 'status' => $request->input('status')]  
      );
      return back()->with('success', 'City has been added successfully!');
   }
   public function editCity(Request $request){
      $id = $request->query('id');
      $city = DB::table('cities')->where('id', $id)->first();
      if (!$city) {
         return redirect()->route('cities')->with('error', 'City not found.');
      }
      return view('city.edit-city', compact('city'));
   }
   public function postEditCity(Request $request){
      $id = $request->input('id');
      $cityName = $request->input('city_name');
      DB::table('cities')->where('id', $id)->update(
         ['name' => strtoupper($cityName), 'status' => $request->input('status')]  
      );
      return back()->with('success', 'City has been updated successfully!');
   }
   public function deleteCity($id){
      DB::table('cities')->where('id', $id)->delete();
      return back()->with('success', 'City has been deleted successfully!');
   }
   public function addCity(){
      return view('city.add-city');
   }
   

   /*-- Subpoint management functions --*/

   public function subpoints(){
      $query = filter_var(request('search')) ? request('search') : '';
      $subpoints = DB::table('subpoints')
         ->join('cities', 'subpoints.city_id', '=', 'cities.id')
         ->select('subpoints.*', 'cities.name as city_name')
         ->where(function ($q) use ($query) {
            $q->where('subpoints.name', 'like', '%' . $query . '%')
              ->orWhere('cities.name', 'like', '%' . $query . '%');
         })
         ->orderBy('subpoints.id', 'desc')
         ->paginate(Config::get('pagination.per_page'))
         ->withQueryString();
      return view('subpoint.subpoints', compact('subpoints'));
   }
   public function addSubpoint(){
      $cities = DB::table('cities')->where('status', '1')->get();
      return view('subpoint.add-subpoint', compact('cities'));
   }
   public function postSubpoints(Request $request){
      $subpointName = $request->input('subpoint_name');
      $cityId = $request->input('city_id');
      DB::table('subpoints')->insert(
         ['name' => strtoupper($subpointName), 'city_id' => $cityId, 'status' => $request->input('status')]  
      );
      return back()->with('success', 'Subpoint has been added successfully!');
   }
   public function editSubpoint(Request $request){
      $id = $request->query('id');
      $subpoint = DB::table('subpoints')->where('id', $id)->first();
      if (!$subpoint) {
         return redirect()->route('subpoints')->with('error', 'Subpoint not found.');
      }
      $cities = DB::table('cities')->where('status', '1')->get();
      return view('subpoint.edit-subpoint', compact('subpoint', 'cities'));
   }
   public function postEditSubpoint(Request $request){
      $id = $request->input('id');
      $subpointName = $request->input('subpoint_name');
      $cityId = $request->input('city_id');
      DB::table('subpoints')->where('id', $id)->update(
         ['name' => strtoupper($subpointName), 'city_id' => $cityId, 'status' => $request->input('status')]  
      );
      return back()->with('success', 'Subpoint has been updated successfully!');
   }  
   public function deleteSubpoint($id){
      DB::table('subpoints')->where('id', $id)->delete();
      return back()->with('success', 'Subpoint has been deleted successfully!');
   }  

   /*-- Postal code management functions --*/
   public function postalCodes(){
      $query = filter_var(request('search')) ? request('search') : '';
      $postalCodes = DB::table('postal_codes')
         ->join('cities', 'postal_codes.city_id', '=', 'cities.id')
         ->select('postal_codes.*', 'cities.name as city_name')
         ->where(function ($q) use ($query) {
            $q->where('postal_codes.name', 'like', '%' . $query . '%')
              ->orWhere('cities.name', 'like', '%' . $query . '%');
         })
         ->orderBy('postal_codes.id', 'desc')
         ->paginate(Config::get('pagination.per_page'))
         ->withQueryString();
      return view('postalcode.postalcodes', compact('postalCodes'));
   }  
   public function addPostalCode(){
      $cities = DB::table('cities')->where('status', '1')->get();
      return view('postalcode.add-postalcode', compact('cities'));
   }
   public function postPostalCode(Request $request){
      $postalCode = $request->input('name');
      $cityId = $request->input('city_id');
      $subpoint = $request->input('subpoint');
      DB::table('postal_codes')->insert(
         ['name' => strtoupper($postalCode), 'city_id' => $cityId, 'subpoint' => $subpoint, 'status' => $request->input('status')]  
      );
      return back()->with('success', 'Postal code has been added successfully!');
   }
   public function editPostalCode(Request $request){
      $id = $request->query('id');
      $postalCode = DB::table('postal_codes')->where('id', $id)->first();
      if (!$postalCode) {
         return redirect()->route('postalcodes')->with('error', 'Postal code not found.');
      }
      $cities = DB::table('cities')->where('status', '1')->get();
      $subpoints = DB::table('subpoints')->where('city_id', $postalCode->city_id)->where('status', '1')->get();
      return view('postalcode.edit-postalcode', compact('postalCode', 'cities', 'subpoints'));
   }
   public function postEditPostalCode(Request $request){
      $id = $request->input('id');
      $postalCode = $request->input('name');
      $cityId = $request->input('city_id');
      $subpoint = $request->input('subpoint');
      DB::table('postal_codes')->where('id', $id)->update(
         ['name' => strtoupper($postalCode), 'city_id' => $cityId, 'subpoint' => $subpoint, 'status' => $request->input('status')]  
      );
      return back()->with('success', 'Postal code has been updated successfully!');
   }
   public function deletePostalCode($id){
      DB::table('postal_codes')->where('id', $id)->delete();
      return back()->with('success', 'Postal code has been deleted successfully!');
   }
   public function getSubpoints($cityId){
      $subpoints = DB::table('subpoints')->where('city_id', $cityId)->where('status', '1')->get();
      return response()->json($subpoints);
   }

   /*-- Shift management functions --*/

   public function addShift(){
      $cities = DB::table('cities')->where('status', '1')->get(); 

      return view('shift.shift-add',compact('cities'));
   }
   public function postShift(Request $request){
      $shiftName = $request->input('shift_name');
      
      $timing = explode(' ', $request->input('timing'));
      $timeOrder = str_replace(':', '', $timing[0]);
   foreach($request->input('route_name') as $route){
      DB::table('shifts')->insert(
         ['shift_name' => strtoupper($shiftName), 'route_name' => strtoupper($route), 'timing' => $timing[0], 'time_format' => $timing[1], 'time_order' => $timeOrder, 'status' => 1]  
      );
   }
      return back()->with('success', 'Shift has been added successfully!');
   }
   public function shiftList(Request $request){
      $query = filter_var(request('route_name')) ? request('route_name') : '';
      $shiftName = filter_var(request('shift_name')) ? request('shift_name') : '';
      $shifts = DB::table('shifts')
         ->when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('route_name', 'like', '%' . $query . '%');
         })
         ->when($shiftName, function ($queryBuilder) use ($shiftName) {
            return $queryBuilder->where('shift_name', $shiftName);
         })
         ->orderBy('time_order', 'asc')
         ->paginate(Config::get('pagination.per_page'))
         ->withQueryString();
         $cities = DB::table('cities')->where('status', '1')->get();
      return view('shift.shifts', compact('shifts', 'cities'));
   }
   
   public function editShift(Request $request){
      $id = $request->query('id');
      $shift = DB::table('shifts')->where('id', $id)->first();
      if (!$shift) {
         return redirect()->route('shift.list')->with('error', 'Shift not found.');
      }
      $cities = DB::table('cities')->where('status', '1')->get();
      return view('shift.shift-edit', compact('shift', 'cities'));
   }
   public function postEditShift(Request $request){
      $id = $request->input('id');
      $shiftName = $request->input('shift_name');
      $timing = explode(' ', $request->input('timing'));
      $timeOrder = str_replace(':', '', $timing[0]);
      DB::table('shifts')->where('id', $id)->update(
         ['shift_name' => strtoupper($shiftName), 'timing' => $timing[0], 'time_format' => $timing[1], 'time_order' => $timeOrder, 'status' => 1]  
      );
      return back()->with('success', 'Shift has been updated successfully!');
   }
   public function deleteShift($id){
      DB::table('shifts')->where('id', $id)->delete();
      return back()->with('success', 'Shift has been deleted successfully!');
   }

   public function carouselList(Request $request){
      $query = filter_var(request('status')) ? request('status') : '';
      $type = filter_var(request('type')) ? request('type') : '';
      $carousels = DB::table('carousels')
         ->when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('status', $query);
         })
         ->when($type, function ($queryBuilder) use ($type) {
            return $queryBuilder->where('type', $type);
         })
         ->orderBy('id', 'desc')
         ->paginate(Config::get('pagination.per_page'))
         ->withQueryString();
      return view('carousel.list', compact('carousels'));
   }

   public function carouselAdd(){
      return view('carousel.add');
   }
   public function postCarousel(Request $request){
      $type = $request->input('type');
      $link = $request->input('link');
      $sort = $request->input('sort');
      $status = $request->input('status');
      if($request->hasFile('image_path')){
         $file = $request->file('image_path');
         $filename = time().'_'.$file->getClientOriginalName();
         $filePath = $file->storeAs('storage/carousel', $filename);
        $imagePath = 'storage/carousel/' . $filename;
         DB::table('carousels')->insert(
            ['type' => strtoupper($type), 'link' => $link, 'sort' => $sort, 'status' => $status, 'image_path' => $filePath]  
         );
         return back()->with('success', 'Carousel has been added successfully!');
      }else{
         return back()->with('error', 'Image upload failed. Please try again.');
      }
   }

   public function editCarousel(Request $request){
      $id = $request->query('id');
      $carousel = DB::table('carousels')->where('id', $id)->first();
      if (!$carousel) {
         return redirect()->route('carousel.list')->with('error', 'Carousel not found.');
      }
      return view('carousel.edit', compact('carousel'));
   }
   public function postEditCarousel(Request $request){
      $id = $request->input('id');
      $type = $request->input('type');
      $link = $request->input('link');
      $sort = $request->input('sort');
      $status = $request->input('status');
      if($request->hasFile('image_path')){
         $file = $request->file('image_path');
         $filename = time().'_'.$file->getClientOriginalName();
         $filePath = $file->storeAs('public/carousel', $filename);
         $imagePath = 'storage/carousel/' . $filename;
         DB::table('carousels')->where('id', $id)->update(
            ['type' => strtoupper($type), 'link' => $link, 'sort' => $sort, 'status' => $status, 'image_path' => $imagePath]  
         );
         return back()->with('success', 'Carousel has been updated successfully!');
      }else{
         DB::table('carousels')->where('id', $id)->update(
            ['type' => strtoupper($type), 'link' => $link, 'sort' => $sort, 'status' => $status]  
         );
         return back()->with('success', 'Carousel has been updated successfully!');
      }
   }
   public function deleteCarousel($id){
      DB::table('carousels')->where('id', $id)->delete();
      return back()->with('success', 'Carousel has been deleted successfully!');
   }


}


