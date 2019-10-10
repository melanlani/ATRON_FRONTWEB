<div class="row">
    <div class="col-md-12">            
        <div class="main-card mb-3 card">
            <div class="card-header">All Data Occupancy
                <div class="btn-actions-pane-right">
                    <button class="mb-2 mr-2 btn btn-success-second" data-toggle="modal" data-target="#addNode">Add Data
                        <i class="metismenu-icon pe-7s-plus"></i>
                    </button>
                </div>
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
                                        <th class="text-center">Port Uplink</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($basic as $all)
                                        @foreach ($all['data'] as $data)
                                    <tr>
                                        <td class="text-center">{{$all['treg']}}</td>
                                        <td class="text-center">{{$all['witel']}}</td>
                                        <td class="text-center">
                                            <a class="btn-transition btn btn-outline-primary" href="#">{{$all['site_id']}}</a>
                                        </td>
                                        <td class="text-center">{{$all['site_name']}}</td>
                                        <td class="text-center">{{$all['bw_current']}}</td>
                                        <td class="text-center">{{$data['port_uplink']}}</td>
                                        <td class="text-center">
                                            <button class="mb-2 mr-2 btn btn-primary" title="Edit"><i class="metismenu-icon pe-7s-note"></i>
                                            </button>
                                            <button class="mb-2 mr-2 btn btn-danger" title="Delete"><i class="metismenu-icon pe-7s-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                        @endforeach
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



