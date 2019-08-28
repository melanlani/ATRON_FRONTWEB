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
