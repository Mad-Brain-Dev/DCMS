@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center">
                    Case
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
        <div class="col-md-4">
            <div id="success" class="text-success"></div>
            <div class="card">
                <div class="card-header text-center">Updates Upload</div>
                <div class="card-body">
                    <form enctype="multipart/form-data" action="{{ route('create.case.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">
                        <div class="mb-3">
                            <label class="form-label">GN Case Update</label>
                            <input type="file" name="gn_update" class="form-control">
                            @error('gn_update')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">CR Update</label>
                            <input type="file" name="cr_update" class="form-control">
                            @error('cr_update')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">FV Update</label>
                            <input type="file" name="fv_update" class="form-control">
                            @error('fv_update')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">MS Update </label>
                            <input type="file" name="ms_update" class="form-control">
                            @error('ms_update')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">

                        <div class="row">
                            <div class="mb-3">
                                <div class="text-end">
                                    <button class="btn btn-primary waves-effect waves-lightml-2 me-2" type="submit">
                                        <i class="fa fa-save"></i> Save
                                    </button>
                                    <a class="btn btn-secondary waves-effect" href="{{ route('admin.cases.index') }}">
                                        <i class="fa fa-times"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center">Documents</div>
                <div class="card-body">
                    @foreach ($gr_updates as $gr_update)
                        <iframe src="{{ asset('storage/document/' . $gr_update->gr_update) }}"></iframe>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('/admin/js/passwordCheck.js') }}"></script>
@endpush
@push('style')
    <style>
        .timeline {
            border-left: 1px solid #353535;
            border-bottom-right-radius: 4px;
            border-top-right-radius: 4px;
            background: rgba(108, 108, 108, 0.09);
            margin: 0 auto;
            letter-spacing: 0.2px;
            position: relative;
            line-height: 1.4em;
            font-size: 1.03em;
            padding: 50px;
            list-style: none;
            text-align: left;
            max-width: 40%;
        }

        .btn-color {
            background-color: #F66B0E;
            outline: none;
            border: 0
        }

        .btn-color:hover {
            background-color: #F66B0E;
            outline: none;
            border: 0
        }

        @media (max-width: 767px) {
            .timeline {
                max-width: 98%;
                padding: 25px;
            }
        }

        .timeline h1 {
            font-weight: 300;
            font-size: 1.4em;
        }

        .timeline h2,
        .timeline h3 {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .timeline .event {
            border-bottom: 1px dashed #e8ebf1;
            padding-bottom: 25px;
            margin-bottom: 25px;
            position: relative;
        }

        @media (max-width: 767px) {
            .timeline .event {
                padding-top: 30px;
            }
        }

        .timeline .event:last-of-type {
            padding-bottom: 0;
            margin-bottom: 0;
            border: none;
        }

        .timeline .event:before,
        .timeline .event:after {
            position: absolute;
            display: block;
            top: 0;
        }

        .timeline .event:before {
            left: -207px;
            content: attr(data-date);
            text-align: right;
            font-weight: 100;
            font-size: 0.9em;
            min-width: 120px;
        }

        @media (max-width: 767px) {
            .timeline .event:before {
                left: 0px;
                text-align: left;
            }
        }

        .timeline .event:after {
            -webkit-box-shadow: 0 0 0 3px #e2e2e2;
            box-shadow: 0 0 0 3px #e2e2e2;
            left: -55.8px;
            background: #fff;
            border-radius: 50%;
            height: 9px;
            width: 9px;
            content: "";
            top: 5px;
        }

        @media (max-width: 767px) {
            .timeline .event:after {
                left: -31.8px;
            }
        }

        .rtl .timeline {
            border-left: 0;
            text-align: right;
            border-bottom-right-radius: 0;
            border-top-right-radius: 0;
            border-bottom-left-radius: 4px;
            border-top-left-radius: 4px;
            border-right: 3px solid #727cf5;
        }

        .rtl .timeline .event::before {
            left: 0;
            right: -170px;
        }

        .rtl .timeline .event::after {
            left: 0;
            right: -55.8px;
        }
    </style>
@endpush
