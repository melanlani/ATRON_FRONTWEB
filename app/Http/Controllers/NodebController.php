<?php

namespace App\Http\Controllers;

use App\BasicInfo;
use Illuminate\Http\Request;

class NodebController extends Controller
{
    public function index(){
    $basic = BasicInfo::raw(function($collection){
            return $collection->aggregate([
                    ['$lookup' => [
                                    'from' => 'additional_info',
                                    'localField'=> 'site_id',
                                    'foreignField'=> 'site_id',
                                    'as'=> 'data'
                                ] ],
                    ['$limit' =>20 ]
                ]);
            });
    return view('nodeb',compact('basic'));
    }

    public function findWitel(Request $request){
    	$treg = (int)$request->treg;
    	$data_witel = BasicInfo::raw(function($collection) use ($treg){
            return $collection->aggregate([
                    ['$match' => ['treg' => $treg ] ],
                    ['$group' => ['_id' => '$witel' ] ],
                    [ '$project' => ['_id'=> 0, 'witel'=>'$_id'] ]
                ]);
            });
    	if(count($data_witel) !="0"){
	    	foreach($data_witel as $row){
	    		echo '<option value="'.$row->witel.'">'.$row->witel.'</option>';
	    	}
    	}else{
    			echo '<option value="">No Data Found Under This TREG</option>';
    	}
    }
}
