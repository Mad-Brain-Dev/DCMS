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

    <style>
        @media print {

            html, body {
                width: 210mm;
                margin: 0;
                padding: 0;
                font-family: "Times New Roman", serif;
                font-size: 12px;
                line-height: 1.5;
            }

            @page {
                size: A4;
                margin: 15mm 15mm 20mm 15mm;
            }

            /* ===== HEADER ===== */
            .print-header {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                height: 85px; 
                background: #fff;
                z-index: 9999;
            }

            /* ===== FOOTER ===== */
            .warrant-footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                height: 55px; 
                font-size: 9px;
                background: #fff;
                z-index: 9999;
            }

            /* ===== CONTENT ===== */
            .container {
                margin-top: 95px;   /* header height + small gap */
                margin-bottom: 70px; /* footer height + gap */
                padding: 0 !important;
            }

            /* ===== PAGE BREAK ===== */
            .page-break {
                page-break-before: always;
            }

            /* ===== AVOID BREAK ISSUES ===== */
            .section,
            .details_container {
                page-break-inside: avoid;
            }

            /* ===== CLEAN BOOTSTRAP ===== */
            .row, .col-md-12 {
                display: block !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            /* ===== HIDE BUTTON ===== */
            .buttons {
                display: none !important;
            }

        }
    </style>

</head>

<body>

    <div class="second-section">
        <div class="print-header">
            <div class= "top_of_header">
                <div class="header">

                    <div class="contract_logo_div">
                        <img class="securre_text_img1" src="{{ asset('images/for_lod_page1.png') }}" alt="" />

                    </div>

                    <div class="tagline">
                    <span class="tag_text">
                        <b>Debt Collection, Factoring</b> | Transportation | Logistics Services | <b>© 2001</b>
                    </span>
                    </div>

                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 buttons">
                    <div class="d-flex justify-content-end pt-3">
                        <a href="{{ route('admin.clients.index') }}" class="btn btn-danger mr-1">Back</a>
                        <button class="btn btn-primary" onclick="printDocument()">Print</button>
                    </div>
                </div>
            </div>
            <div class="">


                <h3 class="title">SECURRE DEBT COLLECTION AGREEMENT</h3>

                <div class= "text_section">

                    <p>
                        {{--                This Agreement is entered into on the <span class="span_1">4<sup>th</sup></span> day of <span--}}
                        {{--                    class="span_2">March</span>, 20<span class="span_3">26</span> between:--}}
                        @php
                            $date = $client_details->date_of_agreement;
                        @endphp

                        This Agreement is entered into on the
                        <span class="span_1">
    {{ $date->format('j') }}<sup>{{ substr($date->format('jS'), -2) }}</sup>
</span>
                        day of
                        <span class="span_2">{{ $date->format('F') }}</span>,
                        <span class="span_3">{{ $date->format('Y') }}</span>
                        between:
                    </p>

                    <p>
                        <strong>Securre Collection Pte. Ltd.,</strong> (UEN: 2023331790G) (hereinafter referred to as “SC”),
                    </p>

                    <p>
                        and <span class="span_4">{{$client_details->name}}</span> (NRIC/UEN: <span
                            class="span_5">{{$client_details->nric}}</span>),
                        (hereinafter referred to as the “Client”).
                    </p>

                    <p class="span_6">Both parties agree as follows.</p>


                    <div class="section">

                        <p class="section-title">1. Scope of Services</p>

                        <ul class="sc_shall_text">
                            <li>SC shall undertake debt recovery services on behalf of the Client for outstanding
                                debts assigned by the Client to SC (“the Case”). SC may conduct recovery through
                                communication, field visits, negotiations, or other lawful recovery methods permitted
                                under the laws of Singapore.</li>
                        </ul>

                    </div>

                    <p class="span_7"></p>

                    <div class="section">

                        <p class="section-title">2. Commission and Fees</p>

                        <ol class="sub-list">

                            <li>
                                The Client agrees to pay SC a commission of <strong><span class="span_8">{{ $client_details->collection_commission }}%</span></strong> of
                                the total amount recovered,
                                including any interest, settlement sum, or other benefit obtained from the debtor.
                            </li>

                            <li>
                                The commission shall be payable whether recovery is made:
                                <ul class="directly_text">
                                    <li>directly by SC,</li>
                                    <li>through legal proceedings,</li>
                                    <li>through third-party agents, or</li>
                                    <li>directly by the debtor to the Client following SC’s engagement.</li>
                                </ul>
                            </li>

                            <li>
                                Such commission shall become immediately due and payable upon receipt
                                of payment, settlement, or any benefit from the debtor.
                            </li>

                            <li>
                                An administrative and/or enforcement fee of <strong>S$ <span
                                        class="span_9">{{ number_format($client_details->admin_fee, 2, '.', ',') }}</span></strong> is agreed between
                                the parties and shall be payable in accordance with this Agreement.
                            </li>

                        </ol>

                    </div>

                    <p class="span_7"></p>

                    <div class="section">

                        <p class="section-title">3. Authority / Warrant to Act</p>

                        <ol class="sub-list">

                            <li>
                                The Client hereby authorises SC to act as its recovery representative in
                                respect of the assigned Case and grants SC a <b>Warrant to Act</b> (attached herewith)
                                to communicate, negotiate, and pursue recovery from the debtor on the Client’s behalf.
                            </li>

                        </ol>

                    </div>

                    <div class="page-break"></div>

                    <p class="span_7"></p>

                    <div class="section">
                        <p class="section-title">4. Direct Settlement / Non-Circumvention</p>
                        <ol class="sub-list">
                            <li>
                                The Client shall not directly or indirectly negotiate, settle, compromise, or otherwise recover
                                the
                                assigned debt from the debtor without SC’s written knowledge.
                            </li>
                            <li>
                                Where any payment, settlement, asset transfer, credit, goods, services, or other benefit is
                                received by the Client from the debtor during the engagement period or as a result of SC’s
                                recovery efforts, SC’s commission shall remain immediately payable.
                            </li>
                        </ol>
                    </div>


                    <p class="span_7"></p>

                    <div class="section">
                        <p class="section-title">5. Authority to Appoint Solicitors or Agents</p>
                        <ol class="sub-list">
                            <li>
                                SC shall have the authority, where necessary, to appoint solicitors or third-party recovery
                                agents
                                to assist in the recovery of debts. Any such solicitors or agents shall be deemed to act on
                                behalf
                                of the Client
                            </li>
                            <li>
                                Legal costs, professional fees, or enforcement costs may be recoverable from the debtor or
                                otherwise payable in accordance with instructions provided by the Client.
                            </li>
                        </ol>
                    </div>


                    <p class="span_7"></p>

                    <div class="section">
                        <p class="section-title">6. Client Obligations</p>
                        <ol class="sub-list">
                            <li>
                                The Client warrants that all information provided to SC regarding the debtor and the debt is
                                true,
                                accurate and complete to the best of their knowledge.
                            </li>
                            <li>
                                SC shall not be liable for any loss arising from inaccurate or incomplete information supplied
                                by
                                the Client.
                            </li>
                        </ol>
                    </div>


                    <p class="span_7"></p>

                    <div class="section">
                        <p class="section-title">7. Settlement Authority</p>
                        <ol class="sub-list">
                            <li>
                                SC may negotiate and recommend settlements with the debtor where commercially reasonable.
                                Any settlement exceeding 25% reduction of the outstanding debt shall require the Client’s prior
                                written approval.
                            </li>
                            <li>
                                SC shall not be liable for any loss arising from inaccurate or incomplete information supplied
                                by
                                the Client.
                            </li>
                        </ol>
                    </div>


                    <p class="span_7"></p>

                    <div class="section">
                        <p class="section-title">8. Liability Limitation</p>
                        <ol class="sub-list">
                            <li>
                                SC shall not be liable for any losses arising from:
                                <ul class="directly_text">
                                    <li>debtor insolvency or bankruptcy</li>
                                    <li>debtor absconding or refusal to pay</li>
                                    <li>legal proceedings commenced by the debtor</li>
                                    <li>acts or omissions of solicitors or third-party agents</li>
                                </ul>
                            </li>
                            <li>
                                SC’s role is to use reasonable commercial efforts to recover debts but does not guarantee
                                recovery.
                            </li>
                        </ol>
                    </div>

                    <div class="page-break"></div>

                    <p class="span_7"></p>

                    <div class="section">
                        <p class="section-title">9. Post-Termination Recovery</p>
                        <ol class="sub-list">
                            <li>
                                Where the Client, directly or indirectly, receives any payment, settlement, asset transfer,
                                credit, goods,
                                services, or any other benefit from the debtor at any time within twenty-four (24) months
                                following the
                                termination, cancellation, or expiry of this Agreement in relation to the assigned Case, such
                                recovery shall
                                be deemed to have arisen from SC’s recovery efforts and SC’s commission shall remain payable in
                                full.
                            </li>
                            <li>
                                For the avoidance of doubt, this obligation shall apply regardless of whether such recovery
                                occurs directly
                                between the Client and the debtor, through legal proceedings, through third-party agents, or
                                through any
                                other arrangement whatsoever.
                            </li>
                        </ol>
                    </div>


                    <p class="span_7"></p>

                    <div class="section">
                        <p class="section-title">10. Case Duration</p>
                        <ol class="sub-list">
                            <li>
                                Each Case shall remain active for 90 days from the date of assignment, unless repayment
                                arrangements are ongoing or otherwise extended by mutual agreement.

                            </li>
                            <li>
                                SC may terminate any Case where recovery becomes commercially unviable.
                            </li>
                        </ol>
                    </div>

                    <p class="span_7"></p>

                    <div class="section">
                        <p class="section-title">11. Entire Agreement</p>
                        <ol class="sub-list">
                            <li>
                                This Agreement constitutes the entire agreement between the parties and supersedes all previous
                                discussions or understandings relating to the recovery of the assigned debt.

                            </li>
                        </ol>
                    </div>

                    <p class="span_7"></p>

                    <div class="section">
                        <p class="section-title">12.Governing Law</p>
                        <ol class="sub-list">
                            <li>
                                This Agreement shall be governed by and construed in accordance with the laws of Singapore

                            </li>
                        </ol>
                    </div>

                    <p class="span_7"></p>

                </div>

                <div class="details_container">

                    <!-- Left Side -->
                    <div class="left">
                        @php
                            $date = $client_details->date_of_agreement;
                        @endphp

                        <h3>For Securre Collection Pte Ltd</h3>
                        <h5>(UEN: 202331790G)</h5>

                        <div class="line"></div>

                        <h5>Name: Ra’id Ravin Raj</h5>
                        <h5>Designation: Operations Director</h5>
                        <h5>Date: {{ $date->format('j') }}<sup>{{ substr($date->format('jS'), -2) }}</sup> {{ $date->format('F') }} {{ $date->format('Y') }}</h5>

                    </div>


                    <!-- Right Side -->
                    <div class="right">

                        <h3 class="the_clients">For the clients;</h3>

                        <div class="form-row">
                            <span>Clients’ Name:</span>
                            <div class="input-line">{{$client_details->name}}</div>
                        </div>

                        <div class="form-row">
                            <span>Clients’ ID:</span>
                            <div class="input-line">{{$client_details->nric}}</div>
                        </div>

                        <div class="form-row">
                            @php
                                $date = $client_details->date_of_agreement;
                            @endphp
                            <span>Date:</span>
                            <div class="input-line">{{ $date->format('j') }}<sup>{{ substr($date->format('jS'), -2) }}</sup> {{ $date->format('F') }} {{ $date->format('Y') }}</div>
                        </div>

                        <div class="form-row">
                            <span>Signature/Stamp:</span>
                            <div class="input-line"></div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>



    <footer class="warrant-footer">
        <div class="footer-section">

            <p class="note">
                Note: This document is strictly private, confidential and personal to the sender and its recipients</br>
                and should not be copied, edited, distributed or reproduced in whole or in part, nor passed to any third
                party.
            </p>

            <div class="divider"></div>

            <p class="info">
                Operating as <b>Securre Collection Pte Ltd</b> | 202331790G |
                DID: <span class="blue">dcms@securre.net</span> |
                W: <span class="blue">www.securre.net</span><br>

                E: <span class="blue">hello@securre.net</span> |
                A: 111 North Bridge Rd, #21-01, S’179098 |
                T: (+65) 8505-5484 |
                L: LDCA/2024/000179
            </p>
        </div>
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
