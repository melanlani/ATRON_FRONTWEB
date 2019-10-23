<div class="app-header header-shadow">
    <div class="app-header__logo">
        <div class="logo-src"></div>
        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="app-header__content">        
        <div class="app-header-right">
            <div class="header-btn-lg pr-0">
                <div class="widget-content p-0">

                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                    <div class="widget-content-wrapper">
                        <div class="widget-content-left  ml-3 header-user-info">
                            <div class="widget-heading">
                                {{ Auth::user()->name }}
                            </div>
                            <div class="widget-subheading">
                                {{ Auth::user()->username }} - {{ Auth::user()->role }}
                            </div>
                        </div>
                        <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                            <button type="button" tabindex="0" class="dropdown-item" data-toggle="modal" data-target="#exampleModal">Edit Profil</button>
                            <button type="button" tabindex="0" class="dropdown-item" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}</button>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </a>
                </div>
            </div>        
        </div>
    </div>   
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">     
                <form class="">
                    <div class="position-relative form-group"><label for="dataBw" class="">NIK</label>
                        <input name="bw_current" id="dataBw" placeholder="1312123122" type="text" class="form-control">
                    </div>
                    <div class="position-relative form-group"><label for="dataBw" class="">Nama</label>
                        <input name="bw_current" id="dataBw" placeholder="Admin" type="text" class="form-control">
                    </div>
                    <div class="position-relative form-group"><label for="dataBw" class="">Email</label>
                        <input name="bw_current" id="dataBw" placeholder="atronteam@yahoo.com" type="email" class="form-control">
                    </div>
                    <div class="position-relative form-group"><label for="dataBw" class="">Password</label>
                        <input name="bw_current" id="dataBw" placeholder="1234" type="password" class="form-control">
                    </div>
                    <div class="position-relative form-group"><label for="dataBw" class="">Role</label>
                        <select name="select" id="exampleSelect" class="form-control">
                            <option disabled="">SA</option>
                            <option value="1" selected>Admin</option>
                            <option disabled="">User</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addNode" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Node B</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="">
                    <div class="position-relative form-group"><label for="dataBw" class="">Regional</label>
                        <select type="select" name="regional" class="custom-select" id="regional" data-dependent="regional">
                            <option value="">Choose Treg</option>
                            <option value="1">TREG 1</option>
                            <option value="2">TREG 2</option>
                            <option value="3">TREG 3</option>
                            <option value="4">TREG 4</option>
                            <option value="5">TREG 5</option>
                            <option value="6">TREG 6</option>
                            <option value="7">TREG 7</option>
                        </select>
                    </div>
                    <div class="position-relative form-group"><label for="dataBw" class="">Witel</label>
                        <select type="select" name="witel" class="custom-select" id="witel" data-dependent="witel">
                            <option value="">Choose Witel</option>
                        </select>
                    </div>
                    <div class="position-relative form-group"><label for="dataBw" class="">Bandwidth</label>
                        <input name="bw_current" id="dataBw" placeholder="" type="text" class="form-control">
                    </div>
                    <div class="position-relative form-group"><label for="dataBw" class="">Site ID</label>
                        <input name="bw_current" id="dataBw" placeholder="" type="text" class="form-control">
                    </div>
                    <div class="position-relative form-group"><label for="dataBw" class="">Site Name</label>
                        <input name="bw_current" id="dataBw" placeholder="" type="text" class="form-control">
                    </div>
                    <div class="position-relative form-group"><label for="dataBw" class="">Port Uplink</label>
                        <select name="select" id="exampleSelect" class="custom-select">
                            <option>0/0/1</option>
                            <option>0/0/0</option>
                            <option>...</option>
                            <option>etc</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="/user/store">
                        {{ csrf_field() }}
                    <div class="position-relative form-group"><label for="dataBw" class="">Nama</label>
                        <input id="name" type="text" class="form-control" name="name">
                    </div>

                    <div class="position-relative form-group"><label for="dataBw" class="">Username</label>
                        <input id="username" type="text" class="form-control" name="username">
                    </div>

                    <div class="position-relative form-group"><label for="dataBw" class="">Email</label>
                        <input id="email" type="email" class="form-control" name="email">
                    </div>

                    <div class="position-relative form-group"><label for="dataBw" class="">Password</label>
                        <input id="password" type="password" class="form-control" name="password">
                    </div>
                    <div class="position-relative form-group"><label for="dataBw" class="">Role</label>
                        <select name="role" class="form-control">
                            <option value="SA">SA</option>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
             
<!-- Modal -->
<div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="">
                    <div class="position-relative form-group"><label for="dataBw" class="">NIK</label>
                        <input name="bw_current" id="dataBw" placeholder="1312123122" type="text" class="form-control">
                    </div>
                    <div class="position-relative form-group"><label for="dataBw" class="">Nama</label>
                        <input name="bw_current" id="dataBw" placeholder="Admin" type="text" class="form-control">
                    </div>
                    <div class="position-relative form-group"><label for="dataBw" class="">Email</label>
                        <input name="bw_current" id="dataBw" placeholder="atronteam@yahoo.com" type="email" class="form-control">
                    </div>
                    <div class="position-relative form-group"><label for="dataBw" class="">Password</label>
                        <input name="bw_current" id="dataBw" placeholder="1234" type="password" class="form-control">
                    </div>
                    <div class="position-relative form-group"><label for="dataBw" class="">Role</label>
                        <select name="select" id="exampleSelect" class="form-control">
                            <option disabled="">SA</option>
                            <option value="1" selected>Admin</option>
                            <option disabled="">User</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>   

