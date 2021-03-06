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

class BoxesController extends Controller
{

    public function occCriticalAll(){

        $tregs = 'All Treg';
        $category = 'Critical';
    	
    	$basic_info = BasicInfo::all();

        $site_ids = [];
        foreach ($basic_info as $key => $value) {
            array_push($site_ids, sprintf("%s", $value->site_id));
        }

        $occreg = $this->getOccbasBySiteIDs('today', $site_ids);

        $resultSiteIds=[];
        foreach ($occreg as $key => $value) {
            //>70
            if($value->max_occ > 70){    
                array_push($resultSiteIds, sprintf("%s", $value->site_id));
            }
        }
        $occbasToday = $this->getOccbasBySiteIDs('today', $resultSiteIds);
        $occbasWeek = $this->getOccbasBySiteIDs('this week', $resultSiteIds);
        $occbasMonth = $this->getOccbasBySiteIDs('this month', $resultSiteIds);
        $occbasYear = $this->getOccbasBySiteIDs('this year', $resultSiteIds);

        $occAlert=[];
        foreach ($occbasToday as $key => $value) {
            //Today
            $value->max_occ_today = $value->max_occ;
            //Week
            foreach ($occbasWeek as $keyWeek => $valueWeek) {
                if($value->site_id == $valueWeek->site_id){
                    $value->max_occ_week = $valueWeek->max_occ;
                }
            }
            //Month
            foreach ($occbasMonth as $keyMonth => $valueMonth) {
                if($value->site_id == $valueMonth->site_id){
                    $value->max_occ_month = $valueMonth->max_occ;
                }
            }
            //Year
            foreach ($occbasYear as $keyYear => $valueYear) {
                if($value->site_id == $valueYear->site_id){
                    $value->max_occ_year = $valueYear->max_occ;
                }
            }
            array_push($occAlert, $value);
        }          
         
        return view('alertTreg',['occAlert' => $occAlert, 'tregs' => $tregs, 'category' => $category]);
    }

    public function occCriticalTreg($treg){

        $tregs = (int)$treg;
        $category = 'Critical';
        
        $basic_info = BasicInfo::raw(function($collection) use ($tregs){
                return $collection->find(["treg" => $tregs]);
            });

        $site_ids = [];
        foreach ($basic_info as $key => $value) {
            array_push($site_ids, sprintf("%s", $value->site_id));
        }

        $occreg = $this->getOccbasBySiteIDs('today', $site_ids);

        $resultSiteIds=[];
        foreach ($occreg as $key => $value) {
            //>70
            if($value->max_occ > 70){    
                array_push($resultSiteIds, sprintf("%s", $value->site_id));
            }
        }
        $occbasToday = $this->getOccbasBySiteIDs('today', $resultSiteIds);
        $occbasWeek = $this->getOccbasBySiteIDs('this week', $resultSiteIds);
        $occbasMonth = $this->getOccbasBySiteIDs('this month', $resultSiteIds);
        $occbasYear = $this->getOccbasBySiteIDs('this year', $resultSiteIds);

        $occAlert=[];
        foreach ($occbasToday as $key => $value) {
            //Today
            $value->max_occ_today = $value->max_occ;
            //Week
            foreach ($occbasWeek as $keyWeek => $valueWeek) {
                if($value->site_id == $valueWeek->site_id){
                    $value->max_occ_week = $valueWeek->max_occ;
                }
            }
            //Month
            foreach ($occbasMonth as $keyMonth => $valueMonth) {
                if($value->site_id == $valueMonth->site_id){
                    $value->max_occ_month = $valueMonth->max_occ;
                }
            }
            //Year
            foreach ($occbasYear as $keyYear => $valueYear) {
                if($value->site_id == $valueYear->site_id){
                    $value->max_occ_year = $valueYear->max_occ;
                }
            }
            array_push($occAlert, $value);
        }          
         
        return view('alertTreg',['occAlert' => $occAlert, 'tregs' => $tregs, 'category' => $category]);
    }

    public function getOccbasBySiteIDs($timeformat, $site_ids){
    	$starttime = 0;
        $endtime = 0;
        if( $timeformat == 'today'){
            $starttime = new UTCDateTime(date(time())*1000); //to milisecond
            $endtime = new UTCDateTime(strtotime('last days')*1000); //to milisecond
        }else if( $timeformat == 'this week'){
            $starttime = new UTCDateTime(date(time())*1000); //to milisecond
            $endtime = new UTCDateTime(strtotime('last week')*1000); //to milisecond
        }else if( $timeformat == 'this month'){
            $starttime = new UTCDateTime(date(time())*1000); //to milisecond
            $endtime = new UTCDateTime(strtotime('last month')*1000); //to milisecond
        }else if( $timeformat == 'this year'){
            $starttime = new UTCDateTime(mktime(0, 0, 0, 1, 1, 2020)*1000); //to milisecond
            $endtime = new UTCDateTime(mktime(0, 0, 0, 1, 1, 2019)*1000); //to milisecond
        }
        $occbas = Periodic::raw(function($collection) use ($starttime,$endtime, $site_ids){
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
                                            '$gt' => $endtime, '$lt' => $starttime
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
                                'last_occ'=> ['$last'=> '$data.occ'],
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
                                'last_occ' => ['$arrayElemAt'=> ['$last_occ', -1] ],
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
