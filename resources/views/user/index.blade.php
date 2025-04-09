<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/index.css') }}">
</head>

<body>
    <div class="container-fluid p-0">
        <div class="row g-0 flex-column flex-lg-row">
            <!-- Sidebar -->
            @include('user.components.sidebar')

            <!-- Main Content -->
            <div class="col p-0">
                <div class="container py-4 py-lg-5">
                    <!-- Header -->
                    <div class="dashboard-header d-flex justify-content-between align-items-lg-center mb-4 mb-lg-5">
                        <div class="mb-3 mb-lg-0">
                            <h4 class="fw-bold mb-1">Dashboard</h4>
                            <p class="text-muted mb-0">Welcome back, Alex!</p>
                        </div>
                        <button class="btn btn-peach rounded-pill">
                            <i class="fas fa-plus me-2"></i>Add Transaction
                        </button>
                    </div>

                    <!-- Stats Cards -->
                    <div class="row g-3 g-lg-4 mb-4 mb-lg-5">
                        <div class="col-md-4">
                            <div class="card stat-card">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="stat-icon bg-peach-light me-3">
                                            <i class="fas fa-wallet"></i>
                                        </div>
                                        <div>
                                            <p class="stat-label">Total Balance</p>
                                            <p class="stat-value">$2,540.00</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-peach-light text-peach me-2">
                                            <i class="fas fa-arrow-up me-1"></i>2.5%
                                        </span>
                                        <small class="text-muted">From last month</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card stat-card">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="stat-icon bg-peach-light me-3">
                                            <i class="fas fa-arrow-down"></i>
                                        </div>
                                        <div>
                                            <p class="stat-label">Income</p>
                                            <p class="stat-value">$3,240.00</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-peach-light text-peach me-2">
                                            <i class="fas fa-arrow-up me-1"></i>4.3%
                                        </span>
                                        <small class="text-muted">From last month</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card stat-card">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="stat-icon bg-peach-light me-3">
                                            <i class="fas fa-arrow-up"></i>
                                        </div>
                                        <div>
                                            <p class="stat-label">Expenses</p>
                                            <p class="stat-value">$700.00</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-peach-light text-peach me-2">
                                            <i class="fas fa-arrow-down me-1"></i>1.8%
                                        </span>
                                        <small class="text-muted">From last month</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Toggle Button -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>
