@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
                    <h4 class="card-title mb-3">{{ get_page_meta('title', true) }}</h4>
                    <form action="{{ route('admin.cases.update', $case->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-body">
                                <div class="row">

                                    <div class="mb-3 col-md-3">
                                        <label class="form-label">Case Number</label>
                                        <input type="text" name="case_sku" class="form-control"
                                            value="{{ $case->case_sku }}">
                                        @error('case_sku')
                                            <p class="error">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-3">
                                        <label class="form-label">Date of Warrant</label>
                                        <input type="date" name="date_of_warrant" class="form-control"
                                            value="{{ date('Y-m-d', strtotime($case->date_of_expiry)) }}">
                                        @error('date_of_warrant')
                                            <p class="error">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-3">
                                        <label class="form-label">Manager IC</label>
                                        <input type="text" name="manager_ic" class="form-control"
                                            value="{{ $case->manager_ic }}">
                                        @error('manager_ic')
                                            <p class="error">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-3">
                                        <label class="form-label">Collector IC</label>
                                        <input type="text" name="collector_ic" class="form-control"
                                            value="{{ $case->collector_ic }}">
                                        @error('collector_ic')
                                            <p class="error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-3">
                                        <label class="form-label">Case Status</label>
                                        <select class="form-select select2" id="case_status" name="current_status"
                                            aria-label="Default select example">
                                            <option selected disabled>Select Case Status</option>


                                            <option value="{{ \App\Utils\GlobalConstant::CASE_PENDING }}" {{ $case->current_status == \App\Utils\GlobalConstant::CASE_PENDING ? 'selected' : ''}}>{{ \App\Utils\GlobalConstant::CASE_PENDING }}</option>
                                            <option value="{{ \App\Utils\GlobalConstant::CASE_OPEN }}" {{ $case->current_status == \App\Utils\GlobalConstant::CASE_OPEN ? 'selected' : ''}}>{{ \App\Utils\GlobalConstant::CASE_OPEN }}</option>

                                            <option value="{{ \App\Utils\GlobalConstant::CASE_FIELD }}" {{ $case->current_status == \App\Utils\GlobalConstant::CASE_FIELD ? 'selected' : ''}}>
                                                {{ \App\Utils\GlobalConstant::CASE_FIELD }}</option>

                                            <option value="{{ \App\Utils\GlobalConstant::CASE_DESPATCHED }}" {{ $case->current_status == \App\Utils\GlobalConstant::CASE_DESPATCHED ? 'selected' : ''}}>
                                                {{ \App\Utils\GlobalConstant::CASE_DESPATCHED }}</option>


                                            <option value="{{ \App\Utils\GlobalConstant::CASE_INVESTIGATION_NEEDED }}" {{ $case->current_status == \App\Utils\GlobalConstant::CASE_INVESTIGATION_NEEDED ? 'selected' : ''}}>
                                                {{ \App\Utils\GlobalConstant::CASE_INVESTIGATION_NEEDED }}</option>


                                            <option value="{{ \App\Utils\GlobalConstant::CASE_NEGOTIATING_WITH_DB }}" {{ $case->current_status == \App\Utils\GlobalConstant::CASE_NEGOTIATING_WITH_DB ? 'selected' : ''}}>
                                                {{ \App\Utils\GlobalConstant::CASE_NEGOTIATING_WITH_DB }}</option>


                                            <option value="{{ \App\Utils\GlobalConstant::CASE_UNDER_INSTALMENT }}" {{ $case->current_status == \App\Utils\GlobalConstant::CASE_UNDER_INSTALMENT ? 'selected' : ''}}>
                                                {{ \App\Utils\GlobalConstant::CASE_UNDER_INSTALMENT }}</option>


                                            <option value="{{ \App\Utils\GlobalConstant::CASE_FULLY_SETTELED }}" {{ $case->current_status == \App\Utils\GlobalConstant::CASE_FULLY_SETTELED ? 'selected' : ''}}>
                                                {{ \App\Utils\GlobalConstant::CASE_FULLY_SETTELED }}</option>


                                            <option value="{{ \App\Utils\GlobalConstant::CASE_PARTIALLY_SETTELED }}" {{ $case->current_status == \App\Utils\GlobalConstant::CASE_PARTIALLY_SETTELED ? 'selected' : ''}}>
                                                {{ \App\Utils\GlobalConstant::CASE_PARTIALLY_SETTELED }}</option>


                                            <option value="{{ \App\Utils\GlobalConstant::CASE_CASE_ON_HOLD_BY_CLIENT }}" {{ $case->current_status == \App\Utils\GlobalConstant::CASE_CASE_ON_HOLD_BY_CLIENT ? 'selected' : ''}}>
                                                {{ \App\Utils\GlobalConstant::CASE_CASE_ON_HOLD_BY_CLIENT }}</option>


                                            <option value="{{ \App\Utils\GlobalConstant::CASE_ON_HOLD_BY_MANAGEMENT }}" {{ $case->current_status == \App\Utils\GlobalConstant::CASE_ON_HOLD_BY_MANAGEMENT ? 'selected' : ''}}>
                                                {{ \App\Utils\GlobalConstant::CASE_ON_HOLD_BY_MANAGEMENT }}</option>


                                            <option value="{{ \App\Utils\GlobalConstant::CASE_CLOSED_WITHOUT_PAYMENT }}" {{ $case->current_status == \App\Utils\GlobalConstant::CASE_CLOSED_WITHOUT_PAYMENT ? 'selected' : ''}}>
                                                {{ \App\Utils\GlobalConstant::CASE_CLOSED_WITHOUT_PAYMENT }}</option>


                                            <option value="{{ \App\Utils\GlobalConstant::CASE_AWAITING_UPDATE_FR_CLIENT }}" {{ $case->current_status == \App\Utils\GlobalConstant::CASE_AWAITING_UPDATE_FR_CLIENT ? 'selected' : ''}}>
                                                {{ \App\Utils\GlobalConstant::CASE_AWAITING_UPDATE_FR_CLIENT }}</option>


                                            <option value="{{ \App\Utils\GlobalConstant::CASE_UNDER_LITIGATION }}" {{ $case->current_status == \App\Utils\GlobalConstant::CASE_UNDER_LITIGATION ? 'selected' : ''}}>
                                                {{ \App\Utils\GlobalConstant::CASE_UNDER_LITIGATION }}</option>

                                                <option value="{{ \App\Utils\GlobalConstant::CASE_CLOSED }}">
                                                    {{ \App\Utils\GlobalConstant::CASE_CLOSED }}</option>
                                        </select>
                                        @error('current_status')
                                            <p class="error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                            {{-- <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Collection Commission</label>
                                            <input type="text" name="collection_commission" class="form-control"
                                                value="{{ $case->collection_commission }}">
                                            @error('collection_commission')
                                                <p class="error">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Field Visits</label>
                                            <input type="text" name="field_visit" class="form-control"
                                                value="{{ $case->field_visit }}">
                                            @error('field_visit')
                                                <p class="error">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div> --}}

{{--                            <div class="card">--}}
{{--                                <div class="card-body">--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="mb-3 col-md-3">--}}
{{--                                            <label class="form-label">DB Name <span class="error">*</span></label>--}}
{{--                                            <input type="text" name="name" class="form-control" value="{{ $case->name }}">--}}
{{--                                            @error('name')--}}
{{--                                                <p class="error">{{ $message }}</p>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}

{{--                                        <div class="mb-3 col-md-3">--}}
{{--                                            <label class="form-label">DB NRIC</label>--}}
{{--                                            <input type="text" name="nric" class="form-control" value="{{ $case->nric }}">--}}
{{--                                            @error('nric')--}}
{{--                                                <p class="error">{{ $message }}</p>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}

{{--                                        <div class="mb-3 col-md-3">--}}
{{--                                            <label class="form-label">DB Company Name</label>--}}
{{--                                            <input type="text" name="company_name" class="form-control"--}}
{{--                                                value="{{ $case->nric }}">--}}
{{--                                            @error('company_name')--}}
{{--                                                <p class="error">{{ $message }}</p>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}

{{--                                        <div class="mb-3 col-md-3">--}}
{{--                                            <label class="form-label">DB Company UEN</label>--}}
{{--                                            <input type="text" name="company_uen" class="form-control"--}}
{{--                                                value="{{ $case->company_uen }}">--}}
{{--                                            @error('company_uen')--}}
{{--                                                <p class="error">{{ $message }}</p>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}

{{--                                        <div class="mb-3 col-md-3">--}}
{{--                                            <label class="form-label">DB Email</label>--}}
{{--                                            <input type="email" name="email" class="form-control" value="{{ $case->email }}">--}}
{{--                                            @error('email')--}}
{{--                                                <p class="error">{{ $message }}</p>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                        <div class="mb-3 col-md-3">--}}
{{--                                            <label class="form-label">DB Phone</label>--}}
{{--                                            <input type="text" name="phone" class="form-control" value="{{ $case->phone }}">--}}
{{--                                            @error('phone')--}}
{{--                                                <p class="error">{{ $message }}</p>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                        <div class="mb-3 col-md-3">--}}
{{--                                            <label class="form-label">DB Address</label>--}}
{{--                                            <input type="text" name="adderss" class="form-control" value="{{ $case->adderss }}">--}}
{{--                                            @error('adderss')--}}
{{--                                                <p class="error">{{ $message }}</p>--}}
{{--                                            @enderror--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

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
                                        $oldDebtors = $debtors;
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

                            {{-- <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Debt Amount</label>
                                            <input type="number" name="debt_amount" class="form-control"
                                                value="{{ $case->debt_amount }}">
                                            @error('debt_amount')
                                                <p class="error">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Legal Cost</label>
                                            <input type="number" name="legal_cost" class="form-control"
                                                value="{{ $case->legal_cost }}">
                                            @error('legal_cost')
                                                <p class="error">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Debt Interest/Annum</label>
                                            <input type="number" name="debt_interest" class="form-control"
                                                value="{{ $case->debt_interest }}">
                                            @error('debt_interest')
                                                <p class="error">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Interest Start Date</label>
                                            <input type="date" name="interest_start_date" class="form-control"
                                                value="{{ date('Y-m-d', strtotime($case->interest_start_date)) }}">
                                            @error('interest_start_date')
                                                <p class="error">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Interest End Date</label>
                                            <input type="date" name="interest_end_date" class="form-control"
                                                value="{{ date('Y-m-d', strtotime($case->interest_start_date)) }}">
                                            @error('interest_end_date')
                                                <p class="error">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Total Amount Owed</label>
                                            <input type="number" name="total_amount_owed" class="form-control"
                                                value="{{ $case->total_amount_owed }}">
                                            @error('total_amount_owed')
                                                <p class="error">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Total Interest</label>
                                            <input type="number" name="total_interest" class="form-control"
                                                value="{{ $case->total_interest }}">
                                            @error('total_interest')
                                                <p class="error">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Total Amount Paid</label>
                                            <input type="Number" name="total_amount_paid" class="form-control"
                                                value="{{ $case->total_amount_paid }}">
                                            @error('total_amount_paid')
                                                <p class="error">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Total Amount Balance</label>
                                            <input type="Number" name="total_amount_balance" class="form-control"
                                                value="{{ $case->total_amount_balance }}">
                                            @error('total_amount_balance')
                                                <p class="error">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            {{-- <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Administrative Fee</label>
                                            <input type="number" name="administrative_fee" class="form-control"
                                                placeholder="Enter Administrative Fee" value="{{ $case->administrative_fee }}">
                                            @error('administrative_fee')
                                                <p class="error">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Enforcement Fee</label>
                                            <input type="number" name="enforcement_fee" class="form-control"
                                                placeholder="Enter Enforcement Fee" value="{{ $case->enforcement_fee }}">
                                            @error('enforcement_fee')
                                                <p class="error">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Professional Fee</label>
                                            <input type="number" name="professional_fee" class="form-control"
                                                placeholder="Enter Professional Fee" value="{{ $case->professional_fee }}">
                                            @error('professional_fee')
                                                <p class="error">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Annual Fee</label>
                                            <input type="number" name="annual_fee" class="form-control"
                                                placeholder="Enter Annual Fee" value="{{ $case->annual_fee }}">
                                            @error('annual_fee')
                                                <p class="error">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Skip-Tracing Fee</label>
                                            <input type="number" name="skip_tracing_fee" class="form-control"
                                                placeholder="Enter Skip Tracing Fee" value="{{ $case->skip_tracing_fee }}">
                                            @error('skip_tracing_fee')
                                                <p class="error">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Overseas Allowance</label>
                                            <input type="number" name="overseas_allowance" class="form-control"
                                                placeholder="Enter Overseas Allowance" value="{{ $case->overseas_allowance }}">
                                            @error('overseas_allowance')
                                                <p class="error">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
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
                    </form>
                </div>
            </div>
@endsection

@push('script')
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
@endpush
@push('style')
@endpush
