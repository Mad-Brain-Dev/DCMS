<!doctype html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Work+Sans:ital,wght@0,100..900;1,100..900&family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Hello, world!</title>


    <style>
        .first-row {}
        .first-agreement-container{
            font-family: "Open Sans", sans-serif;
            font-size: 14px;
            font-weight: 600;
        }
        .logo {
            width: 380px;
            margin-right: 10px;
        }

        .debt-text {
            margin-left: 20px;
            padding-top: 24px;
            font-size: 45px;
            font-weight: 500;
            font-family: "Barlow", sans-serif;
        }

        hr {
            background: #000;
            padding-top: 2px;
            transform: translateY(-21px);
        }

        .text-to {
            position: relative;
            padding-left: 38px;
        }

        .text-to::after {
            content: '';
            position: absolute;
            background: #000;
            height: 1px;
            width: 595px;
            bottom: -7px;
            left: 78px;
        }

        .text-to::before {
            content: '';
            position: absolute;
            background: #000;
            height: 1px;
            width: 595px;
            bottom: -57px;
            left: 78px;
        }

        .d-f-agreement {
            padding-right: 25px;
            position: relative;
        }

        .d-f-agreement::after {
            content: '';
            position: absolute;
            background: #000;
            height: 1px;
            width: 95%;
            bottom: -5px;
            left: 92%;
        }
        .expiry{
            padding-right: 30px;
        }

        .d-f-expiry {
            margin-right: 30px;
            position: relative;
        }

        .d-f-expiry::after {
            content: '';
            position: absolute;
            background: #000;
            height: 1px;
            width: 155%;
            bottom: -5px;
            left: 107%;
        }

        .case-num {
            font-family: "Open Sans", sans-serif;
            font-size: 13px;
            text-align: center;
            color: #ffff;
            background: #000;
            font-weight: 600;
            padding-left: 0;
            padding-top: 7px;
            padding-bottom: 7px;
            padding-right: 0;
            border-bottom: none;
            border-top: 3px solid #000;
            border-right: 1px solid #000;
            border-bottom: 1px solid #000;
            border-left: 3px solid #000;
        }

        .case-prov {
            font-family: "Open Sans", sans-serif;
            text-align: center;
            font-size: 13px;
            color: #ffff;
            background: #000;
            font-weight: 600;
            padding-left: 0;
            padding-right: 0;
            padding-top: 7px;
            padding-bottom: 7px;
            border-top: 1px solid #000;
            border-right: 1px solid #000;
            border-bottom: 3px solid #000;
            border-left: 3px solid #000;
        }

        .box-1st {
            border-top: 3px solid #000;
            border-right: 3px solid #000;
            border-bottom: 1px solid #000;
            border-left: 1px solid #000;
        }

        .box-2nd {
            border-top: 1px solid #000;
            border-right: 3px solid #000;
            border-bottom: 3px solid #000;
            border-left: 1px solid #000;
        }
        .dear-sir h5{
            padding-top: 17px;
            padding-left: 15px;
            font-size: 15px;
            font-weight: 700;
            font-family: "Open Sans", sans-serif;
        }
        .ol-start .first-ol{
            padding-right: 50px;
            font-size: 14px;
            font-weight: 600;
            font-family: "Open Sans", sans-serif;
        }
        .ol-start .first-ol h5 {
            padding-top: 30px;
            font-size: 18px;
            font-weight: 700;
            font-family: "Open Sans", sans-serif;
        }

/* provisions start */
        .new-ul-start .provisions li{
            padding-bottom: 20px;
            list-style: none;
        }
        .new-ul-start .provisions h6{
            padding-left: 30px;
            font-size: 18px;
            font-weight: 700;
            font-family: "Open Sans", sans-serif;
        }
/* provisions ends */
        .information-box {
            border: 3px solid #000;
        }

        .debt-collection {
            padding-top: 5px;
            text-align: center;
            border-bottom: 2px solid #000;
            border-right: 2px solid #000;
        }
        .debt-collection h6{
            font-size: 17px;
            font-weight: 700;
            font-family: "Open Sans", sans-serif;
        }
        .fees-ul {
            font-size: 15px;
        }
        .fees-ul li{
            font-size: 14px;
            font-weight: 600;
            font-family: "Open Sans", sans-serif;
        }
        .amount-ul li i{
            font-size: 18px;
            font-weight: 600;
            font-family: "Open Sans", sans-serif;
            font-style: italic;
        }
        .amount-ul li h6{
            font-size: 15px;
            font-weight: 600;
            font-family: "Open Sans", sans-serif;
            font-style: italic;
        }
        .another-ul{
            font-size: 13px;
            font-weight: 500;
            font-family: "Open Sans", sans-serif;
            font-style: italic;
        }
        .another-ul .cost{
            font-size: 13px;
            font-weight: 700;
            font-family: "Open Sans", sans-serif;
            font-style: italic;
            border-bottom: 1.5px solid #000;
        }
        .amount-informetion {
            margin-top: 30px;
        }

        .amount-informetion ul li {
            list-style: none;
            margin-top: 15px;
        }

        .amount-data ul {
            font-size: 15px;
        }

        .amount-data ul li h6{
            text-align: center;
        }
        .amount-data ul li i{
            position: relative;
        }
        .amount-data ul li i::after{
            content: '';
            position: absolute;
            background: #000;
            width: 140px;
            height: 1.5px;
            bottom: 0;
            left: 100%;
        }
        
        .new-informetion {}

        .new-informetion ul li {
            list-style: none;
            font-size: 14px;
            font-weight: 600;
            font-family: "Open Sans", sans-serif;
        }

        .collection-li {
            padding-left: 28px;
        }

        .percenteg-li {
            padding-left: 90px;
        }

        .total-li {
            padding-left: 90px;
        }
        .total-li i{
            position: relative;
            padding-left: 30px;
            font-style: italic;
        }
        .total-li i::after{
            content: '';
            position: absolute;
            background: #000;
            width: 180px;
            height: 1.5px;
            bottom: 0;
            left: 100%;
        }
     
        .new-text p{
            font-size: 13px;
            font-weight: 600;
            font-family: "Open Sans", sans-serif;
            font-style: italic;
            padding-left: 35px;
        }
        .new-text .further{
            padding-left: 10px;
        }
        .bold{
            font-weight: 800;
        }
        .right-padd{
            padding-left: 30px;
        }
        .right-within{
            padding-left: 38px;
        }
        .another-padd{
            padding-left: 38px;
        }
        .continue-ul{
            margin-top: 15px;
            padding-left: 150px;
        }
        .after-ul{
            margin-top: 15px;
            padding-left: 60px;
        }

        .dated{
            position: relative;
        }
        .dated::after{
            content: '';
            position: absolute;
            background: #000;
            width: 170px;
            height: 2px;
            bottom: -8px;
            right: -410%;
        }
        .january-4{
            padding-left: 50px;
            font-weight: 700;
        }
        .another-row{
            margin-top: 20px;
            margin-block: 40px;
        }
        .another-row .second-box{
            border: 2px solid #000;
            padding-top: 30px;
            padding-bottom: 30px;
        }
        .sincere .director{
            font-size: 14px;
            font-weight: 600;
            font-family: "Open Sans", sans-serif;
        }
        .ravin{
            padding-left: 65px;
        }
        .ravin-date{
            padding-left: 110px;
        }
        .sincere h4{
            padding-left: 47px;
            position: relative;
            margin-top: 75px;
            margin-bottom: 40px;
            font-size: 20px;
            font-weight: 700;
            font-family: "Open Sans", sans-serif;
        }
        .sincere h4::after{
            content: '';
            position: absolute;
            width: 340px;
            height: 1.6px;
            background: #000;
            top: -15px;
            left: 10px;
        }
        .sincere .enclosed{
            font-size: 13px;
            font-weight: 500;
            font-family: "Open Sans", sans-serif;
            font-style: italic;
            padding-top: 20px;
        }
        .company{
            position: relative;
        }
        .company::after{
            content: '';
            position: absolute;
            width: 290px;
            height: 1.5px;
            background: #000;
            bottom: -6px;
            right: -305%;
        }
        .uen{
            position: relative;
        }
        .uen::after{
            content: '';
            position: absolute;
            width: 290px;
            height: 1.5px;
            background: #000;
            bottom: -6px;
            right: -305%;
        }
        .nric{
            position: relative;
        }
        .nric::after{
            content: '';
            position: absolute;
            width: 290px;
            height: 1.5px;
            background: #000;
            bottom: -6px;
            right: -425%;
        }
        .designation{ 
            position: relative;
        }
        .designation::after{
            content: '';
            position: absolute;
            width: 290px;
            height: 1.5px;
            background: #000;
            bottom: -6px;
            right: -390%;
        }
        .stamp{
            position: relative;
            font-size: 13px;
        }
        .stamp:after{
            content: '';
            position: absolute;
            width: 290px;
            height: 1.5px;
            background: #000;
            bottom: -6px;
            right: -278%;
        }
        .take-note{
            margin-bottom: 200px;
        }
        .please-take{
            font-size: 17px;
            font-weight: 500px;
            font-family: "Work Sans", sans-serif;
        }
        .coll-comm{
            text-decoration: underline;
        }
        .serve{
            font-size: 15px;
            font-weight: 600px;
            font-family: "Inter", sans-serif;

        }


        /*  */
        .warrant-act h1{
            font-size: 110px;
            font-weight: 400;
            font-family: "Playfair Display", serif;
        }
    </style>

</head>

<body>
<!--first agreement section start-->
    <section>
        <div class="">
            <div class="container first-agreement-container">
                <div class="row first-row mt-5 justify-content-center">
                    <div class=" align-items-start d-flex">
                        <img class="logo" src="{{ asset('images/logo.jpg') }}" alt=""><span
                            class="debt-text">DEBT COLLECTION AGREEMENT</span>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-7">
                        <span class="text-to">To:</span>
                    </div>
                    <div class="col-md-5">
                        <div class="col-md-10 justify-content-end d-flex pt-2 pb-3">
                            <span class="d-f-agreement">Date of Agreement:</span><span>4-January-2024</span>
                        </div>
                        <div class="col-md-10 justify-content-end d-flex pt-3 pb-2 expiry">
                            <span class="d-f-expiry">Date of Expiry:</span> <span class="">3-April-2024</span>
                        </div>
                    </div>
                </div>


                <div class="row mt-4">
                    <div class="col-md-4 ml-3 dear-sir">
                       <h5>Dear Sir / Madam,</h5>
                    </div>
                    <div class="col-md-7 ml-2">
                        <div class="row justify-content-end d-flex cases">
                            <div class="col-md-2 case-num">CASE NUMBER</div>
                            <div class="col-md-5 box-1st"></div>
                            <div class="w-100"></div>
                            <div class="col-md-2 case-prov">CASE PROVISION</div>
                            <div class="col-md-5 box-2nd"></div>
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


                <div class="col-md-12 information-box">
                    <div class="row">
                        <div class="debt-collection col-md-3">
                            <h6>2.1 DEBT COLLECTION FEES</h6>
                        </div>
                    </div>

                    <div class="amount-informetion col-md-11 mx-auto">
                        <div class="row">
                            <div class="col-md-3">
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
                            <div class="col-md-2 amount-data pl-0 ml-0">
                                <ul class="pl-1 amount-ul">
                                    <li><i class="fa fa-usd" aria-hidden="true"></i></li>
                                    <li><i class="fa fa-usd" aria-hidden="true"></i></li>
                                    <li><i class="fa fa-usd" aria-hidden="true"></i></li>
                                    <li><h6>NIL</h6></li>
                                    <li><h6>NIL</h6></li>
                                    <li><h6>N/A</h6></li>
                                    <li><h6>10</h6></li>
                                </ul>
                            </div>
                            <div class="col-md-7">
                                <ul class="pl-0 another-ul">
                                    <li>(one-time, non-refundable)</li>
                                    <li>(for field engagement, in teams of 2-3 agents / <span class="cost">cost per visit</span>)</li>
                                    <li>(per assignment, for legal fees)</li>
                                    <li>(non-refundable, recurring fee, renewable every 12 months)</li>
                                    <li>(per assignment)</li>
                                    <li>(per assignment)</li>
                                </ul>


                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="new-informetion col-md-11 mx-auto">
                            <ul class="d-flex align-items-center pl-0">
                                <li class="collection-li">Collection Comm.:</li>
                                <li class="percenteg-li">______ % / 20% / 30 % / 40%</li>
<li class="total-li">Total Fees Payable:<i class="fa fa-usd" aria-hidden="true"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="row">
                        <div class="new-text col-md-12 px-4">
                            <p>
                                * The above-mentioned fees are on an upfront payable fee structure for case enforcement, only executable upon clearance of payment.<br><span class="further">
Any further enforcement procedures requires the same and will incur additional costs to you. Minimum of 2-3 field officers per visit.</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                  <div class="new-ul-start mt-4">
                    
                      <ul class="provisions">
                        <h6 >Provisions</h6>
                        <li>3. <span class="pl-3">In the event the the number of field visits for a particular case has reached its maximum prescribed at Clause 2 above before full payment from the debtor/s, <span class="right-padd">we shall be be entitled to either:</span> </span>
                             <ul class="continue-ul">
                                <li>3.1  <span class="pl-3">Continue with the Agreement subject to payment of additional Enforcement Fees for further field visits to secure repayment <br> <span class="another-padd"> from the debtor; or,</span></span></li>
                                <li>3.2  <span class="pl-3"></span>Terminate the Agreement without any liability at no cost to Securre whatsoever.</li>
                             </ul>
                        </li>
                        <h6>Collection Commission</h6>
                        <li>4.  <span class="pl-3">In addition to the above-mentioned fee, the respective <span class="coll-comm">Collection Commission</span> as per the debt amount recovered is payable to us, whether the debt is <span class="right-padd">recovered in full or in part, or upon termination or expiry of this Agreement, as whatever the case may be.</span> </span></li>

                        <h6>Expiration of Agreement</h6>
                        <li>5. <span class="pl-3">For the avoidance of doubt, the criteria for expiration of this Agreement applies severally to individual cases referred to us byyou (in the event that there are <span class="right-padd">multiple cases assigned to us, they would apply to these terms individually of the same). ThisAgreement shall automatically expire and the relevant case file in  </span> <span class="right-padd">our records shall be closed in the following circumstances;</span></span>

                            <ul class="after-ul">
                                <li>5.1  <span class="pl-3">If after 90 days from the date of this Agreement, we are unable to obtain any repayment of the debt from the debtor;o
                                </span></li>
                                <li>5.2  <span class="pl-3">In the case of a payment of the debt by instalments / partial-payment, a period of 120 days has lapsed since payment of the last instalment or <span class="another-padd">part-payment by the debtor(s) and no further instalment / part-payment has been received from the debtor(s) (e.g. the debtor is undergoing </span> <span class="another-padd">bankruptcy / winding up proceedings or has absconded).
                                </span></span></li>
                            </ul>
                        </li>
                        <li>6.  <span class="pl-3">In a situation described at paragraph 5.1 above, any and all unutilized fees and/or enforcement procedures, shall be forfeited upon expiration of the <span class="right-padd"> Agreement.</span></span></li>
                        <li>7.  <span class="pl-3">You acknowledge and agree that all the information and documents provided to us in respect of each and every case is true and accurate to the best of your <span class="right-padd"> knowledge and information.</span></span></li>
                        <li>8.  <span class="pl-3">In the event that the information on the debtor (e.g. the residential address, commercial address and as well as other contact details) provided by you to us <span class="right-padd"> are inaccurate, there shall be no refund of any of the fees whatsoever.</span></span></li>
                        <li>9.  <span class="pl-3">The contractual agreement between you and us is embodied in this <span class="bold">Agreement,</span> the <span class="bold">"Terms and Conditions"</span> as annexed hereto</span>
                            and the <span class="bold">Warrant to Act</span> as <span class="right-padd"> attached herewith on Page 3 of 3. Together, these shall be indentified as the <span class="bold">"Contract
                            Documents".</span> Your execution of this Agreement confirms that you </span>  <span class="right-padd"> have read, understood and accepted any and all the terms
                            as set out in the Contract Documents.</span></li>
                        <li>10.  <span class="pl-3">As per the terms of this Agreement set out in paragraph 5, this Agreement shall be considered void after the Date of Expiry as</span>
                            stated above unless renewed  <span class="right-within"> within 14 days prior to expiry by both parties.</span></li>
                        <li>11.  <span class="pl-3">This Agreement is void and unenforceable unless accompanied by the signature of our authorised agent or representative.</span></li>
                      </ul>
                  </div>
              </div>

              
              <div class="col-md-12">
                <div class="row another-row">
                    <div class="col-md-6 sincere py-4">
                        <span class="sincerely">Sincerely,</span>
                        <h4>Securre Collection Pte Ltd</h4>
                         <span class="director">Name: <span class="ravin">Ravin Raj G.(Ops Director)</span></span><br>
                         <span class="director">Date: <span class="ravin-date">4-january-2024</span></span> 
                         <p class="enclosed">* Enclosed herein: Warrant to Act, herewith: T&C.</p>
                    </div>
                    <div class="col-md-6 second-box py-4">
                        <p>I have read, and hereby confirm acceptance of all terms and <br>conditions set-out herein <span class="dated">dated: </span> <span class="january-4">4-January-2024</span></p><br>
                        <span class="company">Company/UEN:</span><br>
                        <span class="uen">Company/UEN:</span><br><br>
                        <span class="nric">Name/NRIC</span><br>
                        <span class="designation">Designation:</span><br><br>
                        <span class="stamp">Signature/Stamp:</span><br>
                    </div>
                </div>
              </div>

              <div class="col-md-12 take-note">
                    <div class="col-md-3 bg-dark text-white py-2 my-4 d-flex justify-content-center"><span class="please-take">PLEASE TAKE NOTE:</span></div>
                    <div class="col-md-12">
                        <ol class="serve">
                            <li class="pl-4">All payments shall be made via CASH/CHEQUE or PAYNOW and this contract will serve as an official receipt.
                            </li>
                            <li class="pl-4 pt-2">Cheques should be made to Securre Collection Pte Ltd.</li>
                            <li class="pl-4 pt-2">Bank transfer receipts should be submitted to us for bank transfers. (Upon receiving full payment your case file will be allocated accordingly and an official receipts will be issued via email/letter accordingly.
                            </li>
                            <li class="pl-4 pt-2">All case updates communications should be via email <span class="coll-comm">hello@securre.net</span> or via our App/Website. Login details will be issued to you within 14 working days upon full payment of registration fees.
                            </li>
                            <li class="pl-4 pt-2">All communications on payments should be via email to <span class="coll-comm">dcms@securre.net</span> (cc: hello@securre.net). 
                            </li>
                            <li class="pl-4 pt-2">1st case update will be within 10-14 working days, subsequently, fortnightly. Any and all updates will be made available in your login 24hrs/day, everyday.
                            </li>
                        </ol>
                    </div>
              </div>
              
              </div>
            </div>
        </div>
    </section>
<!--first agreement section end-->


<!--second section start-->
{{-- <section>
    <div class="">
        <div class="container mb-5">
            <div class="col-md-12 mx-auto text-center warrant-act">
                <h1>WARRANT TO ACT</h1>
                <p>SUBJECT TO CHAPTER 53B (ORIGINAL ENACTMENT: ACT 39 of 2001) REVISED EDITION 2002, SECTION 2.1</p>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-5 bg-info">
                    <p>TO: Securre Collection Pte Ltd</p>
                </div>
                <div class="col-md-7 bg-danger"></div>
            </div>
        </div>
    </div>
</section> --}}
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
