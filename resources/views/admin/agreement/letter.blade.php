<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('admin/css/letter-screen.css') }}" media="screen">
    <link rel="stylesheet" href="{{ asset('admin/css/letter-print.css') }}" media="print">
</head>

<body>
    <div class="container">
        <div class="col-md-12 print-button">
            <div class=" d-flex justify-content-end mt-2">
                <a href="{{ route('admin.cases.index') }}" class="btn btn-danger mr-1">Back</a>
                <button class="btn btn-primary" id="letter_print" onclick="printLetter()">Print</button>
                <a class="btn btn-dark ml-1" href="{{ route('printable.case.agreement', $case_number->id) }}">Print
                    Warrant</a>
            </div>
        </div>
        {{-- Header button end --}}

        <section style="margin-bottom: 4rem;">
            <div class="container-padding">
                <div class="row mb-3 header" style="margin-top: 1rem;">
                    <div class="col-1">
                        <div class="first_col"></div>
                    </div>
                    <div class="col-4 pl-0 second_col">
                        <div>
                            <img src="{{ asset('admin/images/logo.png') }}" class="d-block logo-size-2nd"
                                alt="logo" />
                        </div>
                    </div>
                    <div class="col-7 pl-0 third_col d-flex">

                        <p class="" style="margin-top: -5px;">
                            <span style="font-weight: 600">Debt Collection</span>, Factoring |
                            Transportation | Logistics Services |
                            <span style="font-weight: 600">© 2001</span>
                        </p>

                    </div>
                </div>
                {{-- logo div end --}}

                <div class="d-flex justify-contant-center align-items-start debtor-part">
                    <div class="col-md-6">
                        <ul>
                            <li>
                                <b><span style="font-weight: 700; color: #000">{{ $case_number->name }}
                                        {{ $case_number->company_name }}</span></b>
                            </li>

                            <li><span style="color: #000">{{ $case_number->adderss }}</span></li>

                            <li>
                                <b><span
                                        style="color: #000; font-weight: 700;">{{ $case_number->guarantor_name }}</span></b>
                            </li>

                            <li><span style="color: #000;">{{ $case_number->guarantor_address }}</span></li>
                        </ul>
                    </div>

                    <div class="col-md-6 d-flex justify-content-center align-items-start">
                        <ul>
                            <li>
                                <b style="padding-right: 30px">OUR REF : </b> <span
                                    style="color: #000">{{ $case_number->case_sku }}</span>
                            </li>

                            <li>
                                <b>YOUR REF : </b>
                                <span style="padding-left: 23px;"></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- debtor div end -->


                <div class="d-flex justify-content-center align-items-start sir_or_byHand">
                    <div class="col-md-6">
                        <p class="dear_sir">Dear Sir/Madam,</p>
                    </div>
                    <div class="col-md-6 d-flex justify-content-center">
                        <p class="by_hand_only">BY HAND ONLY</p>
                    </div>
                </div>
                <!--  dear sir div end -->
                <div class="d-flex align-items-start re_debts_owend">
                    <div class="col-md-6">
                        <p style="font-weight: 700; font-size: 18px;">
                            RE: DEBTS OWED TO <span style="">{{ strtoupper($client_details->name) }}</span>
                        </p>
                    </div>
                    <div class="col-md-5 d-flex justify-content-end">
                        <p style="font-weight: 700; font-size: 18px">
                            <span
                                style="font-weight: 700;">{{ $case_number->created_at->format('jS \\of F Y') }}</span>
                        </p>
                    </div>
                </div>

                <!-- debts owed end -->

                <div class="row order_list" style="padding-right: 40px">
                    @php
                        $formattedAmount = number_format($case_number->total_amount_owed, 2, '.', ',');
                    @endphp
                    <ol type="1">
                        <li>
                            Our firm represents Messrs. <span
                                style="text-transform: uppercase; font-size: 18px;">{{ $client_details->name }}</span>
                            . We have
                            been retained by them to collect your account which is
                            seriously delinquent in the amounts of <span class="amount_after">
                                S${{ $formattedAmount }}
                            </span> .
                        </li>

                        <li>
                            We know of no legitimate basis for you stopping payment other than
                            an attempt by to avoid paying a just indebtedness. As such, your
                            failure to timely pay is a breach of your agreement and contract law.
                        </li>

                        <li>
                            We will give you an opportunity to pay the amount due before any further debt recovery
                            arrangements are made, (which may include but is not limited to, attaining a Court Order,
                            enforcing the Judgement through filing for Bankruptcy, Writ of Seizure and Sale, Garnishee
                            orders and/or engaging News Media Correspondents to highlight this matter at your registered
                            addresses listed on file); however, payment must be made in strict accordance with the terms
                            of this letter. The terms are as follows;

                            <ol class="chile_order_list" style="padding-left: 50px" type="a">
                                <li>
                                    Full payment of the total amount due must be received in our
                                    office within seven (07) days of this letter;
                                </li>

                                <li>No partial payments will be accepted; and,</li>

                                <li>
                                    Other than this letter, no additional demands will be made
                                    upon you to pay prior to our field enforcement and/or legal
                                    proceedings.
                                </li>
                            </ol>
                        </li>

                        <li>
                            This is an attempt to collect a debt and any information obtained
                            will be used against you for that purpose.
                        </li>

                        <li>
                            If the total amount due is not paid to our office by the <span class="date_time_after">
                                @php
                                    use Carbon\Carbon;
                                    $newDate = Carbon::parse($case_number->created_at)
                                        ->addDays(7)
                                        ->format('jS \\of F Y');
                                @endphp
                                {{ $newDate }} 15:00 hours</span>, our next course of action will be enforced
                            against
                            you without further notice and you will be liable for any and all costs arising thereof.
                        </li>

                        <li>
                            This is a serious matter which requires your immediate attention. As such, we’d advise you
                            to expedite payment arrangements as soon as possible.
                        </li>

                        <li>
                            For more information on debt settlement, debt financing and loan assistance (on a
                            case-to-case basis) via Securre Network, please visit our website at
                            <span style="color: #1f497d;  font-weight: 600; cursor: pointer;">
                                www.securre.net/dcms</span> or you may contact us via WhatsApp at +65 8505 5484.

                        </li>

                    </ol>
                    <div>
                        <ul>
                            <li style="padding-bottom: 20px; padding-left: 14px;">

                                8.<span style="padding-left: 10px;"> In the meantime, our client and we hereby reserve
                                    our rights
                                    against you to exercise any and all legal<br />
                                    <span style="padding-left: 27px;">countermeasure made available to us.</span>
                                </span>
                            </li>

                            <li style="padding-left: 14px;" class="thank-you-part">

                                9.<span style="padding-left: 10px;"> Thank you for your time and we expect to hear from
                                    you within
                                    seven (07) days.
                                </span>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="ravin_self_div">

                <div class="col-md-11" style="padding-left: 80px;">
                    <h5 id="point-eight">Sincerely ,</h5>
                    <div class="d-flex" style="padding-left: 60px;">
                        <div class="new-logo-div">
                            <img src="{{ asset('admin/images/new_logo.png') }}" alt="logo" />
                        </div>

                        <div class="ravin_raj pl-5 pt-2">
                            <h2>Ravin Raj G.</h2>
                            <div class="column_div">
                                <span style="font-style: italic; padding-top: 10px;">Operations Director |
                                    Partner</span>
                                <span style="font-weight: 800; color: #002060;">Securre Collection Pte Ltd</span>
                                <span> <span style="color: #0c5897;">t: </span><span style="padding-left: 12px;">+65
                                        8505 5484</span></span>
                                <span><span style="color: #0c5897;">a: </span><span
                                        style="padding-left: 10px;">Peninsula Plaza, 111 North Bridge
                                        Rd,</span><br> <span style="padding-left: 24px;">#21-01, Singapore
                                        179098.</span></span>
                                <span><span style="color: #0c5897;">w: </span><span style="padding-left: 5px;"><span
                                            style="font-weight:700;">www.</span>securre.net e:
                                        hello@securre.net</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="address row d-flex justify-content-center align-items-center">
                <div class="col-9">
                    <p class="text-center footer-text mb-1" style="font-size: 13px; color: #9e9c9c;">
                        Note: This document is strictly private, confidential and personal
                        to the sender and its recipients and should be copied, edited,
                        <br />
                        distributed or reproduced in whole or in part, nor passed to any
                        third party. No signature is required from Securre Collection Pte
                        Ltd.
                    </p>
                </div>

                <div class="col-12 footer-divider mb-1" style="border: #8090b0 1.3px solid"></div>

                <div class="col-9">
                    <p class="text-center" style="font-size: 13px; color: #9e9c9c;">
                        Operating as Securre Collection Pte Ltd | 2023331790G | DID:
                        <span style="color: #9bb0c9;">dcms@securre.net </span> | Website: <span
                            style="color: #9bb0c9;">www.securre.net</span> <br />
                        Email:
                        <span> <span style="color: #9bb0c9;">hello@securre.net </span> | Address: Peninsula Plaza, 111
                            North Bridge
                            Rd, #21-01, S'179098 | Tel:(+65) <span style="color: #9bb0c9;">8505-5484</span></span>
                    </p>
                </div>
            </div>
        </section>
    </div>

    <!-- first page end -->


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
</body>

</html>
