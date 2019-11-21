<div class="row">
    <div class="col-md-12">            
        <div class="main-card mb-3 card">
            <div class="card-header">All Data User
                <div class="btn-actions-pane-right">
                    <button class="mb-2 mr-2 btn btn-success-second" data-toggle="modal" data-target="#addUser">Add Data
                        <i class="metismenu-icon pe-7s-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tabs-eg-77">
                        <div class="widget-content p-0">
                            <table class="table table-striped" id="alluser">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Username</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Role</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $data)
                                        <tr>
                                            <td class="text-center">{{$data->name}}</td>
                                            <td class="text-center">{{$data->username}}</td>
                                            <td class="text-center">{{$data->email}}</td>
                                            @if($data->role == '1' || $data->role == '2' || $data->role =='3' || $data->role =='4' || $data->role =='5' || $data->role =='6' || $data->role =='7')
                                            <td class="text-center">User Regional {{$data->role}}</td>
                                            @else 
                                            <td class="text-center">{{$data->role}}</td>
                                            @endif
                                            <td class="text-center">
                                                <button class="mb-2 mr-2 btn btn-primary" title="Edit" data-toggle="modal" data-target="#editUsers"><i class="metismenu-icon pe-7s-note"></i>
                                                </button>
                                                <a href="/user/delete/{{ $data->id }}" class="mb-2 mr-2 btn btn-danger" onclick="return confirm('Are you sure you want to delete this?')"><i class="metismenu-icon pe-7s-trash"></i></a>
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


