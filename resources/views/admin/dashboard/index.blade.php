@extends('layouts.master')


@section('content')
    <div class="row">
        <div class="col-md-4 mb-2">
            {{-- @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif --}}
            <form action="{{ route('search.for.client') }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="search" id="search_client" required name="client_search" class="form-control"
                        placeholder="Enter Client Name" aria-describedby="basic-addon1">
                    <button type="submit" class="input-group-text"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
        <div class="col-md-4  mb-2">
            <form action="{{ route('search.for.case') }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="search" id="search_case" required name="case_search" class="form-control"
                        placeholder="Enter Case Number">
                    <button type="submit" class="input-group-text"><i class="fa fa-search"></i></button>
                </div>
            </form>

        </div>
        <div class="col-md-4 mb-3 text-end">
            <a class="btn btn-primary" href="{{ route('admin.clients.create') }}">Create Client</a>
            <a class="btn btn-primary" href="{{ route('admin.cases.create') }}">Create Case</a>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg-primary text-white">
                <div class="card-body">
                    <div class="">
                        <div class="float-start mini-stat-img total_case">
                            <i class="fas fa-layer-group"></i>
                        </div>
                        <h5 class="font-size-16 text-uppercase text-white-50">Total Cases</h5>
                        <h4 class="fw-medium font-size-24">{{ $case_number }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg-primary text-white">
                <div class="card-body">
                    <div class="">
                        <div class="float-start bill">
                            <i class="fas fa-money-check-alt"></i>
                        </div>
                        <h5 class="font-size-16 text-uppercase text-white-50">Total Amount Owed</h5>
                        <h4 class="fw-medium font-size-24"> {{ $total_amount_owed }} $</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg-primary text-white">
                <div class="card-body">
                    <div class="">
                        <div class="float-start bill">
                            <i class="fas fa-money-check"></i>
                        </div>
                        <h5 class="font-size-16 text-uppercase text-white-50">Paid Amount</h5>
                        <h4 class="fw-medium font-size-24"> {{ $total_amount_paid }} $</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card mini-stat bg-primary text-white">
                <div class="card-body">
                    <div class="">
                        <div class="float-start bill">
                            <i class="fas fa-money-bill"></i>
                        </div>
                        <h5 class="font-size-16 text-uppercase text-white-50">Bal Amount</h5>
                        <h4 class="fw-medium font-size-24"> {{ $total_amount_balance }} $</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="">
                <table class="table">
                    {{-- <thead>
                    <tr>
                        <th>#</th>
                        <th>Bill</th>
                        <th>Payment Date</th>
                        <th>Payment Status</th>
                    </tr>
                </thead> --}}
                    <tbody>
                        <tr class="table-primary">
                            <td>PDG</td>
                            <td class="text-end">{{ $pdg_case_status }}</td>
                        </tr>
                        <tr class="table-success">
                            <td>OPN</td>
                            <td class="text-end">{{ $opn_case_status }}</td>
                        </tr>
                        <tr class="table-info">
                            <td>FLD</td>
                            <td class="text-end">{{ $fld_case_status }}</td>
                        </tr>
                        <tr class="table-warning">
                            <td>DSP</td>
                            <td class="text-end">{{ $fld_case_status }}</td>
                        </tr>
                        <tr class="table-danger">
                            <td>INV</td>
                            <td class="text-end">{{ $inv_case_status }}</td>
                        </tr>
                        <tr class="table-light">
                            <td>NGD</td>
                            <td class="text-end">{{ $ngd_case_status }}</td>
                        </tr>
                        <tr class="table-primary">
                            <td>INS</td>
                            <td class="text-end">{{ $ins_case_status }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="">
                <table class="table">
                    {{-- <thead>
                    <tr>
                        <th>#</th>
                        <th>Bill</th>
                        <th>Payment Date</th>
                        <th>Payment Status</th>
                    </tr>
                </thead> --}}
                    <tbody>
                        <tr class="table-primary">
                            <td>FST</td>
                            <td class="text-end">{{ $fst_case_status }}</td>
                        </tr>
                        <tr class="table-success">
                            <td>PST</td>
                            <td class="text-end">{{ $pst_case_status }}</td>
                        </tr>
                        <tr class="table-info">
                            <td>OHC</td>
                            <td class="text-end">{{ $ohc_case_status }}</td>
                        </tr>
                        <tr class="table-warning">
                            <td>OHM</td>
                            <td class="text-end">{{ $ohm_case_status }}</td>
                        </tr>
                        <tr class="table-danger">
                            <td>CST</td>
                            <td class="text-end">{{ $cst_case_status }}</td>
                        </tr>
                        <tr class="table-light">
                            <td>AFC</td>
                            <td class="text-end">{{ $afc_case_status }}</td>
                        </tr>
                        <tr class="table-primary">
                            <td>ULT</td>
                            <td class="text-end">{{ $ult_case_status }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        var availableTags = [];
        $.ajax({
            url: '/admin/client/search/',
            method: 'GET',
            success: function(response) {
                // Handle successful response
                console.log(response);
                startAutoComplete(response)
            },
            error: function(xhr) {
                // Handle error
                console.log(xhr.responseText);
            }
        });
        function startAutoComplete(availableTags) {
            $("#search_client").autocomplete({
                source: availableTags
            });
        }

        $.ajax({
            url: '/admin/case/search/',
            method: 'GET',
            success: function(response) {
                // Handle successful response
                console.log(response);
                startAutoCompleteTwo(response)
            },
            error: function(xhr) {
                // Handle error
                console.log(xhr.responseText);
            }
        });
        function startAutoCompleteTwo(availableTags) {
            $("#search_case").autocomplete({
                source: availableTags
            });
        }


    </script>
@endpush

@push('style')
    <style>
        .fa-layer-group,
        .fa-money-bill,
        .wallet,
        .fa-money-check,
        .fa-money-check-alt {
            font-size: 30px;
        }

        .total_case,
        .bill,
        .wallet {
            margin-right: 15px;
        }
    </style>
@endpush
