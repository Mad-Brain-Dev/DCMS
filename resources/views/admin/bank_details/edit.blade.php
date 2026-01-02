@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">{{get_page_meta('title', true)}}</h4>

                    <form action="{{ route('admin.bank-details.update', $detail->tenant_id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Account Name <span class="error">*</span></label>
                                <input type="text" name="account_name" class="form-control" required=""
                                    placeholder="Account Name" value="{{ $detail->account_name }}">
                                @error('account_name')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Bank Name <span class="error">*</span></label>
                                <input type="text" name="bank_name" class="form-control" required=""
                                    placeholder="Bank Name" value="{{ $detail->bank_name }}">
                                @error('bank_name')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Account Number <span class="error">*</span></label>
                                <input type="text" name="account_number" class="form-control" required="" placeholder="Account Number"
                                    value="{{ $detail->account_number }}">
                                @error('account_number')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Bank Code <span class="error">*</span></label>
                                <input type="text" name="bank_code" class="form-control" required="" placeholder="Bank Code"
                                    value="{{ $detail->bank_code }}">
                                @error('bank_code')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Branch Code <span class="error">*</span></label>
                                <input type="text" name="branch_code" class="form-control" required="" placeholder="Branch Code"
                                    value="{{ $detail->branch_code }}">
                                @error('branch_code')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Bank Address <span class="error">*</span></label>
                                <input type="text" name="bank_address" class="form-control" required="" placeholder="Bank Address"
                                    value="{{ $detail->bank_address }}">
                                @error('bank_address')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Swift Code <span class="error">*</span></label>
                                <input type="text" name="swift_code" class="form-control" required="" placeholder="Swift Code"
                                    value="{{ $detail->swift_code }}">
                                @error('swift_code')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Payment Methods <span class="error">*</span></label>
                                <input type="text" name="payment_methods" class="form-control" required="" placeholder="Payment Methods"
                                    value="{{ $detail->payment_methods }}">
                                @error('payment_methods')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label class="form-label">Payment Terms <span class="error">*</span></label>
                                <input type="text" name="payment_terms" class="form-control" required="" placeholder="Payment Terms"
                                    value="{{ $detail->payment_terms }}">
                                @error('payment_terms')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 offset-md-6 col-md-6">
                                <div class="text-end">
                                    <button class="btn btn-primary waves-effect waves-lightml-2 me-2" type="submit">
                                        <i class="fa fa-save"></i> Save
                                    </button>

{{--                                    <a class="btn btn-secondary waves-effect" href="{{ route('admin.users.index') }}">--}}
{{--                                        <i class="fa fa-times"></i> Cancel--}}
{{--                                    </a>--}}
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('script')
@endpush

