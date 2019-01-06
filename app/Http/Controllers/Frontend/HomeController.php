<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Frontend\FrontendController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;


class HomeController extends FrontendController
{
    
    public function index() {
       
        return view('frontend.home');
    }
}
