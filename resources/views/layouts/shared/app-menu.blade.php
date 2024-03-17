<ul class="metismenu" id="menu-bar">
    <li class="menu-title">Navigation</li>
    <li>
        <a href="{{ route('dashboard') }}">
            <i data-feather="airplay"></i>
            <span> Dashboard </span>
        </a>
    </li>

    <li>
        <a href="javascript: void(0);">
            <i data-feather="user"></i>
            <span> User Management </span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="nav-second-level" aria-expanded="false">
            <li>
                <a href="{{ route('users.index') }}">
                    <i data-feather="users"></i>
                    <span> Users </span>
                </a>
            </li>
        </ul>
    </li>

    <li>
        <a href="javascript: void(0);">
            <i data-feather="dollar-sign"></i>
            <span> Bet Management</span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="nav-second-level" aria-expanded="false">
            <li>
                <a href="{{ route('bets.index') }}">
                    <i data-feather="dollar-sign"></i>
                    <span> Bets </span>
                </a>
            </li>
        </ul>
    </li>

    <li>
        <a href="javascript: void(0);">
            <i data-feather="dollar-sign"></i>
            <span> Game Management</span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="nav-second-level" aria-expanded="false">
            <li>
                <a href="{{ route('games.index') }}">
                    <i data-feather="life-buoy"></i>
                    <span> Games </span>
                </a>
            </li>
            <li>
                <a href="{{ route('gametypes.index') }}">
                    <i data-feather="life-buoy"></i>
                    <span> Game Types </span>
                </a>
            </li>
        </ul>
    </li>

    <li class="menu-title">Account Management</li>
    <li>
        <a href="javascript: void(0);">
            <i data-feather="book-open"></i>
            <span> Accounts </span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="nav-second-level" aria-expanded="false">
            <li>
                <a href=""> <i data-feather="plus-circle"></i> Wins</a>
            </li>
            <li>
                <a href=""> <i data-feather="minus-circle"></i>
                    Losses</a>
            </li>
        </ul>
    </li>

    <li class="menu-title">System Configurations</li>
    <li>
        <a href="javascript: void(0);">
            <i data-feather="sliders"></i>
            <span> Configure </span>
            <span class="menu-arrow"></span>
        </a>

        <ul class="nav-second-level" aria-expanded="false">
            <li>
                <a href="{{ route('roles.index') }}"> <i class="uil uil-briefcase"></i> Roles</a>
            </li>
            <li>
                <a href=""> <i class="uil uil-key-skeleton-alt"></i>
                    Permissions</a>
            </li>
        </ul>
    </li>
</ul>
