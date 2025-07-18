@extends('layouts.master')


@section('content')
    <div class="row">
            <div class="col-xl-4 col-md-6">
                <div class="card mini-stat">
                    <div class="card-body bg-primary">
                        <div class="">
                            <h5 class="font-size-16 text-uppercase text-white">Admin</h5>
                            @foreach ($admin_installments as $task)
                            <a href="{{ route('admin.tasks.show', $task->id) }}" class="text-dark">
                                <div class="card">
                                    <div class="card-body">
                                        <tr>
                                            <td>
                                                @if ($task->installment)
                                                    <h6>Case Number: {{ $task->installment->case->case_sku }}</h6>
                                                    <h6>Field Visit Date: {{date('m-d-Y', strtotime($task->installment->fv_date))}}</h6>
                                                    <h6>Collected By: {{$task->installment->user->name}}</h6>
                                                @else
                                                    No installment details
                                                @endif
                                            </td>
                                        </tr>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="card mini-stat">
                    <div class="card-body bg-primary">
                        <div class="">
                            <h5 class="font-size-16 text-uppercase text-white">Accounts</h5>
                            @foreach ($accounts_installments as $task)
                            <a href="{{ route('admin.tasks.show', $task->id) }}" class="text-dark">
                            <div class="card">
                                <div class="card-body">
                                    <tr>
                                        <td>
                                            @if ($task->installment)
                                                <h6>Case Number: {{ $task->installment->case->case_sku }}</h6>
                                                <h6>Field Visit Date: {{date('m-d-Y', strtotime($task->installment->fv_date))}}</h6>
                                                <h6>Collected By: {{$task->installment->user->name}}</h6>
                                            @else
                                              No installment details
                                            @endif
                                        </td>
                                    </tr>
                                </div>
                            </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card mini-stat">
                    <div class="card-body bg-primary">
                        <div class="">
                            <h5 class="font-size-16 text-uppercase text-white">Completed</h5>
                            @foreach ($completed_tasks as $task)
{{--                            <a href="{{ route('admin.tasks.show', $task->id) }}" class="text-dark">--}}
                                <div class="card">
                                    <div class="card-body">
                                        <tr>
                                            <td>
                                                @if ($task->installment)
                                                    <h6>Case Number: {{ $task->installment->case->case_sku }}</h6>
                                                    <h6>Field Visit Date: {{date('m-d-Y', strtotime($task->installment->fv_date))}}</h6>
                                                    <h6>Collected By: {{$task->installment->user->name}}</h6>
                                                @else
                                                    Installment deleted
                                                @endif
                                            </td>
                                        </tr>
                                    </div>
                                </div>
{{--                            </a>--}}
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>


    </div>
@endsection
