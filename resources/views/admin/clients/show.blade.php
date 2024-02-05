@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            {{-- <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Name</h5>
                            <p>{{ $client->name }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Nric</h5>
                            <p>{{ $client->nric }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Company Name</h5>
                            <p>{{ $client->company_name }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Company Uen</h5>
                            <p>{{ $client->company_uen }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Phone</h5>
                            <p>{{ $client->phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Email</h5>
                            <p>{{ $client->email }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Address</h5>
                            <p>{{ $client->address }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Date of agreement</h5>
                            <p>{{ date('d-m-Y', strtotime($client->date_of_agreement)) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Date of expiry</h5>
                            <p>{{ date('d-m-Y', strtotime($client->date_of_expiry)) }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Admin Fee</h5>
                            <p>{{ $client->admin_fee }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Admin Fee Paid</h5>
                            <p>{{ $client->admin_fee_paid }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Admin Fee Balance</h5>
                            <p>{{ $client->admin_fee_balance }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Collection Commission</h5>
                            <p>{{ $client->collection_commission }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Field Visit Per Case</h5>
                            <p>{{ $client->field_visit_per_case }}</p>
                        </div>
                    </div>
                </div>

            </div> --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th scope="row">Name</th>
                                        <td>{{ $client->name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">NRIC</th>
                                        <td>{{ $client->nric }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Company Name</th>
                                        <td>{{ $client->company_name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Company Uen</th>
                                        <td>{{ $client->company_uen }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Phone</th>
                                        <td>{{ $client->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Email</th>
                                        <td>{{ $client->email }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Address</th>
                                        <td>{{ $client->address }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th scope="row">Date of Agreement</th>
                                        <td>{{ date('d-m-Y', strtotime($client->date_of_agreement)) }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Date of Expiry</th>
                                        <td>{{ date('d-m-Y', strtotime($client->date_of_expiry)) }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Admin Fee</th>
                                        <td>{{ $client->admin_fee }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Admin Fee Paid</th>
                                        <td>{{ $client->admin_fee_paid }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Admin Fee Balance</th>
                                        <td>{{ $client->admin_fee_balance}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Collection Commission</th>
                                        <td>{{ $client->collection_commission }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Field Visit Per Case</th>
                                        <td>{{ $client->field_visit_per_case }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($cases as $case)
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5>CASE</h5>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th scope="row">Key</th>
                                        <td>Value</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Case Number</th>
                                        <td>{{ $case->case_number }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Current Status</th>
                                        <td>{{ $case->current_status }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Date of Agreement</th>
                                        <td>{{ $case->date_of_agreement }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Date of Expiry</th>
                                        <td>{{ $case->date_of_expiry }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Client Name</th>
                                        <td>{{ $case->client->name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Collection Commission</th>
                                        <td>{{ $case->collection_commission }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Field Visit</th>
                                        <td>{{ $case->field_visit }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Bal Field Visit</th>
                                        <td>{{ $case->bal_field_visit }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Manager IC</th>
                                        <td>{{ $case->manager_ic }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Collector IC</th>
                                        <td>{{ $case->collector_ic }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Debtor Name</th>
                                        <td>{{ $case->name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Debtor NRIC</th>
                                        <td>{{ $case->nric }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Debtor Company Name</th>
                                        <td>{{ $case->company_name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Debtor Company UEN</th>
                                        <td>{{ $case->company_uen }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Debtor Phone</th>
                                        <td>{{ $case->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Debtor Email</th>
                                        <td>{{ $case->email }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Debtor Address</th>
                                        <td>{{ $case->adderss }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Debt Amount</th>
                                        <td>{{ $case->debt_amount }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Legal Cost</th>
                                        <td>{{ $case->legal_cost }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Debt Interest</th>
                                        <td>{{ $case->debt_interest }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Interest Start Date</th>
                                        <td>{{ $case->interest_start_date }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Interest End Date</th>
                                        <td>{{ $case->interest_start_date }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Total Interest</th>
                                        <td>{{ $case->total_interest }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Total Amount Owed</th>
                                        <td>{{ $case->total_amount_owed }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Total Amount Paid</th>
                                        <td>{{ $case->total_amount_paid }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Total Amount Balance</th>
                                        <td>{{ $case->total_amount_balance }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endsection

    @push('script')
        <script src="{{ asset('/admin/js/passwordCheck.js') }}"></script>
    @endpush
