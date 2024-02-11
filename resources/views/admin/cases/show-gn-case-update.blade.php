@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div id="success" class="text-success"></div>
            <div class="card">
                <div class="card-header text-center">Gn Case Update</div>
                <div class="card-body">
                    <form enctype="multipart/form-data" action="{{ route('general.case.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">
                        <div class="mb-3">
                            <label class="form-label">Gn Case Update</label>
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
                            <label class="form-label">Gn Summary</label>
                            <textarea name="gn_summary" class="form-control" id="" rows="2"></textarea>
                            @error('gn_summary')
                                <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <input type="hidden" name="case_id" value="{{ $case->id }}" id="case_id">

                        <div class="row">
                            <div class="mb-3 text-end">
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
            <div id="content">
                <ul class="timeline">
                    @foreach ($gn_updates as $gn_update)
                        <li class="event"
                            data-date="{{ date('d-m-Y', strtotime($gn_update->created_at)) }}, {{ date('h:i a', strtotime($gn_update->created_at)) }} ">
                            <iframe src="{{ asset('storage/document/' . $gn_update->gn_update) }}" width="300"
                                height="200"></iframe>

                            <h6 class="mt-2">Field Visited at: {{ date('d-m-Y', strtotime($gn_update->fv_date)) }}</h6>
                            <span class="d-block">{{ $gn_update->gn_summary }}</span>
                            <div>
                                <a href="#" class="btn  btn-primary mt-2 viewFVUpdate" data-toggle="modal"
                                data-target="#exampleModal">
                                <span class="fv_id d-none">{{ $gn_update->id }}</span>
                                <i class="far fa-eye"></i> View
                            </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
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
@endsection
@push('script')
    <script src="{{ asset('/admin/js/passwordCheck.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <script>
        $(document).ready(function() {
            $('.viewFVUpdate').click(function(e) {
                var fv_update_id = $(this).find('.fv_id').text();
                $.ajax({
                    type: 'get',
                    url: '{{ route('single.general.update') }}',
                    data: {
                        id: fv_update_id
                    },
                    success: (response) => {
                        console.log(response);
                        let href = "{{ asset('/storage/document/') }}" + "/" + response.data
                            .fv_update
                        let fv_update = $('#fv_update').attr('src', href);
                        let field_visited_at = $('#field_visited_at').text(
                            'Field Visited at : ' + response.data.fv_date);
                        let created_at = $('#created_at').text('Created at : ' + response.data
                            .created_at);
                    },
                    error: function(response) {
                        $('#error').text(response.responseJSON.message);
                    }

                });
            });
        });
    </script>
@endpush
@push('style')
    <style>
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
            max-width: 40%;
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
    </style>
@endpush
