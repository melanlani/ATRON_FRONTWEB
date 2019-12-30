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
        $site_ids = ['BKS563'];       
        $starttime = 0;
        $endtime = 0;
        date_default_timezone_set('Asia/Jakarta');
            $starttime = new UTCDateTime((strtotime(date("H:i"))+360*60)*1000); //to milisecond
            $endtime=new UTCDateTime(strtotime(date("Y-m-d 06:00:00"))*1000);
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
        return $starttime;
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

}
