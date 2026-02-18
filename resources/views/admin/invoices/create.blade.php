@extends('layouts.master')

@section('content')

    <div class="row">

        {{-- ========================= --}}
        {{-- PAGE HEADER --}}
        {{-- ========================= --}}
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h4>Create Invoice</h4>
                <a href="{{ route('admin.invoices.index') }}" class="btn btn-dark btn-sm">
                    ← Back
                </a>
            </div>
        </div>

        {{-- ========================= --}}
        {{-- CLIENT SELECTION --}}
        {{-- ========================= --}}
{{--        <form id="invoiceForm" method="POST" action="{{ route('admin.invoices.store') }}">--}}
{{--            @csrf--}}
{{--            @method('POST')--}}
        <div class="col-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <label class="fw-bold">Select Client</label>
                    <select id="clientSelect" class="form-select select2" name="client_id">
                        <option value="">-- Select Client --</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}"
                                    data-commission="{{ $client->collection_commission }}">
                                {{ $client->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Client Summary</h5>
                    <div class="d-flex justify-content-between">
                        <h5>Client Name: <span id="bannerClientName"></span></h5>
                        <h5>Payment Count: <span id="bannerPaymentCount"></span></h5>
                        <h5>Total Collected: <span id="bannerTotalCollected"></span></h5>
                        <h5>Total Balance: <span id="bannerTotalBalance"></span></h5>
                    </div>
                </div>
            </div>
        </div>

        {{-- ========================= --}}
        {{-- MAIN SECTION --}}
        {{-- ========================= --}}
        <div class="col-md-9">

            <div class="card shadow-sm">
                <div class="card-body">

                    <h5 class="mb-3">Installments</h5>

                    <form id="invoiceForm" method="POST" action="{{ route('admin.invoices.store') }}">
                        @csrf
                        <input type="hidden" name="client_id" id="selectedClientId">

                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                            <tr>
                                <th width="30"><input type="checkbox" id="selectAll"></th>
                                <th>Case #</th>
                                <th>Debtor</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Collected By</th>
                                <th>Paid To</th>
                                <th>Total Paid</th>
                                <th>Total Balance</th>
                                <th>Total Debt</th>
                                <th>Next Payment</th>
                            </tr>
                            </thead>
                            <tbody id="installmentTableBody">
                            <tr>
                                <td colspan="11" class="text-center text-muted">
                                    Select client to load installments
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </form>

                </div>
            </div>

        </div>

        {{-- ========================= --}}
        {{-- LIVE SUMMARY PANEL --}}
        {{-- ========================= --}}
        <div class="col-md-3">

            <div class="card shadow-sm">
                <div class="card-body">

                    <h5 class="mb-3">Invoice Summary</h5>

                    <div class="mb-2">
                        <small>Total Selected</small>
                        <h6 class="fw-bold" id="totalSelected">0</h6>
                    </div>

                    <hr>

                    <div class="mb-2">
                        <small>Total Collected by Client</small>
                        <h6 class="fw-bold text-primary" id="collectedClient">$0.00</h6>
                    </div>

                    <div class="mb-2">
                        <small>Total Collected by Securre</small>
                        <h6 class="fw-bold text-primary" id="collectedSecurre">$0.00</h6>
                    </div>

                    <hr>

                    <div class="mb-2">
                        <small>Payable to Client</small>
                        <h6 class="fw-bold text-success" id="payableClient">$0.00</h6>
                    </div>

                    <div class="mb-2">
                        <small>Payable to Securre</small>
                        <h6 class="fw-bold text-danger" id="payableSecurre">$0.00</h6>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <small>Final Invoice Amount</small>
                        <h4 class="fw-bold" id="finalAmount">$0.00</h4>
                    </div>

                    <button type="submit"
                            form="invoiceForm"
                            class="btn btn-dark w-100"
                            id="generateBtn"
                            disabled>
                        Generate Invoice
                    </button>

                </div>
            </div>

        </div>
{{--        </form>--}}

    </div>

@endsection

@push('script')
    <script>

        $('.select2').select2();

        let commissionRate = 0;

        $('#clientSelect').change(function () {
            console.log('selected working')

            let clientId = $(this).val();
            console.log('client ID: '+clientId)
            commissionRate = parseFloat($(this).find(':selected').data('commission')) || 0;
            console.log('commission: '+commissionRate)

            $('#selectedClientId').val(clientId);

            if (!clientId) return;

            $.ajax({
                url: "{{ route('admin.invoices.client-installments') }}",
                type: "GET",
                data: { client_id: clientId },
                dataType: "json",
                success: function (response) {

                    console.log(response);

                    // =========================
                    // UPDATE TOP BANNER
                    // =========================

                    if (response.banner) {

                        $('#bannerClientName').text(response.banner.client_name);
                        $('#bannerPaymentCount').text(response.banner.payment_count);
                        $('#bannerTotalCollected').text('$' + parseFloat(response.banner.total_collected).toFixed(2));
                        $('#bannerTotalBalance').text('$' + parseFloat(response.banner.total_balance).toFixed(2));
                    }

                    // =========================
                    // CHECK INSTALLMENTS
                    // =========================

                    if (!response.data || response.data.length === 0) {

                        $('#installmentTableBody').html(`
            <tr>
                <td colspan="11" class="text-center text-muted">
                    No installments found
                </td>
            </tr>
        `);

                        return;
                    }

                    let rows = '';

                    response.data.forEach(function (item) {

                        let rowClass = item.is_invoiced ? 'table-success' : '';
                        let disabled = item.is_invoiced ? 'disabled' : '';

                        console.log('rowClass: '+rowClass)

                        rows += `
            <tr class="${rowClass}">
                <td>
                    <input type="checkbox"
                        class="installment-checkbox"
                        name="installments[]"
                        value="${item.id}"
                        data-amount="${item.amount_paid}"
                        data-type="${item.pay_to_who}"
                        ${disabled}>
                </td>
                <td>${item.case.case_number ?? '-'}</td>
                <td>${item.debtor ?? '-'}</td>
                <td>${item.date_of_payment ?? '-'}</td>
                <td>$${parseFloat(item.amount_paid).toFixed(2)}</td>
                <td>${item.collectedBy ?? '-'}</td>
                <td>${item.pay_to_who}</td>
                <td>$${parseFloat(item.case.snapshot_total_paid).toFixed(2)}</td>
                <td>$${parseFloat(item.case.snapshot_total_balance).toFixed(2)}</td>
                <td>$${parseFloat(item.case.snapshot_total_debt).toFixed(2)}</td>
                <td>${item.next_payment_date ?? '-'}</td>
            </tr>
        `;
                    });

                    $('#installmentTableBody').html(rows);
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                }
            });

        });

        $(document).on('change', '.installment-checkbox', function () {

            let totalSelected = 0;
            let collectedClient = 0;
            let collectedSecurre = 0;
            let payableClient = 0;
            let payableSecurre = 0;

            $('.installment-checkbox:checked').each(function () {

                totalSelected++;

                let amount = parseFloat($(this).data('amount'));
                let type = $(this).data('type');

                let commissionAmount = amount * (commissionRate / 100);

                if (type === 'Client') {
                    collectedClient += amount;
                    payableSecurre += commissionAmount;
                } else {
                    collectedSecurre += amount;
                    payableClient += (amount - commissionAmount);
                }

            });

            let finalAmount = Math.abs(payableClient - payableSecurre);

            $('#totalSelected').text(totalSelected);
            $('#collectedClient').text('$' + collectedClient.toFixed(2));
            $('#collectedSecurre').text('$' + collectedSecurre.toFixed(2));
            $('#payableClient').text('$' + payableClient.toFixed(2));
            $('#payableSecurre').text('$' + payableSecurre.toFixed(2));
            $('#finalAmount').text('$' + finalAmount.toFixed(2));

            $('#generateBtn').prop('disabled', totalSelected === 0);
        });

        $('#selectAll').click(function () {
            $('.installment-checkbox').prop('checked', this.checked).trigger('change');
        });

    </script>

@endpush
