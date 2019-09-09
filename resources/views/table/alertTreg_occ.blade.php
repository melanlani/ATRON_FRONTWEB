<div class="row">
    <div class="col-md-12">            
        <div class="main-card mb-3 card">
            <div class="card-header">Data Occupancy Regional {{$tregs}} Category {{$category}}
                <div class="btn-actions-pane-right">
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tabs-eg-77">
                        <div class="widget-content p-0">
                            <table class="table table-striped" id="alert_occ">
                                <thead>
                                    <tr>
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
                                        <th class="text-center">Category</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($occAlert as $all)
                                    <tr>
                                        <td class="text-center">{{$all['witel']}}</td>
                                        <td class="text-center">
                                            <a class="btn-transition btn btn-outline-primary" href="#">{{$all['site_id']}}</a>
                                        </td>
                                        <td class="text-center">{{substr($all['site_name'], 0, 15)}}</td>
                                        <td class="text-center">{{$all['bw_current']}}</td>
                                        <td class="text-center"><i class="pe-7s-angle-up-circle icon-gradient bg-malibu-beach" style="font-size:35px"></i></td>
                                        <td class="text-center">{{$all->last_occ}}</td>
                                        <?php
                                            if($all->max_occ_today < 50){
                                                echo '<td class="text-center"><div class="btn-transition btn btn-outline-success">'.$all->max_occ_today.'</div></td>';
                                            }else if($all->max_occ_today >= 50 && $all->max_occ_today <= 70){
                                                echo '<td class="text-center"><div class="btn-transition btn btn-outline-warning">'.$all->max_occ_today.'</div></td>';
                                            }else if($all->max_occ_today > 70){
                                                echo '<td class="text-center"><div class="btn-transition btn btn-outline-danger">'.$all->max_occ_today.'</div></td>';
                                            }
                                            if($all->max_occ_week < 50){
                                                echo '<td class="text-center"><div class="btn-transition btn btn-outline-success">'.$all->max_occ_week.'</div></td>';
                                            }else if($all->max_occ_week >= 50 && $all->max_occ_week <= 70){
                                                echo '<td class="text-center"><div class="btn-transition btn btn-outline-warning">'.$all->max_occ_week.'</div></td>';
                                            }else if($all->max_occ_week > 70){
                                                echo '<td class="text-center"><div class="btn-transition btn btn-outline-danger">'.$all->max_occ_week.'</div></td>';
                                            }
                                            if($all->max_occ_month < 50){
                                                echo '<td class="text-center"><div class="btn-transition btn btn-outline-success">'.$all->max_occ_month.'</div></td>';
                                            }else if($all->max_occ_month >= 50 && $all->max_occ_month <= 70){
                                                echo '<td class="text-center"><div class="btn-transition btn btn-outline-warning">'.$all->max_occ_month.'</div></td>';
                                            }else if($all->max_occ_month > 70){
                                                echo '<td class="text-center"><div class="btn-transition btn btn-outline-danger">'.$all->max_occ_month.'</div></td>';
                                            }
                                            if($all->max_occ_year < 50){
                                                echo '<td class="text-center"><div class="btn-transition btn btn-outline-success">'.$all->max_occ_year.'</div></td>';
                                            }else if($all->max_occ_year >= 50 && $all->max_occ_year <= 70){
                                                echo '<td class="text-center"><div class="btn-transition btn btn-outline-warning">'.$all->max_occ_year.'</div></td>';
                                            }else if($all->max_occ_year > 70){
                                                echo '<td class="text-center"><div class="btn-transition btn btn-outline-danger">'.$all->max_occ_year.'</div></td>';
                                            }
                                        ?>
                                        <?php 
                                            if($all['max_occ'] < 50){
                                                echo '<td class="text-center"><div class="badge badge-success"><50%</div></td>';
                                            }
                                            else if($all['max_occ'] >= 50 && $all['max_occ'] <= 70 ){
                                                echo '<td class="text-center"><div class="badge badge-warning">50%-70%</div></td>';
                                            }
                                            else if($all['max_occ'] > 70){
                                                echo '<td class="text-center"><div class="badge badge-danger">>70%</div></td>';
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

