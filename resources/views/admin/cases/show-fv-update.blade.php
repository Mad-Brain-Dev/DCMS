@extends('layouts.master')

@section('content')
    <div class="row">
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
