@extends('layouts.master')


@section('content')

<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card mini-stat bg-primary text-white">
            <div class="card-body">
                <div class="">
                    <div class="float-start bill">
                        <i class="fa fa-sticky-note" aria-hidden="true"></i>
                    </div>
                    <h5 class="font-size-16 text-uppercase text-white-50">Total Cases</h5>
                    <h4 class="fw-medium font-size-24"> {{ $total_cases }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card mini-stat bg-primary text-white">
            <div class="card-body">
                <div class="">
                    <div class="float-start bill">
                        <i class="fa fa-folder-open" aria-hidden="true"></i>
                    </div>
                    <h5 class="font-size-16 text-uppercase text-white-50">New Cases</h5>
                    <h4 class="fw-medium font-size-24"> {{ $open_cases }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card mini-stat bg-primary text-white">
            <div class="card-body">
                <div class="">
                    <div class="float-start bill">
                        <i class="fa fa-folder" aria-hidden="true"></i>
                    </div>
                    <h5 class="font-size-16 text-uppercase text-white-50">Pending Cases</h5>
                    <h4 class="fw-medium font-size-24"> {{ $pending_cases }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card mini-stat bg-primary text-white">
            <div class="card-body">
                <div class="">
                    <div class="float-start bill">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </div>
                    <h5 class="font-size-16 text-uppercase text-white-50">Closed Cases</h5>
                    <h4 class="fw-medium font-size-24"> {{ $close_cases }}</h4>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="row">
    <div class="col-md-6">
        <table class="table">
            <tbody>
                <tr class="table-light">
                    <th scope="row">Name</th>
                    <td class="text-end">{{ $client->name }}</td>
                </tr>
                <tr class="table-light">
                    <th scope="row">NRIC</th>
                    <td class="text-end">{{ $client->nric }}</td>
                </tr>
                <tr class="table-light">
                    <th scope="row">PIC Name</th>
                    <td class="text-end">{{ $client->pic_name }}</td>
                </tr>
                <tr class="table-light">
                    <th scope="row">PIC Number</th>
                    <td class="text-end">{{ $client->pic_number }}</td>
                </tr>
                <tr class="table-light">
                    <th scope="row">Phone</th>
                    <td class="text-end">{{ $client->phone }}</td>
                </tr>
                <tr class="table-light">
                    <th scope="row">Email</th>
                    <td class="text-end">{{ $client->email }}</td>
                </tr>
                <tr class="table-light">
                    <th scope="row">Address</th>
                    <td class="text-end">{{ $client->address }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <table class="table">
            <tbody>
                <tr class="table-light">
                    <th scope="row">Total Field Visit</th>
                    <td class="text-end">{{ $client->field_visit_per_case }}</td>
                </tr>
                <tr class="table-light">
                    <th scope="row">Date of Agreement</th>
                    <td class="text-end">{{ date('d-m-Y', strtotime($client->date_of_agreement)) }}</td>
                </tr>
                <tr class="table-light">
                    <th scope="row">Date of Expiry</th>
                    <td class="text-end">{{ date('d-m-Y', strtotime($client->date_of_expiry)) }}</td>
                </tr>

                <tr class="table-light">
                    <th scope="row">Collection Commission</th>
                    <td class="text-end">{{ $client->collection_commission }} %</td>
                </tr>
                <tr class="table-light">
                    <th scope="row">Admin Fee</th>
                    <td class="text-end">$ {{ number_format($client->admin_fee, 2, '.', ',') }} </td>
                </tr>
                <tr class="table-light">
                    <th scope="row">Admin Fee Paid</th>
                    <td class="text-end">$ {{ number_format($client->admin_fee_paid, 2, '.', ',') }} </td>
                </tr>
                <tr class="table-light">
                    <th scope="row">Admin Fee Balance</th>
                    <td class="text-end">$ {{ number_format($client->admin_fee_balance, 2, '.', ',') }} </td>
                </tr>
            </tbody>
        </table>
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
                                <th scope="row">Case Number</th>
                                <td class="text-end">{{ $case->case_sku }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Current Status</th>
                                <td class="text-end">{{ $case->current_status }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Client Name</th>
                                <td class="text-end">{{ $case->client->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Date of Warrant</th>
                                <td class="text-end">{{ date('d-m-Y', strtotime($case->date_of_warrant)) }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Manager IC</th>
                                <td class="text-end">{{ $case->manager_ic }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Collector IC</th>
                                <td class="text-end">{{ $case->collector_ic }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Collection Commission</th>
                                <td class="text-end">{{ $case->collection_commission }} %</td>
                            </tr>
                            <tr>
                                <th scope="row">Field Visit</th>
                                <td class="text-end">{{ $case->field_visit }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Bal Field Visit</th>
                                <td class="text-end">{{ $case->bal_field_visit }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Debtor Name</th>
                                <td class="text-end">{{ $case->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Debtor NRIC</th>
                                <td class="text-end">{{ $case->nric }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Debtor Company Name</th>
                                <td class="text-end">{{ $case->company_name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Debtor Company UEN</th>
                                <td class="text-end">{{ $case->company_uen }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Debtor Phone</th>
                                <td class="text-end">{{ $case->phone }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Debtor Email</th>
                                <td class="text-end">{{ $case->email }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Debtor Address</th>
                                <td class="text-end">{{ $case->adderss }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Debt Amount</th>
                                <td class="text-end">$ {{ number_format($case->debt_amount, 2, '.', ',') }} </td>
                            </tr>
                            <tr>
                                <th scope="row">Legal Cost</th>
                                <td class="text-end">$ {{ number_format($case->legal_cost, 2, '.', ',') }} </td>
                            </tr>
                            <tr>
                                <th scope="row">Debt Interest</th>
                                <td class="text-end">{{ $case->debt_interest }} %</td>
                            </tr>
                            <tr>
                                <th scope="row">Interest Start Date</th>
                                <td class="text-end">{{ date('d-m-Y', strtotime($case->interest_start_date)) }}</td>
                            </tr>
                            {{-- <tr>
                                <th scope="row">Interest End Date</th>
                                <td class="text-end">{{ date('d-m-Y', strtotime($case->interest_start_date)) }}</td>
                            </tr> --}}
                            <tr>
                                <th scope="row">Total Interest</th>

                                <td class="text-end">$ {{ number_format($case->total_amount_owed - ($case->debt_amount + $case->legal_cost), 2, '.', ',') }} </td>
                            </tr>
                            <tr>
                                <th scope="row">Total Amount Owed</th>
                                <td class="text-end">$ {{ number_format($case->total_amount_owed, 2, '.', ',') }} </td>
                            </tr>
                            <tr>
                                <th scope="row">Total Amount Balance</th>
                                <td class="text-end">$ {{ totalBalance($case->id) }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection

@push('style')
    <style>
        .bill{
            margin-right: 6px;
        }
        .fa-sticky-note, .fa-folder-open, .fa-folder{
            font-size: 30px;
        }
        .fa-times{
            font-size: 25px;
            background: #fff;
            padding-top: 2px;
            padding-bottom: 2px;
            padding-left: 4px;
            padding-right: 4px;
            color: #626ed4
        }
    </style>
@endpush
