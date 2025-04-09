<div class="col-lg-auto col-12 sidebar px-4 py-4 py-lg-5">
    <div class="sidebar-content">
        <div class="logo fs-4 mb-4 mb-lg-5 text-center text-lg-start">💰 ExpTra</div>
        <div
            class="nav flex-row flex-lg-column justify-content-between justify-content-lg-start flex-nowrap overflow-auto">
            <a href="#dashboard" class="navbar-item active mb-0 mb-lg-2">
                <i class="fas fa-th-large me-0 me-lg-3"></i>
                <span class="d-none d-lg-inline">Dashboard</span>
            </a>
            <a href="#analytics" class="navbar-item mb-0 mb-lg-2">
                <i class="fas fa-chart-pie me-0 me-lg-3"></i>
                <span class="d-none d-lg-inline">Analytics</span>
            </a>
            <a href="#transactions" class="navbar-item mb-0 mb-lg-2">
                <i class="fas fa-wallet me-0 me-lg-3"></i>
                <span class="d-none d-lg-inline">Transactions</span>
            </a>
            <a href="#cards" class="navbar-item mb-0 mb-lg-2">
                <i class="fas fa-credit-card me-0 me-lg-3"></i>
                <span class="d-none d-lg-inline">Cards</span>
            </a>
            <a href="#settings" class="navbar-item mb-0">
                <i class="fas fa-cog me-0 me-lg-3"></i>
                <span class="d-none d-lg-inline">Settings</span>
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
