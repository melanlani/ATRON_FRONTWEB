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
    public function index(){
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

            $occbas = $this->getOccbasBySiteIDs('-6 hours', $site_ids);
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
    	$topnOccbas = $this->getTopNAllTregOccbas('today',300, 0);
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

        return view('dashboard', compact('tregUtils','tregUtilTotal','allOccBas','total'));
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
		            	'$limit' => $limit
		            ],
		            [ 
		            	'$skip' => $skip
		            ]
		        ]
		    );
		});

		return $alloccbas;
    }

    public function paginationAllOcc(Request $request){
        $page = (int)$request->page;
        $limit = 10;
        if($page!=0){
            $totaldata = $page*10; //batasan halaman
        } else{
            $totaldata = 10;
        }
        $start = ($page>1) ? ($page * $limit) - $limit : 0;
        // //ALL DATA OCCUPANCY
        $topnOccbas = $this->getTopNAllTregOccbas('today',$totaldata, $start);
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

        return view('table.occfilter',['allOccBas' => $allOccBas, 'page' => $page]);

    }

    public function filter(Request $request){
    	$treg = (int)$request->treg;
		
      	$data_witel = BasicInfo::raw(function($collection) use ($treg){
		return $collection->aggregate([
                ['$match' => ['treg' => $treg ] ],
                ['$group' => ['_id' => '$witel' ] ],
                [ '$project' => ['_id'=> 0, 'witel'=>'$_id'] ]
            ]);
		});

    	$timerange = new UTCDateTime(strtotime('-6 hours')*1000); //to milisecond
    	
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

            $occreg = $this->getOccbasBySiteIDs('-6 hours', $site_ids);

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
       	
       	if(count($data_witel)=="0"){
        	echo "
         	<div class='main-card mb-3 card'>
		        <div class='card-header'>NODE B OCCUPANCY OVERVIEW
		        </div>
		        <div class='table-responsive'>
		            <table class='table table-striped'>
		         		<thead>
						    <tr>
						        <th class='text-center'>Witel</th>
						        <th class='text-center'><div class='badge badge-success'><50%</div></th>
						        <th class='text-center'><div class='badge badge-warning'>50%-70%</div></th>
						        <th class='text-center'><div class='badge badge-danger'>>70%</div></th>
						        <th class='text-center'><div class='badge badge-primary'>Total</div></th>
						    </tr>
						</thead>
						<tbody>
							<tr>
						        <td class='text-center' align='center' colspan='5'>No Data Found Under This TREG</td>
						    </tr>
						</tbody>
						<tfoot>
		                    <tr>
		                        <th class='text-center'>Total</th>
		                        <th class='text-center'><div class='badge badge-success'></div></th>
		                        <th class='text-center'><div class='badge badge-warning'></div></th>
		                        <th class='text-center'><div class='badge badge-danger'></div></th>
		                        <th class='text-center'><div class='badge badge-primary'></div></th>
		                    </tr>
		                </tfoot>
		            </table>
		        </div>
		    </div>
			    ";
       	}else{
	       	return view('table.occwitel',[
	        	'witelUtils' => $witelUtils, 'witelUtilTotal' => $witelUtilTotal
	      	]);
     	}
    }

    public function filter_inner(Request $request){
        $treg = (int)$request->treg;
        
        $data_witel = BasicInfo::raw(function($collection) use ($treg){
        return $collection->aggregate([
                ['$match' => ['treg' => $treg ] ],
                ['$group' => ['_id' => '$witel' ] ],
                [ '$project' => ['_id'=> 0, 'witel'=>'$_id'] ]
            ]);
        });

        $timerange = new UTCDateTime(strtotime('-6 hours')*1000); //to milisecond
        
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

            $occreg = $this->getOccbasBySiteIDs('-6 hours', $site_ids);

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

        return view('template.inner_witel',[
            'witelUtilTotal' => $witelUtilTotal
        ]);
    }

}
