{{--@extends('layouts.master')--}}

{{--@section('content')--}}
{{--    <div class="row">--}}
{{--        <div class="col-sm-12">--}}
{{--            <div class="card">--}}
{{--                <div class="card-body">--}}
{{--                    <div class="d-flex justify-content-between">--}}
{{--                        <h4 class="card-title mb-3">Employees</h4>--}}
{{--                        @can('Employee Create')--}}
{{--                        <a href="{{ route('admin.employees.create') }}" class="btn btn-sm btn-primary text-capitalize" style="padding-top: 8px;">Create Employee</a>--}}
{{--                        @endcan--}}
{{--                    </div>--}}
{{--                    {!! $dataTable->table(['class'=>'table-responsive']) !!}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--@endsection--}}

{{--@push('style')--}}
{{--    @include('includes.styles.datatable')--}}
{{--@endpush--}}

{{--@push('script')--}}
{{--    @include('includes.scripts.datatable')--}}
{{--@endpush--}}

@extends('layouts.master')

@section('content')

    <div class="row">

        {{-- ===================== --}}
        {{-- HEADER + MONTH FILTER --}}
        {{-- ===================== --}}
        <div class="col-12 mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0"></h4>

                <form method="GET" id="monthFilterForm" class="d-flex align-items-center">
                    <label class="me-2 fw-bold">Month:</label>
                    <select name="month" class="form-select form-select-sm" style="width:200px;">
                        @foreach($months as $value => $label)
                            <option value="{{ $value }}"
                                {{ $selectedMonth == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>


        {{-- ===================== --}}
        {{-- LIFETIME SUMMARY --}}
        {{-- ===================== --}}
        <div class="col-12 mb-2">
            <h6 class="text-muted">Lifetime Overview</h6>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">Total Generated</small>
                    <h4 class="fw-bold text-primary lifetime-generated">
                        $ {{ number_format($totalGenerated ?? 0, 2) }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">Total Paid</small>
                    <h4 class="fw-bold text-success lifetime-paid">
                        $ {{ number_format($totalPaid ?? 0, 2) }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">Total Outstanding</small>
                    <h4 class="fw-bold text-danger lifetime-pending">
                        $ {{ number_format($totalPending ?? 0, 2) }}
                    </h4>
                </div>
            </div>
        </div>


        {{-- ===================== --}}
        {{-- MONTHLY SUMMARY --}}
        {{-- ===================== --}}
        <div class="col-12 mb-2">
            <h6 class="text-muted">
                Monthly Overview ({{ \Carbon\Carbon::parse($selectedMonth)->format('F Y') }})
            </h6>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">Generated</small>
                    <h4 class="fw-bold text-primary month-generated">
                        $ {{ number_format($monthGenerated ?? 0, 2) }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">Paid</small>
                    <h4 class="fw-bold text-success month-paid">
                        $ {{ number_format($monthPaid ?? 0, 2) }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">Outstanding</small>
                    <h4 class="fw-bold text-danger month-outstanding">
                        $ {{ number_format($thisMonthPayable ?? 0, 2) }}
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">Employees Pending</small>
                    <h4 class="fw-bold text-warning month-pending-count">
                        {{ $pendingEmployeeCount ?? 0 }}
                    </h4>
                </div>
            </div>
        </div>


        {{-- ===================== --}}
        {{-- DATATABLE --}}
        {{-- ===================== --}}
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Monthly Payment Details</h5>
                    {!! $dataTable->table(['class' => 'table table-bordered table-hover w-100']) !!}
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
                        <input type="hidden" name="month" id="modal_month" value="{{ $selectedMonth }}">

                        <div class="mb-2">
                            <small class="text-muted">Month</small>
                            <div class="fw-bold">
                                {{ \Carbon\Carbon::parse($selectedMonth)->format('F Y') }}
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


@push('style')
    @include('includes.styles.datatable')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>

    <style>
        .card {
            border-radius: 12px;
        }
        .card-body small {
            font-size: 13px;
        }
        .table-warning {
            background-color: #fff3cd !important;
        }
        .table-danger {
            background-color: #f8d7da !important;
        }
    </style>
@endpush


@push('script')
    @include('includes.scripts.datatable')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
        };
        $(document).on('change', 'select[name="month"]', function () {
            $('#monthFilterForm').submit();
        });

        $(document).on('click', '.pay-btn', function () {
            let employeeId = $(this).data('id');
            $('#employee_id').val(employeeId);
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

                    // Reload DataTable
                    $('#employee-payment-table').DataTable().ajax.reload(null, false);

                    // Reload summary cards dynamically
                    refreshSummaryCards();
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


        $(document).on('click', '.pay-btn', function () {

            let employeeId = $(this).data('id');
            let earned = parseFloat($(this).data('earned')) || 0;
            let paid = parseFloat($(this).data('paid')) || 0;

            let due = earned - paid;

            $('#employee_id').val(employeeId);
            $('#modal_total_earned').text('$ ' + earned.toFixed(2));
            $('#modal_total_paid').text('$ ' + paid.toFixed(2));
            $('#modal_total_due').text('$ ' + due.toFixed(2));
            $('#payment_amount').val(due.toFixed(2));
            $('#remaining_after_payment').text('$ 0.00');

            $('#payModal').modal('show');
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

        function refreshSummaryCards() {

            $.ajax({
                url: "{{ route('admin.employee.payment.summary') }}",
                type: "GET",
                data: {
                    month: $('select[name="month"]').val()
                },
                success: function (data) {

                    // Lifetime
                    $('.lifetime-generated').text('$ ' + data.totalGenerated);
                    $('.lifetime-paid').text('$ ' + data.totalPaid);
                    $('.lifetime-pending').text('$ ' + data.totalPending);

                    // Monthly
                    $('.month-generated').text('$ ' + data.monthGenerated);
                    $('.month-paid').text('$ ' + data.monthPaid);
                    $('.month-outstanding').text('$ ' + data.thisMonthPayable);
                    $('.month-pending-count').text(data.pendingEmployeeCount);
                }
            });
        }


    </script>
@endpush

