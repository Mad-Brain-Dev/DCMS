@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">{{ get_page_meta('title', true) }}</h4>
                    <form action="{{ route('admin.cases.update', $case->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Case Number <span class="error">*</span></label>
                                <input type="text" name="case_number" class="form-control"
                                    placeholder="Enter Case Number" value="{{ $case->case_number }}">
                                @error('case_number')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="mb-3 col-md-3">
                                <label class="form-label">Case Status <span class="error">*</span></label>
                                <select class="form-select select2" id="case_status" name="current_status"
                                    aria-label="Default select example">
                                    <option selected disabled>Select Case Status</option>
                                    <option value="{{ \App\Utils\GlobalConstant::CASE_PENDING }}">
                                        {{ \App\Utils\GlobalConstant::CASE_PENDING }}</option>
                                    <option value="{{ \App\Utils\GlobalConstant::CASE_OPEN }}">
                                        {{ \App\Utils\GlobalConstant::CASE_OPEN }}</option>
                                    <option value="{{ \App\Utils\GlobalConstant::CASE_FIELD }}">
                                        {{ \App\Utils\GlobalConstant::CASE_FIELD }}</option>
                                    <option value="{{ \App\Utils\GlobalConstant::CASE_DESPATCHED }}">
                                        {{ \App\Utils\GlobalConstant::CASE_DESPATCHED }}</option>
                                    <option value="{{ \App\Utils\GlobalConstant::CASE_INVESTIGATION_NEEDED }}">
                                        {{ \App\Utils\GlobalConstant::CASE_INVESTIGATION_NEEDED }}</option>
                                    <option value="{{ \App\Utils\GlobalConstant::CASE_NEGOTIATING_WITH_DB }}">
                                        {{ \App\Utils\GlobalConstant::CASE_NEGOTIATING_WITH_DB }}</option>
                                    <option value="{{ \App\Utils\GlobalConstant::CASE_UNDER_INSTALMENT }}">
                                        {{ \App\Utils\GlobalConstant::CASE_UNDER_INSTALMENT }}</option>
                                    <option value="{{ \App\Utils\GlobalConstant::CASE_FULLY_SETTELED }}">
                                        {{ \App\Utils\GlobalConstant::CASE_FULLY_SETTELED }}</option>
                                    <option value="{{ \App\Utils\GlobalConstant::CASE_PARTIALLY_SETTELED }}">
                                        {{ \App\Utils\GlobalConstant::CASE_PARTIALLY_SETTELED }}</option>
                                    <option value="{{ \App\Utils\GlobalConstant::CASE_CASE_ON_HOLD_BY_CLIENT }}">
                                        {{ \App\Utils\GlobalConstant::CASE_CASE_ON_HOLD_BY_CLIENT }}</option>
                                    <option value="{{ \App\Utils\GlobalConstant::CASE_ON_HOLD_BY_MANAGEMENT }}">
                                        {{ \App\Utils\GlobalConstant::CASE_ON_HOLD_BY_MANAGEMENT }}</option>
                                    <option value="{{ \App\Utils\GlobalConstant::CASE_CLOSED_WITHOUT_PAYMENT }}">
                                        {{ \App\Utils\GlobalConstant::CASE_CLOSED_WITHOUT_PAYMENT }}</option>
                                    <option value="{{ \App\Utils\GlobalConstant::CASE_AWAITING_UPDATE_FR_CLIENT }}">
                                        {{ \App\Utils\GlobalConstant::CASE_AWAITING_UPDATE_FR_CLIENT }}</option>
                                    <option value="{{ \App\Utils\GlobalConstant::CASE_UNDER_LITIGATION }}">
                                        {{ \App\Utils\GlobalConstant::CASE_UNDER_LITIGATION }}</option>
                                </select>
                                @error('current_status')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Date of Agreement <span class="error">*</span></label>
                                <input type="date" name="date_of_agreement" class="form-control"
                                    value="{{ date('Y-m-d', strtotime($case->date_of_agreement)) }}">
                                @error('date_of_agreement')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Date of Eexpiry <span class="error">*</span></label>
                                <input type="date" name="date_of_expiry" class="form-control"
                                    value="{{ date('Y-m-d', strtotime($case->date_of_expiry)) }}">
                                @error('date_of_expiry')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Collection Commission <span class="error">*</span></label>
                                <input type="text" name="collection_commission" class="form-control"
                                    value="{{ $case->collection_commission }}">
                                @error('collection_commission')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Field Visits <span class="error">*</span></label>
                                <input type="text" name="field_visit" class="form-control"
                                    value="{{ $case->field_visit }}">
                                @error('field_visit')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Bal Field Visits <span class="error">*</span></label>
                                <input type="text" name="bal_field_visit" class="form-control"
                                    value="{{ $case->bal_field_visit }}">
                                @error('bal_field_visit')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Manager IC <span class="error">*</span></label>
                                <input type="text" name="manager_ic" class="form-control"
                                    value="{{ $case->manager_ic }}">
                                @error('manager_ic')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Collector IC <span class="error">*</span></label>
                                <input type="text" name="collector_ic" class="form-control"
                                    value="{{ $case->collector_ic }}">
                                @error('collector_ic')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Debtor Name <span class="error">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ $case->name }}">
                                @error('name')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Debtor NRIC</label>
                                <input type="text" name="nric" class="form-control" value="{{ $case->nric }}">
                                @error('nric')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Debtor Company Name</label>
                                <input type="text" name="company_name" class="form-control"
                                    value="{{ $case->nric }}">
                                @error('company_name')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Debtor Company UEN</label>
                                <input type="text" name="company_uen" class="form-control"
                                    value="{{ $case->company_uen }}">
                                @error('company_uen')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Debtor Contact Number <span class="error">*</span></label>
                                <input type="text" name="phone" class="form-control" value="{{ $case->phone }}">
                                @error('phone')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="mb-3 col-md-3">
                                <label class="form-label">Debtor Email <span class="error">*</span></label>
                                <input type="email" name="email" class="form-control" value="{{ $case->email }}">
                                @error('email')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Phone <span class="error">*</span></label>
                                <input type="text" name="phone" class="form-control" value="{{ $case->phone }}">
                                @error('phone')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Debtor Address <span class="error">*</span></label>
                                <input type="text" name="adderss" class="form-control" value="{{ $case->adderss }}">
                                @error('adderss')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Debt Amount <span class="error">*</span></label>
                                <input type="number" name="debt_amount" class="form-control"
                                    value="{{ $case->debt_amount }}">
                                @error('debt_amount')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Legal Cost <span class="error">*</span></label>
                                <input type="number" name="legal_cost" class="form-control"
                                    value="{{ $case->legal_cost }}">
                                @error('legal_cost')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Debt Interest/Annum <span class="error">*</span></label>
                                <input type="number" name="debt_interest" class="form-control"
                                    value="{{ $case->debt_interest }}">
                                @error('debt_interest')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Interest Start Date <span class="error">*</span></label>
                                <input type="date" name="interest_start_date" class="form-control"
                                    value="{{ date('Y-m-d', strtotime($case->interest_start_date)) }}">
                                @error('interest_start_date')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Interest End Date <span class="error">*</span></label>
                                <input type="date" name="interest_end_date" class="form-control"
                                    value="{{ date('Y-m-d', strtotime($case->interest_start_date)) }}">
                                @error('interest_end_date')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Total Amount Owed <span class="error">*</span></label>
                                <input type="number" name="total_amount_owed" class="form-control"
                                    value="{{ $case->total_amount_owed }}">
                                @error('total_amount_owed')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Total Interest <span class="error">*</span></label>
                                <input type="number" name="total_interest" class="form-control"
                                    value="{{ $case->total_interest }}">
                                @error('total_interest')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Total Amount Paid <span class="error">*</span></label>
                                <input type="Number" name="total_amount_paid" class="form-control"
                                    value="{{ $case->total_amount_paid }}">
                                @error('total_amount_paid')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Total Amount Balance <span class="error">*</span></label>
                                <input type="Number" name="total_amount_balance" class="form-control"
                                    value="{{ $case->total_amount_balance }}">
                                @error('total_amount_balance')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="mb-3 offset-md-6 col-md-6">
                                    <div class="text-end">
                                        <button class="btn btn-primary waves-effect waves-lightml-2 me-2" type="submit">
                                            <i class="fa fa-save"></i> Save
                                        </button>
                                        <a class="btn btn-secondary waves-effect"
                                            href="{{ route('admin.cases.index') }}">
                                            <i class="fa fa-times"></i> Cancel
                                        </a>
                                    </div>
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
    <script src="{{ asset('/admin/js/passwordCheck.js') }}"></script>
@endpush
@push('style')
@endpush
