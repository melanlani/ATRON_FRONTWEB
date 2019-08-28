<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\BSON\UTCDateTime;
use App\BasicInfo;
use App\Periodic;

class TregUtilization
{
	public $treg;
	public $witel;
}

class AlertWitelController extends Controller
{
    public function index(){

    }

    public function alertdetail($witel, $category){
        $basic_info = BasicInfo::raw(function($collection) use ($witel){
            return $collection->find(["witel" => $witel]);
        });

        $site_ids = [];
        foreach ($basic_info as $key => $value) {
            array_push($site_ids, sprintf("%s", $value->site_id));
        }

        $occwitel = $this->getOccbasBySiteIDs('-6 hours', $site_ids);

 		if($category == 'normal'){
 			$occAlert=[];
	        foreach ($occwitel as $key => $value) {
	            //<50
	            if($value->max_occ < 50){    
	        		array_push($occAlert, $value);
	        	}
	        }
	        
 		} else if($category == 'warning'){
 			$occAlert=[];
	        foreach ($occwitel as $key => $value) {
	            //>=50
	            if($value->max_occ >= 50 && $value->max_occ <= 70){    
	        		array_push($occAlert, $value);
	        	}
	        }

 		} else if($category == 'critical'){
 			$occAlert=[];
	        foreach ($occwitel as $key => $value) {
	            //>70
	            if($value->max_occ > 70){    
	        		array_push($occAlert, $value);
	        	}
	        }
 		} else if($category == 'all'){
 			$occAlert=[];
	        foreach ($occwitel as $key => $value) {  
	        	array_push($occAlert, $value);
	        }
 		}

        return view('alert',['occAlert' => $occAlert, 'witel' => $witel, 'category' => $category]);
    }

    public function alertTregdetail($treg, $category){
    	$tregs = (int)$treg;
    	$basic_info = BasicInfo::raw(function($collection) use ($tregs){
                return $collection->find(["treg" => $tregs]);
            });

        $site_ids = [];
        foreach ($basic_info as $key => $value) {
            array_push($site_ids, sprintf("%s", $value->site_id));
        }

        $occreg = $this->getOccbasBySiteIDs('-6 hours', $site_ids);

 		if($category == 'normal'){
 			$occAlert=[];
	        foreach ($occreg as $key => $value) {
	            //<50
	            if($value->max_occ < 50){    
	        		array_push($occAlert, $value);
	        	}
	        }
	        
 		} else if($category == 'warning'){
 			$occAlert=[];
	        foreach ($occreg as $key => $value) {
	            //>=50
	            if($value->max_occ >= 50 && $value->max_occ <= 70){    
	        		array_push($occAlert, $value);
	        	}
	        }

 		} else if($category == 'critical'){
 			$occAlert=[];
	        foreach ($occreg as $key => $value) {
	            //>70
	            if($value->max_occ > 70){    
	        		array_push($occAlert, $value);
	        	}
	        }
 		} else if($category == 'all'){
 			$occAlert=[];
	        foreach ($occreg as $key => $value) {  
	        	array_push($occAlert, $value);
	        }
 		}

        return view('alertTreg',['occAlert' => $occAlert, 'tregs' => $tregs, 'category' => $category]);
    }

    public function getOccbasBySiteIDs($timeformat, $site_ids){
    	$timerange = new UTCDateTime(strtotime($timeformat)*1000); //to milisecond
    	$occbas = Periodic::raw(function($collection) use ($timerange, $site_ids){
                    return $collection->aggregate([
                        [
                            '$match' => [
                                '$and' => [
                                    [
                                        'site_id' => [
                                            '$in' => $site_ids
                                        ]
                                    ],
                                    [
                                        'dt' => [
                                            '$gte' => $timerange
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        [
                            '$group' => [
                                '_id' => '$site_id',
                                'dt' => [ '$last'=> '$dt' ],
                                'site_id'=> [ '$last'=> '$site_id' ],
                                'max_occ'=> [ '$max'=> ['$arrayElemAt'=> ['$data.occ', -1] ]]
                            ]
                        ],
                        [
                            '$lookup' => [
                                'from' => 'basic_info',
                                'localField'=> 'site_id',
                                'foreignField'=> 'site_id',
                                'as'=> 'basic_info'
                            ]
                        ],
                        [
                            '$project' => [
                                'dt'=>'$dt',
                                'site_id'=>'$site_id',
                                'max_occ' => '$max_occ',
                                'bw_current' => ['$arrayElemAt'=> ['$basic_info.bw_current', -1] ],
                                'treg' => ['$arrayElemAt'=> ['$basic_info.treg',-1] ],
                                'witel' => ['$arrayElemAt'=> ['$basic_info.witel',-1] ],
                                'site_name' => ['$arrayElemAt'=> ['$basic_info.site_name',-1] ]
                            ]
                        ]
                    ]
                );
            });
    	return $occbas;
    }
}