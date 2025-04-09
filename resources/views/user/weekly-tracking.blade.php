<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker | Weekly Tracker</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/index.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        /* Peach color scheme */
        :root {
            --peach: #FF9F71;
            --peach-light: rgba(255, 159, 113, 0.15);
            --peach-dark: #FF8C54;
        }

        .bg-peach {
            background-color: var(--peach) !important;
        }

        .bg-peach-light {
            background-color: var(--peach-light) !important;
        }

        .btn-peach {
            background-color: var(--peach);
            border-color: var(--peach);
            color: white;
        }

        .btn-peach:hover {
            background-color: var(--peach-dark);
            border-color: var(--peach-dark);
            color: white;
        }

        .btn-outline-peach {
            color: var(--peach);
            border-color: var(--peach);
        }

        .btn-outline-peach:hover {
            background-color: var(--peach);
            color: white;
        }

        .text-peach {
            color: var(--peach) !important;
        }

        .border-peach {
            border-color: var(--peach) !important;
        }

        .week-card {
            border-left: 4px solid transparent;
            transition: all 0.2s;
        }

        .week-card:hover {
            border-left: 4px solid var(--peach);
        }

        .week-card.active {
            border-left: 4px solid var(--peach);
            background-color: var(--peach-light);
        }
    </style>
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
                    <div class="d-flex justify-content-between align-items-lg-center mb-4 mb-lg-5">
                        <div class="mb-3 mb-lg-0">
                            <h4 class="fw-bold mb-1">Weekly Tracking</h4>
                            <p class="text-muted mb-0">Track your weekly progress toward financial goals</p>
                        </div>

                        <!-- Goal Selector Dropdown -->
                        <div class="d-flex gap-2">
                            <select id="goalSelector" class="form-select" style="min-width: 250px;">
                                <option value="">Select a financial goal</option>
                                @foreach ($goals as $goal)
                                    <option value="{{ $goal->id }}">{{ $goal->title }} - {{ $goal->goal_month }}
                                        {{ $goal->goal_year }}</option>
                                @endforeach
                            </select>

                            <button id="addWeekBtn" class="btn btn-peach rounded-pill" disabled>
                                <i class="fas fa-plus me-2"></i>New Week
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <!-- No Goal Selected Message -->
                        <div id="noGoalSelected" class="col-12 text-center py-5">
                            <img src="{{ asset('assets/img/no-image.jpg') }}" alt="Select a Goal" class="img-fluid mb-4"
                                style="max-width: 200px;">
                            <h5>Select a Financial Goal</h5>
                            <p class="text-muted mb-0">Choose a goal from the dropdown to track your weekly progress</p>
                        </div>

                        <!-- Weeks List Column (Hidden initially) -->
                        <div id="weeksColumn" class="col-md-4 col-lg-3 mb-4" style="display: none;">
                            <div class="card shadow-sm">
                                <div class="card-header bg-light py-3">
                                    <h6 class="mb-0 fw-bold">Weeks</h6>
                                </div>
                                <div class="card-body p-0">
                                    <div id="weeksList" class="list-group list-group-flush">
                                        <!-- Weeks will be loaded here dynamically -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Week Details Column (Hidden initially) -->
                        <div id="weekDetailsColumn" class="col-md-8 col-lg-9" style="display: none;">
                            <div class="card shadow-sm">
                                <div class="card-header bg-light py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-bold">Week Details</h6>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form id="weekForm">
                                        @csrf
                                        <input type="hidden" id="weekId" name="id">
                                        <input type="hidden" id="goalId" name="goal_id">

                                        <div class="row mb-4">
                                            <div class="col-md-4 mb-3 mb-md-0">
                                                <div class="form-floating">
                                                    <input type="number" class="form-control" id="weekNumber"
                                                        name="week_number" min="1" max="53" readonly>
                                                    <label for="weekNumber">Week Number</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3 mb-md-0">
                                                <div class="form-floating">
                                                    <input type="number" class="form-control" id="payable"
                                                        name="payable" step="0.01" min="0">
                                                    <label for="payable">Payable Amount ($)</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input type="number" class="form-control" id="collection"
                                                        name="collection" step="0.01" min="0">
                                                    <label for="collection">Collected Amount ($)</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <div class="form-floating">
                                                <textarea class="form-control" id="remarks" name="remarks" style="height: 80px;"></textarea>
                                                <label for="remarks">Remarks</label>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div>
                                                <p class="mb-0 fw-bold">
                                                    <span id="deficitLabel">Balance:</span>
                                                    <i id="deficitIcon" class="fas fa-check-circle text-success me-1"
                                                        style="display: none;"></i>
                                                    <i id="deficitWarningIcon"
                                                        class="fas fa-exclamation-circle text-danger me-1"
                                                        style="display: none;"></i>
                                                    <span id="deficitValue" class="ms-2">$0.00</span>
                                                </p>
                                            </div>
                                            <button type="submit" class="btn btn-peach">Save Week</button>
                                        </div>
                                    </form>
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

    <!-- Add Week Modal -->
    <div class="modal fade" id="addWeekModal" tabindex="-1" aria-labelledby="addWeekModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="addWeekModalLabel">Add New Week</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="newWeekForm">
                        @csrf
                        <input type="hidden" id="newWeekGoalId" name="goal_id">

                        <div class="mb-3">
                            <label for="newWeekNumber" class="form-label">Week Number</label>
                            <input type="number" class="form-control" id="newWeekNumber" name="week_number"
                                min="1" max="53" required>
                        </div>
                        <div class="mb-3">
                            <label for="newWeekPayable" class="form-label">Payable Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="newWeekPayable" name="payable"
                                    step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="newWeekCollection" class="form-label">Collection Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="newWeekCollection" name="collection"
                                    step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="newWeekRemarks" class="form-label">Remarks (Optional)</label>
                            <textarea class="form-control" id="newWeekRemarks" name="remarks" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="newWeekForm" class="btn btn-peach">Save Week</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Set CSRF token for all Ajax requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let selectedGoalId = null;
            let selectedWeekId = null;

            // Goal selector change handler
            $('#goalSelector').on('change', function() {
                selectedGoalId = $(this).val();

                if (selectedGoalId) {
                    // Enable add week button
                    $('#addWeekBtn').prop('disabled', false);
                    // Load weeks for the selected goal
                    loadWeeks(selectedGoalId);
                    // Show weeks column
                    $('#noGoalSelected').hide();
                    $('#weeksColumn').show();
                } else {
                    // Disable add week button
                    $('#addWeekBtn').prop('disabled', true);
                    // Hide both columns and show no goal message
                    $('#noGoalSelected').show();
                    $('#weeksColumn').hide();
                    $('#weekDetailsColumn').hide();
                }
            });

            // Add Week button click handler
            $('#addWeekBtn').on('click', function() {
                $('#newWeekGoalId').val(selectedGoalId);

                // Get the next week number based on existing weeks
                $.ajax({
                    url: `/financial-goals/${selectedGoalId}/next-week-number`,
                    type: 'GET',
                    success: function(response) {
                        $('#newWeekNumber').val(response.next_week_number);
                        $('#addWeekModal').modal('show');
                    }
                });
            });

            // New Week form submission
            $('#newWeekForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: '/financial-goal-weeks',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#addWeekModal').modal('hide');
                        toastr.success('Week added successfully!');
                        loadWeeks(selectedGoalId);
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(key => {
                            toastr.error(errors[key][0]);
                        });
                    }
                });
            });

            // Week selection handler
            $(document).on('click', '.week-item', function() {
                $('.week-item').removeClass('active');
                $(this).addClass('active');

                selectedWeekId = $(this).data('id');
                loadWeekDetails(selectedWeekId);

                // Show week details column
                $('#weekDetailsColumn').show();
            });

            // Week form submission (update)
            $('#weekForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: `/financial-goal-weeks/${selectedWeekId}`,
                    type: 'PUT',
                    data: $(this).serialize(),
                    success: function(response) {
                        toastr.success('Week updated successfully!');
                        loadWeeks(selectedGoalId);
                        loadWeekDetails(selectedWeekId);
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(key => {
                            toastr.error(errors[key][0]);
                        });
                    }
                });
            });

            // Payable and Collection amount change handler (to calculate deficit)
            $('#payable, #collection').on('input', function() {
                calculateDeficit();
            });

            // Function to load weeks for a goal
            function loadWeeks(goalId) {
                $.ajax({
                    url: `/financial-goals/${goalId}/weeks`,
                    type: 'GET',
                    success: function(response) {
                        const weeks = response.weeks;
                        $('#weeksList').empty();

                        if (weeks.length > 0) {
                            weeks.forEach(week => {
                                $('#weeksList').append(`
                                    <a href="#" class="list-group-item list-group-item-action week-item" data-id="${week.id}">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>Week ${week.week_number}</strong>
                                            </div>
                                            <div>
                                                $${parseFloat(week.collection).toFixed(2)}
                                            </div>
                                        </div>
                                    </a>
                                `);
                            });
                        } else {
                            $('#weeksList').append(`
                                <div class="list-group-item text-center py-4">
                                    <p class="mb-0 text-muted">No weeks added yet</p>
                                </div>
                            `);
                        }
                    }
                });
            }

            // Function to load week details
            function loadWeekDetails(weekId) {
                $.ajax({
                    url: `/financial-goal-weeks/${weekId}`,
                    type: 'GET',
                    success: function(response) {
                        const week = response.week;

                        // Populate form fields
                        $('#weekId').val(week.id);
                        $('#goalId').val(week.goal_id);
                        $('#weekNumber').val(week.week_number);
                        $('#payable').val(week.payable);
                        $('#collection').val(week.collection);
                        $('#remarks').val(week.remarks);

                        // Update deficit display
                        $('#deficitValue').text(`$${parseFloat(week.deficit).toFixed(2)}`);
                    }
                });
            }

            // Function to calculate deficit
            function calculateDeficit() {
                const payable = parseFloat($('#payable').val()) || 0;
                const collection = parseFloat($('#collection').val()) || 0;
                const deficit = collection - payable;

                if (deficit < 0) {
                    $('#deficitValue').text(`-$${Math.abs(deficit).toFixed(2)}`);
                    $('#deficitValue').removeClass('text-success').addClass('text-danger');
                    $('#deficitWarningIcon').show();
                    $('#deficitIcon').hide();
                } else {
                    $('#deficitValue').text(`$${deficit.toFixed(2)}`);
                    $('#deficitValue').removeClass('text-danger').addClass('text-success');
                    $('#deficitIcon').show();
                    $('#deficitWarningIcon').hide();
                }
            }
        });
    </script>
</body>

</html>
