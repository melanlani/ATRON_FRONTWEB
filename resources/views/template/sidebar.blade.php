<div class="app-sidebar sidebar-shadow">
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
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Menu</li>
                @if (Auth::user()->role == 'Admin')
                    <li>
                        <a href="{{ URL::route('home') }}">
                            <i class="metismenu-icon pe-7s-home"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ URL::route('nodeb') }}">
                            <i class="metismenu-icon pe-7s-signal"></i>
                            Node B Administration
                        </a>
                    </li>
                    <li >
                        <a href="{{ URL::route('user') }}">
                            <i class="metismenu-icon pe-7s-user"></i>
                            User Administration 
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{ URL::route('home') }}">
                            <i class="metismenu-icon pe-7s-home"></i>
                            Dashboard
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>