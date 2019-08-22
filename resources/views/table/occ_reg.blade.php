<div class="col-md-7" id="table2">
    <div class="main-card mb-3 card">
        <div class="card-header">NODE B OCCUPANCY OVERVIEW
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">Regional</th>
                        <th class="text-center"><div class="badge badge-success"><50%</div></th>
                        <th class="text-center"><div class="badge badge-warning">50%-70%</div></th>
                        <th class="text-center"><div class="badge badge-danger">>70%</div></th>
                        <th class="text-center"><div class="badge badge-primary">Total</div></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tregUtils as $keyTreg => $valTreg) 
                    <tr>
                        <td class="text-center">{{$valTreg->treg}}</td>
                        <td class="text-center"><a class="btn-transition btn btn-outline-success" href="#">{{$valTreg->linkStatus["normal"]}}</a></td>
                        <td class="text-center"><a class="btn-transition btn btn-outline-warning" href="#">{{$valTreg->linkStatus["warning"]}}</a></td>
                        <td class="text-center"><a class="btn-transition btn btn-outline-danger" href="#">{{$valTreg->linkStatus["critical"]}}</a></td>
                        <td class="text-center"><a class="btn-transition btn btn-outline-primary" href="#">{{$valTreg->subTotal}}</a></td>
                    </tr>
                    @endforeach              
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center">Total</th>
                        <th class="text-center"><div class="badge badge-success">{{$tregUtilTotal->linkStatus["normal"]}}</div></th>
                        <th class="text-center"><div class="badge badge-warning">{{$tregUtilTotal->linkStatus["warning"]}}</div></th>
                        <th class="text-center"><div class="badge badge-danger">{{$tregUtilTotal->linkStatus["critical"]}}</div></th>
                        <th class="text-center"><div class="badge badge-primary">{{$tregUtilTotal->subTotal}}</div></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>