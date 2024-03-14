@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12 text-end">
            {{-- <button class="btn btn-dark" data-toggle="modal" data-target="#exampleModal">Update Admin Fee</button> --}}
            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModal">
                Update Admin Fee
            </button>
        </div>
        <div class="col-md-12">
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
                                        <th scope="row">Collection Commission</th>
                                        <td>{{ $client->collection_commission }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Field Visit Per Case</th>
                                        <td>{{ $client->field_visit_per_case }}</td>
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
                                        <td>{{ $client->admin_fee_balance }}</td>
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
                                        <th scope="row">Client Name</th>
                                        <td>{{ $case->client->name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Date of Warrant</th>
                                        <td>{{date('d-m-Y', strtotime($case->date_of_warrant))}}</td>
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
                                        <td>{{ date('d-m-Y', strtotime($case->interest_start_date))}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Interest End Date</th>
                                        <td>{{ date('d-m-Y', strtotime($case->interest_start_date))}}</td>
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
                                        <th scope="row">Total Amount Balance</th>
                                        <td>{{ $case->total_amount_balance }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Enforcement Fee</th>
                                        <td>{{ $case->enforcement_fee }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Professional Fee</th>
                                        <td>{{ $case->professional_fee }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Annual Fee</th>
                                        <td>{{ $case->annual_fee }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Skip Tracing Fee</th>
                                        <td>{{ $case->skip_tracing_fee }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Overseas allowance</th>
                                        <td>{{ $case->overseas_allowance }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
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
                          <input type="number" class="form-control" name="admin_fee" id="num1" aria-describedby="emailHelp" value="{{ $client->admin_fee }}">
                        </div>
                        <div class="form-group mt-2">
                          <label for="num2">Admin Fee Paid</label>
                          <input type="number" class="form-control" name="admin_fee_paid" id="num2" value="{{ $client->admin_fee_paid }}">
                        </div>
                        <div class="form-group mt-2">
                            <label for="subt">Admin Fee Balance</label>
                            <input type="number" class="form-control" name="admin_fee_balance" id="subt" value="{{ $client->admin_fee_balance }}">
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
$( document ).ready(function() {
    $(function() {
    $("#num2").on("keydown keyup", sum);
	function sum() {
	$("#subt").val(Number($("#num1").val()) - Number($("#num2").val()));
	}
});
});
</script>
@endpush
