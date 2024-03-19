<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">
    <div class="media user-profile mt-2 mb-2">
        <img src="{{ URL::asset('assets/images/avatar.png') }}" class="avatar-sm rounded-circle mr-2"
            alt="admin-template" />

        <div class="media-body">
            @if (auth()->check())
                <h6 class="pro-user-name mt-0 mb-0">{{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}
                </h6>
                <span class="badge badge-info pro-user-desc">{{ role_name(auth()->user()->type) }}</span>
                <br>

                {{--                @if (auth()->check() && auth()->user()->type != 'agent') --}}
                {{--                @else --}}
                {{--                    <span class="pro-user-desc">{{ 'A/C No. ' .agentAccount() }}</span> --}}
                {{--                @endif --}}
            @endif
        </div>

        <div class="dropdown align-self-center profile-dropdown-menu">
            <a class="dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                aria-expanded="false">
                <span data-feather="chevron-down"></span>
            </a>
            <div class="dropdown-menu profile-dropdown">
                <a href="" class="dropdown-item notify-item">
                    <i data-feather="settings" class="icon-dual icon-xs mr-2"></i>
                    <span>Settings</span>
                </a>
                <div class="dropdown-divider"></div>

                <a href="{{ route('logout') }}" class="dropdown-item notify-item">
                    <i data-feather="log-out" class="icon-dual icon-xs mr-2"></i>
                    <span>Logout</span>
                </a>
            </div>
        </div>
    </div>
    <div class="sidebar-content">
        <!--- Sidemenu -->
        <div id="sidebar-menu" class="slimscroll-menu">
            @include('layouts.shared.app-menu')
        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
