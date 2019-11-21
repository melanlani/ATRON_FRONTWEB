<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use MongoDB\BSON\UTCDateTime;
use App\BasicInfo;
use App\Periodic;

class TregUtilization
{
	public $witel;
}

class NodebRegController extends Controller
{
	public function index(){		
		$treg= (int)Auth::user()->role;
		//NODE B OCCUPANCY OVERVIEW
        $data_witel = BasicInfo::raw(function($collection) use ($treg){
            return $collection->aggregate([
                    ['$match' => ['treg' => $treg ] ],
                    ['$group' => ['_id' => '$witel' ] ],
                    [ '$project' => ['_id'=> 0, 'witel'=>'$_id'] ]
                ]);
            });

        $timerange = new UTCDateTime(strtotime('today')*1000); //to milisecond
        
        $witelUtils = [];
        $witels = [];
        $totalNormal = 0;
        $totalWarning = 0;
        $totalCritical = 0;
        $totalSubTotal = 0;

        foreach ($data_witel as $key => $value) {
            array_push($witels, sprintf("%s", $value->witel));
        }

        foreach ($witels as $key => $witel) {
            $normal = 0;
            $warning = 0;
            $critical = 0;

            $basic_info = BasicInfo::raw(function($collection) use ($witel){
                return $collection->find(["witel" => $witel]);
            });

            $site_ids = [];
            foreach ($basic_info as $key => $value) {
                array_push($site_ids, sprintf("%s", $value->site_id));
            }

            $occreg = $this->getOccbasBySiteIDs('today', $site_ids);

            $witelUtil = new TregUtilization();
            $witelUtil->witel = $witel;

            foreach ($occreg as $keyOcc => $occ) {
                if($occ->max_occ < 50 ){
                    $normal++;
                } else if ($occ->max_occ >= 50 && $occ->max_occ <= 70 ){
                    $warning++;
                } else if ($occ->max_occ > 70 ){
                    $critical++;
                }
            }

            $witelUtil->linkStatus = [
                "normal" => $normal,
                "warning" => $warning,
                "critical" => $critical,
            ];

            $subTotal = $normal+$warning+$critical;
            
            $witelUtil->subTotal = $subTotal;

            $totalNormal += $normal;
            $totalWarning += $warning;
            $totalCritical += $critical;
            $totalSubTotal += $subTotal;

            array_push($witelUtils, $witelUtil);
        }
            $witelUtilTotal = new TregUtilization();
            $witelUtilTotal->linkStatus = [
                    "normal" => $totalNormal,
                    "warning" => $totalWarning,
                    "critical" => $totalCritical,
                ];
            $witelUtilTotal->subTotal = $totalSubTotal;

        return view('NodebRegional',[
                'witelUtils' => $witelUtils, 'witelUtilTotal' => $witelUtilTotal, 'treg'=>$treg
            ]);
	}

	public function getOccbasBySiteIDs($timeformat, $site_ids){
        $starttime = 0;
        $endtime = 0;
        date_default_timezone_set('Asia/Jakarta');
        if( $timeformat == 'today'){
            $starttime = new UTCDateTime((strtotime(date("H:i"))+360*60)*1000); //to milisecond
            $endtime=new UTCDateTime(strtotime(date("Y-m-d 06:00:00"))*1000);
        }else if( $timeformat == 'this week'){   
            $starttime = new UTCDateTime((strtotime(date("H:i"))+360*60)*1000); //to milisecond
            $endtime = new UTCDateTime(strtotime(date("Y-m-d 06:00:00", strtotime('sunday last week')))*1000); //to milisecond
        }else if( $timeformat == 'this month'){
            $starttime = new UTCDateTime((strtotime(date("H:i"))+360*60)*1000); //to milisecond
            $endtime = new UTCDateTime(strtotime(date("Y-m-d 06:00:00", strtotime('first day of this month')))*1000); //to milisecond
        }else if( $timeformat == 'this year'){
            $starttime = new UTCDateTime((strtotime(date("H:i"))+360*60)*1000); //to milisecond
            $endtime = new UTCDateTime(strtotime(date("Y-m-d 06:00:00", strtotime('first day of january this year')))*1000); //to milisecond
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
                                        'dt'=>[
                                            '$gt' => $endtime
                                        ]
                                    ],
                                    [
                                        'dt'=>[
                                            '$lt' => $starttime
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
                                "max_occ"=> [ '$max'=> ['$max'=> '$data.occ']]
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
