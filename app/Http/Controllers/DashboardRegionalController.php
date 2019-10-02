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

class AllBasic
{
	public $week;
}

class DashboardRegionalController extends Controller
{
    public function home(){
        $total = BasicInfo::count();
        //NODE B OCCUPANCY OVERVIEW
        $tregUtils = [];
        $tregs = [1,2,3,4,5,6,7];
        $totalNormal = 0;
        $totalWarning = 0;
        $totalCritical = 0;
        $totalSubTotal = 0;

        foreach ($tregs as $key => $treg) {
	        $normal = 0;
	        $warning = 0;
	        $critical = 0;
            $basic_info = BasicInfo::raw(function($collection) use ($treg){
                return $collection->find(["treg" => $treg]);
            });

            $site_ids = [];
            foreach ($basic_info as $key => $value) {
                array_push($site_ids, sprintf("%s", $value->site_id));
            }

            $occbas = $this->getOccbasBySiteIDs('today', $site_ids);
            $tregUtil = new TregUtilization();
            $tregUtil->treg = $treg;

            foreach ($occbas as $keyOcc => $occ) {
                if($occ->max_occ < 50 ){
                    $normal++;
                } else if ($occ->max_occ >= 50 && $occ->max_occ <= 70 ){
                    $warning++;
                } else if ($occ->max_occ > 70 ){
                    $critical++;
                }
            }

            $tregUtil->linkStatus = [
			    "normal" => $normal,
			    "warning" => $warning,
			    "critical" => $critical,
			];

			$subTotal = $normal+$warning+$critical;
            
            $tregUtil->subTotal = $subTotal;

            $totalNormal += $normal;
            $totalWarning += $warning;
            $totalCritical += $critical;
            $totalSubTotal += $subTotal;

            array_push($tregUtils, $tregUtil);
        }

        $tregUtilTotal = new TregUtilization();
        $tregUtilTotal->linkStatus = [
			    "normal" => $totalNormal,
			    "warning" => $totalWarning,
			    "critical" => $totalCritical,
			];
		$tregUtilTotal->subTotal = $totalSubTotal;

    	// //ALL DATA OCCUPANCY
    	$topnOccbas = $this->getTopNAllTregOccbas('today',10, 0);
        $resultSiteIds = [];
        foreach ($topnOccbas as $key => $value) {
            array_push($resultSiteIds, sprintf("%s", $value->site_id));
        }
        $occbasToday = $this->getOccbasBySiteIDs('today', $resultSiteIds);
        $occbasWeek = $this->getOccbasBySiteIDs('this week', $resultSiteIds);
        $occbasMonth = $this->getOccbasBySiteIDs('this month', $resultSiteIds);
        $occbasYear = $this->getOccbasBySiteIDs('this year', $resultSiteIds);

        $allOccBas=[];
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
            array_push($allOccBas, $value);
        }

        // $timerange = new UTCDateTime(strtotime('this month')*1000); //to milisecond
        // echo $timerange;
        return view('dashboard', compact('tregUtils','tregUtilTotal','allOccBas','total'));
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

    public function getTopNAllTregOccbas($timeformat, $limit, $skip){
    	$todaytimerange = new UTCDateTime(strtotime($timeformat)*1000); //to milisecond
		$alloccbas = Periodic::raw(function($collection) use ($todaytimerange, $limit, $skip){
		        return $collection->aggregate([
		            [
		                '$match' => [
                            'dt' => [
                                '$gte' => $todaytimerange
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
		                    'treg' => '$basic_info.treg'
		                ]
		            ],
					[
						'$sort' => [
							'bw_current' => -1
						]
					],
                    [ 
                        '$skip' => $skip
                    ],
		            [ 
		            	'$limit' => $limit
		            ]
		        ]
		    );
		});

		return $alloccbas;
    }

    public function paginationAllOcc(Request $request){
        $page = (int)$request->page;
        $total = BasicInfo::count();
        $limit = 10;
        if ($page < 1) {
            $page = 1;
        }
        $skip = ($page-1)*$limit;
        // //ALL DATA OCCUPANCY
        $topnOccbas = $this->getTopNAllTregOccbas('today',$limit, $skip);
        $resultSiteIds = [];
        foreach ($topnOccbas as $key => $value) {
            array_push($resultSiteIds, sprintf("%s", $value->site_id));
        }
        $occbasToday = $this->getOccbasBySiteIDs('today', $resultSiteIds);
        $occbasWeek = $this->getOccbasBySiteIDs('this week', $resultSiteIds);
        $occbasMonth = $this->getOccbasBySiteIDs('this month', $resultSiteIds);
        $occbasYear = $this->getOccbasBySiteIDs('this year', $resultSiteIds);

        $allOccBas=[];
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
            array_push($allOccBas, $value);
        }

        return view('table.occfilter',['allOccBas' => $allOccBas, 'page' => $page, 'total' => $total]);

    }

    public function filter(Request $request){
    	$treg = (int)$request->treg;

        if($treg != 'all'){
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
            
            
            return view('table.page_group_filter',[
                'witelUtils' => $witelUtils, 'witelUtilTotal' => $witelUtilTotal, 'treg'=>$treg
            ]);
        }else{
            //NODE B OCCUPANCY OVERVIEW
            $tregUtils = [];
            $tregs = [1,2,3,4,5,6,7];
            $totalNormal = 0;
            $totalWarning = 0;
            $totalCritical = 0;
            $totalSubTotal = 0;

            foreach ($tregs as $key => $treg) {
                $normal = 0;
                $warning = 0;
                $critical = 0;
                $basic_info = BasicInfo::raw(function($collection) use ($treg){
                    return $collection->find(["treg" => $treg]);
                });

                $site_ids = [];
                foreach ($basic_info as $key => $value) {
                    array_push($site_ids, sprintf("%s", $value->site_id));
                }

                $occbas = $this->getOccbasBySiteIDs('today', $site_ids);
                $tregUtil = new TregUtilization();
                $tregUtil->treg = $treg;

                foreach ($occbas as $keyOcc => $occ) {
                    if($occ->max_occ < 50 ){
                        $normal++;
                    } else if ($occ->max_occ >= 50 && $occ->max_occ <= 70 ){
                        $warning++;
                    } else if ($occ->max_occ > 70 ){
                        $critical++;
                    }
                }

                $tregUtil->linkStatus = [
                    "normal" => $normal,
                    "warning" => $warning,
                    "critical" => $critical,
                ];

                $subTotal = $normal+$warning+$critical;
                
                $tregUtil->subTotal = $subTotal;

                $totalNormal += $normal;
                $totalWarning += $warning;
                $totalCritical += $critical;
                $totalSubTotal += $subTotal;

                array_push($tregUtils, $tregUtil);
            }

            $tregUtilTotal = new TregUtilization();
            $tregUtilTotal->linkStatus = [
                    "normal" => $totalNormal,
                    "warning" => $totalWarning,
                    "critical" => $totalCritical,
                ];
            $tregUtilTotal->subTotal = $totalSubTotal;

            return view('table.page_group',[
                'tregUtils' => $tregUtils, 'tregUtilTotal' => $tregUtilTotal
            ]);
        }	
      	
    }

}
