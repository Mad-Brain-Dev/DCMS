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
    <!--first agreement section start-->

    <div class="container">
        <div class="">
            <div class=" first-agreement-container">
                <div class="row hide-print-button">
                    <div class="col-12 d-flex justify-content-end mt-3">

                        <a href="{{ route('admin.clients.index') }}" class="btn btn-danger mr-2">Back</a>
                        <div class="btn btn-primary" id="document_print" onclick="printDocument()">Print Document</div>
                    </div>
                </div>
                <div class="row first-row justify-content-center client-agreement-header">
                    <div class=" align-items-start d-flex for-bottom-border">
                        <img class="logo" src="{{ asset('images/logo.jpg') }}" alt=""><span class="debt-text">DEBT
                            COLLECTION AGREEMENT</span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-7 ">

                    </div>

                    <div class="col-5">
                        <div class="row for-p2">
                            {{-- <span class="d-f-agreement">Date of
                                Agreement:</span><span class="date_of_agreement_top">{{ \Carbon\Carbon::parse($client_details->date_of_agreement)->format('d - F - Y') }}</span> --}}
                            <div class="col-4 case-prov">DATE OF EXPIRY</div>
                            <div class="col-5 box-2nd">
                                {{ \Carbon\Carbon::parse($client_details->date_of_expiry)->format('d  F  Y') }}</div>

                        </div>
                        {{-- <div class="col-10 d-flex pt-3 pb-2 expiry">
                            <span class="d-f-expiry">Date of Expiry:</span> <span
                                class="date_of_expiry">{{ \Carbon\Carbon::parse($client_details->date_of_expiry)->format('d - F - Y') }}</span>
                        </div> --}}
                    </div>
                </div>


                <div class="row">
                    <div class="ol-start mt-3">
                        <ol class="first-ol">
                            <li class="f-ol-li1"> This Agreement, entered into as of <span class="text-to">today,
                                </span> <span
                                    class="to-margin">{{ \Carbon\Carbon::parse($client_details->date_of_agreement)->format('d  F  Y') }}</span>
                                , by and between us, <b>Securre Collection Pte. Ltd.</b> (hereon referred to as "SC")
                                <span class="text-and"> and </span><span
                                    class="and-margin">{{ $client_details->name }}</span> (hereon referred to as the
                                "Client").
                            </li>

                            <li>
                                <span> (a) Whereas, the Client have solicited various firms for Debt Collection Services
                                    for the sole purpose of collecting upon their bad <br /> <span
                                        style="padding-left: 20px;"> and/or financing the aforementioned bad debts via
                                        debt-factoring; and,</span></span><br />

                                (b) Whereas, SC has represented to the Client that it is fully capable of performing the
                                services described in this Agreement, and the Client<br><span style="padding-left: 20px;">
                                    has relied on such representation to select SC to
                                    provide the services; and, </span> <br />

                                (c) Whereas, the Client now desire to enter into an agreement setting forth their rights
                                and obligations with regard to SC's good service <br> <span
                                    style="padding-left: 20px;">representation.</span>
                            </li>

                            <li> Both parties hereto agree to the following;

                                <div class="try_it">
                                    <div class="d-flex bd-highlight col-11 p-0 m-0 ">
                                        <div class="both-child-1 col-md-3 pt-2 flex-fill bd-highlight">
                                            (a) Scope of services:
                                        </div>

                                        <div class="both-child-2 col-md-9 pt-2 flex-fill bd-highlight">
                                            SC has agreed to collect outstanding debts as owed to the Client by its
                                            debtors as handed over to SC
                                            by the Client during the endorsement of this Agreement.
                                        </div>
                                    </div>

                                    <div class="d-flex bd-highlight col-md-11 p-0 m-0">
                                        <div class="col-md-3 pt-2 flex-fill bd-highlight">
                                            (b) Administrative fees:
                                        </div>

                                        <div class=" col-md-9 pt-2 flex-fill bd-highlight">
                                            The Client/s has agreed to pay an upfront fee of <span class="s-dollar-sign"> S$
                                                <span class="dollar-margin"><b>{{ $client_details->admin_fee }}</b></span>
                                            </span>, for filing, administrative,
                                            and registration costs to SC for the engagement of this service. It is also
                                            understood that this payment
                                            is non-refundable and payable in full upon the endorsement of this
                                            Agreement.
                                        </div>
                                    </div>

                                    <div class="d-flex bd-highlight col-md-11 p-0 m-0">
                                        <div class=" col-md-3 pt-2 flex-fill bd-highlight">
                                            (c) Debt Commission:
                                        </div>

                                        <div class=" col-md-9 pt-2 flex-fill bd-highlight">
                                            The commission payout on the successfully collected debt/s and interest (if
                                            any) will <span class="text-be"> be <span class="be-margin"><b>
                                                        {{ $client_details->collection_commission }}</b> </span></span>.
                                            SC reserves the right to review the commission structure subject to seven
                                            (07) days written notice to the Client.
                                        </div>
                                    </div>

                                    <div class="d-flex bd-highlight col-md-11 p-0 m-0">
                                        <div class=" col-md-3 pt-2 flex-fill bd-highlight">
                                            (d) Payout structure:
                                        </div>

                                        <div class=" col-md-9 pt-2 flex-fill bd-highlight">
                                            SC undertakes to pay to the Client, on a monthly or "as received by debtor"
                                            basis, for all successful
                                            collections of the debt minus the commission and/or any outstanding fees,
                                            payments and costs
                                            calculated herein due to SC from the Client as set forth in section 3.(b)
                                            and 3.(c).
                                        </div>
                                    </div>

                                    <div class="d-flex bd-highlight col-md-11 p-0 m-0">
                                        <div class=" col-md-3 pt-2 flex-fill bd-highlight">
                                            (e) Scope of collection:
                                        </div>

                                        <div class=" col-md-9 pt-2 flex-fill bd-highlight">
                                            SC reserves the right to collect from the debtor/s all expenses and fees as
                                            provided for, as prescribed in the 'Debt Collection Act (2022), Singapore',
                                            and these costs will be deducted from the payments made to SC on a pro-rata
                                            basis.
                                        </div>
                                    </div>

                                    <div class="d-flex bd-highlight col-md-11 p-0 m-0">
                                        <div class=" col-md-3 pt-2 flex-fill bd-highlight">
                                            (f) Interest on debt:
                                        </div>

                                        <div class=" col-md-9 pt-2 flex-fill bd-highlight">
                                            Interest on debt: Interests collected on debt/s in addition to the capital
                                            amount will also be paid over to the Client
                                            subject to the stipulations in section 3.(b), 3.(c) and 3.(d).
                                        </div>
                                    </div>

                                    <div class="d-flex bd-highlight col-md-11 p-0 m-0">
                                        <div class=" col-md-3 pt-2 flex-fill bd-highlight">
                                            (g) Number of visits:
                                        </div>

                                        <div class=" col-md-9 pt-2 flex-fill bd-highlight">
                                            SC undertakes a committment to the Client<span class="text-of"> of <span
                                                    class="of-margin"> <b>
                                                        {{ $client_details->field_visit_per_case }}</b> </span> </span>
                                            visits per case assigned to SC during the validity
                                            of this agreement.
                                        </div>
                                    </div>
                                </div>
                            </li>


                            <li>In addition to the above-mentioned fee, the respective


                                In the event the the number of field visits for a particular case has reached its
                                maximum prescribed at Clause 3.(g) before full payment from the debtor/s, we shall be be
                                entitled to either;

                                <ul class="four-ul">
                                    <li style="margin-top: 8px;">4.1 Continue with the Agreement subject to payment of
                                        additional Enforcement Fees for further field visits to secure
                                        repayment<br><span style="padding-left: 24px; ">from the debtor; irregardless,
                                            or,</span> </li>
                                    <li style="margin-top: 8px;">4.2 Terminate the Agreement without any liability at no
                                        cost to SC whatsoever.</li>
                                </ul>
                            </li>


                            <li class="point-five">
                                In addition to the above-mentioned fees, the respective Debt Commission as per the debt
                                amount recovered is payable to us, whether the debt is recovered in full or in part, or
                                upon termination or expiry of this Agreement, as whatever the case may be.
                            </li>

                            <li>
                                For the avoidance of doubt, the criteria for expiration of this Agreement applies
                                severally to individual case/s referred to SC
                                by the Client.
                            </li>

                            <li>
                                This Agreement shall automatically expire and the relevant case file in our records
                                shall cease in the following circumstances; 03-017Add: Peninsula Plaza, 111 North Bridge
                                Road, #21-01, Singapore 179098 Off: +65 8505 5484 | Email: hello@securre.net | Web:
                                www.securre.netPage 2 of
                                <ul class="four-ul">
                                    <li style="margin-top: 8px;">7.1 If after 90 days from the date of this Agreement,
                                        we are unable to obtain any repayment of the debt from the debtor; or</li>

                                    <li style="margin-top: 8px;">7.2 In the case of a payment of the debt by instalments
                                        / partial-payment, a period of 120 days has lapsed since payment of the <br>
                                        <span style="padding-left: 24px;"> last instalment or part-payment by the
                                            debtor(s) and no further instalment / part-payment has been received from
                                            the </span> <br> <span style="padding-left: 24px;">debtor(s) (e.g. the
                                            debtor is undergoing bankruptcy / winding up proceedings or has
                                            absconded).</span>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                The Client/s acknowledge and agree that all the information and documents provided to us
                                in respect of each and every case is true and accurate to the best of their knowledge
                                and information.
                            </li>

                            <li>
                                In the event that the information on the debtor (e.g. the residential address,
                                commercial address and as well as other contact details) provided by you to us are
                                inaccurate, there shall be no refund of any of the fees whatsoever.
                            </li>

                            <li>
                                The contractual agreement between you and us is embodied in this <b>Agreement</b> , the
                                <b>Terms and Conditions </b> as annexed hereto
                                and the <b>Warrant to Act</b>/s as attached herewith from Page 3 onwards. Together,
                                these shall be indentified as the <b>"Contract Documents"</b> . Your execution of this
                                Agreement confirms that you have read, understood and accepted any and all the terms
                                as set out in the Contract Documents.
                            </li>

                            <li>
                                As per the terms of this Agreement set out in Clause 7., this Agreement shall be
                                considered void after the Date of Expiry as
                                stated unless renewed by SC at any time or by the Client within 14 days prior to expiry
                                with SC's written approval.
                            </li>

                            <li>
                                This Agreement is void and unenforceable unless accompanied by the signature of our
                                authorised agent or representative.
                            </li>

                        </ol>
                    </div>
                </div>


                <div class="col-12">
                    <div class="row another-row">
                        <div class="col-5 sincere py-4">
                            <h4>For Seccure Collection Pte. Ltd.</h4>
                            <span class="director for-after">Name: <span class="ravin">Ravin Raj G.(Ops
                                    Director)</span></span><br><br>
                            <span class="director">Designation:</span><br><br>
                            <span class="director">Date: <span
                                    class="ravin-date">{{ \Carbon\Carbon::parse($client_details->date_of_agreement)->format('d  F  Y') }}</span></span>
                            <p class="enclosed"> * Enclosed herein: Warrant to Act, herewith: T&C.</p>
                        </div>

                        <div class="col-7 second-box py-4">
                            <p>For the Client/s; </p>

                            <span class="Client">Client Name/s: </span> <span
                                class="company_uen_2">{{ $client_details->name }}</span><br><br>

                            <span class="company">Company Name: </span> <span
                                class="company_name">{{ $client_details->company_name }}</span><br><br>

                            <span class="designation">Designation:</span>
                            <span class="company_uen">{{ $client_details->company_uen }}</span><br><br>

                            <span class="Date">Date: </span> <span
                                class="date_uen">{{ \Carbon\Carbon::parse($client_details->date_of_agreement)->format('d  F  Y') }}</span><br><br><br>

                            <span class="stamp">Signature/Stamp:</span>
                        </div>
                    </div>
                </div>

                <div class="col-12 take-note" style="margin-bottom: 100px;">
                    <div class="col-2 bg-dark text-white py-2 my-4 d-flex justify-content-center"><span
                            style="font-size: 15px; font-weight: 600;">PLEASE TAKE NOTE:</span>
                    </div>
                    <div class="col-12">
                        <ol class="serve">
                            <li class="pl-4">All payments shall be made via CASH/CHEQUE or PAYNOW and an official
                                receipt will be issued.
                            </li>
                            <li class="pl-4 pt-2">Cheques should be made to Securre Collection Pte Ltd. Internet
                                banking should be via PayNow to <span style="text-decoration: underline;">"87428158"</span>
                            </li>
                            <li class="pl-4 pt-2">Bank transfer receipts should be submitted to us for bank transfers.
                                (Upon receiving full payment your case file will be allocated accordingly and an
                                official receipts will be issued via email/letter accordingly.
                            </li>
                            <li class="pl-4 pt-2">All case updates communications should be via email <span
                                    class="hello_securre_mail">hello@securre.net</span> or via our App/Website. Login
                                details will be
                                issued to you within 14 working days upon full payment of registration fees.
                            </li>
                            <li class="pl-4 pt-2">All communications on payments should be via email to <span
                                    class="hello_securre_web">dcms@securre.net</span> (cc: hello@securre.net).
                            </li>
                            <li class="pl-4 pt-2">1st case update will be within 10-14 working days, subsequently,
                                fortnightly. Any and all updates will be made available in your login 24hrs/day,
                                everyday.
                            </li>
                        </ol>
                    </div>
                </div>

            </div>
        </div>
    </div>




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
