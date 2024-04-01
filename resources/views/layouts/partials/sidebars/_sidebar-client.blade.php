<div class="vertical-menu">

    <div data-simplebar class="h-100">
        <!-- Sidemenu -->
        <div id="sidebar-menu">
            <div class="top-logo mb-3 ms-3">
                <img src="{{ asset('admin/images/logo-sm.png') }}" class="img-fluid" width="100px">
            </div>
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">

                <li class="">
                    <a href="{{ route('home') }}" class="">
                        <i class="fa fa-home"></i><span> Dashboard </span>
                    </a>
                </li>

               {{-- <li class="{{ request()->is('/case/show/to/perticular/client') ? 'mm-active' : '' }}">
                    <a href="{{ route('case.show.perticual.client') }}"
                        class="{{ request()->routeIs('case.show.perticual.client') ? 'active' : '' }}">
                        <span class="mdi mdi-briefcase-edit-outline pe-2"></span><span> Cases </span>
                    </a>
                </li> --}}

                {{-- <li class="{{ request()->is('case/show/client') ? 'mm-active' : '' }}">
                    <a href="{{ route('case.show.client') }}"
                        class="{{ request()->routeIs('case.show.client') ? 'active' : '' }}">
                        <span class="mdi mdi-briefcase-edit-outline pe-2"></span><span> Cases </span>
                    </a>
                </li> --}}

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
