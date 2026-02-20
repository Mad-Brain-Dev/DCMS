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
                        <a href="{{ route('printable.case.warrant', $case_number->id) }}" class="btn btn-dark ml-1">Print Warrant</a>
                    </div>
                </div>
            </div>

            <div>
                <div class="lod_heading_div">
                    <div class="lod_img">
                        <img src="{{asset('images/for_lod_page.png')}}" alt="" />
                    </div>

                    <div class="lod_span_text">
                        <p><b>Debt Collection</b>, Factoring | Transportation | Logistics Services | 2001</p>
                    </div>

                </div>


                <div class="ref_row">
                    <!-- LEFT BOX -->
                    <div class="ref_box_group">
                        <div class="ref_label_box">Our Ref.:</div>
                        <div class="ref_value_box red">CASE # {{$case_number->case_sku}}</div>
                    </div>

                    <!-- RIGHT BOX -->
                    <div class="ref_box-group ref_box_group_right">
                        <div class="ref_label_box">Your Ref.:</div>
                        <div class="ref_value_box">TBA</div>
                    </div>
                </div>

                @php
                    $debtors = $case_number->debtors->values(); // reset index
                @endphp

                <div class="name_add_row">

                    {{-- LEFT COLUMN (1st & 3rd) --}}
                    <div class="first_3rd">

                        {{-- DB 1 --}}
                        @if(isset($debtors[0]))
                            <div class="name">
                                <span>{{ $debtors[0]->name }}</span>
                            </div>
                            <div class="add">
                                <span>{{ $debtors[0]->address }}</span>
                            </div>
                        @endif

                        {{-- DB 3 --}}
                        @if(isset($debtors[2]))
                            <div class="name name_3rd">
                                <span>{{ $debtors[2]->name }}</span>
                            </div>
                            <div class="add">
                                <span>{{ $debtors[2]->address }}</span>
                            </div>
                        @endif

                    </div>


                    {{-- RIGHT COLUMN (2nd & 4th) --}}
                    <div class="second_4th">

                        {{-- DB 2 --}}
                        @if(isset($debtors[1]))
                            <div class="name">
                                <span>{{ $debtors[1]->name }}</span>
                            </div>
                            <div class="add">
                                <span>{{ $debtors[1]->address }}</span>
                            </div>
                        @endif

                        {{-- DB 4 --}}
                        @if(isset($debtors[3]))
                            <div class="name name_4th">
                                <span>{{ $debtors[3]->name }}</span>
                            </div>
                            <div class="add">
                                <span>{{ $debtors[3]->address }}</span>
                            </div>
                        @endif

                    </div>

                </div>


{{--                <div class="name_add_row">--}}
{{--                    <div class="first_3rd">--}}
{{--                        <div class="name"><span>DB 1 Name</span></div>--}}
{{--                        <div class="add"><span>DB 1 Address</span></div>--}}
{{--                        <div class="name name_3rd"><span>DB 3 Name</span></div>--}}
{{--                        <div class="add"><span>DB 3 Address</span></div>--}}
{{--                    </div>--}}

{{--                    <div class="second_4th">--}}
{{--                        <div class="name"><span>DB 2 Name</span></div>--}}
{{--                        <div class="add"><span>DB 2 Address</span></div>--}}
{{--                        <div class="name name_4th"><span>DB 4 Name</span></div>--}}
{{--                        <div class="add"><span>DB 4 Address</span></div>--}}
{{--                    </div>--}}
{{--                </div>--}}



                <div class="content_for_sir_mam">
                    Dear Sir/Madam,
                </div>

                <div class="ref">
                    RE: DEBTS OWED TO - <span>{{$case_number->client->name}}</span>
                </div>
                <div class="top-row">
                    <div></div>
                    <div class="right-box">
                        <a>BY HAND ONLY</a><br>
                        <div class="date">{{optional($case_number->created_at)->format('d M Y')}}</div>
                    </div>
                </div>


                <div>
                    <ol class="lod_ol_cls" type="1">
                        <li>
                            <p class="">
                                Our firm represents <span>{{$case_number->client->name}}</span>.
                            </p>
                        </li>

                        <li>
                            @php
                                $formattedAmount = number_format($case_number->total_amount_owed, 2, '.', ',');
                            @endphp
                            <p class="">
                                Our Client has informed us that, despite repeated reminders, the following amount
                                remains unpaid;<br />
                                • <span>S${{ $formattedAmount }}</span>.
                            </p>
                        </li>

                        <li>
                            <p class="">
                                We know of no legitimate basis for you stopping payment other than an attempt to avoid
                                paying a just indebtedness. As such, your failure to timely pay is a breach of the court
                                order and/or your agreement within contract law.
                            </p>
                        </li>

                        <li class="list_4">
                            <p class="">
                                We will give you an opportunity to pay the amount due before any further debt recovery
                                arrangements are made, (which may include but is not limited to, enforcing the Judgement
                                through filing for Bankruptcy, Writ of Seizure and Sale, Garnishee orders and/or
                                engaging News Media Correspondents to highlight this matter at your registered addresses
                                listed on file); however, payment must be made in strict accordance with the terms of
                                this letter. The terms are as follows;
                            </p>

                            <div class="list_4_div_cls_1">
                                <span class="alpha_lod_1"> a) </span>
                                <p> Full payment of the total amount due must be received in our office within seven
                                    (07) days of this letter;</p>
                            </div>
                            <div class="list_4_div_cls_2">
                                <span class="alpha_lod_2"> b) </span>
                                <p> No partial payments will be accepted; and,</p>
                            </div>
                            <div class="list_4_div_cls_3">
                                <span class="alpha_lod_3"> c) </span>
                                <p> Other than this letter, no additional demands will be made upon you to pay prior to
                                    our field enforcement and/or legal proceedings.</p>
                            </div>
                        </li>
                        </li>

                        <li class="list_5">
                            <p class="">
                                @php
                                    use Carbon\Carbon;
                                    $newDate = Carbon::parse($case_number->created_at)
                                        ->addDays(7)
                                        ->format('d M Y');
                                @endphp
                                If the total amount due is not paid to our office by the <span>{{$newDate}} at
                                    15:00hrs,</span> our next course of action will be enforced against you without
                                further notice, and you will be made liable for any and all costs arising thereof.
                            </p>
                        </li>

                        <li class="list_6">
                            <p class="">
                                This is a serious matter which requires your immediate attention. As such, we’d advise
                                you to expedite payment arrangements as soon as possible.
                            </p>
                        </li>

                        <li class="list_7">
                            <p class="">
                                For more information on debt settlement, debt financing and loan assistance (on a
                                case-to-case basis) via our loan department, please visit our website at <span
                                    class="ind_color">www.securre.net/dcms</span> or you may contact us via WhatsApp at
                                <span class="ind_color">+65 8505 5484</span>.
                            </p>
                        </li>

                        <li class="list_7">
                            <p class="">
                                Without prejudice to the foregoing, our Client and we hereby reserve all rights and
                                remedies available at law
                                and in equity, including the right to commence proceedings without further notice
                            </p>
                        </li>

                        <li class="list_7">
                            <p class="">
                                Thank you for your time and we expect to hear from you within the stipulated time frame.
                            </p>
                        </li>
                    </ol </div>


                    <div class="lod_footer_div">
                        <div class="lod_f_img">
                            <p>Sincerely,</p>
                            <img src="{{asset('images/n_logo.png')}}" alt="" />
                        </div>

                        <div class="lod_f_span_text">
                            <h5 class="Ravin_Raj">Ravin Raj G.</h5>
                            <p class="operations_d">Operations Director | Partner </p>
                            <p class="Securre_Collection">Securre Collection Pte Ltd</p>

                            <p class="lod_f_span_text_links">
                                <span class="lod_f_span_t">t:</span><span>+65 8505 5484</span>
                                <span class="lod_f_span_a">a:</span><span>81 Tagore Lane, Tag.A, #04-07,
                                    S'878502.</span>
                            </p>
                            <p class="lod_f_span_text_links">
                                <span>w: </span>
                                <span>www.securre.net</span>

                                <span class="lod_f_span_e">e:</span><span>hello@securre.net</span>
                                <span class="lod_f_span_e">lic:</span><span>L/DCA/2024/000179</span>
                            </p>
                            <span class="after_span"></span>
                        </div>
                    </div>


                    <div class="footer_text_cls">
                        <div class="footer_text_cls_child">
                            <p class="lod_last_p">
                            Note: This document is strictly private, confidential and personal to the sender and its recipients and should not be copied, edited, <br/> distributed or reproduced in whole or in part, nor passed to any third party. No signature is required from Securre Collection Pte Ltd.
                            </p>
                            <span class="footer_after_span"></span>
                        </div>
                    </div>

                      <div class="lod_footer_info">
                            <p class="">
                                <span>Operating as Securre Collection Pte Ltd | 2023331790G |</span>
                                <span class="lod_f_did">DID:  dcms@securre.net | Web:  www.securre.net</span>
                            </p>
                            <p class="lod_foot_mail">
                                <span>Email:  hello@securre.net | Address:  Peninsula Plaza, 111</span>

                                <span class="North_Bridge">North Bridge Rd, #21-01, S179098 | Tel:  8505 5484</span>
                            </p>
                        </div>
                    <!-- lod is end -->

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
