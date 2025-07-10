<body class="dark-sidenav">
    <!-- Left Sidenav -->
    <div class="left-sidenav">
        <!-- LOGO -->
        <div class="brand">
            <a href="{{ route('admin.dashboard') }}" class="logo">
                <span>
                    <img src="{{ asset('assets/logo/white-logo.png') }}" alt="logo-small"
                        style="width: 215px; margin-top: -64px;">
                </span>
            </a>
        </div>
        <!-- end logo -->

        <div class="menu-content h-100" data-simplebar>
            <ul class="metismenu left-sidenav-menu">

                <!-- Dashboard -->
                 <li>
        <span style="font-weight:bold; margin-left:10px; color: white;">
            Welcome, {{ Auth::user()->name }}
        </span>
    </li>
                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="ti-control-record"></i> Dashboard
                    </a>
                </li>

                @auth

                {{-- =========================== ADMIN =========================== --}}
                @if(auth()->user()->role === 'admin')

                    <!-- Users -->
                    <li>
                        <a href="javascript: void(0);">
                            <i class="ti-control-record"></i> Users
                            <span class="menu-arrow left-has-menu">
                                <i class="mdi mdi-chevron-right"></i>
                            </span>
                        </a>
                        <ul class="nav-second-level">
                            <li><a href="{{ route('add-users.create') }}">Add User</a></li>
                            <li><a href="{{ route('add-users.index') }}">All Users</a></li>
                        </ul>
                    </li>

                    <!-- Developers -->
                    <li>
                        <a href="javascript: void(0);">
                            <i class="ti-control-record"></i> Developers
                            <span class="menu-arrow left-has-menu">
                                <i class="mdi mdi-chevron-right"></i>
                            </span>
                        </a>
                        <ul class="nav-second-level">
                            <li><a href="{{ route('developers.create') }}">Add Developer</a></li>
                            <li><a href="{{ route('developers.index') }}">All Developers</a></li>
                        </ul>
                    </li>

                    <!-- Clients -->
                    <li>
                        <a href="javascript: void(0);">
                            <i class="ti-control-record"></i> Clients
                            <span class="menu-arrow left-has-menu">
                                <i class="mdi mdi-chevron-right"></i>
                            </span>
                        </a>
                        <ul class="nav-second-level">
                            <li><a href="{{ route('clients.create') }}">Add Client</a></li>
                            <li><a href="{{ route('clients.index') }}">All Clients</a></li>
                        </ul>
                    </li>

                    <!-- Company Expense -->
                    <li><a href="{{ route('companyExpense.index') }}">
                        <i class="ti-control-record"></i> Company Expense
                    </a></li>

                    <!-- Attendance -->
                    <li><a href="{{ route('attendances.index') }}">
                        <i class="ti-control-record"></i> Attendance
                    </a></li>

                    <!-- Manage Teams -->
                    <li><a href="{{ route('admin.teams.index') }}">
                        <i class="ti-control-record"></i> Manage Teams
                    </a></li>

                    <!-- Manage Projects -->
                    <li><a href="{{ route('admin.projects.index') }}">
                        <i class="ti-control-record"></i> Manage Projects
                    </a></li>

                    <!-- Manage Tasks -->
                    <li><a href="{{ route('admin.tasks.index') }}">
                        <i class="ti-control-record"></i> Manage Tasks
                    </a></li>

                    <!-- Project Schedule -->
                    <li>
                        <a href="javascript: void(0);">
                            <i class="ti-control-record"></i> Project Schedule
                            <span class="menu-arrow left-has-menu">
                                <i class="mdi mdi-chevron-right"></i>
                            </span>
                        </a>
                        <ul class="nav-second-level">
                            <li><a href="{{ route('projectSchedule.create') }}">Add Schedule</a></li>
                            <li><a href="{{ route('projectSchedule.index') }}">All Schedules</a></li>
                        </ul>
                    </li>

                    <!-- Developer Points -->
                    <li><a href="{{ route('developer.points') }}">
                        <i class="ti-control-record"></i> Developer Points
                    </a></li>

                    <!-- Manage Salaries -->
                    <li><a href="{{ route('admin.salaries.index') }}">
                        <i class="ti-control-record"></i> Manage Salaries
                    </a></li>

                {{-- =========================== TEAM MANAGER =========================== --}}
                @elseif(auth()->user()->role === 'team manager')

                    <!-- Users (View Only) -->
                    <li><a href="{{ route('add-users.index') }}">
                        <i class="ti-control-record"></i> Users
                    </a></li>

                    <!-- Developers -->
                    <li><a href="{{ route('developers.index') }}">
                        <i class="ti-control-record"></i> Developers
                    </a></li>

                    <!-- Clients -->
                    <li><a href="{{ route('clients.index') }}">
                        <i class="ti-control-record"></i> Clients
                    </a></li>

                    <!-- Company Expense -->
                    <li><a href="{{ route('companyExpense.index') }}">
                        <i class="ti-control-record"></i> Company Expense
                    </a></li>

                    <!-- Attendance -->
                    <li><a href="{{ route('attendances.index') }}">
                        <i class="ti-control-record"></i> Attendance
                    </a></li>

                    <!-- Manage Teams -->
                    <li><a href="{{ route('admin.teams.index') }}">
                        <i class="ti-control-record"></i> Manage Teams
                    </a></li>

                    <!-- Manage Projects -->
                    <li><a href="{{ route('admin.projects.index') }}">
                        <i class="ti-control-record"></i> Manage Projects
                    </a></li>

                    <!-- Manage Tasks -->
                    <li><a href="{{ route('admin.tasks.index') }}">
                        <i class="ti-control-record"></i> Manage Tasks
                    </a></li>

                    <!-- Project Schedule -->
                    <li><a href="{{ route('projectSchedule.index') }}">
                        <i class="ti-control-record"></i> Project Schedule
                    </a></li>

                    <!-- Developer Points -->
                    <li><a href="{{ route('developer.points') }}">
                        <i class="ti-control-record"></i> Developer Points
                    </a></li>

                    <!-- Manage Salaries -->
                    <li><a href="{{ route('admin.salaries.index') }}">
                        <i class="ti-control-record"></i> Manage Salaries
                    </a></li>

                {{-- =========================== BUSINESS DEVELOPER =========================== --}}
                @elseif(auth()->user()->role === 'business developer')

                    <!-- Clients -->
                    <li><a href="{{ route('clients.index') }}">
                        <i class="ti-control-record"></i> Clients
                    </a></li>

                    <!-- Deals / Projects -->
                    <li><a href="{{ route('admin.projects.index') }}">
                        <i class="ti-control-record"></i> Deals / Projects
                    </a></li>

                    <!-- Meetings & Tasks -->
                    <li><a href="{{ route('admin.tasks.index') }}">
                        <i class="ti-control-record"></i> Meetings & Tasks
                    </a></li>

                {{-- =========================== DEVELOPER =========================== --}}
                @elseif(auth()->user()->role === 'developer')

                    <!-- My Points -->
                    <li><a href="{{ route('developer.points') }}">
                        <i class="ti-control-record"></i> My Points
                    </a></li>

                @endif

        @if(auth()->check() && auth()->user()->role === 'client')
    <li>
        <a href="{{ route('client.dashboard') }}">
            <i class="ti-control-record"></i> My Projects
        </a>
    </li>
@endif


                @endauth

            </ul>
        </div>
    </div>
</body>
