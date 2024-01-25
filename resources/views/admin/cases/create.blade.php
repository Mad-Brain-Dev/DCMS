@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">{{ get_page_meta('title', true) }}</h4>

                    <form action="{{ route('admin.cases.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Select Name <span class="error">*</span></label>
                                {{-- <input type="hidden" name="practicioner_id" value="{{ $practicioner_id }}"> --}}
                                <select class="form-control" data-placeholder="Choose ..." id="debtor" name="debtor_id">
                                    <option value="" disabled selected class="text-capitalize">
                                        Select Debtor
                                    </option>
                                    @foreach ($debtors as $debtor)
                                        <option value="{{ $debtor->id }}" class="text-capitalize">
                                            {{ $debtor->first_name }} {{ $debtor->last_name }}</option>
                                    @endforeach
                                </select>
                                @error('debtor')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Amount Owed <span class="error">*</span></label>
                                <input type="text" name="amount_owed" class="form-control" placeholder="Amount Owed"
                                    value="{{ old('amount_owed') }}">
                                @error('amount_owed')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="mb-3 col-md-6">
                                <label class="form-label">Case Type <span class="error">*</span></label>
                                <select class="form-select" name="case_type" aria-label="Default select example"
                                    id="case_type">
                                    <option selected disabled>Select One</option>
                                    <option class="text-capitalize"
                                        value="{{ App\Models\Cases::CASE_TYPE_OUTSTANDING_LOAN }}">
                                        {{ App\Models\Cases::CASE_TYPE_OUTSTANDING_LOAN }}</option>

                                    <option class="text-capitalize" value="{{ App\Models\Cases::CASE_TYPE_UNPAID_BILLS }}">
                                        {{ App\Models\Cases::CASE_TYPE_UNPAID_BILLS }}</option>

                                </select>
                                @error('user_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div class="mb-3 col-md-6">
                                <label class="form-label">Case Status <span class="error">*</span></label>
                                <select class="form-select" name="case_status" aria-label="Default select example"
                                    id="case_type">
                                    <option selected disabled>Select One</option>
                                    <option class="text-capitalize" value="{{ App\Models\Cases::CASE_STATUS_OPEN }}">
                                        {{ App\Models\Cases::CASE_STATUS_OPEN }}</option>

                                    <option class="text-capitalize" value="{{ App\Models\Cases::CASE_STATUS_CLOSED }}">
                                        {{ App\Models\Cases::CASE_STATUS_CLOSED }}</option>

                                    <option class="text-capitalize"
                                        value="{{ App\Models\Cases::CASE_STATUS_IN_PROGRESS }}">
                                        {{ App\Models\Cases::CASE_STATUS_IN_PROGRESS }}</option>

                                    <option class="text-capitalize" value="{{ App\Models\Cases::CASE_STATUS_RESOLVED }}">
                                        {{ App\Models\Cases::CASE_STATUS_RESOLVED }}</option>
                                </select>
                                @error('case_status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Case Priority <span class="error">*</span></label>
                                <select class="form-select" name="case_priority" aria-label="Default select example"
                                    id="case_type">
                                    <option selected disabled>Select One</option>
                                    <option class="text-capitalize" value="{{ App\Models\Cases::CASE_PRIORITY_HIGH }}">
                                        {{ App\Models\Cases::CASE_PRIORITY_HIGH }}</option>

                                    <option class="text-capitalize" value="{{ App\Models\Cases::CASE_PRIORITY_MEDIUM }}">
                                        {{ App\Models\Cases::CASE_PRIORITY_MEDIUM }}</option>

                                    <option class="text-capitalize"
                                        value="{{ App\Models\Cases::CASE_PRIORITY_LOW }}">
                                        {{ App\Models\Cases::CASE_PRIORITY_LOW }}</option>
                                </select>
                                @error('case_priority')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Due Date <span class="error">*</span></label>
                                <input type="date" name="due_date" class="form-control" placeholder="Due Date"
                                    value="{{ old('due_date') }}">
                                @error('due_date')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>



                            <div class="col-md-4">
                            </div>
                            <div class="row">
                                <div class="mb-3 offset-md-6 col-md-6">
                                    <div class="text-end">
                                        <button class="btn btn-primary waves-effect waves-lightml-2 me-2" type="submit">
                                            <i class="fa fa-save"></i> Save
                                        </button>

                                        <a class="btn btn-secondary waves-effect"
                                            href="{{ route('admin.clients.index') }}">
                                            <i class="fa fa-times"></i> Cancel
                                        </a>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
