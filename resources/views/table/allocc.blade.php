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
                                            <a class="btn-transition btn btn-outline-primary" href="#">{{$value->site_id}}</a>
                                        </td>
                                        <td class="text-center">{{substr($value->site_name, 0, 17)}}</td>
                                        <td class="text-center">{{$value->bw_current}}</td>
                                        <td class="text-center"><i class="pe-7s-angle-up-circle icon-gradient bg-malibu-beach" style="font-size:35px"></i></td>
                                        <td class="text-center"></td>

                                    <?php
                                        if($value->max_occ_today < 50){
                                            echo '<td class="text-center"><button class="btn-transition btn btn-outline-success">'.$value->max_occ_today.'</button></td>';
                                        }else{
                                            echo '<td class="text-center"><button class="btn-transition btn btn-outline-warning">'.$value->max_occ_today.'</button></td>';
                                        }
                                        if($value->max_occ_week < 50){
                                            echo '<td class="text-center"><button class="btn-transition btn btn-outline-success">'.$value->max_occ_week.'</button></td>';
                                        }else{
                                            echo '<td class="text-center"><button class="btn-transition btn btn-outline-warning">'.$value->max_occ_week.'</button></td>';
                                        }
                                        if($value->max_occ_month < 50){
                                            echo '<td class="text-center"><button class="btn-transition btn btn-outline-success">'.$value->max_occ_month.'</button></td>';
                                        }else{
                                            echo '<td class="text-center"><button class="btn-transition btn btn-outline-warning">'.$value->max_occ_month.'</button></td>';
                                        }
                                        if($value->max_occ_year < 50){
                                            echo '<td class="text-center"><button class="btn-transition btn btn-outline-success">'.$value->max_occ_year.'</button></td>';
                                        }else{
                                            echo '<td class="text-center"><button class="btn-transition btn btn-outline-warning">'.$value->max_occ_year.'</button></td>';
                                        }
                                    ?>
                                    </tr>
                                    @endforeach 
                                </tbody>
                            </table>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Page</h5> 
                            <nav class="" aria-label="Page navigation example">
                                <ul class="pagination">
                                    <li class="page-item"><a href="javascript:void(0);" class="page-link" aria-label="Previous"><span aria-hidden="true">«</span><span class="sr-only">Previous</span></a>
                                    </li>
                                    <?php 
                                        $page=1;
                                        for($i=1;$i<=10;$i++)
                                        if ($i != $page){
                                        ?>

                                        <li class='page-item'>
                                            <button class="page-link" value="<?php echo $i; ?>"><?php echo $i; ?></button>
                                        </li>
                                        <?php 
                                        }
                                        else{ 
                                         echo " <li class='page-item'>
                                                    <button class='page-link'>$i</button>
                                                </li>"; 
                                        }
                                    ?>
                                    <li class="page-item"><a href="javascript:void(0);" class="page-link" aria-label="Next"><span aria-hidden="true">»</span><span class="sr-only">Next</span></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>