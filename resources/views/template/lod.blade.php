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

    <div class="container">
        <div class="row">
            <div class="col-md-12 buttons">
                <div class="d-flex justify-content-end pt-3">
                    <a href="{{ route('admin.cases.index') }}" class="btn btn-danger mr-1">Back</a>
                    <button class="btn btn-primary" onclick="printDocument()">Print</button>
                    <a href="{{ route('printable.case.warrant', $case_number->id) }}" class="btn btn-dark ml-1">Print Warrant</a>
                </div>
            </div>
        </div>
        <div class= "lod_header top_of_header">
            <div class="header">

                <div class="contract_logo_div">
                    <img class="securre_text_img1" src="{{ asset('images/for_lod_page1.png') }}" alt="" />

                </div>

                <div class="lod_tagline tagline">
                    <span class="tag_text">
                        <b>Debt Collection, Factoring</b> | Transportation | Logistics Services | <b>© 2001</b>
                    </span>
                </div>

            </div>
        </div>


        <!-- Top Section -->
        <div class="top">
            @php
                $debtors = $case_number->debtors->values();
            @endphp

            <div class="left">
                {{-- DB 1 --}}
                @if(isset($debtors[0]))
                    <div class="name">
                        <h5 class="highlight">{{ $debtors[0]->name }}</h5>
                    </div>
                    <div class="add">
                        <p class="highlight">{{ $debtors[0]->address }}</p>
                    </div>
                @endif


                {{-- DB 3 --}}
                @if(isset($debtors[2]))
                    <div class="name">
                        <h5 class="highlight space">{{ $debtors[2]->name }}</h5>
                    </div>
                    <div class="add">
                        <p class="highlight">{{ $debtors[2]->address }}</p>
                    </div>
                @endif
            </div>

            <div class="middle">
                {{-- DB 2 --}}
                @if(isset($debtors[1]))
                    <div class="name">
                        <h5 class="highlight">{{ $debtors[1]->name }}</h5>
                    </div>
                    <div class="add">
                        <p class="highlight">{{ $debtors[1]->address }}</p>
                    </div>
                @endif


                {{-- DB 4 --}}
                @if(isset($debtors[3]))
                    <div class="name">
                        <h5 class="highlight space">{{ $debtors[3]->name }}</h5>
                    </div>
                    <div class="add">
                        <p class="highlight">{{ $debtors[3]->address }}</p>
                    </div>
                @endif
            </div>

            <div class="right">
                <p><b>Our Ref.:</b> <span class="box highlight">{{$case_number->case_sku}}</span></p>
                <p><b>Your Ref.:</b> <span class="box" style="display: inline-block; width: 100px;">J M A</span></p>

{{--                <p class="date highlight">09 March, 2026</p>--}}
                <p class="date highlight">{{optional($case_number->created_at)->format('d F, Y')}}</p>
            </div>

        </div>

        <hr>

        <p>Dear Sir/Madam,</p>

        <!-- Claim -->
        <div class="claim">
            <p><b>CLAIMANT NAME:</b> <span class="highlight_client">{{$case_number->client->name}}</span></p>
            @php
                $formattedAmount = number_format($case_number->total_amount_owed, 2, '.', ',');
            @endphp
            <p><b>CLAIM AMOUNT:</b> <span class="highlight_client">S$ {{ $formattedAmount }}</span></p>
        </div>


        <div class="lod_text">

            <ol>

                <li>
                    Our firm acts for the above-mentioned Claimant in relation to the outstanding debt/s owed by you.
                </li>

                <li>
                    Our Client has informed us that, despite repeated reminders, the above-mentioned amount remains
                    unpaid.
                </li>

                <li>
                    To date, we are not aware of any legitimate basis for the continued non-payment of this debt. Your
                    failure to make
                    payment therefore constitutes a breach of your contractual obligations, court order (if applicable),
                    and/or the terms of
                    the relevant agreement between the parties
                </li>

                <li>
                    Our Client is prepared to afford you a final opportunity to settle the outstanding amount before
                    further recovery
                    action is taken. Such action may include, but is not limited to, debt collection officers being
                    deployed to your place of
                    work/residence to negotiate payment, enforcement proceedings through bankruptcy proceedings, Writs
                    of Seizure
                    and Sale, and/or garnishee orders, where applicable.
                </li>

                <li>
                    Payment must therefore be made in strict accordance with the following terms:

                    <ul>
                        <li>Full payment of the total outstanding amount must be received by our office within seven (7)
                            days from the date of this letter;</li>
                        <li>Partial payments will <span class="lod_span_1">NOT</span> be accepted; and,</li>
                        <li>In the event payment is not received within the stipulated timeframe, no further notice will
                            be given
                            prior to enforcement action being taken.</li>
                    </ul>

                </li>

                <li>
                    @php
                        use Carbon\Carbon;
                        $newDate = Carbon::parse($case_number->created_at)
                            ->addDays(7)
                            ->format('d F, Y');
                    @endphp
                    If the full amount due is not received by <span class="lod_span_2">{{$newDate}}</span> at <span
                        class = "lod_span_3">16:00 hours</span>, our Client will proceed with
                    the next
                    course of action without further notice to you, and you may be held liable for any additional costs
                    incurred.
                </li>

                <li>
                    This is a serious matter which requires your immediate attention. As such, we’d advise you to
                    expedite
                    payment arrangements as soon as possible.
                </li>

                <li>
                    For more information on debt settlement, debt financing and loan assistance (on a case-to-case
                    basis) via
                    our loan department, please visit our website at <span
                        class="lod_span_4">www.securre.net/dcms</span> or you may contact us via WhatsApp at <span
                        class="lod_span_5">+65 8505 5484.</span>
                </li>

                <li>
                    Without prejudice to the foregoing, our Client and we hereby reserve all rights and remedies
                    available at law
                    and in equity, including the right to commence proceedings without further notice.
                </li>

                <li>
                    Thank you for your time and we expect to hear from you within the stipulated time frame.
                </li>

            </ol>

        </div>


        <div class="signature">

            <p class="sincerely">Sincerely,</p>

            <div class="top-section">

                <div class="lod_logo">
                    <img class="lod_img1" src="{{ asset('images/n_logo.png') }}" alt="" />
                </div>

                <div class="lod_footer_text">
                    <h3>Operations Department | Legal</h3>
                    <p>A division of Securre Network, operating as:</p>

                    <p class="lod_company">Securre Collection Pte Ltd | 202331790G</p>

                    <p>t: +65 8505 5484 <span class="lod_a">a: 81 Tagore Lane,</span> <span class="lod_tag"> Tag.A,
                            #04-07, S878502.</span></p>

                    <p>w: www.securre.net <span class="lod_e">e: hello@securre.net</span> <span class="lod_lic">lic:
                            L/DCA/2024/000179</span></p>

                </div>

            </div>

    </div>

    <div>
       <div class="lod_divider_text">
                <p>
                    Note: This document is strictly private, confidential and personal to the sender and its recipients
                    and should not be copied, edited,</br>
                    distributed or reproduced in whole or in part, nor passed to any third party. No signature is
                    required from Securre Collection Pte Ltd
                </p>
            </div>

            <div class="lod_foot_divider"></div>

            <div class="footer_text">
                Operating as Securre Collection Pte Ltd | 2023331790G <br>
                Web: www.securre.net | Email: hello@securre.net | Address: Peninsula Plaza, 111 North Bridge Rd, #21-01,
                S179098 | Main Line: <b>+65 8505 5484</b>
            </div>
        </div>
    </div>





{{--    <footer class="warrant-footer">--}}
{{--        Add: Peninsula Plaza, 111 North Bridge Road, #21-01, Singapore 179098--}}
{{--        Off: +65 8505 5484 | Email: hello@securre.net | Web: www.securre.net--}}
{{--    </footer>--}}
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
