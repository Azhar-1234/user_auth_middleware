<?php

namespace App\Http\Controllers\frontEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function home(){
        return 'home';
    }
}
