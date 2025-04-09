<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker | Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/index.css') }}">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
</head>

<body>
    <div class="container-fluid p-0">
        <div class="row g-0 flex-column flex-lg-row">
            <!-- Sidebar -->
            @include('user.components.sidebar')

            <!-- Main Content -->
            <div class="col p-0">
                <div class="container py-4 py-lg-5">
                    <h1 class="mb-4">Financial Reports</h1>

                    <!-- Month Filter -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Filter Reports</h5>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="monthFilter" class="form-label">Month</label>
                                    <select class="form-select" id="monthFilter">
                                        <option value="">All Months</option>
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="yearFilter" class="form-label">Year</label>
                                    <select class="form-select" id="yearFilter">
                                        <option value="">All Years</option>
                                        @for ($year = date('Y') - 2; $year <= date('Y') + 2; $year++)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Goals Table -->
                    <div class="card mb-4" id="goalsCard">
                        <div class="card-body">
                            <h5 class="card-title">Financial Goals</h5>
                            <div class="table-responsive">
                                <table id="goalsTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Target Amount</th>
                                            <th>Month/Year</th>
                                            <th>Total Collection</th>
                                            <th>Progress</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($goals as $goal)
                                            <tr data-month="{{ $goal->goal_month }}" data-year="{{ $goal->goal_year }}">
                                                <td>{{ $goal->title }}</td>
                                                <td>₱{{ number_format($goal->target_amount, 2) }}</td>
                                                <td class="month-year-column">
                                                    {{ date('M', mktime(0, 0, 0, (int) $goal->goal_month, 1)) }}
                                                    {{ $goal->goal_year }}
                                                </td>
                                                <td>₱{{ number_format($goal->total_collection, 2) }}</td>
                                                <td>
                                                    @php
                                                        $percentage = $goal->progress_percentage;
                                                        $badgeClass = 'bg-danger';

                                                        if ($percentage >= 75) {
                                                            $badgeClass = 'bg-success';
                                                        } elseif ($percentage >= 50) {
                                                            $badgeClass = 'bg-warning';
                                                        } elseif ($percentage >= 25) {
                                                            $badgeClass = 'bg-info';
                                                        }
                                                    @endphp
                                                    <div class="progress">
                                                        <div class="progress-bar {{ $badgeClass }}"
                                                            role="progressbar" style="width: {{ $percentage }}%"
                                                            aria-valuenow="{{ $percentage }}" aria-valuemin="0"
                                                            aria-valuemax="100">
                                                            {{ number_format($percentage, 2) }}%
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary view-weeks"
                                                        data-id="{{ $goal->id }}">
                                                        View Weeks
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Goal Weeks Detail Table (shown when a goal is clicked) -->
                    <div class="card d-none" id="weeksDetailCard">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title">Weekly Breakdown: <span id="goalTitle"></span></h5>
                                <button class="btn btn-sm btn-secondary" id="backToGoals">Back to Goals</button>
                            </div>
                            <div class="table-responsive">
                                <table id="weeksTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Week</th>
                                            <th>Payable</th>
                                            <th>Collection</th>
                                            <th>Deficit</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody id="weeksTableBody">
                                        <!-- Week details will be dynamically loaded -->
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Total</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script>
        $(document).ready(function() {
            let goalsTable = $('#goalsTable').DataTable();
            let currentGoalId = null;

            // Initialize the weeks table with empty data first
            let weeksTable = $('#weeksTable').DataTable({
                searching: false,
                paging: false,
                info: false,
                columns: [{
                        title: "Week",
                        data: "week_number",
                        render: function(data) {
                            return 'Week ' + data;
                        }
                    },
                    {
                        title: "Payable",
                        data: "payable",
                        render: function(data) {
                            return '₱' + parseFloat(data).toFixed(2);
                        }
                    },
                    {
                        title: "Collection",
                        data: "collection",
                        render: function(data) {
                            return '₱' + parseFloat(data).toFixed(2);
                        }
                    },
                    {
                        title: "Deficit",
                        data: "deficit",
                        render: function(data) {
                            const value = parseFloat(data);
                            const color = value >= 0 ? 'text-success' : 'text-danger';
                            return '<span class="' + color + '">₱' + value.toFixed(2) + '</span>';
                        }
                    },
                    {
                        title: "Remarks",
                        data: "remarks",
                        defaultContent: ""
                    }
                ],
                // Add a footer callback to create the totals row
                footerCallback: function(row, data, start, end, display) {
                    const api = this.api();

                    // Calculate column totals
                    const totalPayable = api.column(1).data().reduce(function(a, b) {
                        return parseFloat(a) + parseFloat(b);
                    }, 0);

                    const totalCollection = api.column(2).data().reduce(function(a, b) {
                        return parseFloat(a) + parseFloat(b);
                    }, 0);

                    const totalDeficit = api.column(3).data().reduce(function(a, b) {
                        return parseFloat(a) + parseFloat(b);
                    }, 0);

                    // Format the deficit with appropriate color
                    const deficitColor = totalDeficit >= 0 ? 'text-success' : 'text-danger';

                    // Update footer cells
                    $(api.column(0).footer()).html('<strong>Total</strong>');
                    $(api.column(1).footer()).html('<strong>₱' + totalPayable.toFixed(2) + '</strong>');
                    $(api.column(2).footer()).html('<strong>₱' + totalCollection.toFixed(2) +
                        '</strong>');
                    $(api.column(3).footer()).html('<strong><span class="' + deficitColor + '">₱' +
                        totalDeficit.toFixed(2) + '</span></strong>');
                }
            });

            // Handle click on view weeks button
            $('.view-weeks').on('click', function() {
                const goalId = $(this).data('id');
                const goalTitle = $(this).closest('tr').find('td:first').text();
                currentGoalId = goalId;

                // Show goal title
                $('#goalTitle').text(goalTitle);

                // Fetch weeks for this goal using AJAX
                $.ajax({
                    url: '/financial-goals/' + goalId + '/weeks',
                    method: 'GET',
                    success: function(response) {
                        // Clear the table first
                        weeksTable.clear();

                        // Add the new data and redraw
                        if (response.weeks && response.weeks.length > 0) {
                            weeksTable.rows.add(response.weeks).draw();
                        } else {
                            // If no weeks data, show a message
                            $('#weeksTableBody').html(
                                '<tr><td colspan="5" class="text-center">No weekly data available for this goal.</td></tr>'
                            );
                        }

                        // Hide goals table and show weeks table
                        $('#goalsCard').addClass('d-none');
                        $('#weeksDetailCard').removeClass('d-none');
                    },
                    error: function(error) {
                        console.error('Error fetching weeks data:', error);
                        alert('Failed to load weekly data');
                    }
                });
            });

            // Handle back button
            $('#backToGoals').on('click', function() {
                $('#weeksDetailCard').addClass('d-none');
                $('#goalsCard').removeClass('d-none');
                currentGoalId = null;
            });

            // Handle month and year filtering
            $('#monthFilter, #yearFilter').on('change', function() {
                const month = $('#monthFilter').val();
                const year = $('#yearFilter').val();

                // Remove any previous filters first
                $.fn.dataTable.ext.search.pop();

                // Custom filtering function
                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        // Only apply to goals table
                        if (settings.nTable.id !== 'goalsTable') return true;

                        const row = goalsTable.row(dataIndex).node();
                        const rowMonth = $(row).data('month');
                        const rowYear = $(row).data('year');

                        // If no filters are set, show all rows
                        if (!month && !year) return true;

                        // Filter by month if set
                        if (month && !year) {
                            return rowMonth == month;
                        }

                        // Filter by year if set
                        if (!month && year) {
                            return rowYear == year;
                        }

                        // Filter by both month and year
                        return rowMonth == month && rowYear == year;
                    }
                );

                // Redraw the table with the filter applied
                goalsTable.draw();

                // Remove the filter after drawing to prevent affecting future operations
                $.fn.dataTable.ext.search.pop();
            });
        });
    </script>
</body>

</html>
