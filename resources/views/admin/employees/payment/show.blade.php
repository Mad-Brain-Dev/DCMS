@extends('layouts.master')

@section('content')

    <div class="row">

        {{-- HEADER --}}
        <div class="col-12 mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-user me-2"></i>
                    {{ $employee->name }}
                </h4>

                <h4 class="mb-0">
                    <i class="fas fa-id-card me-2"></i>
                    {{ $employee->role }}
                </h4>

                <a href="{{ route('admin.employee-payment.index') }}"
                   class="btn btn-light">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        {{-- TABS --}}
        <div class="col-md-12">
            <ul class="nav nav-pills nav-fill mb-3 update-tabs" id="updateTabs" role="tablist">

                <!-- ALL DEBTORS (DEFAULT TAB) -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link active"
                            id="debtors-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#profile-tab"
                            type="button"
                            role="tab"
                            aria-controls="profile-tab"
                            aria-selected="true">
                        <i class="fas fa-user-circle me-1"></i>
                        Profile Summary
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link"
                            id="general-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#commission-tab"
                            type="button"
                            role="tab"
                            aria-controls="commission-tab">
                        <i class="fas fa-chart-line me-1"></i>
                        Monthly Commission
                    </button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link"
                            id="payment-tab"
                            data-bs-toggle="pill"
                            data-bs-target="#history-tab"
                            type="button"
                            role="tab"
                            aria-controls="history-tab">
                        <i class="fas fa-history me-1"></i>
                        Payment History
                    </button>
                </li>

            </ul>

            <div class="tab-content">

                {{-- ============================= --}}
                {{-- TAB 1 — PROFILE SUMMARY --}}
                {{-- ============================= --}}
                <div class="tab-pane fade show active" id="profile-tab">

                    <div class="row mb-3">

                        <div class="col-md-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body text-center">
                                    <small class="text-muted">Commission Rate</small>
                                    <h4 class="fw-bold text-primary">
                                        {{ $employee->commission_rate }}%
                                    </h4>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body text-center">
                                    <small class="text-muted">Total Earned</small>
                                    <h4 class="fw-bold text-primary" id="profile_total_earned">
                                        $ {{ number_format($totalEarned,2) }}
                                    </h4>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body text-center">
                                    <small class="text-muted">Total Paid</small>
                                    <h4 class="fw-bold text-success" id="profile_total_paid">
                                        $ {{ number_format($totalPaid,2) }}
                                    </h4>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body text-center">
                                    <small class="text-muted">Total Due</small>
                                    <h4 class="fw-bold text-danger" id="profile_total_due">
                                        $ {{ number_format($totalDue,2) }}
                                    </h4>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Assigned Cases --}}
                    <div class="card shadow-sm">
                        <div class="card-body">

                            <h5 class="text-center table-outer-border p-2 bg-soft-lime text-lime">
                                Assigned Cases
                            </h5>

                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                    <tr>
                                        <th>Case #</th>
                                        <th>Client</th>
                                        <th>Status</th>
                                        <th>Total Balance</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($assignedCases as $case)
                                        <tr>
                                            <td>{{ $case->case_sku }}</td>
                                            <td>{{ $case->client->name }}</td>
                                            <td><span class="badge {{$case->status->bg_color??'bg-primary'}}">{{ $case->status?->name }}</span></td>
                                            <td>$ {{ totalBalance($case->id) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">
                                                No assigned cases
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>

                {{-- TAB 2  --}}

                <div class="tab-pane fade"
                     id="commission-tab">

                    <div class="card">
                        <div class="card-body">

                            <div class="d-flex justify-content-between bg-soft-lime align-items-center mb-3" style="padding-right: 15px;">

                                <h5 class="text-center table-outer-border p-2  text-lime mb-0 flex-grow-1">
                                    Monthly Commission Breakdown
                                </h5>
                                <form method="GET" class="ms-3">
                                    <select id="commissionFilter"
                                            class="form-select form-select-sm"
                                            style="width: 180px;">

                                        <option value="6" selected>Last 6 Months</option>
                                        <option value="12">Last 12 Months</option>
                                        <option value="all">All Time</option>

                                    </select>
                                </form>

                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                    <tr>
                                        <th>Month</th>
                                        <th>Total Commission</th>
                                        <th>Paid</th>
                                        <th>Due</th>
                                        <th>Status</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="commissionTableBody">

                                    @forelse($monthlyBreakdown as $month)

                                        <tr id="row-{{ $month->month }}">
                                            <td>
                                                <strong>
                                                    {{ \Carbon\Carbon::createFromFormat('Y-m', $month->month)->format('F Y') }}
                                                </strong>
                                            </td>

                                            <td class="text-primary fw-bold">
                                                $ {{ number_format($month->total_commission, 2) }}
                                            </td>

                                            <td>
                                                <div class="d-flex flex-column">

                                    <span class="text-success fw-semibold">
                                        $ {{ number_format($month->total_paid, 2) }}
                                    </span>

                                                    <div class="progress mt-1" style="height:6px;">
                                                        <div class="progress-bar bg-success"
                                                             style="width: {{ $month->progress }}%">
                                                        </div>
                                                    </div>

                                                </div>
                                            </td>

                                            <td class="text-danger fw-bold">
                                                $ {{ number_format($month->due, 2) }}
                                            </td>

                                            <td>
                                                @if($month->status == 'Paid')
                                                    <span class="badge bg-success">Paid</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @endif
                                            </td>

                                            <td class="text-end">
                                                @if($month->due > 0)
                                                    <button class="btn btn-sm btn-success payBtn"
                                                            data-employee="{{ $employee->id }}"
                                                            data-month="{{ $month->month }}"
                                                            data-due="{{ $month->due }}">
                                                        <i class="fas fa-money-bill-wave"></i> Pay
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-light" disabled>
                                                        Completed
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>

                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">
                                                No commission records found.
                                            </td>
                                        </tr>
                                    @endforelse

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>

                {{-- TAB 3 --}}

                <div class="tab-pane fade"
                     id="history-tab">

                    {{-- ========================= --}}
                    {{-- SUMMARY CARDS --}}
                    {{-- ========================= --}}
                    <div class="row mb-4">

                        <div class="col-md-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body text-center">
                                    <small class="text-muted">Total Payments Made</small>
                                    <h5 class="fw-bold text-success mb-0" id="totalPaymentsMade">
                                        $ 0.00
                                    </h5>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body text-center">
                                    <small class="text-muted">Total Transactions</small>
                                    <h5 class="fw-bold mb-0" id="totalTransactions">
                                        0
                                    </h5>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body text-center">
                                    <small class="text-muted">Last Payment</small>
                                    <h6 class="fw-bold mb-0" id="lastPaymentDate">
                                        -
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card shadow-sm border-0">
                                <div class="card-body text-center">
                                    <small class="text-muted">Running Balance</small>
                                    <h5 class="fw-bold text-danger mb-0" id="runningBalance">
                                        $ 0.00
                                    </h5>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card">
                        <div class="card-body">

                            {{-- ========================= --}}
                            {{-- HEADER --}}
                            {{-- ========================= --}}
                            <h5 class="text-center table-outer-border p-2 bg-soft-lime text-lime">
                                Payment History
                            </h5>

                            {{-- ========================= --}}
                            {{-- TABLE --}}
                            {{-- ========================= --}}
                            <div class="table-responsive">

                                <table class="table table-hover align-middle mb-0" id="paymentHistoryTable">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Month</th>
                                        <th>Amount</th>
                                        <th>Method</th>
                                        <th>Note</th>
                                        <th>
                                            Running Balance
                                            <i class="fas fa-info-circle text-muted ms-1"
                                               data-bs-toggle="tooltip"
                                               data-bs-placement="top"
                                               title="Running balance shows how much commission is still owed after this payment was recorded (lifetime basis).">
                                            </i>
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody id="paymentHistoryBody">
                                    {{-- AJAX Loaded Rows Here --}}
                                    </tbody>

                                </table>

                            </div>

                            {{-- ========================= --}}
                            {{-- PAGINATION --}}
                            {{-- ========================= --}}
                            <div class="d-flex justify-content-end mt-3">
                                <nav>
                                    <ul class="pagination mb-0" id="paymentPagination">
                                        {{-- AJAX Pagination Links --}}
                                    </ul>
                                </nav>
                            </div>

                        </div>
                    </div>

                </div>



            </div>
        </div>

    </div>


    <div class="modal fade" id="payModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="payForm">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Pay Employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" name="employee_id" id="employee_id">
                        <input type="hidden" name="month" id="modal_month">

                        <div class="mb-2">
                            <small class="text-muted">Month</small>
                            <div class="fw-bold" id="modal_month_label">
                                --
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <small>Total Earned</small>
                                    <div class="fw-bold text-primary" id="modal_total_earned">$0.00</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <small>Total Paid</small>
                                    <div class="fw-bold text-success" id="modal_total_paid">$0.00</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <small>Total Due</small>
                                    <div class="fw-bold text-danger" id="modal_total_due">$0.00</div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label>Payment Amount</label>
                            <input type="number" step="0.01" class="form-control"
                                   name="amount" id="payment_amount" required>
                        </div>

                        <div class="mb-2 text-muted">
                            Remaining after this payment:
                            <strong id="remaining_after_payment">$0.00</strong>
                        </div>

                        <div class="mb-3">
                            <label>Payment Method</label>
                            <select class="form-select" aria-label="Default select example" name="payment_method">
                                <option value="" {{ old('payment_method') ? '' : 'selected' }} selected disabled>Select</option>
                                <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                <option value="Check" {{ old('payment_method') == 'Check' ? 'selected' : '' }}>Check</option>
                                <option value="Online" {{ old('payment_method') == 'Online' ? 'selected' : '' }}>Online</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Payment Date</label>
                            <input type="date" class="form-control"
                                   name="payment_date"
                                   value="{{ now()->format('Y-m-d') }}">
                        </div>

                        <div class="mb-3">
                            <label>Note</label>
                            <textarea class="form-control" name="note"></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            Confirm Payment
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>

    {{--    to open previous tab after refresing or form submission--}}
    <script>
        $(document).ready(function () {

            const STORAGE_KEY = 'activeUpdateTabPayment';

            function activateTab(targetSelector) {
                $('#updateTabs .nav-link').removeClass('active');
                $('.tab-pane').removeClass('show active');

                $('#updateTabs button[data-bs-target="' + targetSelector + '"]').addClass('active');
                $(targetSelector).addClass('show active');
            }

            const savedTab = localStorage.getItem(STORAGE_KEY);

            // Default = All Debtors
            const defaultTab = '#profile-tab';

            const initialTab = (savedTab && $(savedTab).length)
                ? savedTab
                : defaultTab;

            activateTab(initialTab);

            $('.update-tabs, .tab-content').css('visibility', 'visible');

            $('#updateTabs').on('click', 'button[data-bs-toggle="pill"]', function () {
                const target = $(this).attr('data-bs-target');
                localStorage.setItem(STORAGE_KEY, target);
            });

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

        });


        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
        };
        // $(document).on('change', 'select[name="month"]', function () {
        //     $('#monthFilterForm').submit();
        // });

        $(document).on('click', '.payBtn', function () {

            let employeeId = $(this).data('employee');
            let month = $(this).data('month');
            let due = parseFloat($(this).data('due')) || 0;

            // Set hidden inputs
            $('#employee_id').val(employeeId);
            $('#modal_month').val(month);

            // Set month label
            let formattedMonth = moment(month, "YYYY-MM").format("MMMM YYYY");
            $('#modal_month_label').text(formattedMonth);

            // Get row data directly from table (safe)
            let row = $('#row-' + month);

            let earned = parseFloat(
                row.find('td:eq(1)').text().replace('$','').replace(',','')
            ) || 0;

            let paid = parseFloat(
                row.find('td:eq(2)').text().replace('$','').replace(',','')
            ) || 0;

            // Set modal values
            $('#modal_total_earned').text('$ ' + earned.toFixed(2));
            $('#modal_total_paid').text('$ ' + paid.toFixed(2));
            $('#modal_total_due').text('$ ' + due.toFixed(2));

            $('#payment_amount').val(due.toFixed(2));
            $('#remaining_after_payment').text('$ 0.00');

            $('#payModal').modal('show');
        });

        $('#payForm').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.employees.payment.store') }}",
                type: "POST",
                data: $(this).serialize(),
                success: function (response) {

                    $('#payModal').modal('hide');
                    toastr.success(response.message);

                    let month = response.monthData.month;
                    let row = $('#row-' + month);

                    // Update Paid
                    row.find('.text-success.fw-semibold')
                        .text('$ ' + parseFloat(response.monthData.total_paid).toFixed(2));

                    // Update Due
                    row.find('.text-danger.fw-bold')
                        .text('$ ' + parseFloat(response.monthData.due).toFixed(2));

                    // Update Progress Bar
                    row.find('.progress-bar')
                        .css('width', response.monthData.progress + '%');

                    // Update Status Badge
                    if (response.monthData.status === 'Paid') {

                        row.find('td:nth-child(5)')
                            .html('<span class="badge bg-success">Paid</span>');

                        row.find('td:nth-child(6)')
                            .html('<button class="btn btn-sm btn-light" disabled>Completed</button>');

                        row.addClass('table-success');

                    } else {

                        row.find('td:nth-child(5)')
                            .html('<span class="badge bg-warning text-dark">Pending</span>');
                    }

                    // Update Profile Summary Cards
                    $('#profile_total_paid')
                        .text('$ ' + parseFloat(response.lifetime.paid).toFixed(2));

                    $('#profile_total_due')
                        .text('$ ' + parseFloat(response.lifetime.due).toFixed(2));

                },
                error: function (xhr) {

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        toastr.error('Something went wrong.');
                    }
                }
            });
        });


        $('#payment_amount').on('input', function () {

            let earned = parseFloat($('#modal_total_earned').text().replace('$','')) || 0;
            let paid = parseFloat($('#modal_total_paid').text().replace('$','')) || 0;
            let payment = parseFloat($(this).val()) || 0;

            let due = earned - paid;

            if (payment > due) {
                $(this).val(due.toFixed(2));
                payment = due;
            }

            let remaining = due - payment;

            $('#remaining_after_payment').text('$ ' + remaining.toFixed(2));
        });

        // month filter
        $(document).ready(function () {

            $('#commissionFilter').on('change', function () {

                let range = $(this).val();
                let employeeId = "{{ $employee->id }}";

                $('#commissionTableBody').fadeTo(150, 0.4);

                $.ajax({
                    url: "/admin/employee-payments/" + employeeId + "/monthly-breakdown",
                    type: "GET",
                    data: { range: range },
                    success: function (response) {

                        let rows = '';

                        if (response.length === 0) {
                            rows = `
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            No commission records found.
                        </td>
                    </tr>`;
                        } else {

                            response.forEach(function (month) {

                                let formattedMonth = moment(month.month, "YYYY-MM").format("MMMM YYYY");

                                rows += `
                        <tr id="row-${month.month}">
                            <td>
                                <strong>${formattedMonth}</strong>
                            </td>

                            <td class="text-primary fw-bold">
                                $ ${parseFloat(month.total_commission).toFixed(2)}
                            </td>

                            <td>
                                <div class="d-flex flex-column">

                                    <span class="text-success fw-semibold">
                                        $ ${parseFloat(month.total_paid).toFixed(2)}
                                    </span>

                                    <div class="progress mt-1" style="height:6px;">
                                        <div class="progress-bar bg-success"
                                             style="width: ${month.progress}%">
                                        </div>
                                    </div>

                                </div>
                            </td>

                            <td class="text-danger fw-bold">
                                $ ${parseFloat(month.due).toFixed(2)}
                            </td>

                            <td>
                                ${month.status === 'Paid'
                                    ? `<span class="badge bg-success">Paid</span>`
                                    : `<span class="badge bg-warning text-dark">Pending</span>`
                                }
                            </td>

                            <td class="text-end">
                                ${month.due > 0
                                    ? `<button class="btn btn-sm btn-success payBtn"
                                        data-employee="${employeeId}"
                                        data-month="${month.month}"
                                        data-due="${month.due}">
                                        <i class="fas fa-money-bill-wave"></i> Pay
                                       </button>`
                                    : `<button class="btn btn-sm btn-light" disabled>
                                         Completed
                                       </button>`
                                }
                            </td>
                        </tr>
                    `;
                            });
                        }

                        $('#commissionTableBody')
                            .html(rows)
                            .fadeTo(200, 1);
                    }
                });

            });


        });

        function loadPaymentHistory(page = 1) {
            console.log('comming')

            let employeeId = "{{ $employee->id }}";

            $.ajax({
                url: "{{ route('admin.employee-payment.history', $employee->id) }}?page=" + page,
                type: "GET",
                success: function (response) {

                    let rows = '';

                    if (response.data.length === 0) {
                        rows = `
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            No payment history found.
                        </td>
                    </tr>
                `;
                    } else {

                        response.data.forEach(function (item) {

                            rows += `
                        <tr>
                            <td>${item.date}</td>
                            <td>${item.month}</td>
                            <td class="text-success fw-semibold">$ ${item.amount}</td>
                            <td>${item.method ?? '-'}</td>
                            <td>${item.note ?? '-'}</td>
                            <td class="text-danger fw-bold"
                                data-bs-toggle="tooltip"
                                title="Running Balance After This Payment =
                                Total Earned - SUM(all payments up to and including this payment)">
                                $ ${item.running_balance}
                            </td>

                        </tr>
                    `;
                        });

                    }

                    $('#paymentHistoryBody').html(rows);
                    $('[data-bs-toggle="tooltip"]').tooltip();

                    /*
                    |--------------------------------------------------------------------------
                    | Update Cards
                    |--------------------------------------------------------------------------
                    */

                    $('#totalPaymentsMade').text('$ ' + response.summary.total_paid);
                    $('#totalTransactions').text(response.summary.total_transactions);
                    $('#lastPaymentDate').text(response.summary.last_payment);
                    $('#runningBalance').text('$ ' + response.summary.running_balance);

                    /*
                    |--------------------------------------------------------------------------
                    | Pagination
                    |--------------------------------------------------------------------------
                    */

                    let pagination = '';
                    for (let i = 1; i <= response.pagination.last_page; i++) {
                        pagination += `
                    <li class="page-item ${i === response.pagination.current_page ? 'active' : ''}">
                        <a class="page-link historyPageBtn" href="#" data-page="${i}">
                            ${i}
                        </a>
                    </li>
                `;
                    }

                    $('#paymentPagination').html(pagination);

                }
            });
        }

        $(document).ready(function () {
            loadPaymentHistory();
        });

        $(document).on('click', '.historyPageBtn', function (e) {
            e.preventDefault();
            let page = $(this).data('page');
            loadPaymentHistory(page);
        });

        $('button[data-bs-target="#history-tab"]').on('shown.bs.tab', function () {
            loadPaymentHistory();
        });



    </script>
@endpush

@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
    <style>

        /*tab css start*/

        .update-tabs .nav-link {
            font-weight: 600;
            color: #6c757d;
            border-radius: 10px;
            padding: 10px 15px;
            transition: all 0.25s ease;
        }

        .update-tabs .nav-link.active {
            background: linear-gradient(135deg, #c7f000, #9adf00);
            color: #1f2d3d;
            box-shadow: 0 6px 15px rgba(154, 223, 0, 0.35);
        }

        .update-tabs .nav-link i {
            opacity: 0.85;
        }

        /* Smooth fade + slide animation for tab content */
        .tab-pane {
            opacity: 0;
            transform: translateY(8px);
            transition: all 0.35s ease;
        }

        .tab-pane.show.active {
            opacity: 1;
            transform: translateY(0);
        }

        .update-tabs .nav-link {
            transition: all 0.25s ease;
        }

        .update-tabs .nav-link.active {
            transform: translateY(-1px);
        }

        /* Prevent tab flash before JS restores state */
        .update-tabs,
        .tab-content {
            visibility: hidden;
        }

        /* Scrollable tab content */
        #tabContentWrapper {
            overflow-y: auto;
            padding-top: 12px;
            overflow-x:hidden ;
        }

        /* Scroll shadow indicator */
        #tabContentWrapper::before {
            content: "";
            position: sticky;
            top: 0;
            height: 12px;
            /*background: linear-gradient(to bottom, rgba(0,0,0,0.15), transparent);*/
            display: none;
            /*z-index: 5;*/
        }

        #tabContentWrapper.scrolled::before {
            display: block;
        }

        #history-tab .card {
            border-radius: 10px;
        }

        #paymentHistoryTable tbody tr {
            transition: all 0.2s ease;
        }

        #paymentHistoryTable tbody tr:hover {
            background-color: #f8f9fa;
            transform: translateY(-1px);
        }
    </style>
@endpush
