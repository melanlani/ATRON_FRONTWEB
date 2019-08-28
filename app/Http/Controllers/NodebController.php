<?php

namespace App\Http\Controllers;
use App\BasicInfo;

use Illuminate\Http\Request;

class NodebController extends Controller
{
    public function index(){
    	$basic = BasicInfo::skip(0)
    						->take(20)
    						->get();
    return view('nodeb',compact('basic'));
    }
}
