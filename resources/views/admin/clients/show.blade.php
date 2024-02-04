@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Name</h5>
                            <p>{{$client->name}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Nric</h5>
                            <p>{{$client->nric}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Company Name</h5>
                            <p>{{$client->company_name}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Company Uen</h5>
                            <p>{{$client->company_uen}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Phone</h5>
                            <p>{{$client->phone}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Email</h5>
                            <p>{{$client->email}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Address</h5>
                            <p>{{$client->address}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Date of agreement</h5>
                            <p>{{date('d-m-Y', strtotime($client->date_of_agreement))}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Date of expiry</h5>
                            <p>{{date('d-m-Y', strtotime($client->date_of_expiry))}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Admin Fee</h5>
                            <p>{{$client->admin_fee}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Admin Fee Paid</h5>
                            <p>{{$client->admin_fee_paid}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Admin Fee Balance</h5>
                            <p>{{$client->admin_fee_balance}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Collection Commission</h5>
                            <p>{{$client->collection_commission}}</p>
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

            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('/admin/js/passwordCheck.js') }}"></script>
@endpush
