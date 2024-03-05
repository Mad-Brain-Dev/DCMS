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
    <title>DCMS</title>


   <link rel="stylesheet" href="{{ asset('admin/css/agreement-print-screen.css') }}" media="screen">
   <link rel="stylesheet" href="{{ asset('admin/css/agreement-print.css') }}" media="print">

</head>

<body>
    <!--first agreement section start-->
    <section class="first_agreement">
        <div class="">
            <div class="container first-agreement-container">
                <div class="row hide-print-button">
                        <div class="col-12 d-flex justify-content-end mt-3">
                            <a href="{{ route('admin.cases.index') }}" class="btn btn-dark mr-2">Back</a>
                            <div class="btn btn-dark" id="document_print" onclick="printDocument()">Print Document</div>
                        </div>
                </div>
                <div class="row first-row justify-content-center">
                    <div class=" align-items-start d-flex">
                        <img class="logo" src="{{ asset('images/logo.jpg') }}" alt=""><span
                            class="debt-text">DEBT COLLECTION AGREEMENT</span>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <span class="text-to">To: </span><span class="to-margin">{{ $case_number->client->name }}</span>
                    </div>
                    <div class="col-6">
                        <div class="col-10 d-flex pt-2 pb-3">
                            <span class="d-f-agreement">Date of
                                Agreement:</span><span class="date_of_agreement_top">{{ \Carbon\Carbon::parse($client_details->date_of_agreement)->format('d - F - Y') }}</span>
                        </div>
                        <div class="col-10 d-flex pt-3 pb-2 expiry">
                            <span class="d-f-expiry">Date of Expiry:</span> <span
                                class="date_of_expiry">{{ \Carbon\Carbon::parse($client_details->date_of_expiry)->format('d - F - Y') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-4 ml-3 dear-sir">
                        <h5>Dear Sir / Madam,</h5>
                    </div>
                    <div class="col-7 ml-2">
                        <div class="row justify-content-end d-flex cases">
                            <div class="col-2 case-num">CASE NUMBER</div>
                            <div class="col-5 box-1st">{{ $case_number->case_number }}</div>
                            <div class="w-100"></div>
                            <div class="col-2 case-prov">CASE PROVISION</div>
                            <div class="col-5 box-2nd">{{ $case_number->current_status }}</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="ol-start mt-3">
                        <ol class="first-ol">
                            <li>Thank you for your interest in our services. We are pleased to set out the terms of our
                                debt collection services in this
                                letter. This Debt Collection Agreement (the "Agreement") shall apply severally to each
                                and every case you refer to us at
                                the point of execution of the Agreement, notwithstanding that only one original version
                                of this Agreement is signed between
                                the parties ("Parties" referred to as Securre Collection Pte Ltd and the person/company
                                ["Client"] as indicated in the 'Client
                                Information' section in the Warrant To Act attached herein. "SC" referred to as Securre
                                Collection Pte Ltd.)
                            </li>


                            <h5>Fees Payable, Collection Commission</h5>
                            <li>SC wishes to offer you our professional service of debt recovery,catered to your
                                delinquent account/s. The following
                                fees are pursuant to the respective package shall be payable upon execution of this
                                Agreement, as follows:-

                            </li>
                        </ol>
                    </div>
                </div>
                <div class="col-12 information-box">
                    <div class="row">
                        <div class="debt-collection col-md-3">
                            <h6>2.1 DEBT COLLECTION FEES</h6>
                        </div>
                    </div>

                    <div class="amount-informetion col-md-11 mx-auto">
                        <div class="row">
                            <div class="col-3">
                                <ul class="pl-3 fees-ul">
                                    <li>Administrative Fee:</li>
                                    <li>Enforcement Fee:</li>
                                    <li>Professional Fee</li>
                                    <li>Annual Fee:</li>
                                    <li>Skip-Tracing Fee</li>
                                    <li>Overseas Allowance</li>
                                    <li>Number of Visits:</li>
                                </ul>
                            </div>
                            <div class="col-2 amount-data pl-0 ml-0">
                                <ul class="pl-1 amount-ul">
                                    <li><i class="fa fa-usd" aria-hidden="true"></i><span
                                            class="fee">{{ $case_number->administrative_fee }}</span></li>
                                    <li><i class="fa fa-usd" aria-hidden="true"></i><span
                                            class="fee">{{ $case_number->enforcement_fee }}</span></li>
                                    <li><i class="fa fa-usd" aria-hidden="true"></i> <span
                                            class="fee">{{ $case_number->professional_fee }}</span></li>
                                    <li>
                                        <h6>{{ $case_number->annual_fee }}</h6>
                                    </li>
                                    <li>
                                        <h6>{{ $case_number->skip_tracing_fee }}</h6>
                                    </li>
                                    <li>
                                        <h6>{{ $case_number->overseas_allowance }}</h6>
                                    </li>
                                    <li>
                                        <h6>{{ $case_number->field_visit }}</h6>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-7">
                                <ul class="pl-0 another-ul">
                                    <li>(one-time, non-refundable)</li>
                                    <li>(for field engagement, in teams of 2-3 agents / <span class="cost">cost per
                                            visit</span>)</li>
                                    <li>(per assignment, for legal fees)</li>
                                    <li>(non-refundable, recurring fee, renewable every 12 months)</li>
                                    <li>(per assignment)</li>
                                    <li>(per assignment)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="new-informetion col-11 mx-auto">
                            <ul class="d-flex align-items-center pl-0">
                                <li class="collection-li">Collection Comm.:</li>
                                <li class="percenteg-li">{{ $case_number->collection_commission }} <span
                                        class="collection_comm_per">%</span></li>
                                <li class="total-li">Total Fees Payable:<i class="fa fa-usd"
                                        aria-hidden="true"></i><span class="fee-total">1000</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="new-text col-12 px-4">
                            <p>
                                * The above-mentioned fees are on an upfront payable fee structure for case enforcement,
                                only executable upon clearance of payment.<br><span class="further">
                                    Any further enforcement procedures requires the same and will incur additional costs
                                    to you. Minimum of 2-3 field officers per visit.</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="new-ul-start mt-4">

                        <ul class="provisions">
                            <h6>Provisions</h6>
                            <li>3. <span class="pl-3">In the event the the number of field visits for a particular
                                    case has reached its maximum prescribed at Clause 2 above before full payment from
                                    the debtor/s, <span class="right-padd">we shall be be entitled to either:</span>
                                </span>
                                <ul class="continue-ul">
                                    <li>3.1 <span class="pl-3">Continue with the Agreement subject to payment of
                                            additional Enforcement Fees for further field visits to secure repayment
                                            <br> <span class="another-padd"> from the debtor; or,</span></span></li>
                                    <li>3.2 <span class="pl-3"></span>Terminate the Agreement without any liability at
                                        no cost to Securre whatsoever.</li>
                                </ul>
                            </li>
                            <h6>Collection Commission</h6>
                            <li>4. <span class="pl-3">In addition to the above-mentioned fee, the respective <span
                                        class="collection-commission-bold">Collection Commission</span> as per the debt
                                    amount recovered is
                                    payable to us, whether the debt is <span class="right-padd">recovered in full or in
                                        part, or upon termination or expiry of this Agreement, as whatever the case may
                                        be.</span> </span></li>

                            <h6>Expiration of Agreement</h6>
                            <li>5. <span class="pl-3">For the avoidance of doubt, the criteria for expiration of this
                                    Agreement applies severally to individual cases referred to us byyou (in the event
                                    that there are <span class="right-padd">multiple cases assigned to us, they would
                                        apply to these terms individually of the same). ThisAgreement shall
                                        automatically expire and the relevant case file in </span> <span
                                        class="right-padd">our records shall be closed in the following
                                        circumstances;</span></span>

                                        {{-- <p class="location">Add: Peninsula Plaza, 111 North Bridge Road, #21-01, Singapore 179098
                                            Off: +65 8505 5484 | Email: hello@securre.net | Web: www.securre.net</p> --}}

                                <ul class="after-ul">
                                    <li>5.1 <span class="pl-3">If after 90 days from the date of this Agreement, we
                                            are unable to obtain any repayment of the debt from the debtor;o
                                        </span></li>
                                    <li class="five-point-two">5.2 <span class="pl-3">In the case of a payment of the debt by instalments /
                                            partial-payment, a period of 120 days has lapsed since payment of the last
                                            instalment or <span class="another-padd">part-payment by the debtor(s) and
                                                no further instalment / part-payment has been received from the
                                                debtor(s) (e.g. the debtor is undergoing </span> <span
                                                class="another-padd">bankruptcy / winding up proceedings or has
                                                absconded).
                                            </span></span></li>
                                </ul>
                            </li>
                            <li>6. <span class="pl-3">In a situation described at paragraph 5.1 above, any and all
                                    unutilized fees and/or enforcement procedures, shall be forfeited upon expiration of
                                    the <span class="right-padd"> Agreement.</span></span></li>
                            <li>7. <span class="pl-3">You acknowledge and agree that all the information and
                                    documents
                                    provided to us in respect of each and every case is true and accurate to the best of
                                    your <span class="right-padd"> knowledge and information.</span></span></li>
                            <li>8. <span class="pl-3">In the event that the information on the debtor (e.g. the
                                    residential address, commercial address and as well as other contact details)
                                    provided by you to us <span class="right-padd"> are inaccurate, there shall be no
                                        refund of any of the fees whatsoever.</span></span></li>
                            <li>9. <span class="pl-3">The contractual agreement between you and us is embodied in
                                    this <b>Agreement,</b> the <b>"Terms and Conditions"</b> as annexed hereto</span>
                                and the <b>Warrant to Act</b> as <span class="right-padd"> attached herewith on Page 3
                                    of 3. Together, these shall be indentified as the <b>"Contract
                                        Documents".</b> Your execution of this Agreement confirms that you </span> <span
                                    class="right-padd"> have read, understood and accepted any and all the terms
                                    as set out in the Contract Documents.</span></li>
                            <li>10. <span class="pl-3">As per the terms of this Agreement set out in paragraph 5,
                                    this Agreement shall be considered void after the Date of Expiry as</span>
                                stated above unless renewed <span class="right-within"> within 14 days prior to expiry
                                    by both parties.</span></li>
                            <li>11. <span class="pl-3">This Agreement is void and unenforceable unless accompanied by
                                    the signature of our authorised agent or representative.</span></li>
                        </ul>
                    </div>
                </div>


                <div class="col-12">
                    <div class="row another-row">
                        <div class="col-6 sincere py-4">
                            <span class="sincerely">Sincerely,</span>
                            <h4>Securre Collection Pte Ltd</h4>
                            <span class="director">Name: <span class="ravin">Ravin Raj G.(Ops
                                    Director)</span></span><br>
                            <span class="director">Date: <span
                                    class="ravin-date">{{ \Carbon\Carbon::parse($client_details->date_of_agreement)->format('d - F - Y') }}</span></span>
                            <p class="enclosed">* Enclosed herein: Warrant to Act, herewith: T&C.</p>
                        </div>
                        <div class="col-6 second-box py-4">
                            <p>I have read, and hereby confirm acceptance of all terms and <br>conditions set-out herein
                                <span class="dated">dated: </span> <span
                                    class="january-4">{{ \Carbon\Carbon::parse($client_details->date_of_agreement)->format('d - F - Y') }}</span>
                            </p><br>
                            <span class="company">Company/UEN: </span> <span
                                class="company_uen">{{ $client_details->company_uen }}</span><br>
                            <span class="uen">Company/UEN: </span> <span
                                class="company_uen">{{ $client_details->company_uen }}</span><br><br>
                            <span class="nric">Name/NRIC: </span> <span
                                class="company_uen_2">{{ $client_details->nric }}</span><br>
                            <span class="designation">Designation:</span><span class="company_uen_2"></span><br><br>
                            <span class="stamp">Signature/Stamp:</span><br>
                        </div>
                    </div>
                </div>

                <div class="col-12 take-note">
                    <div class="col-3 bg-dark text-white py-2 my-4 d-flex justify-content-center"><span
                            class="">PLEASE TAKE NOTE:</span></div>
                    <div class="col-12">
                        <ol class="serve">
                            <li class="pl-4">All payments shall be made via CASH/CHEQUE or PAYNOW and this contract
                                will serve as an official receipt.
                            </li>
                            <li class="pl-4 pt-2">Cheques should be made to Securre Collection Pte Ltd.</li>
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
               {{-- <div class="row">
                <div class="col-12">
                    <p class="location-for-second-page">Add: Peninsula Plaza, 111 North Bridge Road, #21-01, Singapore 179098
                        Off: +65 8505 5484 | Email: hello@securre.net | Web: www.securre.net</p>
                </div>
               </div> --}}
            </div>
        </div>
        </div>
    </section>
    <!--first agreement section end-->


 <!--second section start-->
<section>
    <div class="second-section">
        <div class="container mb-5">
            <div class="col-md-12 mx-auto text-center warrant-act">
                <h1>WARRANT TO ACT</h1>
                <p>SUBJECT TO CHAPTER 53B (ORIGINAL ENACTMENT: ACT 39 of 2001) REVISED EDITION 2002, SECTION 2.1</p>
            </div>
            <hr class="new-hr">
            <div class="row">
                <div class="col-5">
                    <p><span class="to-securre">TO:</span> Securre Collection Pte Ltd</p>
                    <span class="client-information">CLIENT INFORMATION</span>
                </div>
                <div class="col-7">
                    <div class="d-flex new-case">
                        <div class="col-3 case-ref">CASE REF. #:</div>
                    <div class="col-9 data-for-case"><span class="case_ref">{{ $case_number->case_number }}</span></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-11 mx-auto take-information">
                    <ul class="list-unstyled">
                        <li><span class="full-name">Full Name:</span> <span class="padding-for-new-data"> {{ $client_details->name }}</span></li>
                        <li><span class="company-name">Company Name:</span> <span class="padding-for-new-data"> {{ $client_details->company_name }}</span> </li>
                        <li><span class="nric-no">NRIC No./UEN:</span> <span class="padding-for-new-data">{{ $client_details->nric }}</span>  </li>
                        <li><span class="contact-no">Contact No.:</span> <span class="padding-for-new-data">{{ $client_details->phone }}</span>  </li>
                        <li><span class="email-add">Email Add.:</span>
                        <span class="padding-for-new-data"> {{ $client_details->email }}</span> </li>
                        <li><span class="address">Address:</span> <span class="padding-for-new-data"> {{ $client_details->address }} </span></li>
                    </ul>
                </div>
            </div>
            <div class="row mt-4">
                <span class="debtor-information">DEBTOR INFORMATION</span>
                <div class="col-md-11 mx-auto take-information">
                    <ul class="list-unstyled">
                        <li><span class="full-name">Full Name:</span> <span class="padding-for-new-data">{{ $case_number->name }}</span> </li>
                        <li><span class="company-name">Company Name:</span> <span class="padding-for-new-data">{{ $case_number->company_name }}</span> </li>
                        <li><span class="nric-no">NRIC No./UEN:</span> <span class="padding-for-new-data">{{ $case_number->company_uen }}</span> </li>
                        <li><span class="contact-no">Contact No.:</span> <span class="padding-for-new-data">{{ $case_number->phone }}</span> </li>
                        <li><span class="email-add">Email Add.:</span> <span class="padding-for-new-data">{{ $case_number->email }}</span> </li>
                        <li><span class="address-2">Address:</span> <span class="padding-for-new-data">{{ $case_number->adderss }}</span> </li>
                        <li class="remarks-li"><span class="remarks">Remarks:</span><span class="padding-for-new-data">{{ $case_number->remarks }}</span></li>
                    </ul>
                </div>
            </div>
            <div class="row debt-amount-row">
                <div class="col-8">
                    <span class="total-debt">Total Debt Amount in</span><br>
                    <span class="singapore-dollars"> Singapore Dollars:
                         {{ ucwords((new NumberFormatter('en_IN', NumberFormatter::SPELLOUT))->format($case_number->debt_amount)) }} </span>
                </div>
                <div class="col-4 new-usd">
                     <span class="new-usd-after">(SG<i class="fa fa-usd" aria-hidden="true"></i>:</span> <span class="right-usd-data">{{ $case_number->debt_amount }}</span><span class="bracket_end">)</span>
               </div>
            </div>
          <div class="row another-information-row">
            <ol class="">
                <li class="first-child">*I/We, the undersigned, hereby appoint you to act for <span class="me-us-after">*me/us </span> <span class="agreement_name">{{ $client_details->name }}</span><br>
                    <span class="nric-no-uen-after">NRIC No./UEN: </span><span class="agreement_nric">{{ $client_details->nric }}</span> <br>in connection with the above matter until it
                    is completed, settled, resolved or the contractual agreement between us and you is terminated for whatsoever reason.
                    All cheques shall be made payable to Securre Collection Pte Ltd, and online payments made via PayNow to<span class="new-underline"> 85055484.</span></li>
                <li class=""><span class="">Our engagement of your services are subjected to the terms and conditions as set out in the Debt Collection Agreement
                    as stated above on Page 1 and Page 2.</span></li>
                <li class=""><span class="">*I/We authorise you to receive payment from the debtor directly in your favour (on our behalf) and to do everything you
                    consider necessary in your conduct of the above matter. This Warrant to Act serves as a formal Warrant to Act which may
                    be produced to third parties as evidence of your engagement to act on our behalf in connection with the above matter.</span></li>
                <li class=""><span class="">*I/We authorise you to take instructions in respect of this matter from:</span></li>
            </ol>
         <div class="col-md-10 mx-auto mb-2">
          <div class="row">
            <div class="col-6"><span class="person pb-1">Person:</span> <span class="lorem-2">{{ $client_details->name }}</span></div>
            <div class="col-6"><span class="contact pb-1">Contact:</span> <span class="lorem-2">{{ $client_details->phone }}</span></div>
          </div>
         </div>
         </div>
         <div class="pt-2">
            <ul class="list-unstyled">
                <li>Full Name: {{ $client_details->name }}</li>
                <li>Company Name: {{ $client_details->company_name }}</li>
                <li>NRIC No./UEN: {{ $client_details->company_name }} </li>
                <li>Contact No.: {{ $client_details->phone }}</li>
                <li>Signature/Stamp:</li>
                <li class="font-italic">*Strike out where necessary.</li>
            </ul>
        </div>
      </div>
    </div>

</section>
<footer style="font-weight: 700; font-style:italic">
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
</body>

</html>
