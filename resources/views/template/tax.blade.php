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
    <title>DCMS</title>
</head>

<body>


    <div class="second-section">
        <div class="container mb-5">

            <div>
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
                        <p>{{ $client->address ?? '-' }}</p>
                        <p>{{ $client->phone ?? '-' }}</p>
                        <p>{{ $client->email ?? '-' }}</p>
                    </div>
                </div>




                <div class="statement_display">
                    <div class="statement_info_1">
                        <p>Statement #: <span class="stat_num">{{ $sequenceNumber }}</span></p>

                        <p>Date: <span class="stat_date">{{ now()?->format('d F, Y') }}</span></p>

                        <p>Customer ID: <span class="stat_cus_id">{{ $clientAbbr }}</span></p>
                        <p>Client Name: <span class="stat_cl_name">{{ $client->name }}</span></p>
                    </div>


                    <div class="invoice-summary-box">

                        <table class="summary-table border-4 border-black">
                            <tr class="final-row">
                                <td class="final-left">FINAL INVOICE AMOUNT</td>
                                <td colspan="4" class="final-right">
                                    @php $amount = $invoice->final_invoice_amount; @endphp

                                    @if($amount < 0)
                                        (${{ number_format(abs($amount), 2) }})
                                    @else
                                        ${{ number_format($amount, 2) }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="label-cell final-left">
                                    INVOICE PAYABLE TO
                                </td>
                                <td colspan="4" class="amount-cell final-right">
                                    {{ $invoice->final_payable_to === 'client'
                                        ? $client->name
                                        : 'Securre' }}
                                </td>
                            </tr>
                        </table>

                    </div>
                </div>




                <div class="report-box">

                    <table class="first_table">
                        <thead>
                            <tr>
                                <th>Date Paid</th>
                                <th>Case #</th>
                                <th>Debtor Name</th>
                                <th>Collected By</th>
                                <th>Collected Amt</th>
                                <th>Nett Amount</th>
                                <th>Balance</th>
                            </tr>
                        </thead>

{{--                        <tbody>--}}
{{--                            <tr>--}}
{{--                                <td>16 Jan 2025</td>--}}
{{--                                <td>123</td>--}}
{{--                                <td>DB NAME</td>--}}
{{--                                <td>Securre</td>--}}
{{--                                <td>$1,000.00</td>--}}
{{--                                <td>($400.00)</td>--}}
{{--                                <td>$9,000.00</td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td>20 Jan 2025</td>--}}
{{--                                <td>124</td>--}}
{{--                                <td>DB NAME</td>--}}
{{--                                <td>Client Name</td>--}}
{{--                                <td>$2,000.00</td>--}}
{{--                                <td>$800.00</td>--}}
{{--                                <td>$8,000.00</td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td>21 Jan 2025</td>--}}
{{--                                <td>125</td>--}}
{{--                                <td>DB NAME</td>--}}
{{--                                <td>Client Name</td>--}}
{{--                                <td>$3,000.00</td>--}}
{{--                                <td>$1,200.00</td>--}}
{{--                                <td>$7,000.00</td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td>21 Jan 2025</td>--}}
{{--                                <td>126</td>--}}
{{--                                <td>DB NAME</td>--}}
{{--                                <td>Securre</td>--}}
{{--                                <td>$4,000.00</td>--}}
{{--                                <td>($1,600.00)</td>--}}
{{--                                <td>$6,000.00</td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td>28 Jan 2025</td>--}}
{{--                                <td>127</td>--}}
{{--                                <td>DB NAME</td>--}}
{{--                                <td>Securre</td>--}}
{{--                                <td>$5,000.00</td>--}}
{{--                                <td>($2,000.00)</td>--}}
{{--                                <td>$5,000.00</td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td>31 Jan 2025</td>--}}
{{--                                <td>128</td>--}}
{{--                                <td>DB NAME</td>--}}
{{--                                <td>Securre</td>--}}
{{--                                <td>($2,400.00)</td>--}}
{{--                                <td class="first_table_position">$7,026.68</td>--}}
{{--                                <td>$4,000.00</td>--}}
{{--                            </tr>--}}
{{--                            <tr>--}}
{{--                                <td colspan="5" class="no-border-bg">Final Amount:</td>--}}
{{--                                <td class="first_table_position">($4,400.00)</td>--}}
{{--                            </tr>--}}
{{--                        </tbody>--}}
                        <tbody>

                        @foreach($invoice->installments as $installment)

                            @php
                                $amount = $installment->pivot->amount_paid;
                                $net = $installment->pivot->net_amount;
                            @endphp

                            <tr>

                                {{-- 1. Date Paid --}}
                                <td>
                                    {{ \Carbon\Carbon::parse($installment->payment_date)->format('d F, Y') }}
                                </td>

                                {{-- 2. Case Number (LAST 3 DIGITS ONLY) --}}
                                <td>
                                    {{ substr($installment->case->case_sku ?? '', -3) }}
                                </td>

                                {{-- 3. Debtor --}}
                                <td>
                                    {{ $installment->debtor->name ?? '-' }}
                                </td>

                                {{-- 4. Collected By --}}
                                <td>
                                    {{ $installment->pivot->collected_type === 'securre'
                                        ? 'Securre'
                                        : $clientAbbr }}
                                </td>

                                {{-- 5. Amount Collected --}}
                                <td>
                                    ${{ number_format($amount, 2) }}
                                </td>

                                {{-- 6. Nett Amount --}}
                                <td>
                                    @if($net < 0)
                                        (${{ number_format(abs($net), 2) }})
                                    @else
                                        ${{ number_format($net, 2) }}
                                    @endif
                                </td>

                                {{-- 7. Balance --}}
                                <td>
                                    ${{ number_format($installment->pivot->balance_snapshot, 2) }}
                                </td>

                            </tr>

                        @endforeach

                        {{-- FINAL ROW --}}
                        <tr>
                            <td colspan="5" class="no-border-bg">Final Amount:</td>

                            <td>
                                @if($invoice->final_invoice_amount < 0)
                                    (${{ number_format(abs($invoice->final_invoice_amount), 2) }})
                                @else
                                    ${{ number_format($invoice->final_invoice_amount, 2) }}
                                @endif
                            </td>
                        </tr>

                        </tbody>
                    </table>





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
                            to the sender and its recipients and should not be copied, edited,</br>
                            distributed or reproduced in whole or in part, nor passed to any third party. No signature
                            is required from Securre Collection Pte Ltd</p>
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
                <script>
                    function printDocument() {
                        window.print();
                    }
                </script>
</body>

</html>
