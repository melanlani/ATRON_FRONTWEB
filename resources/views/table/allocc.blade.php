<div class="row">
    <div class="col-md-12">            
        <div class="main-card mb-3 card">
            <div class="card-header">All Data Occupancy
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tabs-eg-77">
                        <div class="widget-content p-0">
                            
                            <table class="table table-striped" id="allocc">
                                <thead>
                                    <tr>
                                        <th class="text-center">Reg</th>
                                        <th class="text-center">Witel</th>
                                        <th class="text-center">Site ID</th>
                                        <th class="text-center">Site Name</th>
                                        <th class="text-center">BW</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Current Occupancy</th>
                                        <th class="text-center">Today Highest</th>
                                        <th class="text-center">Weekly Highest</th>
                                        <th class="text-center">Monthly Highest</th>
                                        <th class="text-center">Yearly Highest</th>
                                    </tr>
                                </thead>
                                <tbody id="table3">
                                    @foreach ($allOccBas as $key => $value)

                                    <tr>
                                        <td class="text-center">{{$value->treg}}</td>
                                        <td class="text-center">{{$value->witel}}</td>
                                        <td class="text-center">
                                            <a class="btn-transition btn btn-outline-primary" href="{{ route('alert.grafik', ['site_id' => $value->site_id, 'site_name' => $value->site_name ]) }}">{{$value->site_id}}</a>
                                        </td>
                                        <td class="text-center">{{substr($value->site_name, 0, 17)}}</td>
                                        <td class="text-center">{{$value->bw_current}}</td>
                                        <td class="text-center"><i class="pe-7s-angle-up-circle icon-gradient bg-malibu-beach" style="font-size:35px"></i></td>
                                        <td class="text-center">{{$value->last_occ}}</td>

                                    <?php
                                            if($value->max_occ_today < 50){
                                                echo '<td class="text-center"><div class="btn-transition btn btn-outline-success">'.$value->max_occ_today.'</div></td>';
                                            }else if($value->max_occ_today >= 50 && $value->max_occ_today <= 70){
                                                echo '<td class="text-center"><div class="btn-transition btn btn-outline-warning">'.$value->max_occ_today.'</div></td>';
                                            }else if($value->max_occ_today > 70){
                                                echo '<td class="text-center"><div class="btn-transition btn btn-outline-danger">'.$value->max_occ_today.'</div></td>';
                                            }
                                            if($value->max_occ_week < 50){
                                                echo '<td class="text-center"><div class="btn-transition btn btn-outline-success">'.$value->max_occ_week.'</div></td>';
                                            }else if($value->max_occ_week >= 50 && $value->max_occ_week <= 70){
                                                echo '<td class="text-center"><div class="btn-transition btn btn-outline-warning">'.$value->max_occ_week.'</div></td>';
                                            }else if($value->max_occ_week > 70){
                                                echo '<td class="text-center"><div class="btn-transition btn btn-outline-danger">'.$value->max_occ_week.'</div></td>';
                                            }
                                            if($value->max_occ_month < 50){
                                                echo '<td class="text-center"><div class="btn-transition btn btn-outline-success">'.$value->max_occ_month.'</div></td>';
                                            }else if($value->max_occ_month >= 50 && $value->max_occ_month <= 70){
                                                echo '<td class="text-center"><div class="btn-transition btn btn-outline-warning">'.$value->max_occ_month.'</div></td>';
                                            }else if($value->max_occ_month > 70){
                                                echo '<td class="text-center"><div class="btn-transition btn btn-outline-danger">'.$value->max_occ_month.'</div></td>';
                                            }
                                            if($value->max_occ_year < 50){
                                                echo '<td class="text-center"><div class="btn-transition btn btn-outline-success">'.$value->max_occ_year.'</div></td>';
                                            }else if($value->max_occ_year >= 50 && $value->max_occ_year <= 70){
                                                echo '<td class="text-center"><div class="btn-transition btn btn-outline-warning">'.$value->max_occ_year.'</div></td>';
                                            }else if($value->max_occ_year > 70){
                                                echo '<td class="text-center"><div class="btn-transition btn btn-outline-danger">'.$value->max_occ_year.'</div></td>';
                                            }
                                        ?>
                                    </tr>
                                    @endforeach 
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
