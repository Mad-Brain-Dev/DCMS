@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Cases</h4>
                    </div>
                    <div class="table-responsive">
                        {!! $dataTable->table(['class'=>'table table-bordered table-hover w-100']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('style')
    @include('includes.styles.datatable')
    <style>
        tr.client-update-pending {
            background-color: #fff3cd !important; /* soft yellow */
        }
    </style>
@endpush

@push('script')
    @include('includes.scripts.datatable')
@endpush
