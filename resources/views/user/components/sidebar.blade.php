<div class="col-lg-auto col-12 sidebar px-4 py-4 py-lg-5">
    <div class="sidebar-content">
        <div class="logo fs-4 mb-4 mb-lg-5 text-center text-lg-start">💰 ExpTra</div>
        <div
            class="nav flex-row flex-lg-column justify-content-between justify-content-lg-start flex-nowrap overflow-auto">
            <a href="{{ route('dashboard') }}"
                class="navbar-item {{ request()->routeIs('dashboard') ? 'active' : '' }} mb-0 mb-lg-2">
                <i class="fas fa-home me-0 me-lg-3"></i>
                <span class="d-none d-lg-inline">Dashboard</span>
            </a>
            <a href="{{ route('financial-goals') }}"
                class="navbar-item {{ request()->routeIs('financial-goals') ? 'active' : '' }} mb-0 mb-lg-2">
                <i class="fas fa-bullseye me-0 me-lg-3"></i>
                <span class="d-none d-lg-inline">Financial Goals</span>
            </a>
            <a href="{{ route('weekly-tracking') }}"
                class="navbar-item {{ request()->routeIs('weekly-tracking') ? 'active' : '' }} mb-0 mb-lg-2">
                <i class="fas fa-calendar-week me-0 me-lg-3"></i>
                <span class="d-none d-lg-inline">Weekly Tracking</span>
            </a>
            <a href="{{ route('reports') }}"
                class="navbar-item {{ request()->routeIs('reports') ? 'active' : '' }} mb-0 mb-lg-2">
                <i class="fas fa-chart-bar me-0 me-lg-3"></i>
                <span class="d-none d-lg-inline">Reports</span>
            </a>

            <!-- Logout Link -->
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <a href="{{ route('logout') }}" class="navbar-item text-danger mb-0"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="fas fa-sign-out-alt me-0 me-lg-3"></i>
                    <span class="d-none d-lg-inline">Logout</span>
                </a>
            </form>
        </div>
    </div>
</div>
