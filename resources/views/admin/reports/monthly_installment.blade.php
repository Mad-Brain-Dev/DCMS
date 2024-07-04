@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between" style="padding-left: 30px;padding-right: 30px;">
                        <h4 class="card-title mb-3 text-capitalize">{{user_fullname($employee)}}'s Monthly Installment & Admin Fee collection data</h4>
                    </div>

                    <canvas id="monthlyCollectionBarChat" style="max-height: 400px;"></canvas>
{{--                    <installment-bar-chart/>--}}
                </div>
            </div>
        </div>

    </div>
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const a = @json($monthly_order_data_array);
            const b = @json($monthly_admin_data_array);

            // Combine and align data by months
            const allMonths = [...new Set([...a.months, ...b.months])].sort();
            const installments = allMonths.map(month => a.months.includes(month) ? a.installment[a.months.indexOf(month)] : 0);
            const admins = allMonths.map(month => b.months.includes(month) ? b.admin[b.months.indexOf(month)] : 0);

            const ctx = document.getElementById('monthlyCollectionBarChat').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: allMonths,
                    datasets: [
                        {
                            label: 'Installment',
                            data: installments,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Admin Fee',
                            data: admins,
                            backgroundColor: 'rgba(255, 99, 132, 0.6)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });

    </script>
@endpush
@push('style')
<style>

</style>
@endpush
