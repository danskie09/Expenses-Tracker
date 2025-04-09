<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker | Financial Goal</title>
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

        /* Card styles */
        .card {
            border-radius: 15px;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .card-header {
            border-top-left-radius: 15px !important;
            border-top-right-radius: 15px !important;
        }

        /* Progress bar */
        .progress {
            border-radius: 10px;
            background-color: #f4f4f4;
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
                            <h4 class="fw-bold mb-1">Financial Goals</h4>
                            <p class="text-muted mb-0">Track your monthly financial targets and progress</p>
                        </div>
                        <button class="btn btn-peach rounded-pill" data-bs-toggle="modal"
                            data-bs-target="#addGoalModal">
                            <i class="fas fa-plus me-2"></i>New Goal
                        </button>
                    </div>

                    <!-- Goals List -->
                    <div class="row g-4">
                        @if (count($goals) > 0)
                            @foreach ($goals as $goal)
                                <div class="col-md-6 col-lg-4 goal-card" data-id="{{ $goal->id }}">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-header bg-transparent">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <h5 class="mb-0">{{ $goal->title }}</h5>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary border-0"
                                                        data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item edit-goal" href="#"
                                                                data-id="{{ $goal->id }}">
                                                                <i class="fas fa-edit me-2"></i>Edit</a>
                                                        </li>
                                                        <li><a class="dropdown-item text-danger delete-goal"
                                                                href="#" data-id="{{ $goal->id }}">
                                                                <i class="fas fa-trash me-2"></i>Delete</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <small class="text-muted">Progress</small>
                                                    <small
                                                        class="text-muted">{{ number_format($goal->progress_percentage ?? 0) }}%</small>
                                                </div>
                                                <div class="progress" style="height: 10px;">
                                                    <div class="progress-bar bg-peach" role="progressbar"
                                                        style="width: {{ $goal->progress_percentage ?? 0 }}%"
                                                        aria-valuenow="{{ $goal->progress_percentage ?? 0 }}"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="row g-2 mb-3">
                                                <div class="col-6">
                                                    <div class="p-3 rounded bg-peach-light">
                                                        <small class="d-block text-muted">Target</small>
                                                        <span
                                                            class="fw-bold">${{ number_format($goal->target_amount, 2) }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="p-3 rounded bg-light">
                                                        <small class="d-block text-muted">Collected</small>
                                                        <span
                                                            class="fw-bold">${{ number_format($goal->total_collection, 2) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="small text-muted mb-0">
                                                <i class="fas fa-calendar-alt me-1"></i> {{ $goal->goal_month }}
                                                {{ $goal->goal_year }}
                                            </p>
                                        </div>
                                        <div class="card-footer bg-transparent">
                                            <a href="#" class="btn btn-sm btn-outline-peach w-100 view-details"
                                                data-id="{{ $goal->id }}">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <!-- Empty State Card -->
                            <div class="col-12" id="emptyState">
                                <div class="card shadow-sm border-0 p-5 text-center">
                                    <img src="{{ asset('assets/img/no-image.jpg') }}" alt="No Goals"
                                        class="img-fluid mb-4" style="max-width: 200px; margin: 0 auto;">
                                    <h5>No Financial Goals Yet</h5>
                                    <p class="text-muted mb-4">Start planning your financial future by adding your first
                                        goal</p>
                                    <button class="btn btn-peach rounded-pill mx-auto" style="width: fit-content;"
                                        data-bs-toggle="modal" data-bs-target="#addGoalModal">
                                        <i class="fas fa-plus me-2"></i>Add Your First Goal
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Toggle Button -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Add Goal Modal -->
    <div class="modal fade" id="addGoalModal" tabindex="-1" aria-labelledby="addGoalModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="addGoalModalLabel">Add New Financial Goal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="goalForm">
                        <div class="mb-3">
                            <label for="title" class="form-label">Goal Title</label>
                            <input type="text" class="form-control" id="title" name="title" required
                                placeholder="e.g., Car Installment, House Bills">
                        </div>
                        <div class="mb-3">
                            <label for="target_amount" class="form-label">Target Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="target_amount" name="target_amount"
                                    required step="0.01" min="0" placeholder="0.00">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="goal_month" class="form-label">Month</label>
                                <select class="form-select" id="goal_month" name="goal_month" required>
                                    <option value="">Select Month</option>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="goal_year" class="form-label">Year</label>
                                <select class="form-select" id="goal_year" name="goal_year" required>
                                    <option value="">Select Year</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes (Optional)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"
                                placeholder="Add any additional notes about this goal"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="goalForm" class="btn btn-peach">Save Goal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Goal Modal -->
    <div class="modal fade" id="editGoalModal" tabindex="-1" aria-labelledby="editGoalModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="editGoalModalLabel">Edit Financial Goal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editGoalForm">
                        @csrf
                        <input type="hidden" id="edit_goal_id" name="goal_id">
                        <div class="mb-3">
                            <label for="edit_title" class="form-label">Goal Title</label>
                            <input type="text" class="form-control" id="edit_title" name="title" required
                                placeholder="e.g., Car Installment, House Bills">
                        </div>
                        <div class="mb-3">
                            <label for="edit_target_amount" class="form-label">Target Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="edit_target_amount"
                                    name="target_amount" required step="0.01" min="0" placeholder="0.00">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="edit_goal_month" class="form-label">Month</label>
                                <select class="form-select" id="edit_goal_month" name="goal_month" required>
                                    <option value="">Select Month</option>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="edit_goal_year" class="form-label">Year</label>
                                <select class="form-select" id="edit_goal_year" name="goal_year" required>
                                    <option value="">Select Year</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_notes" class="form-label">Notes (Optional)</label>
                            <textarea class="form-control" id="edit_notes" name="notes" rows="3"
                                placeholder="Add any additional notes about this goal"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="editGoalForm" class="btn btn-peach">Update Goal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteGoalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Delete Financial Goal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this financial goal? This action cannot be undone.</p>
                    <input type="hidden" id="delete_goal_id">
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirmDelete" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>


    <script>
        $(document).ready(function() {
            // Add CSRF token to all Ajax requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Create new goal
            $('#goalForm').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('financial-goals') }}",
                    data: formData,
                    success: function(response) {
                        if (response.status) {
                            $('#addGoalModal').modal('hide');
                            $('#goalForm')[0].reset();

                            // Show success notification
                            toastr.success('Financial goal created successfully');

                            // Reload the page to show the new goal
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;

                        // Display errors
                        $.each(errors, function(key, value) {
                            toastr.error(value[0]);
                        });
                    }
                });
            });

            // Open edit modal with goal data (using event delegation)
            $(document).on('click', '.edit-goal', function(e) {
                e.preventDefault();
                let goalId = $(this).data('id');
                console.log("Edit clicked for goal ID:", goalId); // Debug log

                // Ensure goalId is valid
                if (!goalId) {
                    toastr.error('Goal ID not found. Please refresh the page.');
                    return;
                }

                $.ajax({
                    type: 'GET',
                    url: `/financial-goals/${goalId}`,
                    success: function(response) {
                        console.log("Goal data received:", response); // Debug log
                        if (response.status) {
                            let goal = response.goal;

                            // Fill form with goal data
                            $('#edit_goal_id').val(goal.id);
                            $('#edit_title').val(goal.title);
                            $('#edit_target_amount').val(goal.target_amount);
                            $('#edit_goal_month').val(goal.goal_month);
                            $('#edit_goal_year').val(goal.goal_year);
                            $('#edit_notes').val(goal.notes);

                            // Show modal
                            $('#editGoalModal').modal('show');
                        } else {
                            toastr.error('Error loading goal details: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        console.error("AJAX error:", xhr);
                        toastr.error('Error loading goal details. Please try again.');
                    }
                });
            });

            // Update goal
            $('#editGoalForm').on('submit', function(e) {
                e.preventDefault();
                let goalId = $('#edit_goal_id').val();
                let formData = $(this).serialize();

                if (!goalId) {
                    toastr.error('Missing goal ID. Please try again.');
                    return;
                }

                $.ajax({
                    type: 'PUT',
                    url: `/financial-goals/${goalId}`,
                    data: formData,
                    success: function(response) {
                        if (response.status) {
                            $('#editGoalModal').modal('hide');

                            // Show success notification
                            toastr.success('Financial goal updated successfully');

                            // Reload the page to show changes
                            location.reload();
                        } else {
                            toastr.error('Error updating goal: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        console.error("Update error:", xhr);
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let errors = xhr.responseJSON.errors;
                            // Display errors
                            $.each(errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error('An error occurred. Please try again.');
                        }
                    }
                });
            });

            // Open delete confirmation modal (using event delegation)
            $(document).on('click', '.delete-goal', function(e) {
                e.preventDefault();
                let goalId = $(this).data('id');

                if (!goalId) {
                    toastr.error('Goal ID not found. Please refresh the page.');
                    return;
                }

                $('#delete_goal_id').val(goalId);
                $('#deleteGoalModal').modal('show');
            });

            // Confirm delete
            $('#confirmDelete').on('click', function() {
                let goalId = $('#delete_goal_id').val();

                if (!goalId) {
                    toastr.error('Goal ID not found. Please try again.');
                    $('#deleteGoalModal').modal('hide');
                    return;
                }

                $.ajax({
                    type: 'DELETE',
                    url: `/financial-goals/${goalId}`,
                    success: function(response) {
                        if (response.status) {
                            $('#deleteGoalModal').modal('hide');

                            // Show success notification
                            toastr.success('Financial goal deleted successfully');

                            // Remove the goal card from the page
                            $(`.goal-card[data-id="${goalId}"]`).remove();

                            // Check if there are any goals left, if not, show the empty state
                            if ($('.goal-card').length === 0) {
                                $('#emptyState').show();
                            }
                        } else {
                            toastr.error('Error deleting goal: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        console.error("Delete error:", xhr);
                        toastr.error('Error deleting goal. Please try again.');
                    }
                });
            });

            // View details (using event delegation)
            $(document).on('click', '.view-details', function(e) {
                e.preventDefault();
                let goalId = $(this).data('id');

                if (!goalId) {
                    toastr.error('Goal ID not found. Please refresh the page.');
                    return;
                }

                // Navigate to details page
                window.location.href = `/financial-goals/${goalId}/details`;
            });
        });
    </script>

</body>

</html>
