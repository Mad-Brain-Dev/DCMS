@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between" style="padding-left: 30px;padding-right: 30px;">
                        <h4 class="card-title mb-3">Monthly Installment</h4>
                    </div>

                    <canvas id="monthlyCollectionBarChat" style="max-height: 400px;"></canvas>
{{--                    <installment-bar-chart/>--}}
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between" style="padding-left: 30px;padding-right: 30px;">
                        <h4 class="card-title mb-3">Monthly admin</h4>
                    </div>
                    <canvas id="monthlyAdminFeeLineChat" style="max-height: 400px;"></canvas>
                    {{--                    <admin-fee-line-chart/>--}}
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between" style="padding-left: 30px;padding-right: 30px;">
                        <h4 class="card-title mb-3">Cases Status</h4>
                    </div>
                    <canvas id="monthlyCaseStatusDoughnutChat" style="max-height: 335px;"></canvas>
{{--                    <case-status-doughnut-chart/>--}}
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between" style="padding-left: 30px;padding-right: 30px;">
                        <h4 class="card-title mb-3">Debtor Balance</h4>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-wrapper">
                                    <table class="table table-earnings table-earnings__challenge">
                                        <thead>
                                        <tr class="text-capitalize">
                                            <th>Debtor Name</th>
                                            <th>Last Payment Date</th>
                                            <th>Last Payment Amount</th>
                                            <th>Next Payment Date</th>
                                            <th>Next Payment Amount</th>
                                            <th>Balance</th>
                                        </tr>
                                        </thead>
                                        <tbody class="table-body">
                                        @foreach($dbBalanceData as $item)
                                            <tr>
                                                <td>{{$item->name}}</td>
                                                <td>{{date('d-m-Y', strtotime($item->installments->last()?->date_of_payment))}}</td>
                                                <td>{{$item->installments->last()?->date_of_payment != null ? number_format($item->installments->last()?->amount_paid, 2, '.', ',').'$': 'N/A'}}</td>
                                                <td>{{date('d-m-Y', strtotime($item->installments->last()?->next_payment_date))}}</td>
                                                <td>{{$item->installments->last()?->next_payment_amount !=null ? number_format($item->installments->last()?->next_payment_amount, 2, '.', ',').'$':'N/A'}}</td>
                                                <td>{{$item->total_amount_balance}}</td>
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
                        <h4 class="card-title mb-3">Admin Fee Collection</h4>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-wrapper">
                                    <table class="table table-earnings table-earnings__challenge">
                                        <thead>
                                        <tr class="text-capitalize">
                                            <th>Client Name</th>
                                            <th>Total Admin Fee</th>
                                            <th>Total Paid</th>
                                            <th>Balance</th>
                                        </tr>
                                        </thead>
                                        <tbody class="table-body">
                                        @foreach($adminFee as $item)
                                            <tr>
                                                <td>{{$item->name}}</td>
                                                <td>{{$item->admin_fee !=null ? number_format($item->admin_fee, 2, '.', ',').'$':'N/A'}}</td>
                                                <td>{{$item->admin_fee_paid !=null ? number_format($item->admin_fee_paid, 2, '.', ',').'$':'N/A'}}</td>
                                                <td>{{$item->admin_fee_balance !=null ? number_format($item->admin_fee_balance, 2, '.', ',').'$':'N/A'}}</td>
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
                        <h4 class="card-title mb-3">Installment & Admin Fee Collection By Employee</h4>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-wrapper">
                                    <table class="table table-earnings table-earnings__challenge">
                                        <thead>
                                        <tr class="text-capitalize">
                                            <th>SL</th>
                                            <th>Employee Name</th>
                                            <th>Total Installment Collected</th>
                                            <th>Total Admin Fee Collected</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="table-body">
                                        @foreach($merged as $employee)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$employee['user']['first_name'].' '.$employee['user']['last_name'] }}</td>
                                                <td>
                                                    @if(isset($employee['installment_total_amounts']))
                                                        {{ $employee['installment_total_amounts']!=null ? number_format($employee['installment_total_amounts'], 2, '.', ',').'$':'0'}}
                                                    @else
                                                        0
                                                    @endif

                                                </td>
                                                <td>
                                                    @if(isset($employee['admin_total_amounts']))
                                                        {{ $employee['admin_total_amounts']!=null ? number_format($employee['admin_total_amounts'], 2, '.', ',').'$':'0'}}
                                                    @else
                                                        0
                                                    @endif

                                                </td>
                                                <td>
                                                    <a href="{{route('admin.reports.monthlyInstallmentByID',$employee['collected_by_id'])}}" class="btn btn-primary waves-effect waves-light btn-sm">See Monthly Collection</a>
                                                </td>
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

    </div>
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('monthlyCollectionBarChat');
        new Chart(ctx, {
            type: 'bar',
            data: {
                // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                labels: @json($monthly_order_data_array['months']),
                datasets: [{
                    label: 'Total Installment',
                    // data: [12, 19, 3, 5, 2, 3],
                    data: @json($monthly_order_data_array['orders']),
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });


        //line chart
        const ctx1 = document.getElementById('monthlyAdminFeeLineChat');
        new Chart(ctx1, {
            type: 'line',
            data: {
                // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                labels: @json($monthly_admin_fee_data_array['months']),
                datasets: [{
                    label: 'Total Admin Fee',
                    // data: [12, 19, 3, 5, 2, 3],
                    data: @json($monthly_admin_fee_data_array['orders']),
                    backgroundColor: '#ff4c70',
                    borderColor: '#ff355d',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });


        //pie chart
        const ctx2 = document.getElementById('monthlyCaseStatusDoughnutChat');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                // labels: [
                //     'Red',
                //     'Blue',
                //     'Yellow'
                // ],
                labels: @json($dataPie['statuses']),
                datasets: [{
                    label: 'Case',
                    // data: [300, 50, 100],
                    data: @json($dataPie['counts']),
                    // backgroundColor: [
                    //     'rgb(255, 99, 132)',
                    //     'rgb(54, 162, 235)',
                    //     'rgb(255, 205, 86)'
                    // ],
                    backgroundColor: @json($dataPie['colors']),
                    hoverOffset: 4
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
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
    .text-right{
        text-align: right;
    }
</style>
@endpush
