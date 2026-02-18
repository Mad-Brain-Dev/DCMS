<!doctype html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link
        href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"  />
    <link rel="stylesheet" href="{{ asset('admin/css/agreement-print-screen.css') }}" media="screen">
    <link rel="stylesheet" href="{{ asset('admin/css/agreement-print.css') }}" media="print">
    <title>Invoice-{{ $invoice->invoice_number }}</title>
</head>

<body>
<div class="second-section">
    <div class="container mb-5">
        <div class="row">
            <div class="col-md-12 buttons">
                @if(!request('print'))
                    <div class="d-flex justify-content-end pt-3">
                        <a href="{{ route('admin.invoices.index') }}" class="btn btn-danger mr-1">Back</a>
                        <button class="btn btn-primary" onclick="window.print()">Print</button>
                    </div>
                @endif
            </div>
        </div>

        <div id="invoiceArea">
            <div class="tax_heading_div">
                <div class="tax_img">
                    <img src="{{ asset('images/securre.png') }}" alt="" />
                </div>

                <div class="tax_span_text">
                    <p>DEBT COLLECTION INVOICE </p>
                </div>
            </div>


            <div class="tax_name_add_display">
                <div class="display_1">
                    <p>Securre Collection Pte Ltd (UEN: 202331790G)</p>
                    <p>111 N. Bridge Rd, #21-01, S'179098</p>
                    <p>(+65) 8505 5484</p>
                    <p>hello@securre.net</p>
                </div>

                <div class="display_2">
                    <p>{{ $client->name }}</p>
                    <p>{{ $client->address }}</p>
                    <p>{{ $client->phone }}</p>
                    <p>{{ $client->email }}</p>
                </div>
            </div>




            <div class="statement_display">
                <div class="statement_info_1">
                    <p>Statement #: <span class="stat_num">{{ $invoice->invoice_number }}</span></p>
                    <p>Date: <span class="stat_date">{{ $invoice->issued_date->format('F d, Y') }}</span></p>
                    <p>Customer ID: <span class="stat_cus_id">{{ $client->abbr }}</span></p>
                    <p>Client Name: <span class="stat_cl_name">{{ $client->name }}</span></p>
                </div>


                <div class="invoice-summary-box">

                    <table class="summary-table">
                        <tr>
                            <td class="label-cell">
                                Payable to <span class="red-text">{{ $client->name }}</span>
                            </td>
                            <td colspan="4" class="amount-cell">${{ number_format($invoice->payable_to_client, 2) }}</td>
                        </tr>

                        <tr>
                            <td class="label-cell">
                                Payable to SECURRE
                            </td>
                            <td colspan="4" class="amount-cell">${{ number_format($invoice->payable_to_securre, 2) }}</td>
                        </tr>

                        <tr class="final-row">
                            <td class="final-left">FINAL INVOICE AMOUNT</td>
                            <td colspan="4" class="final-right">${{ number_format($invoice->final_invoice_amount, 2) }}</td>
                        </tr>
                    </table>

                </div>
            </div>




            <div class="report-box">
                <div class="report-header">
                    <div class="report_header_chile_1">Payment Collected by <span class="highlight-red">{{ $client->name }}</span></div>
                    <div class="highlight-red">Nett Amount is after deducting CL Commission</div>
                </div>

                <table class="first_table">
                    <thead>
                    <tr>
                        <th>Date Paid</th>
                        <th>Case #</th>
                        <th>Debtor Name</th>
                        <th>Amount</th>
                        <th class="red-col">Nett Amount</th>
                        <th>Nett Amount</th>
                        <th>Balance</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($collectedByClient as $item)
                        <tr>
                            <td>{{ optional($item->date_of_payment)->format('d M Y') }}</td>
                            <td>{{ $item->case->case_sku }}</td>
                            <td>{{ $item->debtor->name ?? '-' }}</td>
                            <td>${{ number_format($item->pivot->amount_paid, 2) }}</td>
                            <td>${{ number_format($item->pivot->commission_amount, 2) }}</td>
                            <td>${{ number_format($item->pivot->net_amount, 2) }}</td>
                            <td>${{ number_format($item->pivot->balance_snapshot, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" class="no-border-bg">Payable to Secure:</td>
                        <td class="first_table_position">${{ number_format($invoice->payable_to_securre, 2) }}</td>
                    </tr>
                    </tbody>
                </table>


                <div class="report-box-2">
                    <div class="report-header">
                        <div class="report_header_chile_1"> Payment Collected by SECURRE COLLECTION PTE LTD
                            <!-- <span class="highlight-red">CL NAME</span> -->
                        </div>
                        <div class="highlight-red">Nett Amount is after deducting Our Commission</div>
                    </div>

                    <table class="first_table">
                        <thead>
                        <tr>
                            <th>Date Paid</th>
                            <th>Case #</th>
                            <th>Debtor Name</th>
                            <th>Amount</th>
                            <th class="red-col">Nett Amount</th>
                            <th>Nett Amount</th>
                            <th>Balance</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($collectedBySecurre as $item)
                            <tr>
                                <td>{{ optional($item->date_of_payment)->format('d M Y') }}</td>
                                <td>{{ $item->case->case_sku }}</td>
                                <td>{{ $item->debtor->name ?? '-' }}</td>
                                <td>${{ number_format($item->pivot->amount_paid, 2) }}</td>
                                <td>${{ number_format($item->pivot->commission_amount, 2) }}</td>
                                <td>${{ number_format($item->pivot->net_amount, 2) }}</td>
                                <td>${{ number_format($item->pivot->balance_snapshot, 2) }}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="4" class="no-border-bg">Payable to {{ $client->name }}:</td>
                            <td class="first_table_position">${{ number_format($invoice->payable_to_client, 2) }}</td>
                        </tr>
                        </tbody>
                    </table>

                </div>


                <div class="remit-box">
                    <div class="remit-header">REMITTANCE</div>

                    <table class="remit-table">
                        <tr>
                            <td class="left-col">Account Name:</td>
                            <td class="mid-col">{{ $securreBank->account_name }}</td>
                            <td class="right-col highlight">{{ $client->account_name }}</td>
                        </tr>
                        <tr>
                            <td class="left-col">Bank Name</td>
                            <td class="mid-col">{{$securreBank->bank_name}}</td>
                            <td class="right-col highlight">{{$client->bank_name}}</td>
                        </tr>
                        <tr>
                            <td class="left-col">Account Number</td>
                            <td class="mid-col">{{$securreBank->account_number}}</td>
                            <td class="right-col highlight">{{$client->account_number}}</td>
                        </tr>
                        <tr>
                            <td class="left-col">Bank Code / Branch Code</td>
                            <td class="mid-col">{{$securreBank->bank_code}} / {{$securreBank->branch_code}}</td>
                            <td class="right-col highlight">{{$client->bank_code}} / {{$client->branch_code}}</td>
                        </tr>
                        <tr>
                            <td class="left-col">Bank Address</td>
                            <td class="mid-col">{{$securreBank->bank_address}}</td>
                            <td class="right-col highlight">{{$client->bank_address}}</td>
                        </tr>
                        <tr>
                            <td class="left-col">Swift Code</td>
                            <td class="mid-col">{{$securreBank->swift_code}}</td>
                            <td class="right-col highlight">{{$client->swift_code}}</td>
                        </tr>
                        <tr>
                            <td class="left-col">Payment Methods</td>
                            <td class="mid-col">{{$securreBank->payment_methods}}</td>
                            <td class="right-col highlight">{{$client->payment_methods}}</td>
                        </tr>
                        <tr>
                            <td class="left-col">Payment Terms:</td>
                            <td class="mid-col only-text" colspan="2">{{$securreBank->payment_terms}}</td>
                        </tr>
                    </table>
                </div>



                <div class="tax-footer-text">
                    <p class="tax-footer-text-1">For questions concerning this payment voucher, pleasecontact us
                        via WhatsApp at +65 8505 5484, or email at hello@securre.net</p>
                    <p class="tax-footer-text-2">Note: This document is strictly private, confidential and personal
                        to the sender and its recipients and should not be copied, edited</p>
                    <p class="tax-footer-text-2">distributed or reproduced in whole or in part, nor passed to any
                        third party. No signature is required from Securre Collection Pte Ltd</p>
                    <p class="tax-footer-text-2">Note: This document is strictly private, confidential and personal
                        to the sender and its recipients and should not be copied, edited,</p>
                    <p class="tax-footer-text-2">distributed or reproduced in whole or in part, nor passed to any
                        third party. No signature is required from Securre Collection Pte Ltd</p>
                </div>


                <!-- tax end -->
                <div>
                </div>
            </div>

            <footer class="warrant-footer">
                Add: Peninsula Plaza, 111 North Bridge Road, #21-01, Singapore 179098
                Off: +65 8505 5484 | Email: hello@securre.net | Web: www.securre.net
            </footer>
            <!--second section end-->




            <!-- Optional JavaScript -->
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
                    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
            </script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
                    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
            </script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
                    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
            </script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

            <script>
                function printDocument() {
                    window.print();
                }
            </script>
</body>

</html>
