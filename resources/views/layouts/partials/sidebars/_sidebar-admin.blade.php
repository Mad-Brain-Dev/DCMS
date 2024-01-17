<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!-- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Main</li>

                <li class="mm-active">
                    <a href="#" class="waves-effect active">
                        <i class="fa fa-home"></i><span> Dashboard </span>
                    </a>
                </li>

                <li
                    class="{{ request()->is('admin/users*') ? 'mm-active' : '' }}">
                    <a href="javascript: void(0);"
                       class="has-arrow waves-effect {{ request()->is('admin/users*') ? 'mm-active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Administration</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li class="{{ request()->is('admin/users*') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.users.index') }}"
                               class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                                Users
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="">
                    <a href="{{ route('admin.clients.index') }}" class="waves-effect active">
                        <i class="fa fa-home"></i><span> Client </span>
                    </a>
                </li>

                <li class="">
                    <a href="{{ route('admin.debtors.index') }}" class="waves-effect active">
                        <i class="fa fa-home"></i><span> Debtor </span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
