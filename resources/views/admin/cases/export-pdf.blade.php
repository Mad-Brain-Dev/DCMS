<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Case</title>
  </head>
  <body>
    <div class="conatner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">{{ get_page_meta('title', true) }}</h4>
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Debtor Name</th>
                                    <th scope="col">Amount Owed</th>
                                    <th scope="col">Case Type</th>
                                    <th scope="col">Case Status</th>
                                    <th scope="col">Due Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <td>{{ $data->debtor->first_name}}</td>
                                        <td>{{ $data->amount_owed}}</td>
                                        <td>{{ $data->case_type }}</td>
                                        <td>{{ $data->case_status }}</td>
                                        <td>{{ $data->due_date }}</td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>
