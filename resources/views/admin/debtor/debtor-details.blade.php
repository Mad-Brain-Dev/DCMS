<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Debtor Details</title>
</head>

<body>
    <div class="container">
        <div class="col-md-12 print-button">
            <div class=" d-flex justify-content-end mt-2">
                <a href="{{ route('admin.cases.index') }}" class="btn btn-danger mr-1">Back</a>
                <button class="btn btn-primary" id="letter_print" onclick="printLetter()">Print</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center mt-3 underline">Debtor Details</h5>
                    <h6>Case Number : {{ $debtor_details->case_sku }}</h6>
                    <h6>Client Name : {{ $debtor_details->clientDetails->name }}</h6>
                    <h6>Client Company : {{ $debtor_details->clientDetails->company_name }}</h6>
                    <h6>Debtor Name : {{ $debtor_details->name }} </h6>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <h5>Updates:</h5>
            </div>
            @foreach ($installments_details as $installments_detail)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h6>Amount Paid : $ {{ number_format($installments_detail->amount_paid, 2, '.', ',') }}
                            </h6>
                            <h6>Payment Date : {{ date('m-d-Y', strtotime($installments_detail->date_of_payment)) }}
                            </h6>
                            <h6>Next Payment Amount : $
                                {{ number_format($installments_detail->next_payment_amount, 2, '.', ',') }}</h6>
                            <h6>Next Payment Date :
                                {{ date('m-d-Y', strtotime($installments_detail->next_payment_date)) }}</h6>
                            <h6>Field Visit Date : {{ date('m-d-Y', strtotime($installments_detail->fv_date)) }}
                            </h6>
                            <h6>Field Visit Date : {{ $installments_detail->payment_method }}</h6>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-md-12">
                <h5 class="mt-3">New Update:</h5>
                <div class="note"></div>
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <script>
        function printLetter() {
            window.print();
        }
    </script>

    <style>
        .note {
            height: 300px;
            width: 100%;
            border: 1px solid #e7e7e7;
        }

        .underline {
            position: relative;
            margin-bottom: 30px;
        }

        .underline:after {
            position: absolute;
            content: "";
            width: 180px;
            height: 2px;
            background: #313131;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);

        }

        @media print {
            .col-md-4 {
                margin-bottom: 20px;
                width: 50%;
            }

            .note {
                height: 300px;
                width: 100%;
                border: 1px solid #e7e7e7;
            }

            .print-button {
                display: none;
            }
        }
    </style>

</body>

</html>
