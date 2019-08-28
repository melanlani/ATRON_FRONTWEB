<div class="row">
    <div class="col-md-12">            
        <div class="main-card mb-3 card">
            <div class="card-header">Data Occupancy Regional {{$tregs}} Category {{$category}}
                <div class="btn-actions-pane-right">
                    <button class="mb-2 mr-2 btn btn-success" data-toggle="modal" data-target="#addNode">Add Data
                        <i class="metismenu-icon pe-7s-plus"></i>
                    </button>
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
                                        <th class="text-center">Info</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($occAlert as $all)
                                    <tr>
                                        <td class="text-center">{{$all['witel']}}</td>
                                        <td class="text-center">
                                            <a class="btn-transition btn btn-outline-primary" href="#">{{$all['site_id']}}</a>
                                        </td>
                                        <td class="text-center">{{substr($all['site_name'], 0, 20)}}</td>
                                        <td class="text-center">{{$all['bw_current']}}</td>
                                        <td class="text-center"><i class="pe-7s-angle-up-circle icon-gradient bg-malibu-beach" style="font-size:35px"></i></td>
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
                                        <td class="text-center">
                                            <button class="btn-transition btn btn-outline-primary">Edit
                                            </button>
                                            <button class="btn-transition btn btn-outline-danger">Delete
                                            </button>
                                        </td>
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

