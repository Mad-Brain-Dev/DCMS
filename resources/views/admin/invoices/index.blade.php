@extends('layouts.master')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">
            {{ $clientSummary
                ? "Showing invoice summary for: " . $clientSummary['name']
                : 'Invoice Dashboard' }}
        </h4>

        <a href="{{ route('admin.invoices.create') }}"
           class="btn btn-dark">
            <i class="mdi mdi-plus"></i> Create Invoice
        </a>
    </div>

    <div class="row">

        {{-- ===================== --}}
        {{-- HEADER + MONTH FILTER --}}
        {{-- ===================== --}}
        <div class="col-12 mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0"></h4>

                <form method="GET" id="monthFilterForm" class="d-flex align-items-center">
                    <label class="me-2 fw-bold">Month:</label>
                    <input type="month"
                           name="month"
                           class="form-control form-control-sm shadow-sm"
                           style="width:200px; border-radius:8px;"
                           value="{{ request('month') ?? now()->format('Y-m') }}">
{{--                    <select name="month" class="form-select form-select-sm" style="width:200px;">--}}
{{--                        @foreach($months as $value => $label)--}}
{{--                            <option value="{{ $value }}"--}}
{{--                                {{ $selectedMonth == $value ? 'selected' : '' }}>--}}
{{--                                {{ $label }}--}}
{{--                            </option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
                </form>
            </div>
        </div>


        {{-- ===================== --}}
        {{-- SUMMARY --}}
        {{-- ===================== --}}
        <div class="row mb-4">

            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <small>Total Invoices</small>
                        <h4 class="fw-bold">{{ $totalInvoices }}</h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <small>Total Collected</small>
                        <h4 class="fw-bold text-primary">
                            $ {{ number_format($totalCollected, 2) }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <small>Total Final Amount</small>
                        <h4 class="fw-bold text-success">
                            $ {{ number_format($totalFinalAmount, 2) }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <small>Outstanding</small>
                        <h4 class="fw-bold text-danger">
                            $ {{ number_format($totalOutstanding, 2) }}
                        </h4>
                    </div>
                </div>
            </div>

        </div>

        @if(!empty($clientSummary))
            <div class="row mb-4">

                <div class="col-md-3">
                    <div class="card shadow-sm border-0 bg-light">
                        <div class="card-body">
                            <small>Client Name</small>
                            <h5 class="fw-bold">{{ $clientSummary['name'] }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm border-0 bg-light">
                        <div class="card-body">
                            <small>Payment Count</small>
                            <h5 class="fw-bold">{{ $clientSummary['payment_count'] }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm border-0 bg-light">
                        <div class="card-body">
                            <small>Total Collected</small>
                            <h5 class="fw-bold text-primary">
                                $ {{ number_format($clientSummary['total_collected'], 2) }}
                            </h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm border-0 bg-light">
                        <div class="card-body">
                            <small>Total Balance</small>
                            <h5 class="fw-bold text-danger">
                                $ {{ number_format($clientSummary['total_balance'], 2) }}
                            </h5>
                        </div>
                    </div>
                </div>

            </div>
        @endif

{{--        Filter section--}}

        <form method="GET" class="row mb-3">

            <div class="col-md-3">
                <label>Date From</label>
                <input type="date" name="from" class="form-control"
                       value="{{ request('from') }}">
            </div>

            <div class="col-md-3">
                <label>Date To</label>
                <input type="date" name="to" class="form-control"
                       value="{{ request('to') }}">
            </div>

            <div class="{{request()->hasAny(['from','to','client_id','status','month']) ? 'col-md-2' : 'col-md-3'}}">
                <label>Client</label>
                <select name="client_id" class="form-select">
                    <option value="">All</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}"
                            {{ request('client_id') == $client->id ? 'selected' : '' }}>
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label>Status</label>
                <select name="status" class="form-select">
                    <option value="">All</option>
                    <option value="issued" {{ request('status') == 'issued' ? 'selected' : '' }}>Issued</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                </select>
            </div>

            <div class="col-md-1 d-flex align-items-end">
                <button class="btn btn-dark w-100">Filter</button>
            </div>
            @if(request()->hasAny(['from','to','client_id','status','month']))
                <div class="col-md-1 d-flex align-items-end">
                    <a href="{{ route('admin.invoices.index') }}"
                       class="btn btn-secondary w-100">
                        Clear
                    </a>
                </div>
            @endif

        </form>



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

    <!-- Change Status Modal -->
    <div class="modal fade" id="changeStatusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="statusForm" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="modal-header">
                        <h5 class="modal-title">Change Invoice Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" id="invoice_id">

                        <div class="mb-3">
                            <label>Status</label>
                            <select name="status" id="statusSelect" class="form-select" required>
                                <option value="issued">Issued</option>
                                <option value="paid">Paid</option>
                            </select>
                        </div>

                        <div class="mb-3" id="paidDateField" style="display:none;">
                            <label>Paid Date</label>
                            <input type="date" name="paid_date" class="form-control">
                        </div>

                        <div class="mb-3" id="issuedDateField" style="display:none;">
                            <label>Issued Date</label>
                            <input type="date" name="issued_date" class="form-control">
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark">
                            Save Changes
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
@endpush


@push('script')
    @include('includes.scripts.datatable')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).on('click', '.change-status-btn', function () {

            let id = $(this).data('id');

            $('#statusForm').attr('action', '/admin/invoices/' + id + '/change-status');

            $('#statusModal').modal('show');
        });

        $(document).on('click', '.change-status-btn', function () {

            let invoiceId = $(this).data('id');
            let currentStatus = $(this).data('status');
            let issuedDate = $(this).data('issued');
            let paidDate = $(this).data('paid');

            $('#invoice_id').val(invoiceId);
            $('#statusSelect').val(currentStatus);

            $('input[name="issued_date"]').val(issuedDate ?? '');
            $('input[name="paid_date"]').val(paidDate ?? '');

            let actionUrl = "{{ route('admin.invoices.update-status', ':id') }}";
            actionUrl = actionUrl.replace(':id', invoiceId);

            $('#statusForm').attr('action', actionUrl);

            toggleDateFields(currentStatus);

            $('#changeStatusModal').modal('show');
        });

        $('#statusSelect').change(function () {
            toggleDateFields($(this).val());
        });

        function toggleDateFields(status) {

            $('#paidDateField').hide();
            $('#issuedDateField').hide();

            if (status === 'paid') {
                $('#paidDateField').show();
            }

            if (status === 'issued') {
                $('#issuedDateField').show();
            }
        }

        $('input[name="month"]').on('change', function () {
            $('#monthFilterForm').submit();
        });

    </script>

@endpush

