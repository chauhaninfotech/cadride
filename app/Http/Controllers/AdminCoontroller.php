<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminCoontroller extends Controller
{
   public function query(){
    return view('query');
   }


   public function passengerList(){
    return view('user.passenger-list');
   }
}


