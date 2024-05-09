@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between" style="padding-left: 30px;padding-right: 30px;">
                        <h4 class="card-title mb-3">Debtor Balance</h4>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-8">
                                <div class="table-wrapper">
                                    <table class="table table-earnings table-earnings__challenge">
                                        <thead>
                                        <tr class="text-center text-capitalize">
                                            <th>DB Name</th>
                                            <th>Last Payment Date</th>
                                            <th>Last Payment Amount</th>
                                            <th>Next Payment Date</th>
                                            <th>Next Payment Amount</th>
                                            <th>Balance</th>
                                        </tr>
                                        </thead>
                                        <tbody class="table-body">
                                        @foreach($dbBalanceData['items'] as $item)
                                            @dd($item)
                                            <tr>
                                                <td>{{$item->name}}</td>
                                                <td>{{$item->last_payment_date}}</td>
                                                <td>{{$item->last_payment_amount}}</td>
                                                <td>{{$item->next_payment_date}}</td>
                                                <td>{{$item->next_payment_amount}}</td>
                                                <td>{{$item->balance}}</td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between" style="padding-left: 30px;padding-right: 30px;">
                        <h4 class="card-title mb-3">Monthly collection Bar chart</h4>
                    </div>
                    <installment-bar-chart/>
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
                </div>
            </div>
        </div>

    </div>
@endsection

@push('style')
<style>
    tbody {
        display:block;
        max-height:300px;
        overflow-y:auto;
    }
    thead, tbody tr {
        display:table;
        width:100%;
        table-layout:fixed;
    }
    thead {
        width: calc( 100% - 1em )
    }
</style>
@endpush
