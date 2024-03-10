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
                            {{-- <label class="form-label">Case Number</label> --}}
                            <input type="hidden" name="case_number" class="form-control" placeholder="Enter Case Number"
                                id="case_number" value="">
                            {{-- @error('case_number')
                                    <p class="error">{{ $message }}</p>
                                @enderror --}}
                            <div class="mb-3 col-md-3">
                                <label class="form-label">CL Name</label>
                                <select class="form-select select2 form-control" id="client_id" name="client_id"
                                    aria-label="Default select example">
                                    <option selected disabled>Select CL Name</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->client_id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Date of Warrant</label>
                                <input type="date" name="date_of_warrant" id="date_of_warrant" class="form-control"
                                    placeholder="Enter Date of Warrant" value="{{ old('date_of_warrant') }}">
                                @error('date_of_warrant')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Manager IC</label>
                                <input type="text" name="manager_ic" class="form-control"
                                    placeholder="Enter Manager IC Name" value="{{ old('manager_ic') }}">
                                @error('manager_ic')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Collector IC</label>
                                <input type="text" name="collector_ic" class="form-control"
                                    placeholder="Enter Collector IC Name" value="{{ old('collector_ic') }}">
                                @error('collector_ic')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Case Status</label>
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
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Case Summary</label>
                                <textarea name="case_summary" cols="30" rows="2" class="form-control">Enter Case Summary Here</textarea>
                                @error('case_summary')
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
                                <label class="form-label">Collection Commission (%)</label>
                                <input type="text" name="collection_commission" id="collection_commission"
                                    class="form-control" placeholder="Enter Collection Commission" value="">
                                @error('collection_commission')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Field Visits</label>
                                <input type="text" name="field_visit" placeholder="Enter Field Visit Number Here"
                                    class="form-control" id="field_visit" value="">
                                @error('field_visit')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <input type="hidden" name="bal_field_visit" placeholder="Enter Field Visit Number Here"
                                class="form-control" id="bal_field_visit" value="">


                            {{-- <div class="mb-3 col-md-4">
                                <label class="form-label">Bal Field Visits</label>
                                <input type="text" name="bal_field_visit" class="form-control"
                                    placeholder="Enter Bal Field Visits" value="">
                                @error('bal_field_visit')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label class="form-label">DB Name <span class="error">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="Enter DB Name"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">DB NRIC</label>
                                <input type="text" name="nric" class="form-control" placeholder="Enter DB NRIC"
                                    value="{{ old('nric') }}">
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
                                <label class="form-label">DB Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter DB Email"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">DB Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="Enter DB Phone"
                                    value="{{ old('phone') }}">
                                @error('phone')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">DB Address</label>
                                <input type="text" name="adderss" class="form-control" placeholder="Enter DB Address"
                                    value="{{ old('adderss') }}">
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
                                <label class="form-label">Debt Amount</label>
                                <input type="number" name="debt_amount" class="form-control"
                                    placeholder="Enter Debt Amount" id="debt_amount" value="{{ old('debt_amount') }}">
                                @error('debt_amount')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Legal Cost</label>
                                <input type="number" name="legal_cost" class="form-control"
                                    placeholder="Enter Legal Cost" id="legal_cost" value="{{ old('legal_cost') }}">
                                @error('legal_cost')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Total Interest</label>
                                <input type="number" name="total_interest" class="form-control"
                                    placeholder="Total Interest will Auto Update" readonly id="total_interest">
                                @error('total_interest')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Total Amount Owed</label>
                                <input type="number" name="total_amount_owed" class="form-control"
                                    placeholder="Total Amount Owed will Auto Update" readonly id="total_amount_owed">
                                @error('total_amount_owed')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Debt Interest/Annum</label>
                                <input type="text" name="debt_interest" class="form-control"
                                    placeholder="Enter Debt Interest/Annum" id="debt_amount_annum">
                                @error('debt_interest')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Interest Start Date</label>
                                <input type="date" name="interest_start_date" class="form-control" id="start_date"
                                    placeholder="Enter Interest Start Date">
                                @error('interest_start_date')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Interest End Date</label>
                                <input type="date" name="interest_end_date" id="end_date"
                                    class="form-control" placeholder="Enter Interest End Date">
                                @error('interest_end_date')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- <div class="mb-3 col-md-3">
                                <label class="form-label">Total Amount Paid</label>
                                <input type="Number" name="total_amount_paid" class="form-control"
                                    placeholder="Enter Total Amount Paid" value="{{ old('total_amount_paid') }}">
                                @error('total_amount_paid')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div> --}}
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Total Amount Balance</label>
                                <input type="text" name="total_amount_balance" readonly id="total_amount_balance" class="form-control"
                                    placeholder="Total Amount Balance will Auto Update">
                                @error('total_amount_balance')
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
                                <label class="form-label">Administrative Fee</label>
                                <input type="text" name="administrative_fee" class="form-control"
                                    placeholder="Enter Administrative Fee" value="{{ old('administrative_fee') }}">
                                @error('administrative_fee')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Enforcement Fee</label>
                                <input type="text" name="enforcement_fee" class="form-control"
                                    placeholder="Enter Enforcement Fee" value="{{ old('enforcement_fee') }}">
                                @error('enforcement_fee')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Professional Fee</label>
                                <input type="text" name="professional_fee" class="form-control"
                                    placeholder="Enter Professional Fee" value="{{ old('professional_fee') }}">
                                @error('professional_fee')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Annual Fee</label>
                                <input type="text" name="annual_fee" class="form-control"
                                    placeholder="Enter Annual Fee" value="{{ old('annual_fee') }}">
                                @error('annual_fee')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Skip-Tracing Fee</label>
                                <input type="text" name="skip_tracing_fee" class="form-control"
                                    placeholder="Enter Skip Tracing Fee" value="{{ old('skip_tracing_fee') }}">
                                @error('skip_tracing_fee')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Overseas Allowance</label>
                                <input type="number" name="overseas_allowance" class="form-control"
                                    placeholder="Enter Overseas Allowance" value="{{ old('overseas_allowance') }}">
                                @error('overseas_allowance')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Remarks</label>
                                <textarea name="remarks" class="form-control" id="" cols="30" rows="1">Enter Remarks Here</textarea>
                                @error('remarks')
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
                        console.log(response);
                        var dateOfAgreement = response.dateofagreement.date_of_agreement;
                        $('#date_of_agreement').val(dayjs(dateOfAgreement).format(
                            'YYYY-MM-DD'));

                        var dateOfExpiry = response.dateofagreement.date_of_expiry
                        $('#date_of_expiry').val(dayjs(dateOfExpiry).format('YYYY-MM-DD'));

                        var fieldVisit = response.dateofagreement.field_visit_per_case
                        $('#field_visit').val(fieldVisit);

                        var balFieldVisit = response.dateofagreement.field_visit_per_case
                        $('#bal_field_visit').val(balFieldVisit);

                        var collection_commission = response.dateofagreement
                            .collection_commission
                        $('#collection_commission').val(collection_commission);

                        var clNameAbbr = response.dateofagreement.abbr
                        var getDate = response.dateofagreement.created_at
                        var formatedDate = dayjs(getDate).format('YYYY')
                        $('#case_number').val(formatedDate + '/' + clNameAbbr + '/');
                    }
                })
            });
            $(function() {
            $("#end_date").on("change", sub);
            function sub() {
                var start = $('#start_date').val();
                var end = $('#end_date').val();
                // end - start returns difference in milliseconds
                diff = new Date(Date.parse(end) - Date.parse(start));
                // get days
                var days = diff / 1000 / 60 / 60 / 24;
                var debt_amount_annum = $('#debt_amount_annum').val();
                var total_interest = debt_amount_annum / 365 * days;
                $('#total_interest').val(parseFloat(total_interest).toFixed(2));


                var debt_amount = $('#debt_amount').val();
                var legal_cost = $('#legal_cost').val();


                var total_amount_owed = parseFloat(debt_amount) + parseFloat(legal_cost) + parseFloat(total_interest);

                $('#total_amount_owed').val(parseFloat(total_amount_owed).toFixed(2));
                $('#total_amount_balance').val(parseFloat(total_amount_owed).toFixed(2));

            }
        });
        });
    </script>
@endpush
@push('style')
@endpush
