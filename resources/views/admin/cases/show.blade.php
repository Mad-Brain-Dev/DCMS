@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">{{ get_page_meta('title', true) }}</h4>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Debtor Name</th>
                                <th scope="col">Amount Owed</th>
                                <th scope="col">Case Type</th>
                                <th scope="col">Case Priority</th>
                                <th scope="col">Due Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr>
                                    <td>{{ $case->debtor->first_name}}</td>
                                    <td>{{ $case->amount_owed}}</td>
                                    <td>{{ $case->case_type }}</td>
                                    <td>{{ $case->case_priority }}</td>
                                    <td>{{ $case->due_date }}</td>
                                    <td>
                                        <a href="{{ route('admin.download.case.pdf', $case->id) }}" class="btn btn-dark btn-sm "> View Pdf </a>
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
