@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between" style="padding-left: 30px;padding-right: 30px;">
                        <h4 class="card-title mb-3">Monthly collection Bar chart</h4>
                    </div>

                    <example-component/>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between" style="padding-left: 30px;padding-right: 30px;">
                        <h4 class="card-title mb-3">Monthly admin fee collection line chart</h4>
                    </div>

                    <admin-fee-line-chart/>
                    {{--                    <create-third-party-drop-off :products="{{json_encode($products)}}"/>--}}
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between" style="padding-left: 30px;padding-right: 30px;">
                        <h4 class="card-title mb-3">Cases Status pie chart</h4>
                    </div>

                    <case-status-doughnut-chart/>
                    {{--                    <create-third-party-drop-off :products="{{json_encode($products)}}"/>--}}
                </div>
            </div>
        </div>

    </div>
@endsection

@push('style')

@endpush
