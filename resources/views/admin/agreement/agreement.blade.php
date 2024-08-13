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
                <div class="row">
                    <div class="col-md-12 buttons">
                        <div class="d-flex justify-content-end pt-3">
                            <a href="{{ route('admin.cases.index') }}" class="btn btn-danger mr-1">Back</a>
                            <button class="btn btn-primary" onclick="printDocument()">Print</button>
                            <a href="{{ route('printable.case.letter', $case_number->id) }}" class="btn btn-dark ml-1">Print Letter</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mx-auto text-center warrant-act">
                    <h1>WARRANT TO ACT</h1>
                    <p>SUBJECT TO CHAPTER 53B (ORIGINAL ENACTMENT: ACT 39 of 2001) REVISED EDITION 2002, SECTION 2.1</p>
                    <div class="divider-top"></div>
                </div>
                <hr class="new-hr">
                <div class="row mt-3">
                    <div class="col-4">
                        <p><span class="to-securre">TO:</span> Securre Collection Pte Ltd</p>
                        <span class="client-information">CLIENT INFORMATION</span>
                    </div>
                    <div class="col-8">
                        <div class="d-flex col-12 new-case ">
                            <div class="col-2 case-ref">CASE REF. #:</div>
                            <div class="col-4 data-for-case"><span class="case_ref">{{ $case_number->case_sku }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-11 mx-auto take-information">
                        <ul class="list-unstyled">
                            <li><span class="full-name">Full Name:</span> <span class="padding-for-new-data1">
                                    {{ $client_details->name }}</span></li>
                            <li><span class="company-name">Company Name:</span> <span class="padding-for-new-data2">
                                    {{ $client_details->company_name }}</span> </li>
                            <li><span class="nric-no">NRIC No./UEN:</span> <span
                                    class="padding-for-new-data3">{{ $client_details->nric }}</span> </li>
                            <li><span class="contact-no">Contact No.:</span> <span
                                    class="padding-for-new-data4">{{ $client_details->phone }}</span> </li>
                            <li><span class="email-add">Email Add.:</span>
                                <span class="padding-for-new-data5"> {{ $client_details->email }}</span>
                            </li>
                            <li><span class="address">Address:</span> <span class="padding-for-new-data6">
                                    {{ $client_details->address }} </span></li>
                        </ul>
                    </div>
                </div>
                <div class="row mt-1">
                    <span class="debtor-information">DEBTOR INFORMATION</span>
                    <div class="col-md-11 mx-auto take-information">
                        <ul class="list-unstyled">
                            <li><span class="full-name">Full Name:</span> <span
                                    class="padding-for-new-data1">{{ $case_number->name }}</span> </li>
                            <li><span class="company-name">Company Name:</span> <span
                                    class="padding-for-new-data2">{{ $case_number->company_name }}</span> </li>
                            <li><span class="nric-no">NRIC No./UEN:</span> <span
                                    class="padding-for-new-data3">{{ $case_number->company_uen }}</span> </li>
                            <li><span class="contact-no">Contact No.:</span> <span
                                    class="padding-for-new-data4">{{ $case_number->phone }}</span> </li>
                            <li><span class="email-id">Email ID.:</span> <span
                                    class="padding-for-new-data5">{{ $case_number->email }}</span> </li>
                            <li><span class="address-2">Address:</span> <span
                                    class="padding-for-new-data6">{{ $case_number->adderss }}</span> </li>
                            <li class="remarks-li"><span class="remarks">Remarks:</span><span
                                    class="padding-for-new-data7">{{ $case_number->remarks }}</span></li>
                        </ul>
                    </div>
                </div>
                <div class="row debt-amount-row">
                    <div class="col-2 total-debt p-0">
                        <span class="">Total Debt Amount </span>
                        <span class=""> in Singapore Dollars:</span>
                    </div>
                    <div class="col-6 align-items-center d-flex">
                        @php
                            $amountInWords = ucfirst(numberToWords($case_number->total_amount_owed));
                        @endphp
                        <span class="singapore-dollars">
                            Dollars {{ decimalToWords($case_number->total_amount_owed) }}
                            plus interests
                        </span>
                    </div>
                    <div class="col-4 p-3  new-usd d-flex align-items-center justify-content-end">
                        @php
                             $formattedAmount = number_format($case_number->total_amount_owed, 2, '.', ',');
                        @endphp
                        {{-- ( <span class="new-usd-after">SG </span> <span class="digit-amount"><i class="fa fa-usd"
                                aria-hidden="true"></i>{{ $formattedAmount }}</span> <span
                            class="some-symble"> /+%</span> ) --}}

                            ( <span class="new-usd-after">SG </span> <span class="digit-amount"><i class="fa fa-usd"
                                aria-hidden="true"></i>{{ $formattedAmount }}</span> <span
                            class="some-symble"> /+%</span> )

                        {{-- <span class="right-usd-data">{{ $case_number->total_amount_owed }}</span><span class="bracket_end">) --}}
                    </div>
                </div>
                <div class="row another-information-row">
                    <ol class="mt-4">
                        <li class="first-child">*I/We, the undersigned, hereby appoint you to act for <span
                                class="me-us-after">*me/us </span> <span
                                class="agreement_name">{{ $client_details->name }}</span><br>
                            <span class="nric-no-uen-after">(NRIC No./UEN: <span
                                    class="agreement_nric">{{ $client_details->nric }}/{{$client_details->company_uen}}</span></span> in connection with
                            the above matter until it
                            is completed, settled, resolved or the contractual agreement between us and you is
                            terminated for whatsoever reason.
                            All cheques shall be made payable to Securre Collection Pte Ltd, and online payments made
                            via PayNow to<span class="new-underline"> 85055484.</span>
                        </li>
                        <li class=""><span class="">Our engagement of your services are subjected to the
                                terms and conditions as set out in the Debt Collection Agreement
                                as stated above on Page 1 and Page 2.</span></li>
                        <li class=""><span class="">*I/We authorise you to receive payment from the debtor
                                directly in your favour (on our behalf) and to do everything you
                                consider necessary in your conduct of the above matter. This Warrant to Act serves as a
                                formal Warrant to Act which may
                                be produced to third parties as evidence of your engagement to act on our behalf in
                                connection with the above matter.</span></li>
                        <li class="">*I/We authorise you to take instructions in respect of this matter
                            from:<br /><br />
                            <span class="person pb-1"> Person:<span class="lorem-2"></span></span> <span
                                class="contact pb-1">Contact: </span><span
                                class="lorem-3"></span>
                        </li>
                    </ol>
                    <div class="col-md-10 mx-auto mb-2">
                        <div class="row">
                            {{-- <div class="col-6"><span class="person pb-1">Person:</span> <span class="lorem-2">{{ $client_details->name }}</span></div> --}}
                            {{-- <div class="col-6"><span class="contact pb-1">Contact;</span> <span class="lorem-3">{{ $client_details->phone }}</span></div> --}}
                        </div>
                    </div>
                </div>
                <div class="pt-2">
                    <ul class="last-ul">
                        <li> <span class="last-ul-li-name"> Full Name: </span> <span class="data-mr1">
                                {{ $client_details->name }} </span></li>

                        <li><span class="last-ul-li-company"> Company Name: </span> <span class="data-mr2">
                                {{ $client_details->company_name }}</span></li>

                        <li><span class="last-ul-li-nric"> NRIC No./UEN: </span> <span
                                class="data-mr3">{{ $client_details->company_name }} </span> </li>

                        <li> <span class="last-ul-li-contact"> Contact No.: </span> <span class="data-mr4">
                                {{ $client_details->phone }} </span></li>

                        <li><span class="last-ul-li-stamp"> Signature/Stamp: </span> <span class="data-mr5"> </span>
                        </li>
                        <br>
                        <li class="font-italic" style="font-weight: 400; margin-top: -5px; margin-left: -8px;"> *
                            Strike out where necessary.</li>
                    </ul>
                </div>
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
