	<!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li class="menu-title">
                        <span>Main</span>
                    </li>
                    <li class="submenu">
                        <a href="#" class="noti-dot">
                            <i class="la la-dashboard"></i>
                            <span> Dashboard</span> <span class="menu-arrow"></span>
                        </a>
                        <ul style="display: none;">
                            <li><a class="{{ (\Request::route()->getName() == 'admin.home') ? 'active' : '' }}" href="{{ route('admin.home') }}">Admin Dashboard</a></li>
                        </ul>
                    </li>
                    
                 {{-- ----------------------------------------------------------------User Menu  ----------------------------------------------------------------}}
                    <li class="submenu"> <a href="#"><i class="la la-user"></i>
                        <span> Users </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ (\Request::route()->getName() == 'admin.userManagement') ? 'active' : '' }}" href="{{ route('admin.userManagement') }}"> All User </a></li>
                            <li><a href="#">Users List</a></li>
                            <li><a href="#">Users Wallet</a></li>
                        </ul>
                    </li>

                    <li class="submenu"> <a href="#"><i class="fa fa-cog"></i>
                        <span> Setting </span> <span class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ (\Request::route()->getName() == 'admin.countrysetting') ? 'active' : '' }}" href="{{ route('admin.countrysetting') }}">Country List</a></li>
                            <li><a href="#">TimeZone List</a></li>
                            <li><a href="#">Currency List</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
	<!-- /Sidebar -->