@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12 text-end">
            {{-- <button class="btn btn-dark" data-toggle="modal" data-target="#exampleModal">Update Admin Fee</button> --}}
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">
                Update Admin Fee
            </button>
        </div>
    </div>
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <tbody>
                        <tr class="table-primary">
                            <th scope="row">Name</th>
                            <td class="text-end">{{ $client->name }}</td>
                        </tr>
                        <tr class="table-success">
                            <th scope="row">NRIC</th>
                            <td class="text-end">{{ $client->nric }}</td>
                        </tr>
                        <tr class="table-info">
                            <th scope="row">Company Name</th>
                            <td class="text-end">{{ $client->company_name }}</td>
                        </tr>
                        <tr class="table-warning">
                            <th scope="row">Company Uen</th>
                            <td class="text-end">{{ $client->company_uen }}</td>
                        </tr>
                        <tr class="table-danger">
                            <th scope="row">Phone</th>
                            <td class="text-end">{{ $client->phone }}</td>
                        </tr>
                        <tr class="table-light">
                            <th scope="row">Email</th>
                            <td class="text-end">{{ $client->email }}</td>
                        </tr>
                        <tr class="table-primary">
                            <th scope="row">Address</th>
                            <td class="text-end">{{ $client->address }}</td>
                        </tr>

                        <tr class="table-success">
                            <th scope="row">Field Visit Per Case</th>
                            <td class="text-end">{{ $client->field_visit_per_case }}</td>
                        </tr>

                        <tr class="table-info">
                            <th scope="row">Date of Agreement</th>
                            <td class="text-end">{{ date('d-m-Y', strtotime($client->date_of_agreement)) }}</td>
                        </tr>
                        <tr class="table-danger">
                            <th scope="row">Date of Expiry</th>
                            <td class="text-end">{{ date('d-m-Y', strtotime($client->date_of_expiry)) }}</td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table">
                    <tbody>

                        <tr class="table-primary">
                            <th scope="row">Collection Commission</th>
                            <td class="text-end">{{ $client->collection_commission }} %</td>
                        </tr>
                        <tr class="table-success">
                            <th scope="row">Administrative Fee</th>
                            <td class="text-end">{{number_format($client->administrative_fee  ? $client->administrative_fee : 0, 2, '.', ',') }} $</td>
                        </tr>
                        <tr class="table-info">
                            <th scope="row">Enforcement Fee</th>
                            <td class="text-end">{{number_format($client->enforcement_fee ? $client->enforcement_fee : 0, 2, '.', ',') }} $</td>
                        </tr>
                        <tr class="table-warning">
                            <th scope="row">Professional Fee</th>
                            <td class="text-end">{{number_format($client->professional_fee ? $client->professional_fee : 0, 2, '.', ',') }} $</td>
                        </tr>
                        <tr class="table-danger">
                            <th scope="row">Annual Fee</th>
                            <td class="text-end">{{ number_format($client->annual_fee ? $client->annual_fee : 0, 2, '.', ',') }} $</td>
                        </tr>
                        <tr class="table-light">
                            <th scope="row">Skip Tracing Fee</th>
                            <td class="text-end"> {{ number_format($client->skip_tracing_fee ? $client->skip_tracing_fee : 0, 2, '.', ',') }} $</td>
                        </tr>
                        <tr class="table-primary">
                            <th scope="row">Overseas Allowance</th>
                            <td class="text-end">{{ number_format($client->overseas_allowance ? $client->overseas_allowance : 0, 2, '.', ',') }} $</td>
                        </tr>
                        <tr class="table-success">
                            <th scope="row">Admin Fee</th>
                            <td class="text-end">{{ number_format($client->admin_fee, 2, '.', ',') }} $</td>
                        </tr>
                        <tr class="table-info">
                            <th scope="row">Admin Fee Paid</th>
                            <td class="text-end">{{ number_format($client->admin_fee_paid, 2, '.', ',') }} $</td>
                        </tr>
                        <tr class="table-danger">
                            <th scope="row">Admin Fee Balance</th>
                            <td class="text-end">{{ number_format($client->admin_fee_balance, 2, '.', ',') }} $</td>
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
                                        <td class="text-end">{{ $case->case_number }}</td>
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
                                        <td class="text-end">{{ number_format($case->debt_amount, 2, '.', ',') }} $</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Legal Cost</th>
                                        <td class="text-end"> {{ number_format($case->legal_cost, 2, '.', ',') }} $</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Debt Interest</th>
                                        <td class="text-end">{{ $case->debt_interest }} %</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Interest Start Date</th>
                                        <td class="text-end">{{ date('d-m-Y', strtotime($case->interest_start_date)) }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Interest End Date</th>
                                        <td class="text-end">{{ date('d-m-Y', strtotime($case->interest_start_date)) }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Total Interest</th>
                                        <td class="text-end">{{ number_format($case->total_interest, 2, '.', ',') }} $</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Total Amount Owed</th>
                                        <td class="text-end">{{ number_format($case->total_amount_owed, 2, '.', ',') }} $</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Total Amount Balance</th>
                                        <td class="text-end">{{ number_format($case->total_amount_balance, 2, '.', ',') }} $</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Admin Fee</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.fee.update', $client->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="num1">Admin Fee</label>
                            <input type="number" class="form-control" name="admin_fee" id="num1"
                                aria-describedby="emailHelp" value="{{ $client->admin_fee }}">
                        </div>
                        <div class="form-group mt-2">
                            <label for="num2">Admin Fee Paid</label>
                            <input type="number" class="form-control" name="admin_fee_paid" id="num2"
                                value="{{ $client->admin_fee_paid }}">
                        </div>
                        <div class="form-group mt-2">
                            <label for="subt">Admin Fee Balance</label>
                            <input type="number" class="form-control" name="admin_fee_balance" id="subt"
                                value="{{ $client->admin_fee_balance }}">
                        </div>
                        <button type="submit" class="btn btn-success mt-2">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('/admin/js/passwordCheck.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            $(function() {
                $("#num2").on("keydown keyup", sum);

                function sum() {
                    $("#subt").val(Number($("#num1").val()) - Number($("#num2").val()));
                }
            });
        });
    </script>
@endpush
