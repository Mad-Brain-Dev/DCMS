@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <h4 class="card-title mb-3">{{ get_page_meta('title', true) }}</h4>
            <form id="frmAppl" method="post">
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
                                <label class="form-label">CL Name <span class="error">*</span></label><br>
                                <select class="form-select select2 form-control" id="client_id" name="client_id">
                                    <option selected disabled>Select CL Name</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                    {{-- @error('client_id')
                                        <p class="error"></p>
                                    @enderror --}}
                                </select>

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
                                    {{-- <option selected disabled>Select Case Status</option> --}}
                                    <option value="{{ \App\Utils\GlobalConstant::CASE_PENDING }}">
                                        {{ \App\Utils\GlobalConstant::CASE_PENDING }}</option>
                                    <option value="{{ \App\Utils\GlobalConstant::CASE_OPEN }}" selected>
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
                                <textarea name="case_summary" cols="30" rows="2" placeholder="Enter Case Summary Here" class="form-control"></textarea>
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
                                <input type="number" name="collection_commission" id="collection_commission"
                                    class="form-control" step="0.01" min="0" max="10000000000000"
                                    placeholder="Enter Collection Commission" readonly value="">
                                @error('collection_commission')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Field Visits</label>
                                <input type="number" name="field_visit" placeholder="Enter Field Visit Number Here"
                                    class="form-control" readonly id="field_visit" value="">
                                @error('field_visit')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <input type="hidden" name="bal_field_visit" placeholder="Enter Field Visit Number Here"
                                class="form-control" id="bal_field_visit" value="">
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
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Guarantor Name</label>
                                <input type="text" name="guarantor_name" class="form-control"
                                    placeholder="Enter guarantor name" value="{{ old('guarantor_name') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Guarantor Address</label>
                                <input type="text" name="guarantor_address" class="form-control"
                                    placeholder="Enter guarantor Address" value="{{ old('guarantor_address') }}">
                                @error('guarantor_address')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Remarks</label>
                                <input type="text" name="remarks_one" class="form-control"
                                    placeholder="Enter Remarks" value="{{ old('remarks_one') }}">
                                @error('remarks_one')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Guarantor Name 2</label>
                                <input type="text" name="guarantor_name2" class="form-control"
                                    placeholder="Enter guarantor name 2" value="{{ old('guarantor_name2') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Guarantor Address 2</label>
                                <input type="text" name="guarantor_address2" class="form-control"
                                    placeholder="Enter guarantor Address 2" value="{{ old('guarantor_address2') }}">
                                @error('guarantor_address2')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Remarks 2</label>
                                <input type="text" name="remarks_two" class="form-control"
                                    placeholder="Enter Remarks 2" value="{{ old('remarks_two') }}">
                                @error('remarks_two')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Guarantor Name 3</label>
                                <input type="text" name="guarantor_name3" class="form-control"
                                    placeholder="Enter guarantor name 3" value="{{ old('guarantor_name3') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Guarantor Address 3</label>
                                <input type="text" name="guarantor_address3" class="form-control"
                                    placeholder="Enter guarantor Address 3" value="{{ old('guarantor_address3') }}">
                                @error('guarantor_address3')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Remarks 3</label>
                                <input type="text" name="remarks_three" class="form-control"
                                    placeholder="Enter Remarks 3" value="{{ old('remarks_three') }}">
                                @error('remarks_three')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label class="form-label">Select Interest Type</label>
                                <div class="gap-4 d-flex">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="simple" checked
                                            name="principal_interest" id="simpleInterest">
                                        <label class="form-check-label" for="simpleInterest">
                                            Simple Interest
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" value="compound"
                                            name="principal_interest" id="compoundInterest">
                                        <label class="form-check-label" for="compoundInterest">
                                            Compound Interest
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="principal_interest"
                                            id="noInterest" value="no">
                                        <label class="form-check-label" for="noInterest">
                                            No Interest
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="principal_interest"
                                            id="stopInterest" value="stop">
                                        <label class="form-check-label" for="stopInterest">
                                            Stop Interest
                                        </label>
                                    </div>
                                </div>
                                @error('interest')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Debt Amount</label>
                                <input type="number" step="0.01" min="0" max="10000000000000"
                                    name="debt_amount" class="form-control" placeholder="Enter Debt Amount"
                                    id="debt_amount" value="{{ old('debt_amount') }}">
                                @error('debt_amount')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Legal Cost</label>
                                <input type="number" step="0.01" min="0" max="10000000000000"
                                    name="legal_cost" class="form-control" placeholder="Enter Legal Cost"
                                    id="legal_cost" value="{{ old('legal_cost') }}">
                                @error('legal_cost')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Total Interest</label>
                                <input type="number" step="0.01" min="0" max="10000000000000"
                                    name="total_interest" class="form-control"
                                    placeholder="Total Interest will Auto Update" readonly id="total_interest">
                                @error('total_interest')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Total Amount Owed</label>
                                <input type="number" step="0.01" min="0" max="10000000000000"
                                    name="total_amount_owed" class="form-control"
                                    placeholder="Total Amount Owed will Auto Update" readonly id="total_amount_owed">
                                @error('total_amount_owed')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Debt Interest/Annum (%)</label>
                                <input type="number" step="0.01" min="0" max="10000000000000"
                                    name="debt_interest" class="form-control" placeholder="Enter Debt Interest/Annum"
                                    id="debt_amount_annum">
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
                                <input type="date" name="interest_end_date" id="end_date" class="form-control"
                                    placeholder="Enter Interest End Date" value="{{ date('Y-m-d') }}">
                                @error('interest_end_date')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Total Amount Balance</label>
                                <input type="number" name="total_amount_balance" readonly id="total_amount_balance"
                                    class="form-control" placeholder="Total Amount Balance will Auto Update">
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
                                <label class="form-label">Remarks</label>
                                <textarea name="remarks" class="form-control" placeholder="Enter Remarks Here" id="" cols="30"
                                    rows="1"></textarea>
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
                            <button class="btn btn-primary waves-effect waves-lightml-2 me-2" type="submit"
                                id="submitBtn">
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

    <div class="modal fade" tabindex="-1" role="dialog" id="showMsg">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-footer d-flex justify-content-between" style="border: none;">

                    <a href="{{ route('admin.cases.index') }}" class="btn btn-danger"
                        class="btn btn-secondary">Close</a>
                    <a class="btn btn-primary" id="letter" href="">Print Letter</a>
                    <a class="btn btn-success" id="agreement" href="">Print Warrant</a>

                </div>
            </div>
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
                        $('#case_number').val(clNameAbbr + ' ' + '/' + ' ' + formatedDate +
                            ' ' + '/' + ' ');
                    }
                })
            });


            $('#start_date, #end_date, input[type=radio][name=principal_interest]').change(sub);

            function sub() {
                var selectedValue = $('input[name=principal_interest]:checked').val();

                if (selectedValue == 'no') {

                    var start = $('#start_date').val();
                    var end = $('#end_date').val();
                    // end - start returns difference in milliseconds
                    diff = new Date(Date.parse(end) - Date.parse(start));
                    // get days
                    var days = diff / 1000 / 60 / 60 / 24;
                    var debt_amount = parseFloat($('#debt_amount').val());
                    var debt_amount_annum = parseFloat($('#debt_amount_annum').val() / 100);
                    var legal_cost = parseFloat($('#legal_cost').val());
                    var interest = 0;
                    var total_amount_owed = parseInt(debt_amount) + parseInt(legal_cost) + parseInt(interest);


                    $('#total_amount_owed').val(parseFloat(total_amount_owed).toFixed(
                        2));

                    $('#total_interest').val(parseFloat(interest).toFixed(2));

                    $('#total_amount_balance').val(parseFloat(total_amount_owed)
                        .toFixed(
                            2));


                    if (start) {

                        $("#debt_amount, #legal_cost, #debt_amount_annum").on("keyup", function() {
                            var start = $('#start_date').val();
                            var end = $('#end_date').val();
                            // end - start returns difference in milliseconds
                            diff = new Date(Date.parse(end) - Date.parse(start));
                            // get days
                            var days = diff / 1000 / 60 / 60 / 24;
                            var debt_amount = parseFloat(('#debt_amount').val());
                            var debt_amount_annum = $('#debt_amount_annum').val() / 100;
                            var legal_cost = parseFloat(('#legal_cost').val());
                            var interest = 0;
                            var total_amount_owed = parseInt(debt_amount) + parseInt(legal_cost) + parseInt(
                                interest);


                            $('#total_amount_owed').val(parseFloat(total_amount_owed).toFixed(
                                2));

                            $('#total_interest').val(parseFloat(interest).toFixed(2));

                            $('#total_amount_balance').val(parseFloat(total_amount_owed)
                                .toFixed(
                                    2));

                        })
                    }

                } else if (selectedValue == 'simple') {

                    var start = $('#start_date').val();
                    var end = $('#end_date').val();
                    // end - start returns difference in milliseconds
                    diff = new Date(Date.parse(end) - Date.parse(start));
                    var days = diff / 1000 / 60 / 60 / 24;


                    var legal_cost = parseFloat($('#legal_cost').val());
                    var debt_amount = parseFloat($('#debt_amount').val()) + legal_cost;


                    var debt_amount_annum = $('#debt_amount_annum').val() / 100 / 365;


                    var interest = debt_amount * debt_amount_annum * days;


                    var totalAmount = debt_amount + interest;

                    $('#total_interest').val(parseFloat(interest).toFixed(2));
                    $('#total_amount_owed').val(parseFloat(totalAmount).toFixed(2));
                    $('#total_amount_balance').val(parseFloat(totalAmount).toFixed(2));

                    if (start) {
                        $("#debt_amount, #legal_cost, #debt_amount_annum").on("keyup", function() {
                            var start = $('#start_date').val();
                            var end = $('#end_date').val();
                            // end - start returns difference in milliseconds
                            diff = new Date(Date.parse(end) - Date.parse(start));
                            var days = diff / 1000 / 60 / 60 / 24;


                            var legal_cost = parseFloat($('#legal_cost').val());
                            var debt_amount = parseFloat($('#debt_amount').val()) + legal_cost;
                            var debt_amount_annum = $('#debt_amount_annum').val() / 100 / 365;


                            var interest = debt_amount * debt_amount_annum * days;


                            var totalAmount = debt_amount + interest;

                            $('#total_interest').val(parseFloat(interest).toFixed(2));
                            $('#total_amount_owed').val(parseFloat(totalAmount).toFixed(2));
                            $('#total_amount_balance').val(parseFloat(totalAmount).toFixed(2));
                        })
                    }

                } else if (selectedValue == 'stop') {

                    var start = $('#start_date').val();
                    var end = $('#end_date').val();
                    // end - start returns difference in milliseconds
                    diff = new Date(Date.parse(end) - Date.parse(start));
                    var days = diff / 1000 / 60 / 60 / 24;


                    var legal_cost = parseFloat($('#legal_cost').val());
                    var debt_amount = parseFloat($('#debt_amount').val()) + legal_cost;
                    var debt_amount_annum = $('#debt_amount_annum').val() / 100 / 365;


                    var interest = debt_amount * debt_amount_annum * days;


                    var totalAmount = debt_amount + interest;

                    $('#total_interest').val(parseFloat(interest).toFixed(2));
                    $('#total_amount_owed').val(parseFloat(totalAmount).toFixed(2));
                    $('#total_amount_balance').val(parseFloat(totalAmount).toFixed(2));

                    if (start) {
                        $("#debt_amount, #legal_cost, #debt_amount_annum").on("keyup", function() {
                            var start = $('#start_date').val();
                            var end = $('#end_date').val();
                            // end - start returns difference in milliseconds
                            diff = new Date(Date.parse(end) - Date.parse(start));
                            var days = diff / 1000 / 60 / 60 / 24;


                            var legal_cost = parseFloat($('#legal_cost').val());
                            var debt_amount = parseFloat($('#debt_amount').val()) + legal_cost;
                            var debt_amount_annum = $('#debt_amount_annum').val() / 100 / 365;


                            var interest = debt_amount * debt_amount_annum * days;


                            var totalAmount = debt_amount + interest;

                            $('#total_interest').val(parseFloat(interest).toFixed(2));
                            $('#total_amount_owed').val(parseFloat(totalAmount).toFixed(2));
                            $('#total_amount_balance').val(parseFloat(totalAmount).toFixed(2));
                        })
                    }

                } else {
                    var start = $('#start_date').val();
                    var end = $('#end_date').val();
                    // end - start returns difference in milliseconds
                    diff = new Date(Date.parse(end) - Date.parse(start));
                    // get days
                    var days = parseInt(diff / 1000 / 60 / 60 / 24);
                    var legal_cost = parseFloat($('#legal_cost').val());
                    var debt_amount = parseFloat($('#debt_amount').val()) + legal_cost;
                    var debt_amount_annum = $('#debt_amount_annum').val() / 100;


                    //Compound Capital Interest
                    const interest = calculateCompoundInterest(debt_amount, debt_amount_annum, days);
                    const total_amount_owed = calculateCompoundPrincipalInterest(debt_amount,
                        debt_amount_annum, days)
                    // $('#result').text('The compound interest for ' + days + ' days is: ' + interest.toFixed(
                    //     2));

                    function calculateCompoundInterest(debt_amount, debt_amount_annum, days) {
                        const dailyRate = debt_amount_annum / 365;
                        const amount = debt_amount * Math.pow((1 + dailyRate), days);
                        return total_interest = amount -
                            debt_amount; // This gives the interest earned over the specified number of days
                    }

                    function calculateCompoundPrincipalInterest(debt_amount, debt_amount_annum, days) {
                        const dailyRate = debt_amount_annum / 365;
                        const amount = debt_amount * Math.pow((1 + dailyRate), days);
                        return amount;
                    }
                    // var total_interest = dailyInterest * days;
                    $('#total_interest').val(parseFloat(interest).toFixed(2));

                    $('#total_amount_owed').val(parseFloat(total_amount_owed).toFixed(2));
                    var installment_number = $('#installment_number').val();
                    var per_installment_amount = parseFloat(total_amount_owed / installment_number)
                        .toFixed(
                            2);
                    $('#per_installment_amount').val(per_installment_amount);

                    $('#total_amount_owed').val(parseFloat(total_amount_owed).toFixed(2));

                    $('#total_amount_balance').val(parseFloat(total_amount_owed).toFixed(2));

                    if (start) {

                        $("#debt_amount, #legal_cost, #debt_amount_annum").on("keyup", function() {

                            var start = $('#start_date').val();
                            var end = $('#end_date').val();
                            // end - start returns difference in milliseconds
                            diff = new Date(Date.parse(end) - Date.parse(start));
                            // get days
                            var days = parseFloat(diff / 1000 / 60 / 60 / 24);
                            var legal_cost = parseFloat($('#legal_cost').val());
                            var debt_amount = parseFloat($('#debt_amount').val()) + legal_cost;
                            var debt_amount_annum = $('#debt_amount_annum').val() / 100;


                            //Compound Capital Interest
                            const interest = calculateCompoundInterest(debt_amount, debt_amount_annum,
                                days);
                            const total_amount_owed = calculateCompoundPrincipalInterest(debt_amount,
                                debt_amount_annum, days)
                            // $('#result').text('The compound interest for ' + days + ' days is: ' + interest.toFixed(
                            //     2));



                            function calculateCompoundInterest(debt_amount, debt_amount_annum, days) {
                                const dailyRate = debt_amount_annum / 365;
                                const amount = debt_amount * Math.pow((1 + dailyRate), days);

                                return total_interest = amount -
                                    debt_amount; // This gives the interest earned over the specified number of days
                            }

                            function calculateCompoundPrincipalInterest(debt_amount, debt_amount_annum,
                                days) {
                                const dailyRate = debt_amount_annum / 365;
                                const amount = debt_amount * Math.pow((1 + dailyRate), days);
                                return amount;
                            }
                            // var total_interest = dailyInterest * days;
                            $('#total_interest').val(parseFloat(interest).toFixed(2));

                            $('#total_amount_owed').val(parseFloat(total_amount_owed).toFixed(2));
                            var installment_number = $('#installment_number').val();
                            var per_installment_amount = parseFloat(total_amount_owed / installment_number)
                                .toFixed(
                                    2);
                            $('#per_installment_amount').val(per_installment_amount);

                            $('#total_amount_owed').val(parseFloat(total_amount_owed).toFixed(2));

                            $('#total_amount_balance').val(parseFloat(total_amount_owed).toFixed(2));
                        })

                    }

                }

            }

        });


        $("#frmAppl").on("submit", function(event) {
            event.preventDefault();
            var error_ele = document.getElementsByClassName('err-msg');
            if (error_ele.length > 0) {
                for (var i = error_ele.length - 1; i >= 0; i--) {
                    error_ele[i].remove();
                }
            }

            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            //     }
            // });

            $.ajax({
                url: "{{ route('admin.cases.store') }}",
                type: "POST",
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function() {
                    $("#submitBtn").prop('disabled', true);
                },
                success: function(data) {
                    if (data.success) {
                        console.log(data);
                        $("#frmAppl")[0].reset();
                        $("#showMsg").modal('show');
                        var url = "/printable/case/agreement/" + data.result.id
                        var letterUrl = "/printable/letter/" + data.result.id

                        $('#agreement').attr('href', url);
                        $('#letter').attr('href', letterUrl);

                    } else {
                        $.each(data.error, function(key, value) {
                            var el = $(document).find('[name="' + key + '"]');
                            el.after($('<span class= "err-msg">' + value[0] + '</span>'));

                        });
                    }
                    $("#submitBtn").prop('disabled', false);
                },
                error: function(err) {
                    $("#message").html("Some Error Occurred!")
                }
            });
        });
    </script>
@endpush

@push('style')
    <style>
        .err-msg {
            color: #ec4561;
            font-size: 12px;
        }

        .select2-container .select2-selection--single {
            height: 33px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 33px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 4px !important;
        }
    </style>
@endpush
