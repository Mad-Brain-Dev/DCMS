@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h4 class="card-title mb-3">{{ get_page_meta('title', true) }}</h4>
            <form action="{{ route('admin.cases.store') }}" method="post">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Case Number <span class="error">*</span></label>
                                <input type="text" name="case_number" class="form-control"
                                    placeholder="Enter Case Number" value="{{ old('case_number') }}">
                                @error('case_number')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">CL Name <span class="error">*</span></label>
                                <select class="form-select select2" id="client_id" name="client_id"
                                    aria-label="Default select example">
                                    <option selected disabled>Select CL Name</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->client_id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                                @error('current_status')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Date of Agreement <span class="error">*</span></label>
                                <input type="date" id="date_of_agreement" name="date_of_agreement" class="form-control"
                                    value=" ">
                                @error('date_of_agreement')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Date of Eexpiry <span class="error">*</span></label>
                                <input type="date" name="date_of_expiry" id="date_of_expiry" class="form-control"
                                    placeholder="Enter Client Company Name" value="{{ old('date_of_expiry') }}">
                                @error('date_of_expiry')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Manager IC <span class="error">*</span></label>
                                <input type="text" name="manager_ic" class="form-control"
                                    placeholder="Enter Manager IC Name" value="{{ old('manager_ic') }}">
                                @error('manager_ic')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Collector IC <span class="error">*</span></label>
                                <input type="text" name="collector_ic" class="form-control"
                                    placeholder="Enter Collector IC Name" value="{{ old('collector_ic') }}">
                                @error('collector_ic')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Case Status <span class="error">*</span></label>
                                <select class="form-select select2" id="current_status" name="current_status"
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
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Collection Commission <span class="error">*</span></label>
                                <input type="text" name="collection_commission" class="form-control"
                                    placeholder="Enter Collection Commission" value="{{ old('collection_commission') }}">
                                @error('collection_commission')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Field Visits <span class="error">*</span></label>
                                <input type="text" name="field_visit" placeholder="Enter Field Visit Number Here" class="form-control" id="field_visit"  value="">
                                @error('field_visit')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Bal Field Visits <span class="error">*</span></label>
                                <input type="text" name="bal_field_visit" class="form-control"
                                    placeholder="Enter Bal Field Visits" value="{{ old('bal_field_visit') }}">
                                @error('bal_field_visit')
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
                                <label class="form-label">DB Name <span class="error">*</span></label>
                                <input type="text" name="name" class="form-control"
                                    placeholder="Enter DB Name" value="{{ old('name') }}">
                                @error('name')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">DB NRIC</label>
                                <input type="text" name="nric" class="form-control"
                                    placeholder="Enter DB NRIC" value="{{ old('nric') }}">
                                @error('nric')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">DB Company Name</label>
                                <input type="text" name="company_name" class="form-control"
                                    placeholder="Enter DB Company Name" value="{{ old('company_name') }}">
                                @error('company_name')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">DB Company UEN</label>
                                <input type="text" name="company_uen" class="form-control"
                                    placeholder="Enter DB Company UEN" value="{{ old('company_uen') }}">
                                @error('company_uen')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">DB Email <span class="error">*</span></label>
                                <input type="email" name="email" class="form-control"
                                    placeholder="Enter DB Email" value="{{ old('email') }}">
                                @error('email')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">DB Phone <span class="error">*</span></label>
                                <input type="text" name="phone" class="form-control"
                                    placeholder="Enter DB Phone" value="{{ old('phone') }}">
                                @error('phone')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">DB Address <span class="error">*</span></label>
                                <input type="text" name="adderss" class="form-control"
                                    placeholder="Enter DB Address" value="{{ old('adderss') }}">
                                @error('adderss')
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
                                <label class="form-label">Debt Amount <span class="error">*</span></label>
                                <input type="number" name="debt_amount" class="form-control"
                                    placeholder="Enter Debt Amount" value="{{ old('debt_amount') }}">
                                @error('debt_amount')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Legal Cost <span class="error">*</span></label>
                                <input type="number" name="legal_cost" class="form-control"
                                    placeholder="Enter Legal Cost" value="{{ old('legal_cost') }}">
                                @error('legal_cost')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Debt Interest/Annum <span class="error">*</span></label>
                                <input type="number" name="debt_interest" class="form-control"
                                    placeholder="Enter Debt Interest/Annum" value="{{ old('debt_interest') }}">
                                @error('debt_interest')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Interest Start Date <span class="error">*</span></label>
                                <input type="date" name="interest_start_date" class="form-control"
                                    placeholder="Enter Interest Start Date" value="{{ old('interest_start_date') }}">
                                @error('interest_start_date')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Interest End Date <span class="error">*</span></label>
                                <input type="date" name="interest_end_date" class="form-control"
                                    placeholder="Enter Interest End Date" value="{{ old('interest_end_date') }}">
                                @error('interest_end_date')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Total Amount Owed <span class="error">*</span></label>
                                <input type="number" name="total_amount_owed" class="form-control"
                                    placeholder="Total Amount Owed" value="{{ old('total_amount_owed') }}">
                                @error('total_amount_owed')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Total Interest <span class="error">*</span></label>
                                <input type="number" name="total_interest" class="form-control"
                                    placeholder="Total Interest" value="{{ old('total_interest') }}">
                                @error('total_interest')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Total Amount Paid <span class="error">*</span></label>
                                <input type="Number" name="total_amount_paid" class="form-control"
                                    placeholder="Enter Total Amount Paid" value="{{ old('total_amount_paid') }}">
                                @error('total_amount_paid')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Total Amount Balance <span class="error">*</span></label>
                                <input type="Number" name="total_amount_balance" class="form-control"
                                    placeholder="Enter Total Amount Balance" value="{{ old('total_amount_balance') }}">
                                @error('total_amount_balance')
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
                            <a class="btn btn-secondary waves-effect" href="{{ route('admin.cases.index') }}">
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

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('change', '#client_id', function() {
                let client_id = $(this).val();
                $.ajax({
                    method: 'get',
                    url: "{{ route('date.of.agreement') }}",
                    data: {
                        client_id: client_id
                    },
                    success: function(response) {
                        // console.log(response);
                        var dateOfAgreement = response.dateofagreement.date_of_agreement;
                        $('#date_of_agreement').val(dayjs(dateOfAgreement).format('YYYY-MM-DD'));

                        var dateOfExpiry = response.dateofagreement.date_of_expiry
                        $('#date_of_expiry').val(dayjs(dateOfExpiry).format('YYYY-MM-DD'));

                        var fieldVisit = response.dateofagreement.field_visit_per_case
                        $('#field_visit').val(fieldVisit);

                    }

                })

            });

        });
    </script>
@endpush
@push('style')
@endpush
