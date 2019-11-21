<div class="col-md-7">
    <div class="main-card mb-3 card">
    <div class="card-header">NODE B OCCUPANCY OVERVIEW Regional {{$treg}}</div>

        <div class="table-responsive">
			<table class="table table-striped">
				<thead>
				    <tr>
				        <th class="text-center">Witel</th>
				        <th class="text-center"><div class="badge badge-success"><50%</div></th>
				        <th class="text-center"><div class="badge badge-warning">50%-70%</div></th>
				        <th class="text-center"><div class="badge badge-danger">>70%</div></th>
				        <th class="text-center"><div class="badge badge-primary">Total</div></th>
				    </tr>
				</thead>

                <?php if(count($witelUtils)=="0"){
                ?>
                <tbody>
                    <tr>
                        <td class='text-center' align='center' colspan='5'>No Data Found Under This TREG</td>
                    </tr>
                </tbody>
                <?php
                }else{ ?>
                <tbody>
                    @foreach ($witelUtils as $keyTreg => $valWitel) 
                        <tr>
                            <td class="text-center">{{$valWitel->witel}}</td>
                            <td class="text-center"><a class="btn-transition btn btn-outline-success" href="{{ route('alert.detail', ['witel' => $valWitel->witel, 'category' => 'normal' ]) }}">{{$valWitel->linkStatus["normal"]}}</a></td>
                            <td class="text-center"><a class="btn-transition btn btn-outline-warning" href="{{ route('alert.detail', ['witel' => $valWitel->witel, 'category' => 'warning' ]) }}">{{$valWitel->linkStatus["warning"]}}</a></td>
                            <td class="text-center"><a class="btn-transition btn btn-outline-danger" href="{{ route('alert.detail', ['witel' => $valWitel->witel, 'category' => 'critical' ]) }}">{{$valWitel->linkStatus["critical"]}}</a></td>
                            <td class="text-center"><a class="btn-transition btn btn-outline-primary" href="{{ route('alert.detail', ['witel' => $valWitel->witel, 'category' => 'all' ]) }}">{{$valWitel->subTotal}}</a></td>
                        </tr>
                    @endforeach              
                </tbody>
                <?php } ?>
                <tfoot>
                    <tr>
                        <th class="text-center">Total</th>
                        <th class="text-center"><div class="badge badge-success">{{$witelUtilTotal->linkStatus["normal"]}}</div></th>
                        <th class="text-center"><div class="badge badge-warning">{{$witelUtilTotal->linkStatus["warning"]}}</div></th>
                        <th class="text-center"><div class="badge badge-danger">{{$witelUtilTotal->linkStatus["critical"]}}</div></th>
                        <th class="text-center"><div class="badge badge-primary">{{$witelUtilTotal->subTotal}}</div></th>
                    </tr>
                </tfoot>
			</table>
		</div>
	</div>
</div>
        