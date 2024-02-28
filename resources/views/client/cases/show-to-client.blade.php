@extends('layouts.master')

@section('content')
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
                                        <th scope="row">Case Number</th>
                                        <td>{{ $case->case_number }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Current Status</th>
                                        <td>{{ $case->current_status }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Date of Warrant</th>
                                        <td>{{ date('d-m-Y', strtotime($case->date_of_warrant)) }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Date of Expiry</th>
                                        <td>{{ date('d-m-Y', strtotime($case->date_of_expiry)) }}</td>
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
                                        <td>{{ date('d-m-Y', strtotime($case->interest_start_date)) }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Interest End Date</th>
                                        <td>{{ date('d-m-Y', strtotime($case->interest_end_date)) }}</td>
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
