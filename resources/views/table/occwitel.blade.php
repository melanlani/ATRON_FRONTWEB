<div class="main-card mb-3 card">
    <div class="card-header">NODE B OCCUPANCY OVERVIEW
    </div>
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
				<tbody>
					@foreach ($witelUtils as $keyTreg => $valWitel) 
                    <tr>
                        <td class="text-center">{{$valWitel->witel}}</td>
                        <td class="text-center"><a class="btn-transition btn btn-outline-success" href="#">{{$valWitel->linkStatus["normal"]}}</a></td>
                        <td class="text-center"><a class="btn-transition btn btn-outline-warning" href="#">{{$valWitel->linkStatus["warning"]}}</a></td>
                        <td class="text-center"><a class="btn-transition btn btn-outline-danger" href="#">{{$valWitel->linkStatus["critical"]}}</a></td>
                        <td class="text-center"><a class="btn-transition btn btn-outline-primary" href="#">{{$valWitel->subTotal}}</a></td>
                    </tr>
                    @endforeach              
                </tbody>
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
        