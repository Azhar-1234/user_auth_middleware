<?php

namespace App\Http\Controllers\backEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MonthlyController extends Controller
{
    public function view(){
    	return view('backEnd.user.monthly-cost');
    }
}
