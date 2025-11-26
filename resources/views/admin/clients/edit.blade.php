@extends('layouts.master')

@section('content')
    <div class="row">
        <div id="loading">
            <div id="loading-content">
            </div>
        </div>
        <div class="col-md-12">
            <h4 class="card-title mb-3">{{ get_page_meta('title', true) }}</h4>
            <form method="post" id="frmAppl" action="{{ route('admin.clients.update', $client->id) }}">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label class="form-label">CL Name <span class="error">*</span></label>
                                <input type="text" name="name" class="form-control" placeholder="Enter CL Name"
                                    value="{{ $client->name }}">
                                @error('name')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">CL Name Abbr <span class="error">*</span></label>
                                <input type="text" name="abbr" class="form-control" placeholder="Enter CL Name"
                                    value="{{ $client->abbr }}">
                                @error('abbr')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">CL ID</label>
                                <input type="text" name="nric" class="form-control" placeholder="Enter CL NRIC"
                                    value="{{ $client->nric }}">
                                @error('nric')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

{{--                            <div class="mb-3 col-md-3">--}}
{{--                                <label class="form-label">Company Name</label>--}}
{{--                                <input type="text" name="company_name" class="form-control"--}}
{{--                                    placeholder="Enter CL Company Name" value="{{ $client->company_name }}">--}}
{{--                                @error('company_name')--}}
{{--                                    <p class="error">{{ $message }}</p>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                            <div class="mb-3 col-md-3">--}}
{{--                                <label class="form-label">Company UEN</span></label>--}}
{{--                                <input type="text" name="company_uen" class="form-control"--}}
{{--                                    placeholder="Enter CL Company Uen" value="{{$client->company_uen}}">--}}
{{--                                @error('company_uen')--}}
{{--                                    <p class="error">{{ $message }}</p>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
                            <div class="mb-3 col-md-3">
                                <label class="form-label">PIC Name</label>
                                <input type="text" name="pic_name" class="form-control"
                                       placeholder="Enter PIC Name" value="{{$client->pic_name}}">
                                @error('pic_name')
                                <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">PIC Number</label>
                                <input type="text" name="pic_number" class="form-control"
                                       placeholder="Enter PIC Number" value="{{$client->pic_number}}">
                                @error('pic_number')
                                <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">PIC Email</label>
                                <input type="text" name="pic_email" class="form-control"
                                       placeholder="Enter PIC email" value="{{$client->pic_email}}">
                                @error('pic_email')
                                <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            {{-- <div class="mb-3 col-md-4">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control"
                                    placeholder="Enter CL Email Address" value="{{$client->email}}">
                                @error('email')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div> --}}
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control"
                                    placeholder="Enter CL Phone Number" value="{{$client->phone}}">
                                @error('phone')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" placeholder="Enter Address Here"
                                    value="{{$client->address}}">
                                @error('address')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Admin Fee</label>
                                <input type="number" name="admin_fee" class="form-control" id="num1"
                                    placeholder="Enter Admin Fee" value="{{ old('admin_fee') }}">
                                @error('admin_fee')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Admin Fee Paid</label>
                                <input type="number" name="admin_fee_paid" class="form-control" id="num2"
                                    placeholder="Enter Admin Fee Paid Amount">
                                @error('admin_fee_paid')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Admin Fee Balance</label>
                                <input type="number" name="admin_fee_balance"
                                    placeholder="Admin Fee Balance will Auto Calculate" class="form-control" readonly
                                    id="subt">
                                @error('admin_fee_balance')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Collection Commission (%)</label>
                                <input type="number" name="collection_commission" class="form-control"
                                    placeholder="Enter Collection Commission (%)"
                                    value="{{ old('collection_commission') }}">
                                @error('collection_commission')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Collected By</label>
                                <select class="form-select select2" id="current_status" name="collected_by"
                                    aria-label="Default select example">
                                    <option selected disabled>Select Employee</option>
                                    @foreach ($employees as $employee )
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach

                                </select>
                                @error('collected_by')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Collection Date</label>
                                <input type="date" name="collection_date" class="form-control"
                                    placeholder="Collection Date" value="{{ old('collection_date') }}">
                                @error('collection_date')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Date of Agreement</label>
                                <input type="date" name="date_of_agreement" class="form-control"
                                    placeholder="Address" value="{{ old('date_of_agreement') }}">
                                @error('date_of_agreement')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Date of Expiry</label>
                                <input type="date" name="date_of_expiry" class="form-control" placeholder="Address"
                                    value="{{ old('date_of_expiry') }}">
                                @error('date_of_expiry')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-3">
                                <label class="form-label">Total Field Visit</label>
                                <input type="number" name="field_visit_per_case" class="form-control"
                                    placeholder="Total Field Visit" value="{{ old('field_visit_per_case') }}">
                                @error('field_visit_per_case')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="row">
                    <div class="mb-3 offset-md-6 col-md-6">
                        <div class="text-end">
                            <button class="btn btn-primary waves-effect waves-lightml-2 me-2" id="submitBtn"
                                type="submit">
                                <i class="fa fa-save"></i> Save
                            </button>

                            <a class="btn btn-secondary waves-effect" href="{{ route('admin.clients.index') }}">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>


            </form>
        </div>
    </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="showMsg">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body" style="text-align: center;">
                    <h4 class="pb-3">Do you want to print this agreement?</h4>
                </div>
                <div class="modal-footer d-flex justify-content-between" style="border: none;">
                    <a class="btn btn-success" id="agreement" href="">Yes, Print It</a>
                    <a href="{{ route('admin.clients.index') }}" class="btn btn-danger"
                        class="btn btn-secondary">Close</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('/admin/js/passwordCheck.js') }}"></script>
    {{-- <script>
        $(document).ajaxStart(function() {
            $('#loading').addClass('loading');
            $('#loading-content').addClass('loading-content');
        });
        $(document).ajaxStop(function() {
            $('#loading').removeClass('loading');
            $('#loading-content').removeClass('loading-content');
        });
        $(document).ready(function() {
            $(function() {
                $("#num2").on("keydown keyup", sum);

                function sum() {
                    $("#subt").val(Number($("#num1").val()) - Number($("#num2").val()));
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

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ route('admin.clients.update') }}",
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
                            $("#frmAppl")[0].reset();
                            $("#showMsg").modal('show');
                            var url = "/printable/client/agreement/" + data.result.id

                            $('#agreement').attr('href', url);

                        } else {
                            $.each(data.error, function(key, value) {
                                var el = $(document).find('[name="' + key + '"]');
                                el.after($('<span class= "err-msg">' + value[0] +
                                    '</span>'));

                            });
                        }
                        $("#submitBtn").prop('disabled', false);
                    },
                    error: function(err) {
                        $("#message").html("Some Error Occurred!")
                    }
                });
            });

        });
    </script> --}}
@endpush
@push('style')
    <style>
        .err-msg {
            color: #ec4561;
            font-size: 12px;
        }

        .loading {
            z-index: 2000;
            position: absolute;
            top: 0;
            left: -5px;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .loading-content {
            position: absolute;
            border: 16px solid #f3f3f3;
            border-top: 16px solid #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            top: 40%;
            left: 50%;
            animation: spin 2s linear infinite;
        }
        @keyframes spin{
            0% {transform: rotate(0deg);}
            100% {transform: rotate(360deg);}
        }
    </style>
@endpush
