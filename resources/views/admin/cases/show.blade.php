@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Case Number</h5>
                            <p>{{ $case->case_number }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Current Status</h5>
                            <p>{{ $case->current_status }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Date of Agreement</h5>
                            <p>{{ date('d-m-Y', strtotime($case->date_of_agreement)) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Date of Expiry</h5>
                            <p>{{ date('d-m-Y', strtotime($case->date_of_expiry)) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Collection Commission</h5>
                            <p>{{ $case->collection_commission }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Field Visit</h5>
                            <p>{{ $case->field_visit }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Bal Field Visit</h5>
                            <p>{{ $case->bal_field_visit }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Manager IC</h5>
                            <p>{{ $case->manager_ic }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Collector IC</h5>
                            <p>{{ $case->collector_ic }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Debtor Name</h5>
                            <p>{{ $case->name }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Debtor NRIC</h5>
                            <p>{{ $case->nric }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Debtor Company Name</h5>
                            <p>{{ $case->company_name }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Debtor Company UEN</h5>
                            <p>{{ $case->company_uen }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Debtor Phone</h5>
                            <p>{{ $case->phone }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Debtor Email</h5>
                            <p>{{ $case->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Debtor Address</h5>
                            <p>{{ $case->adderss }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Debt Amount</h5>
                            <p>{{ $case->debt_amount }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Legal Cost</h5>
                            <p>{{ $case->legal_cost }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Debt interest</h5>
                            <p>{{ $case->debt_interest }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Interest Start Date</h5>
                            <p>{{ date('d-m-Y', strtotime($case->interest_start_date)) }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Interest End Date</h5>
                            <p>{{ date('d-m-Y', strtotime($case->interest_end_date)) }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Total Interest</h5>
                            <p>{{ $case->total_interest }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Total Amount Owed</h5>
                            <p>{{ $case->total_amount_owed }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Total Amount Paid</h5>
                            <p>{{ $case->total_amount_paid }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Total Amount Balance</h5>
                            <p>{{ $case->total_amount_balance }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('/admin/js/passwordCheck.js') }}"></script>
@endpush
