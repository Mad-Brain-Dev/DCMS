@extends('layouts.master')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-end gap-2">
                <a class="btn btn-success" href="{{ route('admin.tasks.complete', $tasks->id) }}">Mark As Complete</a>
                <a class="btn btn-warning" href="{{ route('admin.tasks.edit', $tasks->id) }}">Edit</a>
                <form action="{{ route('admin.tasks.destroy', $tasks->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                </form>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="card-title text-decoration-underline text-center">Task Details</div>
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <td>Amount Paid</td>
                            <td class="text-end">$ {{number_format($tasks->installment->amount_paid, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td>Date of Payment</td>
                            <td class="text-end">{{date('m-d-Y', strtotime($tasks->installment->date_of_payment))}}</td>
                        </tr>
                        <tr>
                            <td>Next payment amount</td>
                            <td class="text-end">$ {{number_format($tasks->installment->next_payment_amount, 2, '.', ',')}}</td>
                        </tr>
                        <tr>
                            <td>Payment Method</td>
                            <td class="text-end">{{ $tasks->installment->payment_method }}</td>
                        </tr>
                        <tr>
                            <td>Field Vist Date</td>
                            <td class="text-end">{{date('m-d-Y', strtotime($tasks->installment->fv_date))}}</td>
                        </tr>
                        <tr>
                            <td>Collected By</td>
                            <td class="text-end">{{$tasks->installment->user->name}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

