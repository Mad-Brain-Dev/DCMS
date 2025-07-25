@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Cases</h4>
                       @can('Create Case')
                       <a href="{{ route('admin.cases.create') }}" class="btn btn-sm btn-primary text-capitalize" style="padding-top: 8px;">Create Case</a>
                       @endcan
                    </div>
                    {!! $dataTable->table(['class'=>'table-responsive']) !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    @include('includes.styles.datatable')
@endpush
@push('script')
    @include('includes.scripts.datatable')
@endpush
