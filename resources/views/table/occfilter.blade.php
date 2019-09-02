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
                <td class="text-center">{{$value->last_occ}}</td>

            <?php
                if($value->max_occ_today < 50){
                    echo '<td class="text-center"><div class="btn-transition btn btn-outline-success">'.$value->max_occ_today.'</div></td>';
                }else{
                    echo '<td class="text-center"><div class="btn-transition btn btn-outline-warning">'.$value->max_occ_today.'</div></td>';
                }
                if($value->max_occ_week < 50){
                    echo '<td class="text-center"><div class="btn-transition btn btn-outline-success">'.$value->max_occ_week.'</div></td>';
                }else{
                    echo '<td class="text-center"><div class="btn-transition btn btn-outline-warning">'.$value->max_occ_week.'</div></td>';
                }
                if($value->max_occ_month < 50){
                    echo '<td class="text-center"><div class="btn-transition btn btn-outline-success">'.$value->max_occ_month.'</div></td>';
                }else{
                    echo '<td class="text-center"><div class="btn-transition btn btn-outline-warning">'.$value->max_occ_month.'</div></td>';
                }
                if($value->max_occ_year < 50){
                    echo '<td class="text-center"><div class="btn-transition btn btn-outline-success">'.$value->max_occ_year.'</div></td>';
                }else{
                    echo '<td class="text-center"><div class="btn-transition btn btn-outline-warning">'.$value->max_occ_year.'</div></td>';
                }
            ?>
            </tr>
            @endforeach 
            </tbody>
        </table>
    </div>
    <?php
    $length = $total;
    $limit = 10;
    $page = $page;
    $max_page = ceil($total/$limit);
    if($page < 1){
        $page= 1;
    }else if($page > $max_page){
        $page=$max_page;
    }
    ?>
    <div class="card-body">
        <nav class="" aria-label="Page navigation example">
            <ul class="pagination">
            <?php if($page > 1) {?>
                <li class="page-item">
                    <button onclick="getURL('<?php echo $page-1; ?>')" class="page-link" aria-label="Prev">
                        <span aria-hidden="true">Prev</span>
                    </button>
                </li>
            <?php }else if($page <= 1){ ?>
                <li class="page-item disabled">
                    <div class="page-link">
                        <span aria-hidden="true">Prev</span>
                    </div>
                </li>
            <?php } ?>
                <li class="page-item">
                    <div class="page-link">
                        {{$page}}
                    </div>
                </li>
            <?php if($page < $max_page) {?>
                <li class="page-item">
                    <button onclick="getURL('<?php echo $page+1; ?>')" class="page-link" aria-label="Next">
                        <span aria-hidden="true">Next</span>
                    </button>
                </li>
            <?php }else if($page >= $max_page){?>
                <li class="page-item disabled">
                    <div class="page-link">
                        <span aria-hidden="true">Next</span>
                    </div>
                </li>
            <?php } ?>

            </ul>
        </nav>
    </div>
</div>

