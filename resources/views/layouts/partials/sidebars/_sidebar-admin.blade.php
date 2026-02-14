<div class="vertical-menu">
    {{-- <div class="top-logo mb-3 ms-3">
        <img src="{{ asset('admin/images/logo-sm.png') }}" class="img-fluid" width="100px">
    </div> --}}
    <div data-simplebar class="h-100">
        <!-- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                {{-- <li class="menu-title">Main</li> --}}

                <li class="">
                    <a href="{{ route('home') }}" class="">
                        <i class="fa fa-home"></i><span> Dashboard </span>
                    </a>
                </li>

                <li class="{{ request()->is('admin/users*') ? 'mm-active' : '' }}">
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
                        <li class="{{ request()->is('admin/roles*') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.roles.index') }}"
                                class="{{ request()->routeIs('admin.roles.index') ? 'active' : '' }}">
                                Roles
                            </a>
                        </li>
                        <li class="{{ request()->is('admin/bank-details*') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.bank-details.edit',1) }}"
                               class="{{ request()->routeIs('admin.bank-details.edit',1) ? 'active' : '' }}">
                                Bank Details
                            </a>
                        </li>
                        {{-- <li class="{{ request()->is('admin/cases*') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.cases.index') }}"
                                class="{{ request()->routeIs('admin.cases.index') ? 'active' : '' }}">
                                Cases
                            </a>
                        </li> --}}
                    </ul>
                </li>
                <li class="{{ request()->is('admin/employees*') || request()->is('admin/employee-payment*') ? 'mm-active' : '' }}">
                    <a href="javascript: void(0);"
                       class="has-arrow waves-effect {{ request()->is('admin/employees*') || request()->is('admin/employee-payment*') ? 'mm-active' : '' }}">
                        <i class="fas fa-users-cog"></i>
                        <span>Team Management</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li class="{{ request()->is('admin/employees*') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.employees.index') }}"
                               class="{{ request()->routeIs('admin.employees.index') ? 'active' : '' }}">
                                Employees
                            </a>
                        </li>
                        <li class="{{ request()->is('admin/employee-payment*') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.employee-payment.index') }}"
                               class="{{ request()->routeIs('admin.employee-payment.index') ? 'active' : '' }}">
                                Payment
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="{{ request()->is('admin/clients*') ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.clients.index') }}"
                        class="{{ request()->routeIs('admin.clients.index') ? 'active' : '' }}">
                        <i class="fa fa-user" aria-hidden="true"></i><span> Clients </span>
                    </a>
                </li>
                <li class="{{ request()->is('admin/cases*') ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.cases.index') }}"
                        class="{{ request()->routeIs('admin.cases.index') ? 'active' : '' }}">
                        <span class="mdi mdi-briefcase-edit-outline pe-2"></span><span> Cases </span>
                    </a>
                </li>
                <li class="{{ request()->is('admin/tasks*') ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.tasks.index') }}"
                        class="{{ request()->routeIs('admin.tasks.index') ? 'active' : '' }}">
                        <span class="mdi mdi-checkbox-multiple-marked-outline pe-2"></span><span> Tasks </span>
                    </a>
                </li>
                <li class="{{ request()->is('admin/reports*') ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.reports.index') }}"
                        class="{{ request()->routeIs('admin.reports.index') ? 'active' : '' }}">
                        <i class="fas fa-sticky-note"></i><span> Reports </span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
