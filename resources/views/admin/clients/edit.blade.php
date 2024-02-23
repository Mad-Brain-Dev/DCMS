@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h4 class="card-title mb-3">{{ get_page_meta('title', true) }}</h4>
            <form action="{{ route('admin.clients.update', $client->id) }}" method="post">
                @csrf
                @method('PUT')
               <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <label class="form-label">Client Name <span class="error">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Client Name"
                                value="{{ $client->name }}">
                            @error('name')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="form-label">Client NRIC</label>
                            <input type="text" name="nric" class="form-control" placeholder="Enter Client NRIC"
                                value="{{ $client->nric }}">
                            @error('nric')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-3">
                            <label class="form-label">Company name</label>
                            <input type="text" name="company_name" class="form-control"
                                placeholder="Enter Client Company Name" value="{{ $client->company_name }}">
                            @error('company_name')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-3">
                            <label class="form-label">Company UEN</label>
                            <input type="text" name="company_uen" class="form-control" placeholder="Enter Client Company Uen"
                                value="{{ $client->company_uen }}">
                            @error('company_uen')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
               </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Phone <span class="error">*</span></label>
                                <input type="text" name="phone" class="form-control" placeholder="Enter Client Phone Number"
                                    value="{{ $client->phone }}">
                                @error('phone')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Address <span class="error">*</span></label>
                                <input type="text" name="address" class="form-control" placeholder="Enter Address Here"
                                    value="{{ $client->address }}">
                                @error('address')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Date of Agreement</label>
                                <input type="date" name="date_of_agreement" class="form-control" placeholder="Address"
                                    value="{{ date('Y-m-d', strtotime($client->date_of_agreement)) }}">
                                @error('date_of_agreement')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="mb-3 col-md-3">
                                <label class="form-label">Date of Expiry</label>
                                <input type="date" name="date_of_expiry" class="form-control" placeholder="Address"
                                    value="{{ date('Y-m-d', strtotime($client->date_of_expiry)) }}">
                                @error('date_of_expiry')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Admin Fee</label>
                                <input type="number" name="admin_fee" class="form-control" placeholder="Enter Admin Fee"
                                    value="{{ $client->admin_fee }}">
                                @error('admin_fee')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Admin Fee Paid</label>
                                <input type="number" name="admin_fee_paid" class="form-control"
                                    placeholder="Enter Admin Fee Paid Amount" value="{{ $client->admin_fee_paid }}">
                                @error('admin_fee_paid')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Admin Fee Balance</label>
                                <input type="number" name="admin_fee_balance" class="form-control"
                                    placeholder="Enter Admin Fee Balance Amount" value="{{ $client->admin_fee_balance }}">
                                @error('admin_fee_balance')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Collection Commission</label>
                                <input type="number" name="collection_commission" class="form-control"
                                    placeholder="Enter Collection Commission" value="{{ $client->collection_commission }}">
                                @error('collection_commission')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Field Visit Per Case</label>
                                <input type="text" name="field_visit_per_case" class="form-control"
                                    placeholder="Field Visit Per Case" value="{{ $client->field_visit_per_case }}">
                                @error('field_visit_per_case')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 offset-md-6 col-md-6">
                        <div class="text-end">
                            <button class="btn btn-primary waves-effect waves-lightml-2 me-2" type="submit">
                                <i class="fa fa-save"></i> Save
                            </button>

                            <a class="btn btn-secondary waves-effect" href="{{ route('admin.clients.index') }}">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('/admin/js/passwordCheck.js') }}"></script>
@endpush
