@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">DB Name</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Next Payment Date</th>
                            <th scope="col">Next Payment Amount</th>
                            <th scope="col">Balance</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($cases as $case)
                          <tr>
                            <td>{{ $case->name }}</td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <canvas id="myChart" width="400" height="400"></canvas>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    {{-- <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($data->pluck('month')) !!},
                datasets: [{
                    label: 'Month-wise Data',
                    data: {!! json_encode($data->pluck('count')) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
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
    </script> --}}
@endpush

@push('style')

@endpush
