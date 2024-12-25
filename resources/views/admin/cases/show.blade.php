@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12 parent-fixed">
            <div class="fixed-content">
                <div class="card bg-primary text-white" id="fixedDiv">
                    <div class="card-body card-padding-start">
                        <div class="row">
                            <div class="col-md-3">
                                <span>Case No. : {{ $case->case_sku }}</span> <br>
                                <span>Current Status : {{ $case->current_status }}</span> <br>
                                <span>Bal Field Visit : {{ $case->bal_field_visit }}</span> <br>
                                {{-- <span>Field Visits :  {{ $case->field_visit }}</span> <br>
                                    <span>Bal Field Visits : {{ $case->bal_field_visit }}</span> <br> --}}
                            </div>
                            <div class="col-md-3">
                                {{-- <span>Debt Interest/Annum : {{ $case->debt_interest }} %</span> <br>
                                <span>Total Interest : $ {{ number_format($case->total_interest, 2, '.', ',') }} </span> <br> --}}
                                {{-- <span>Total Installment : {{ $case->installment_number }}</span> <br>
                                    <span>Per Installment Amount : {{ number_formatCase($case->per_installment_amount, 2, '.', ',') }} $</span> <br> --}}
                                <span>Client Name : {{ $case->client->name }} </span> <br>
                                <span>Debtor Name : {{ $case->name }} </span> <br>
                                {{-- <span>Legal Cost Amount :$ {{ number_format($case->legal_cost, 2, '.', ',') }}</span> --}}
                            </div>
                            <div class="col-md-3">
                                {{-- <span>Debt Amount : {{ number_format($case->debt_amount, 2, '.', ',') }} $</span> <br> --}}
                                <span>Total Amount Owed : $ {{ number_format($case->total_amount_owed, 2, '.', ',') }}
                                </span> <br>
                                {{-- <span>Last Amount Paid : {{ number_format($case->total_amount_paid, 2, '.', ',') }} $</span> <br> --}}
                                <span>Amount Balance : $ {{ totalBalance($case->id) }}</span><br>
                                {{-- <span>Legal Cost Collected Amount : $
                                    {{ number_format($case->legal_cost_received, 2, '.', ',') }}
                                </span> --}}

                            </div>
                            <div class="col-md-3">
                                {{-- <span>Debt Amount : {{ number_format($case->debt_amount, 2, '.', ',') }} $</span> <br> --}}
                                <span>Next Payment Amount :

                                    @if (empty($installment->next_payment_amount))
                                        <span>N/A</span>
                                    @else
                                        $ {{ number_format($installment->next_payment_amount, 2, '.', ',') }}
                                    @endif

                                </span> <br>
                                <span>Next Payment Date :
                                    @if (empty($installment->next_payment_date))
                                        <span>N/A</span>
                                    @else
                                        {{ date('m-d-Y', strtotime($installment->next_payment_date)) }}
                                    @endif
                                </span><br>
                                {{-- <span>Legal Cost :
                                    {{ $case->legal_cost - $case->legal_cost_received == 0 ? 'Paid' : 'Unpaid' }} </span> --}}

                                {{-- date('d-m-Y', strtotime($installment->next_payment_date)) --}}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">SL</th>
                                <th scope="col">Employee Name</th>
                                <th scope="col">Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($installmentByEmployees as $installmentByEmployee)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td> {{ $installmentByEmployee->user->name }}</td>
                                    <td>{{ $installmentByEmployee->total_amounts != null ? '$ ' . number_format($installmentByEmployee->total_amounts, 2, '.', ',') : 'N/A' }}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {{-- {{ $installmentByEmployees->links() }} --}}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div id="success" class="text-success"></div>
            <div class="card">
                <div class="card-header text-center">General Update</div>
                <div class="card-body">
                    <form enctype="multipart/form-data" action="{{ route('general.case.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">

                        <div class="mb-3">
                            <label class="form-label">Gn Case Update</label>
                            <input type="file" name="gn_updates[]" multiple class="form-control">
                            @error('gn_updates')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Amount Paid</label>
                            <input type="number" step="0.01" min="0" max="10000000000000" name="amount_paid"
                                placeholder="Enter Paid Amount Here" class="form-control">
                            @error('amount_paid')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- @if ($case->legal_cost - $case->legal_cost_received != 0)
                            <div class="mb-3">
                                <label class="form-label">Legal Cost</label>
                                <input type="number" name="legal_cost" value="{{ $case->legal_cost }}"
                                    class="form-control">
                                @error('legal_cost')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif --}}
                        <div class="mb-3">
                            <label class="form-label">Payment Method</label>
                            <select class="form-select" aria-label="Default select example" name="payment_method">
                                <option selected>Select One Payment Method</option>
                                <option value="Cash">Cash</option>
                                <option value="Check">Check</option>
                                <option value="Online">Online</option>
                            </select>
                            @error('paid_amount')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Whom To Assign</label>
                            <select class="form-select" aria-label="Default select example" name="assign_type">
                                <option selected>Select One</option>
                                <option value="Admin">Admin</option>
                                <option value="Accounts">Accounts</option>
                                <option value="Noone">Don't assign to anyone</option>
                            </select>
                            @error('assign_type')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Collected By</label>
                            <select class="form-select select2" id="collected_by_id" name="collected_by_id"
                                aria-label="Default select example">
                                <option selected disabled>Select Employee</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                            @error('collected_by_id')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date of Payment</label>
                            <input type="date" name="payment_date" class="form-control">
                            @error('payment_date')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Next Payment Amount</label>
                            <input type="number" step="0.01" min="0" max="10000000000000"
                                name="next_payment_amount" class="form-control" placeholder="Enter Next Payment Amount"
                                id="next_payment_amount">
                            @error('next_payment_amount')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Next Payment Date</label>
                            <input type="date" name="next_payment_date" class="form-control"
                                placeholder="Enter Next Payment Date">
                            @error('next_payment_date')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Field Visit Date</label>
                            <input type="date" name="fv_date" class="form-control">
                            @error('fv_date')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gn Summary</label>
                            <textarea name="gn_summary" class="form-control" id="" rows="2"></textarea>
                            @error('gn_summary')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Remarks</label>
                            <input type="text" name="remarks" class="form-control" placeholder="Enter Remarks Here">
                            @error('remarks')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">

                        <div class="row">
                            <div class="mb-3 text-end">
                                <a href="{{ route('admin.cases.show', $case->id) }}" class="btn btn-light">Cancel</a>
                                <button class="btn btn-primary waves-effect waves-lightml-2 " type="submit">
                                    <i class="fa fa-save"></i> Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5>General updates</h5>
                    <div id="content">
                        <ul class="timeline">
                            @foreach ($gn_updates as $gn_update)
                                <li class="event"
                                    data-date="{{ date('m-d-Y', strtotime($gn_update->created_at)) }}, {{ date('h:i a', strtotime($gn_update->created_at)) }} ">
                                    <div>
                                        @php
                                            $extension = substr($gn_update->gn_update, -3);
                                        @endphp
                                        @if ($gn_update->gn_update != null)
                                            @if ($extension == 'pdf')
                                                <iframe style="overflow: hidden"
                                                    src="{{ asset('/documents/' . $gn_update->gn_update) }}"
                                                    width="100" height="100"></iframe>
                                            @else
                                                <img src="{{ asset('/documents/' . $gn_update->gn_update) }}"
                                                    width="100" height="100" />
                                            @endif
                                        @else
                                            <div class="d-flex align-items-center justify-content-center"
                                                style="background: rgb(168, 168, 168); height: 100px; width: 100px; color: #ffffff; border-radius: 4px">
                                                <small>No file to show</small>
                                            </div>
                                        @endif

                                    </div>
                                    <h6 class="mt-2">Field Visited at:
                                        {{ $gn_update->fv_date == null ? 'N/A' : date('m-d-Y', strtotime($gn_update->fv_date)) }}
                                    </h6>
                                    <span class="d-block">{{ $gn_update->gn_summary }}</span>
                                    <div>
                                        <a href="#" class="btn  btn-primary mt-2 viewFVUpdate" data-toggle="modal"
                                            data-target="#exampleModal">
                                            <span class="gn_id d-none">{{ $gn_update->id }}</span>
                                            <i class="far fa-eye"></i> View
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal for GN Update -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Gn Update</h5>
                    </div>
                    <div class="modal-body">
                        <iframe id="gn_update" src="" class="mt-2" width="100%" height="400">
                        </iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center">Field Visit Update</div>
                <div class="card-body">
                    <form enctype="multipart/form-data" action="{{ route('field.visit.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">
                        <div class="mb-3">
                            <label class="form-label">FV Update</label>
                            <input type="file" name="fv_updates[]" class="form-control" multiple>
                            @error('fv_updates')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Amount Paid</label>
                            <input type="number" step="0.01" min="0" max="10000000000000" name="amount_paid"
                                placeholder="Enter Paid Amount Here" class="form-control">
                            @error('amount_paid')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- @if ($case->legal_cost != 0)
                            <div class="mb-3">
                                <label class="form-label">Legal Cost</label>
                                <input type="number" name="legal_cost" value="{{ $case->legal_cost }}"
                                    class="form-control">
                                @error('legal_cost')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif --}}
                        <div class="mb-3">
                            <label class="form-label">Payment Method</label>
                            <select class="form-select" aria-label="Default select example" name="payment_method">
                                <option selected>Select One Payment Method</option>
                                <option value="Cash">Cash</option>
                                <option value="Check">Check</option>
                                <option value="Online">Online</option>
                            </select>
                            @error('paid_amount')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Whom To Assign</label>
                            <select class="form-select" aria-label="Default select example" name="assign_type">
                                <option selected>Select One</option>
                                <option value="Admin">Admin</option>
                                <option value="Accounts">Accounts</option>
                                <option value="Noone">Don't assign to anyone</option>
                            </select>
                            @error('assign_type')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Collected By</label>
                            <select class="form-select select2" id="collected_by_2" name="collected_by_id"
                                aria-label="Default select example">
                                <option selected disabled>Select Employee</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                            @error('collected_by_id')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date of Payment</label>
                            <input type="date" name="payment_date" class="form-control">
                            @error('payment_date')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Next Payment Amount</label>
                            <input type="number" step="0.01" min="0" max="10000000000000"
                                name="next_payment_amount" class="form-control" placeholder="Enter Next Payment Amount"
                                id="next_payment_amount">
                            @error('next_payment_amount')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Next Payment Date</label>
                            <input type="date" name="next_payment_date" class="form-control"
                                placeholder="Enter Interest Start Date">
                            @error('next_payment_date')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Field Visit Date</label>
                            <input type="date" name="fv_date" class="form-control">
                            @error('fv_date')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">FV Summary</label>
                            <textarea name="fv_summary" class="form-control" id="" rows="2"></textarea>
                            @error('fv_summary')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Remarks</label>
                            <input type="text" name="remarks" class="form-control" placeholder="Enter Remarks Here">
                            @error('remarks')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">

                        <div class="row">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <div class="div">
                                        <a href="{{ route('admin.cases.show', $case->id) }}"
                                            class="btn btn-light">Cancel</a>
                                        <button class="btn btn-primary waves-effect waves-lightml-2 " type="submit">
                                            <i class="fa fa-save"></i> Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5>Field Visit Updates</h5>
                    <div id="content">
                        <ul class="timeline">
                            @foreach ($fv_updates as $fv_update)
                                <li class="event"
                                    data-date="{{ date('m-d-Y', strtotime($fv_update->created_at)) }}, {{ date('h:i a', strtotime($fv_update->created_at)) }} ">


                                    @php
                                        $extension = substr($fv_update->fv_update, -3);
                                    @endphp
                                    @if ($fv_update->fv_update != null)
                                        @if ($extension == 'pdf')
                                            <iframe style="overflow: hidden"
                                                src="{{ asset('/documents/' . $fv_update->fv_update) }}" width="100"
                                                height="100"></iframe>
                                        @else
                                            <img src="{{ asset('/documents/' . $fv_update->fv_update) }}" width="100"
                                                height="100" />
                                        @endif
                                    @else
                                        <div class="d-flex align-items-center justify-content-center"
                                            style="background: rgb(168, 168, 168); height: 100px; width: 100px; color: #ffffff; border-radius: 4px">
                                            <small>No file to show</small>
                                        </div>
                                    @endif
                                    <h6 class="mt-2">Field Visited at:
                                        {{ $fv_update->fv_date == null ? 'N/A' : date('m-d-Y', strtotime($fv_update->fv_date)) }}
                                    </h6>
                                    <span class="d-block">{{ $fv_update->fv_summary }}</span>
                                    <div>
                                        <a href="#" class="btn  btn-primary mt-2 viewFVUpdate2" data-toggle="modal"
                                            data-target="#exampleModal2">
                                            <span class="fv_id d-none">{{ $fv_update->id }}</span>
                                            <i class="far fa-eye"></i> View
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal for FV Update -->
        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Feild Visit Update</h5>
                    </div>
                    <div class="modal-body">
                        <iframe id="fv_update" src="" class="mt-2" width="100%" height="400">
                        </iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center">CR Case Update</div>
                <div class="card-body">
                    <form enctype="multipart/form-data" action="{{ route('general.case.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">
                        <div class="mb-3">
                            <label class="form-label">CR Case Update</label>
                            <input type="file" name="cr_updates[]" class="form-control" multiple>
                            @error('cr_updates')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Field Visit Date</label>
                            <input type="date" name="fv_date" class="form-control">
                            @error('fv_date')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">CR Summary</label>
                            <textarea name="cr_summary" class="form-control" id="" rows="2"></textarea>
                            @error('cr_summary')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">

                        <div class="row">
                            <div class="mb-3 text-end">
                                <a href="{{ route('admin.cases.show', $case->id) }}" class="btn btn-light">Cancel</a>
                                <button class="btn btn-primary waves-effect waves-lightml-2 " type="submit">
                                    <i class="fa fa-save"></i> Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5>CR Updates</h5>
                    <div id="content">
                        <ul class="timeline">
                            @foreach ($cr_updates as $cr_update)
                                <li class="event"
                                    data-date="{{ date('d-m-Y', strtotime($cr_update->created_at)) }}, {{ date('h:i a', strtotime($cr_update->created_at)) }} ">
                                    <iframe src="{{ asset('/documents/' . $cr_update->cr_update) }}" width="400"
                                        height="400"></iframe>

                                    <h6 class="mt-2">Field Visited at:
                                        {{ date('d-m-Y', strtotime($cr_update->fv_date)) }}</h6>
                                    <span class="d-block">{{ $cr_update->cr_summary }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Modal for GN Update -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Gn Update</h5>
                        </div>
                        <div class="modal-body">
                            <iframe id="gn_update" src="" class="mt-2" width="100%" height="400">
                            </iframe>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- Test comment --}}
    {{-- <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center">MS Update</div>
                <div class="card-body">
                    <form enctype="multipart/form-data" action="{{ route('general.case.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">
                        <div class="mb-3">
                            <label class="form-label">MS Update</label>
                            <input type="file" name="ms_updates[]" class="form-control" multiple>
                            @error('ms_update')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Field Visit Date</label>
                            <input type="date" name="fv_date" class="form-control">
                            @error('fv_date')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">MS Summary</label>
                            <textarea name="ms_summary" class="form-control" id="" rows="2"></textarea>
                            @error('ms_summary')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">

                        <div class="row">
                            <div class="mb-3 text-end">
                                <a href="{{ route('admin.cases.show', $case->id) }}" class="btn btn-light">Cancel</a>
                                <button class="btn btn-primary waves-effect waves-lightml-2 " type="submit">
                                    <i class="fa fa-save"></i> Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5>MS Updates</h5>
                    <div id="content">
                        <ul class="timeline">
                            @foreach ($ms_updates as $ms_update)
                                <li class="event"
                                    data-date="{{ date('d-m-Y', strtotime($ms_update->created_at)) }}, {{ date('h:i a', strtotime($ms_update->created_at)) }} ">
                                    <iframe src="{{ asset('/documents/' . $ms_update->ms_update) }}" width="400"
                                        height="400"></iframe>

                                    <h6 class="mt-2">Field Visited at:
                                        {{ date('d-m-Y', strtotime($ms_update->fv_date)) }}</h6>
                                    <span class="d-block">{{ $ms_update->ms_summary }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- <div class="modal fade" id="exampleModal0" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Total Balance</h5>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update.total.amount.balance', $case->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="num1">Total Amount Balance</label>
                            <input type="number" class="form-control" readonly name="" id="num1"
                                aria-describedby="emailHelp" value="{{ $case->total_amount_balance }}">
                        </div>
                        <div class="form-group mt-2">
                            <label for="num2">Amount Paid</label>
                            <input type="number" class="form-control" name="total_amount_paid" id="num2"
                                value="">
                        </div>
                        <div class="form-group mt-2">
                            <label for="subt">Unpaid Amount Balance</label>
                            <input type="text" class="form-control" name="total_amount_balance" id="subt"
                                value="">
                        </div>
                        <button type="submit" class="btn btn-success mt-2">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
@push('script')
    <script src="{{ asset('/admin/js/passwordCheck.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {

            $('#collected_by, #collected_by_2').select2();

            $(function() {
                $("#num2").on("keydown keyup", sum);

                function sum() {
                    var result = Number($("#num1").val()) - Number($("#num2").val())
                    $("#subt").val(result.toFixed(2));
                }
            });
        });
        $(document).ready(function() {
            $('.viewFVUpdate').click(function(e) {
                var gn_update_id = $(this).find('.gn_id').text();
                $.ajax({
                    type: 'get',
                    url: '{{ route('single.general.case.update') }}',
                    data: {
                        id: gn_update_id
                    },
                    success: (response) => {
                        console.log(response);
                        let href = "{{ asset('/documents/') }}" + "/" + response.data
                            .gn_update
                        let gn_update = $('#gn_update').attr('src', href);
                    },
                    error: function(response) {
                        $('#error').text(response.responseJSON.message);
                    }

                });
            });

            $('.viewFVUpdate2').click(function(e) {
                var fv_update_id = $(this).find('.fv_id').text();
                $.ajax({
                    type: 'get',
                    url: '{{ route('single.field.vist.update') }}',
                    data: {
                        id: fv_update_id
                    },
                    success: (response) => {
                        let href = "{{ asset('/documents/') }}" + "/" + response.data
                            .fv_update
                        let fv_update = $('#fv_update').attr('src', href);
                    },
                    error: function(response) {
                        $('#error').text(response.responseJSON.message);
                    }

                });
            });
        });
    </script>
    <script>
        window.addEventListener('scroll', function() {
            var fixedDiv = document.getElementById('fixedDiv');
            var scrollPosition = window.scrollY;

            // Adjust the threshold as needed
            var threshold = 200; // Pixels from the top to fix the div

            if (scrollPosition > threshold) {
                // Add a class to the div to make it fixed
                fixedDiv.classList.add('fixed-top');
            } else {
                // Remove the class if scroll position is less than threshold
                fixedDiv.classList.remove('fixed-top');
            }
        });
    </script>
@endpush
@push('style')
    <style>
        .card-padding-start {
            padding-left: 70px;
        }

        .fixed {
            position: absolute;
            width: 100%;
            background-color: #f1f1f1;
            padding: 10px 0;
            transition: top 0.3s;
            z-index: 9999;
            /* For smooth transition */
        }

        /* Style for the fixed div when it's fixed */
        .fixed.fixed-top {
            position: fixed;
            top: 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .timeline {
            border-left: 3px solid #858AB6;
            border-bottom-right-radius: 4px;
            border-top-right-radius: 4px;
            margin: 0 auto;
            letter-spacing: 0.2px;
            position: relative;
            line-height: 1.4em;
            font-size: 1.03em;
            padding: 50px;
            list-style: none;
            text-align: left;
            max-width: 60%;
        }

        .btn-color {
            background-color: #858AB6;
            outline: none;
            border: 0
        }

        .btn-color:hover {
            background-color: #858AB6;
            outline: none;
            border: 0
        }

        @media (max-width: 767px) {
            .timeline {
                max-width: 98%;
                padding: 25px;
            }
        }

        .timeline h1 {
            font-weight: 300;
            font-size: 1.4em;
        }

        .timeline h2,
        .timeline h3 {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 10px;
        }

        .timeline .event {
            border-bottom: 1px dashed #e8ebf1;
            padding-bottom: 25px;
            margin-bottom: 25px;
            position: relative;
        }

        @media (max-width: 767px) {
            .timeline .event {
                padding-top: 30px;
            }
        }

        .timeline .event:last-of-type {
            padding-bottom: 0;
            margin-bottom: 0;
            border: none;
        }

        .timeline .event:before,
        .timeline .event:after {
            position: absolute;
            display: block;
            top: 0;
        }

        .timeline .event:before {
            left: -207px;
            content: attr(data-date);
            text-align: right;
            font-weight: 100;
            font-size: 0.9em;
            min-width: 120px;
        }

        @media (max-width: 767px) {
            .timeline .event:before {
                left: 0px;
                text-align: left;
            }
        }

        .timeline .event:after {
            -webkit-box-shadow: 0 0 0 3px #858AB6;
            box-shadow: 0 0 0 3px #858AB6;
            left: -55.8px;
            background: #fff;
            border-radius: 50%;
            height: 9px;
            width: 9px;
            content: "";
            top: 5px;
        }

        @media (max-width: 767px) {
            .timeline .event:after {
                left: -31.8px;
            }
        }

        .rtl .timeline {
            border-left: 0;
            text-align: right;
            border-bottom-right-radius: 0;
            border-top-right-radius: 0;
            border-bottom-left-radius: 4px;
            border-top-left-radius: 4px;
            border-right: 3px solid #727cf5;
        }

        .rtl .timeline .event::before {
            left: 0;
            right: -170px;
        }

        .rtl .timeline .event::after {
            left: 0;
            right: -55.8px;
        }

        /* .fixed-content{
                                                                                                                position: fixed;
                                                                                                                z-index: 9999;
                                                                                                                width: 70%;
                                                                                                            } */
        /* .balance-btn{
                                                                                                                padding-top: 100px;
                                                                                                            } */
    </style>
@endpush
