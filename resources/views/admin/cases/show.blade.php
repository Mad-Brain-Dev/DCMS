@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center">
                    Case
                </div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row">Key</th>
                                <td>Value</td>
                            </tr>
                            <tr>
                                <th scope="row">Case Number</th>
                                <td>{{ $case->case_number }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Current Status</th>
                                <td>{{ $case->current_status }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Date of Agreement</th>
                                <td>{{ $case->date_of_agreement }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Date of Expiry</th>
                                <td>{{ $case->date_of_expiry }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Client Name</th>
                                <td>{{ $case->client->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Collection Commission</th>
                                <td>{{ $case->collection_commission }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Field Visit</th>
                                <td>{{ $case->field_visit }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Bal Field Visit</th>
                                <td>{{ $case->bal_field_visit }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Manager IC</th>
                                <td>{{ $case->manager_ic }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Collector IC</th>
                                <td>{{ $case->collector_ic }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Debtor Name</th>
                                <td>{{ $case->name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Debtor NRIC</th>
                                <td>{{ $case->nric }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Debtor Company Name</th>
                                <td>{{ $case->company_name }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Debtor Company UEN</th>
                                <td>{{ $case->company_uen }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Debtor Phone</th>
                                <td>{{ $case->phone }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Debtor Email</th>
                                <td>{{ $case->email }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Debtor Address</th>
                                <td>{{ $case->adderss }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Debt Amount</th>
                                <td>{{ $case->debt_amount }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Legal Cost</th>
                                <td>{{ $case->legal_cost }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Debt Interest</th>
                                <td>{{ $case->debt_interest }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Interest Start Date</th>
                                <td>{{ $case->interest_start_date }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Interest End Date</th>
                                <td>{{ $case->interest_start_date }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Total Interest</th>
                                <td>{{ $case->total_interest }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Total Amount Owed</th>
                                <td>{{ $case->total_amount_owed }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Total Amount Paid</th>
                                <td>{{ $case->total_amount_paid }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Total Amount Balance</th>
                                <td>{{ $case->total_amount_balance }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="div">
                    <a href="{{ URL('/show/field/visit/update/'.$case->id )}}" class="btn btn-primary">View FV Update</a>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div id="success" class="text-success"></div>
            <div class="card">
                <div class="card-header text-center">GN Case Update</div>
                <div class="card-body">
                    <form enctype="multipart/form-data" action="{{ route('general.case.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">
                        <div class="mb-3">
                            <label class="form-label">GN Case Update</label>
                            <input type="file" name="gn_update" class="form-control">
                            @error('gn_update')
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
                            <label class="form-label">GN Case Summary</label>
                            <textarea name="gn_summary" class="form-control" id="" rows="2"></textarea>
                            @error('gn_summary')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">

                        <div class="row">
                            <div class="mb-3 text-end">
                                <div>
                                    <button class="btn btn-primary waves-effect waves-lightml-2 " type="submit">
                                        <i class="fa fa-save"></i> Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    @foreach ($gn_updates as $gn_update)
                        <div class="mt-5"> <span>Created at:</span>
                        {{ date('d-m-Y', strtotime($gn_update->created_at)) }},
                        {{ date('h:i a', strtotime($gn_update->created_at)) }} </div>
                    <iframe src="{{ asset('storage/document/' . $gn_update->gn_update) }}" class="mt-2"
                        width="100%"></iframe>


                        <div class="div text-end mt-2">
                            @csrf
                            <a href="#" class="btn btn-primary mt-2 viewGNUpdate" data-toggle="modal"
                                data-target="#exampleModal">
                                <span class="gn_id d-none">{{ $gn_update->id }}</span>
                                <i class="far fa-eye"></i> View
                            </a>
                        </div>
                        <div class="mt-2">Field Visited At: {{ date('d-m-Y', strtotime($gn_update->fv_date)) }}</div>
                        <div class="mt-2">{{ $gn_update->gn_summary }}</div>
                        <hr class="mt-3">
                    @endforeach

                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div id="success" class="text-success"></div>
            <div class="card">
                <div class="card-header text-center">CR Update</div>
                <div class="card-body">
                    <form enctype="multipart/form-data" action="{{ route('general.case.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">
                        <div class="mb-3">
                            <label class="form-label">CR Update</label>
                            <input type="file" name="cr_update" class="form-control">
                            @error('cr_update')
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
                                <div>
                                    <button class="btn btn-primary waves-effect waves-lightml-2 " type="submit">
                                        <i class="fa fa-save"></i> Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    @foreach ($cr_updates as $cr_update)
                        <div class="mt-5"> <span>Created at:</span>
                        {{ date('d-m-Y', strtotime($cr_update->created_at)) }},
                        {{ date('h:i a', strtotime($cr_update->created_at)) }} </div>
                    <iframe src="{{ asset('storage/document/' . $cr_update->cr_update) }}" class="mt-2"
                        width="100%"></iframe>


                        <div class="div text-end mt-2">
                            @csrf
                            <a href="#" class="btn btn-primary mt-2 viewGNUpdate" data-toggle="modal"
                                data-target="#exampleModal">
                                <span class="gn_id d-none">{{ $cr_update->id }}</span>
                                <i class="far fa-eye"></i> View
                            </a>
                        </div>
                        <div class="mt-2">Field Visited At: {{ date('d-m-Y', strtotime($cr_update->fv_date)) }}</div>
                        <div class="mt-2">{{ $cr_update->cr_summary }}</div>
                        <hr class="mt-3">
                    @endforeach

                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div id="success" class="text-success"></div>
            <div class="card">
                <div class="card-header text-center">FV Update</div>
                <div class="card-body">
                    <form enctype="multipart/form-data" action="{{ route('general.case.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">
                        <div class="mb-3">
                            <label class="form-label">FV Update</label>
                            <input type="file" name="fv_update" class="form-control">
                            @error('cr_update')
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
                        <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">

                        <div class="row">
                            <div class="mb-3 text-end">
                                <div>
                                    <button class="btn btn-primary waves-effect waves-lightml-2 " type="submit">
                                        <i class="fa fa-save"></i> Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="mt-5">
                        <h6 class="bg-success d-inline px-3 py-1 rounded-1 text-white">Bal FV: {{ $case->field_visit }}</h6>
                    </div>

                    @foreach ($fv_updates as $fv_update)
                        <div class="mt-2"> <span>Created at:</span>
                        {{ date('d-m-Y', strtotime($fv_update->created_at)) }},
                        {{ date('h:i a', strtotime($fv_update->created_at)) }} </div>
                    <iframe src="{{ asset('storage/document/' . $fv_update->fv_update) }}" class="mt-2"
                        width="100%"></iframe>
                        <div class="div text-end mt-2">
                            @csrf
                            <a href="#" class="btn btn-primary mt-2 viewGNUpdate" data-toggle="modal"
                                data-target="#exampleModal">
                                <span class="gn_id d-none">{{ $fv_update->id }}</span>
                                <i class="far fa-eye"></i> View
                            </a>
                        </div>
                        <div class="mt-2">Field Visited At: {{ date('d-m-Y', strtotime($fv_update->fv_date)) }}</div>
                        <div class="mt-2">{{ $fv_update->fv_summary }}</div>
                        <hr class="mt-3">
                    @endforeach

                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div id="success" class="text-success"></div>
            <div class="card">
                <div class="card-header text-center">MS Update</div>
                <div class="card-body">
                    <form enctype="multipart/form-data" action="{{ route('general.case.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">
                        <div class="mb-3">
                            <label class="form-label">Ms Update</label>
                            <input type="file" name="ms_update" class="form-control">
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
                                <div>
                                    <button class="btn btn-primary waves-effect waves-lightml-2 " type="submit">
                                        <i class="fa fa-save"></i> Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    @foreach ($ms_updates as $ms_update)
                        <div class="mt-5"> <span>Created at:</span>
                        {{ date('d-m-Y', strtotime($ms_update->created_at)) }},
                        {{ date('h:i a', strtotime($ms_update->created_at)) }} </div>
                    <iframe src="{{ asset('storage/document/' . $ms_update->ms_update) }}" class="mt-2"
                        width="100%"></iframe>


                        <div class="div text-end mt-2">
                            @csrf
                            <a href="#" class="btn btn-primary mt-2 viewGNUpdate" data-toggle="modal"
                                data-target="#exampleModal">
                                <span class="gn_id d-none">{{ $ms_update->id }}</span>
                                <i class="far fa-eye"></i> View
                            </a>
                        </div>
                        <div class="mt-2">Field Visited At: {{ date('d-m-Y', strtotime($ms_update->fv_date)) }}</div>
                        <div class="mt-2">{{ $ms_update->ms_summary }}</div>
                        <hr class="mt-5">
                    @endforeach

                </div>
            </div>
        </div>

        <!-- Modal for GN Update -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                   <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">FV</h5>
                    </div>
                     <div class="modal-body">
                        <iframe id="fv_update" src="" class="mt-2"
                            width="100%" height="400">
                        </iframe>
                        <div class="d-flex justify-content-between mt-3">
                            <p id="field_visited_at"></p>
                            <p id="created_at"></p>
                        </div>
                            <p>{{ $fv_update->fv_summary }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('/admin/js/passwordCheck.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <script>
        $(document).ready(function() {
            $('.viewGNUpdate').click(function(e) {
                var gn_update_id = $(this).find('.gn_id').text();
                $.ajax({
                    type: 'get',
                    url:'{{ route("single.general.update") }}',
                    data:{
                        id : gn_update_id
                    },
                    success: (response) => {
                        console.log(response);
                            let href = "{{ asset('/storage/document/') }}" + "/" + response.data.fv_update
                            let fv_update = $('#fv_update').attr('src', href);
                            let field_visited_at = $('#field_visited_at').text('Field Visited at : ' + response.data.fv_date);
                            let created_at = $('#created_at').text('Created at : ' + response.data.created_at);
                    },
                    error: function(response) {
                        $('#error').text(response.responseJSON.message);
                    }

                });
            });
        });
    </script>
@endpush
