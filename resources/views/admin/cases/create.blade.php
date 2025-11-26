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
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <h4 class="text-capitalize">Debtor Area</h4>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <button id="add-debtor" class="btn btn-success btn-sm" type="button" title="Add Debtor">
                                    <i class="fas fa-plus-circle"></i> Add Debtor
                                </button>
                            </div>
                        </div>

                        <div id="debtor-list">
                            @php
                                $oldDebtors = old('debtors', []);
                                if (count($oldDebtors) === 0) {
                                    $oldDebtors = [
                                        ['name'=>'','nric'=>'','phone'=>'','email'=>'','address'=>'','remarks'=>'']
                                    ];
                                }
                            @endphp

                            @foreach($oldDebtors as $i => $debtor)
                                <div class="card debtor-item mb-3" data-index="{{ $i }}" style="background-color: #eeeeee;">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-md-6">
                                                <h5 class="text-capitalize text-success text-decoration-underline debtor-title">Debtor {{ $i + 1 }}</h5>
                                            </div>
                                            <div class="col-md-6 d-flex justify-content-end">
                                                <button class="btn btn-danger btn-sm remove-debtor" type="button" title="Delete">
                                                    <i class="mdi mdi-trash-can-outline"></i> Delete
                                                </button>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">DB Name <span class="error">*</span></label>
                                                <!-- Important: name attribute for server-side binding -->
                                                <input type="text"
                                                       name="debtors[{{ $i }}][name]"
                                                       data-field="name"
                                                       class="form-control"
                                                       value="{{ $debtor['name'] ?? '' }}">
                                                @error("debtors.$i.name")
                                                <p class="error text-danger small">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">DB ID</label>
                                                <input type="text"
                                                       name="debtors[{{ $i }}][nric]"
                                                       data-field="nric"
                                                       class="form-control"
                                                       value="{{ $debtor['nric'] ?? '' }}">
                                                @error("debtors.$i.nric")
                                                <p class="error text-danger small">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">DB Contact</label>
                                                <input type="text"
                                                       name="debtors[{{ $i }}][phone]"
                                                       data-field="phone"
                                                       class="form-control"
                                                       value="{{ $debtor['phone'] ?? '' }}">
                                                @error("debtors.$i.phone")
                                                <p class="error text-danger small">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">DB Email</label>
                                                <input type="email"
                                                       name="debtors[{{ $i }}][email]"
                                                       data-field="email"
                                                       class="form-control"
                                                       value="{{ $debtor['email'] ?? '' }}">
                                                @error("debtors.$i.email")
                                                <p class="error text-danger small">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">DB Address</label>
                                                <input type="text"
                                                       name="debtors[{{ $i }}][address]"
                                                       data-field="address"
                                                       class="form-control"
                                                       value="{{ $debtor['address'] ?? '' }}">
                                                @error("debtors.$i.address")
                                                <p class="error text-danger small">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="mb-3 col-md-9">
                                                <label class="form-label">Remarks</label>
                                                <textarea
                                                    name="debtors[{{ $i }}][remarks]"
                                                    data-field="remarks"
                                                    cols="30" rows="2"
                                                    class="form-control"
                                                >{{ $debtor['remarks'] ?? '' }}</textarea>
                                                @error("debtors.$i.remarks")
                                                <p class="error text-danger small">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach

                        </div> {{-- #debtor-list --}}

                        {{-- Hidden template for new debtors (no server-side index) --}}
                        <div id="debtor-template" class="d-none">
                            <div class="card debtor-item mb-3" style="background-color: #eeeeee;">
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <h5 class="text-capitalize text-success text-decoration-underline debtor-title">Debtor __NUM__</h5>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-end">
                                            <button class="btn btn-danger btn-sm remove-debtor" type="button" title="Delete">
                                                <i class="mdi mdi-trash-can-outline"></i> Delete
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">DB Name <span class="error">*</span></label>
                                            <input type="text" data-field="name" class="form-control" value="">
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">DB ID</label>
                                            <input type="text" data-field="nric" class="form-control" value="">
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">DB Contact</label>
                                            <input type="text" data-field="phone" class="form-control" value="">
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">DB Email</label>
                                            <input type="email" data-field="email" class="form-control" value="">
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">DB Address</label>
                                            <input type="text" data-field="address" class="form-control" value="">
                                        </div>

                                        <div class="mb-3 col-md-9">
                                            <label class="form-label">Remarks</label>
                                            <textarea data-field="remarks" cols="30" rows="2" class="form-control"></textarea>
                                        </div>
                                    </div>

                                </div>
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

                    <a href="{{ route('admin.cases.index') }}" class="btn btn-danger">Close</a>
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
    {{-- jQuery: simple add/remove + update names/titles --}}

    <script>
        jQuery(function($){
            function updateNamesAndTitles() {
                $('#debtor-list .debtor-item').each(function(index){
                    $(this).attr('data-index', index);
                    $(this).find('.debtor-title').text('Debtor ' + (index + 1));

                    // For every element that has data-field, set the proper name
                    $(this).find('[data-field]').each(function(){
                        var field = $(this).data('field'); // e.g. name, nric...
                        $(this).attr('name', 'debtors[' + index + '][' + field + ']');
                    });
                });

                // disable remove buttons if only one debtor
                if ($('#debtor-list .debtor-item').length <= 1) {
                    $('#debtor-list .remove-debtor').prop('disabled', true).addClass('disabled');
                } else {
                    $('#debtor-list .remove-debtor').prop('disabled', false).removeClass('disabled');
                }
            }

            // run on load (ensures server-rendered blocks also have correct names if not already)
            updateNamesAndTitles();

            // add debtor
            $('#add-debtor').on('click', function(){
                var tpl = $('#debtor-template').html();
                var nextNum = $('#debtor-list .debtor-item').length + 1;
                tpl = tpl.replace(/__NUM__/g, nextNum);
                var $new = $(tpl);
                $('#debtor-list').append($new);
                updateNamesAndTitles();
                $new.find('[data-field="name"]').focus();
            });

            // remove debtor (delegated)
            $(document).on('click', '.remove-debtor', function(){
                if ($('#debtor-list .debtor-item').length <= 1) return;
                $(this).closest('.debtor-item').remove();
                updateNamesAndTitles();
            });

            // UX: if there are validation errors, scroll to the first error and highlight
            var $firstError = $('.text-danger').first();
            if ($firstError.length) {
                // scroll smoothly to the error
                $('html, body').animate({ scrollTop: $firstError.offset().top - 120 }, 300);
                // optional: briefly highlight the parent debtor card
                $firstError.closest('.debtor-item').css('box-shadow','0 0 0 3px rgba(255,0,0,0.08)');
            }

            // Re-enable submit buttons if some other script disabled them before page-load
            $('button[type="submit"]').prop('disabled', false);
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

            // remove previous errors
            $('.err-msg').remove();

            var form = this;
            var $form = $(form);

            // Ensure CSRF token is sent (make sure meta exists in your layout)
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            if (csrfToken) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
            }

            $.ajax({
                url: "{{ route('admin.cases.store') }}",
                type: "POST",
                data: new FormData(form),
                dataType: 'json',
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function() {
                    $("#submitBtn").prop('disabled', true);
                },
                success: function(data) {
                    // Expecting JSON with success true/false
                    if (data.success) {
                        // reset form and show modal as before
                        $form[0].reset();
                        $("#showMsg").modal('show');

                        var url = "/printable/case/agreement/" + data.result.id;
                        var letterUrl = "/printable/letter/" + data.result.id;

                        $('#agreement').attr('href', url);
                        $('#letter').attr('href', letterUrl);

                    } else {
                        // If backend returns structured errors in data.error or data.errors
                        var errors = data.errors || data.error || {};
                        showAjaxErrors(errors);
                    }
                },
                error: function(xhr) {
                    // Laravel validation failures typically return 422 with JSON { errors: { ... } }
                    if (xhr.status === 422 && xhr.responseJSON) {
                        var errors = xhr.responseJSON.errors || xhr.responseJSON.error || {};
                        showAjaxErrors(errors);
                    } else {
                        // Generic error handling
                        $("#message").html("Some Error Occurred!");
                        console.error(xhr);
                    }
                },
                complete: function() {
                    // always re-enable submit
                    $("#submitBtn").prop('disabled', false);
                }
            });

            // helper: convert Laravel dot-notation keys to bracket-style name and show errors
            function showAjaxErrors(errors) {
                // errors is an object like { "debtors.0.name": ["The debtors.0.name field is required."], "title": ["..."] }
                var firstErrorEl = null;
                $.each(errors, function(key, messages) {
                    // key may be 'debtors.0.name' or 'title' etc.
                    // Convert dot-notation to bracket notation: debtors.0.name -> debtors[0][name]
                    var bracketName = key.replace(/\.(\d+)\./g, '[$1].') // intermediate: debtors[0].name
                        .replace(/\./g, '][')           // debtors[0][name]
                        .replace(/\]\[/g, '][')         // keep as is
                        .replace(/^(.+)$/, '$1') ;      // no-op

                    // Better approach: build bracket string piece by piece
                    var parts = key.split('.');
                    var bracket = parts[0];
                    for (var i = 1; i < parts.length; i++) {
                        // if numeric part -> [i] else -> [name]
                        if (/^\d+$/.test(parts[i])) {
                            bracket += '[' + parts[i] + ']';
                        } else {
                            bracket += '[' + parts[i] + ']';
                        }
                    }
                    // bracket now like debtors[0][name] or title

                    // Try to find element(s) by name attribute (input/select/textarea)
                    // Use attribute selector with quotes to be safe for special characters
                    var selector = '[name="' + bracket + '"]';
                    var $el = $(selector);

                    // If not found, try fallback: inputs that have data-field with last part and are inside debtor-item with same index
                    if ($el.length === 0 && key.indexOf('debtors.') === 0) {
                        // extract index and field
                        var m = key.match(/^debtors\.(\d+)\.(.+)$/);
                        if (m) {
                            var idx = parseInt(m[1], 10);
                            var field = m[2];
                            $el = $('#debtor-list').find('.debtor-item').eq(idx).find('[data-field="' + field + '"]');
                        }
                    }

                    // final fallback: try selector by name with dots replaced by brackets in an easier way
                    if ($el.length === 0) {
                        var alt = key.replace(/\./g, '][');
                        alt = alt.replace(/^(.+)$/, '$1'); // no-op
                        alt = alt.replace(/([^\]]+)\]\[/g, '$1][');
                        $el = $('[name="' + alt + '"]');
                    }

                    // create error element
                    var msg = Array.isArray(messages) ? messages[0] : messages;
                    var $err = $('<span class="err-msg text-danger small"></span>').text(msg);

                    if ($el.length) {
                        // If multiple matched (rare), append after last
                        $el.last().after($err);
                        if (!firstErrorEl) firstErrorEl = $el.first();
                    } else {
                        // If no matching field found, append to top of form or a message container
                        if (!firstErrorEl) {
                            firstErrorEl = $form.find('input,textarea,select').first();
                        }
                        // Append generic error at top of form
                        $form.prepend($err);
                    }
                });

                // focus and scroll to the first error field
                if (firstErrorEl && firstErrorEl.length) {
                    var top = firstErrorEl.offset().top - 120;
                    $('html, body').animate({ scrollTop: top }, 300);
                    firstErrorEl.focus();
                }
            }
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
