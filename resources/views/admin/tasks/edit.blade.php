@extends('layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div id="success" class="text-success"></div>
                <div class="card">
                    <div class="card-body">
                        @if ($installment->update_type == "general_update")
                        <form enctype="multipart/form-data" action="{{ route("admin.tasks.update", $task->id) }}" method="POST">
                            @csrf
                            @method('PUT')
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
                                    placeholder="Enter Paid Amount Here" value="{{ $installment->amount_paid }}" class="form-control">
                                @error('amount_paid')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
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
                                <input type="number" step="0.01" min="0" max="10000000000000" value="{{ $installment->next_payment_amount }}"
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
                                <textarea name="gn_summary" class="form-control" id="" rows="2">{{ $general_case_update->gn_summary }}</textarea>
                                @error('gn_summary')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Remarks</label>
                                <input type="text" name="remarks" value="{{ $general_case_update->remarks }}" class="form-control" placeholder="Enter Remarks Here">
                                @error('remarks')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id"> --}}

                            <div class="row">
                                <div class="mb-3 text-end">
                                    <a href="" class="btn btn-light">Cancel</a>
                                    <button class="btn btn-primary waves-effect waves-lightml-2 " type="submit">
                                        <i class="fa fa-save"></i> Save
                                    </button>
                                </div>
                            </div>
                        </form>
                        @else
                        <form enctype="multipart/form-data" action="{{ route("admin.tasks.update", $task->id) }}" method="POST">
                            @csrf
                            @method('PUT')
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
                            {{-- <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id"> --}}

                            <div class="row">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <div class="div">
                                            <a href=""
                                                class="btn btn-light">Cancel</a>
                                            <button class="btn btn-primary waves-effect waves-lightml-2 " type="submit">
                                                <i class="fa fa-save"></i> Save
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
