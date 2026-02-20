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
                        <a href="{{ route('admin.clients.index') }}" class="btn btn-danger mr-1">Back</a>
                        <button class="btn btn-primary" onclick="printDocument()">Print</button>
                    </div>
                </div>
            </div>
            <div class="contract_main">

                <div class="contract_heading_div">
                    <img class="securre_text_img" src="{{asset('images/securre.png')}}" alt="" />
                    <span class="con_span_text">DEBT COLLECTION AGREEMENT</span>

                </div>


                <div class="abbr_row">

                    <!-- LEFT BOX -->
                    <div class="box-group">
                        <div class="label-box">CLIENT ABBR</div>
                        <div class="value-box red">{{$client_details->abbr}}</div>
                    </div>

                    <!-- RIGHT BOX -->
                    <div class="box-group box_group_right">
                        <div class="label-box">DATE OF EXPIRY</div>
                        <div class="value-box">{{$client_details->date_of_expiry->format('d M Y')}}</div>
                    </div>

                </div>

                <div class="agreement_cls">
                    <ol type="1" class="agreement_cls_ol">
                        <li>
                            <p class="line">
                                This Agreement, entered into as of today,
                                <span class="blank date-blank">{{optional($client_details->date_of_agreement)->format('d M Y')}}</span>,
                                by and between us, <strong>Securee Collection Pte. Ltd.</strong> (hereon referred to as
                                "SC") and
                                <span class="client_name"><span class="red">{{$client_details->name}}</span></span>
                                (hereon referred to as the "Client"), with ID Number:
                                <span class="blank client_id"><span class="red">{{$client_details->nric}}</span></span>.
                            </p>
                        </li>

                        <li>
                            <div>
                                <span class="alpha">(a)</span>
                                <p> Whereas, the Client has solicited various firms for Debt Collection Services for the
                                    sole purpose of collecting upon their bad debts and/or financing the aforementioned
                                    bad debts via debt-factoring; and</p>

                            </div>

                            <div>
                                <span class="alpha">(b)</span>
                                <p>Whereas, SC has represented to the Client that it is fully capable of performing the
                                    services described in this Agreement, and the Client has relied on such
                                    representation to select SC to provide the services; and</p>
                            </div>

                            <div>
                                <span class="alpha">(c)</span>
                                <p>Whereas, the Client now desire to enter into an agreement setting forth their rights
                                    and obligations with regard to SC's good service representation.</p>
                            </div>
                        </li>

                        <li class="both_parties_li">
                            <div>
                                <p>Both parties hereto agree to the following;</p>
                            </div>

                            <div>
                                <span class="alpha_2">(a) Scope of services:</span>
                                <p>SC has agreed to collect outstanding debts as owed to the Client by its debtors as
                                    handed over to SC by the Client during the endorsement of this Agreement.</p>
                            </div>

                            <div>
                                <span class="alpha">(b) Administrative fees:</span>
                                <p>The Client has agreed to pay an upfront fee of S$ <span class="admin_fee"><span
                                            class="red">{{ number_format($client_details->admin_fee, 2, '.', ',') }}</span></span> , for filing, administrative, and
                                    registration costs to SC for the engagement of this service. It is also understood
                                    that this payment is non-refundable and payable in full upon the endorsement of this
                                    Agreement.</p>
                            </div>

                            <div>
                                <span class="alpha">(c) Debt Commission:</span>
                                <p>The commission payout on the successfully collected debt/s and interest (if any) will
                                    be <span class="admin_fee interest"><span class="red"> {{ $client_details->collection_commission }}% </span></span> . SC
                                    reserves the right to review the commission structure subject to seven (07) days
                                    written notice to the Client.</p>
                            </div>

                            <div>
                                <span class="alpha">(d) Payout structure:</span>
                                <p>SC undertakes to pay to the Client, on a monthly or "as received by debtor" basis,
                                    for all successful collections of the debt minus the commission and/or any
                                    outstanding fees, payments and costs calculated herein due to SC from the Client as
                                    set forth in section 3.(b) and 3.(c).</p>
                            </div>

                            <div>
                                <span class="alpha">(e) Scope of collection:</span>
                                <p>SC reserves the right to collect from the debtor/s all expenses and fees as provided
                                    for, as prescribed in the 'Debt Collection Act (2022), Singapore', and these costs
                                    will be deducted from the payments made to SC on a pro-rata basis.</p>
                            </div>

                            <div>
                                <span class="alpha">(f) Interest on debt:</span>
                                <p>Interests collected on debt/s in addition to the capital amount will also be paid
                                    over to the Client subject to the stipulations in section 3.(b), 3.(c) and 3.(d).
                                </p>
                            </div>

                            <div>
                                <span class="alpha">(g) Number of visits:</span>
                                <p>SC undertakes a Commitment to the Client of <span class="admin_fee g_sign"><span
                                            class="red"> {{ $client_details->field_visit_per_case }} </span></span> visits per case assigned to SC during the
                                    validity of this agreement.</p>
                            </div>
                        </li>

                        <li class="list_four">
                            <div>
                                <p> In the event the the number of field visits for a particular case has reached its
                                    maximum prescribed at Clause 3.(g) before full
                                    payment from the debtor/s, we shall be be entitled to either;
                                </p>
                            </div>
                            <div>
                                <span class="alpha_3">4.1</span>
                                <p> Continue with the Agreement subject to payment of additional Enforcement Fees for
                                    further field visits to secure
                                    repayment from the debtor; irregardless, or,</p>
                            </div>
                            <div>
                                <span class="alpha_3">4.2</span>
                                <p> Terminate the Agreement without any liability at no cost to SC whatsoever.</p>
                            </div>
                        </li>


                        <li class="list_five">
                            <div>
                                <p> In addition to the above-mentioned fees, the respective Debt Commission as per the
                                    debt amount recovered is payable to us,
                                    whether the debt is recovered in full or in part, or upon termination or expiry of
                                    this Agreement, as whatever the case may be.

                                </p>
                            </div>
                        </li>

                        <li class="list_six">
                            <div>
                                <p> For the avoidance of doubt, the criteria for expiration of this Agreement applies
                                    severally to individual cases referred to SC
                                    by the Client.
                                </p>
                            </div>
                        </li>

                        <li class="list_seven">
                            <div>
                                <p> This Agreement shall automatically expire and the relevant case file in our records
                                    shall cease in the following circumstances;
                                </p>
                            </div>
                            <div>
                                <span class="alpha_4">7.1</span>
                                <p> If after 90 days from the date of this Agreement, we are unable to obtain any
                                    repayment of the debt from
                                    the deb</p>
                            </div>
                            <div>
                                <span class="alpha_4">7.2</span>
                                <p> In the case of a payment of the debt by instalments / partial-payment, a period of
                                    120 days has lapsed since
                                    payment of the last instalment or part-payment by the debtor(s) and no further
                                    instalment / part-payment
                                    has been received from the debtor(s) (e.g. the debtor is undergoing bankruptcy /
                                    winding up proceedings
                                    or has absconded)</p>
                            </div>
                        </li>

                        <li class="list_8">
                            <div>
                                <p> The Client acknowledge and agree that all the information and documents provided to
                                    us in respect of each and every case is true and accurate to the best of their
                                    knowledge and information
                                </p>
                            </div>
                        </li>

                        <li class="list_9">
                            <div>
                                <p> In the event that the information on the debtor (e.g. the residential address,
                                    commercial address and as well as other contact
                                    details) provided by you to us are inaccurate, there shall be no refund of any of
                                    the fees whatsoever.
                                </p>
                            </div>
                        </li>

                        <li class="list_10">
                            <div>
                                <p> The contractual agreement between you and us is embodied in this <strong>Agreement</strong>, the
                                    <strong>Terms and Conditions</strong> as annexed hereto
                                    and the <strong>Warrant to Act</strong>/s as attached herewith from Page 3 onwards. Together, these
                                    shall be indentified as the <strong>"Contract
                                    Documents"</strong>. Your execution of this Agreement confirms that you have read, understood
                                    and accepted any and all the terms
                                    as set out in the Contract Documents
                                </p>
                            </div>
                        </li>

                        <li class="list_11">
                            <div>
                                <p> As per the terms of this Agreement set out in Clause 7., this Agreement shall be
                                    considered void after the Date of Expiry as
                                    stated unless renewed by SC at any time without notice or by the Client within 14
                                    days prior to expiry with SC's written approval
                                </p>
                            </div>
                        </li>

                        <li class="list_12">
                            <div>
                                <p> This Agreement is void and unenforceable unless accompanied by the signature of our
                                    authorised agent or representative.
                                </p>
                            </div>
                        </li>
                    </ol>
                </div>


                <div class="For_Securre_Collection">
                    <!-- LEFT SIDE -->
                    <div class="left">
                        <p>For Securre Collection Pte. Ltd.</p>

                        <div class="just_line"></div>

                        <div class="row_for_left"><span class="label_1">Name:</span> Ravin Raj G.</div>
                        <div class="row_for_left"><span class="label_2">Designation:</span> Operations Director</div>
                        <div class="row_for_left"><span class="label_3">Date:</span> {{optional($client_details->date_of_agreement)->format('d M Y')}}</div>

                        <div class="divider"></div>
                        <div class="divider_2"></div>

                    </div>

                    <!-- RIGHT SIDE -->
                    <div class="right">
                        <p>For the Client;</p>

                        <div class="row_for_right">
                            <span class="r_label_1">Signature/Stamp: <span class="signature"></span></span>
                        </div>

                        <div class="row_for_right">
                            <span class="r_label_2">Client Name/s:</span>
                            <span class="red r_signature_2 signature">{{$client_details->name}}</span>
                        </div>

                        <div class="row_for_right">
                            <span class="r_label_3">Client ID Number:</span>
                            <span class="red signature">{{$client_details->nric}}</span>
                        </div>

                        <div class="row_for_right"><span class="label r_date">Date:</span> {{optional($client_details->date_of_agreement)->format('d M Y')}}</div>
                    </div>
                </div>

                <p class="note">
                    * Enclosed herein: Warrant to Act, herewith: T&C.
                </p>


                <div class="take_note_main">
                    <div class="just_take_note"><span>PLEASE TAKE NOTE :</span></div>

                    <ol type = "1" class="take_note_ol">
                        <li>
                            <p> All payments shall be made via CASH/CHEQUE or PAYNOW and an official receipt will be
                                issued.
                            </p>
                        </li>
                        <li>
                            <p> Cheques should be made to Securre Collection Pte Ltd. Internet banking should be via
                                PayNow to <span class="pay_now">"87428158"</span>
                            </p>
                        </li>
                        <li>
                            <p> Bank transfer receipts should be submitted to us for bank transfers. (Upon receiving
                                full payment your case file
                                will be allocated accordingly and an official receipts will be issued via email/letter
                                accordingly.
                            </p>
                        </li>
                        <li>
                            <p> All case updates communications should be via email <u>hello@securre.net</u> or via our
                                App/Website. Login details
                                will be issued to you within 14 working days upon full payment of all outstanding fees.
                            </p>
                        </li>
                        <li>
                            <p> All communications on payments should be via email to <u>dcms@securre.net</u> (cc:
                                hello@securre.net)
                            </p>
                        </li>
                        <li>
                            <p> 1st case update will be within 14-21 working days, subsequently, fortnightly. Any and
                                all updates will be made
                                available in your login 24hrs/day, everyday.
                            </p>
                        </li>
                    </ol>
                </div>
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
