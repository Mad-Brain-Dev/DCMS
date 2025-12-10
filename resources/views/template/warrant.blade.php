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
                        <a href="{{ route('printable.case.letter', 1) }}" class="btn btn-dark ml-1">Print Letter</a>
                    </div>
                </div>
            </div>


            <div>
                <div class="doc-wrapper">

                    <div class="title-block">WARRANT TO ACT</div>

                    <div class="subtext-block">
                        This Warrant is issued SUBJECT TO the laws of the Republic of Singapore, including but not
                        limited to the CHAPTER 53B (ORIGINAL <br /> ENACTMENT: ACT 39 of 2001) REVISED EDITION 2002,
                        SECTION 2.1 and the Debt Collection Act 2022 (No. 27 of 2022), where applicable.
                    </div>

                    <div class="line-divider"></div>

                    <div class="info-row">
                        <div class="issuer">
                            <span class="issuer-label">Issued to:</span>
                            <span class="issuer-value"><strong>Securre Collection Pte Ltd</strong>
                                (L/DCA/2024/000179)</span>
                        </div>

                        <div class="warrant-case-ref">
                            <span class="case-label">CASE REF. #:</span>
                            <span class="case-number">CASE NUMBER</span>
                        </div>
                    </div>
                </div>



                <div class="clause-line">
                    <ol type="1">
                        <li>
                            <p>We, the undersigned, hereby appoint you to act for us ("Client"),
                                <span class="warrant_cl_name"><span class="red-text">CL NAME</span></span>,
                                (NRIC/UEN #:
                                <span class="warrant_cl_id"><span class="red-text">CL ID</span></span>
                                ), in connection with the below matter until it is completed, settled, resolved or the
                                contractual agreement between us and you is terminated for whatsoever reason.
                                You may contact PI
                                <span class="warrant_pic_name"><span class="red-text">PIC NAME</span></span>
                                telephone at
                                <span class="warrant_pic_num"><span class="red-text">PIC NUMBER</span></span>,
                                alternatively via email
                                <span class="warrant_pic_mail"><span class="red-text">PIC EMAIL</span></span>,
                                for instructions/updates.
                            </p>
                        </li>
                        <li>
                            <p>We authorise you to receive payment from the debtor directly in your favour (on our
                                behalf) and to do everything you may consider,
                                necessary in your conduct of this matter. This Warrant to Act serves as a formal warrant
                                to act which may be produced to third parties,
                                as evidence of our engagement of your good firm to act on our behalf in connection with
                                this matter.
                            </p>
                        </li>
                        <li>
                            <p>All cheques shall be made payable to, <strong>"Securre Collection Pte Ltd"</strong>, and
                                online payments made via PayNow to 202331790G / 87428158.</p>
                        </li>
                        <li>
                            <p>We agree that this Warrant of your services are subjected to the terms and conditions as
                                set out in the Debt Collection Agreement.</p>
                        </li>
                    </ol>
                </div>



                <div class="debt-box-wrapper">

                    <div class="debt-label-block">
                        <p>
                            Debt Amount in <br>
                            Singapore Dollars:
                        </p>
                        <p class="debt-placeholder">DEBT IN WORDS</p>
                    </div>



                    <div class="debt-right-side">
                        ( SG <span class="red-num">DEBT</span> /+% )
                    </div>

                </div>



                <div class="debtor-section">
                    <div class="debtor-header">DEBTOR (1)</div>

                    <div class="debtor-row">
                        <div class="debtor-field-1">
                            <p class="debtor-label">Full Name:<span class="debtor-value">DB 1 Name</span></p>
                        </div>

                        <div class="debtor-field-2">
                            <p class="debtor-label">NRIC / UEN:<span class="debtor-value">DB 1 ID</span></p>
                        </div>
                    </div>

                    <div class="debtor-row">
                        <div class="debtor-field-1">
                            <p class="debtor-label debtor-label-add">Address:<span
                                    class="debtor-value debtor-value-add">DB 1 Address</span></p>
                        </div>

                        <div class="debtor-field-2">
                            <p class="debtor-label">Contact No.:<span class="debtor-value">DB 1 Contact</span></p>
                        </div>
                    </div>

                    <div class="debtor-remarks">
                        <p class="debtor-label">Remarks:<span class="remarks-line-1">ABC</span> <br />
                            <span class="remarks-line-2">XYZ</span>
                        </p>
                    </div>
                </div>



                <div class="debtor-section">
                    <div class="debtor-header">DEBTOR (2)</div>

                    <div class="debtor-row">
                        <div class="debtor-field-1">
                            <p class="debtor-label">Full Name:<span class="debtor-value">DB 2 Name</span></p>
                        </div>

                        <div class="debtor-field-2">
                            <p class="debtor-label">NRIC / UEN:<span class="debtor-value">DB 2 ID</span></p>
                        </div>
                    </div>

                    <div class="debtor-row">
                        <div class="debtor-field-1">
                            <p class="debtor-label debtor-label-add">Address:<span
                                    class="debtor-value debtor-value-add">DB 2 Address</span></p>
                        </div>

                        <div class="debtor-field-2">
                            <p class="debtor-label">Contact No.:<span class="debtor-value">DB 2 Contact</span></p>
                        </div>
                    </div>

                    <div class="debtor-remarks">
                        <p class="debtor-label">Remarks:<span class="remarks-line-1">ABC</span> <br />
                            <span class="remarks-line-2">XYZ</span>
                        </p>
                    </div>
                </div>



                <div class="debtor-section">
                    <div class="debtor-header">DEBTOR (3)</div>

                    <div class="debtor-row">
                        <div class="debtor-field-1">
                            <p class="debtor-label">Full Name:<span class="debtor-value">DB 3 Name</span></p>
                        </div>

                        <div class="debtor-field-2">
                            <p class="debtor-label">NRIC / UEN:<span class="debtor-value">DB 3 ID</span></p>
                        </div>
                    </div>

                    <div class="debtor-row">
                        <div class="debtor-field-1">
                            <p class="debtor-label debtor-label-add">Address:<span
                                    class="debtor-value debtor-value-add">DB 3 Address</span></p>
                        </div>

                        <div class="debtor-field-2">
                            <p class="debtor-label">Contact No.:<span class="debtor-value">DB 3 Contact</span></p>
                        </div>
                    </div>

                    <div class="debtor-remarks">
                        <p class="debtor-label">Remarks:<span class="remarks-line-1">ABC</span> <br />
                            <span class="remarks-line-2">XYZ</span>
                        </p>
                    </div>
                </div>



                <div class="debtor-section">
                    <div class="debtor-header">DEBTOR (4)</div>

                    <div class="debtor-row">
                        <div class="debtor-field-1">
                            <p class="debtor-label">Full Name:<span class="debtor-value">DB 4 Name</span></p>
                        </div>

                        <div class="debtor-field-2">
                            <p class="debtor-label">NRIC / UEN:<span class="debtor-value">DB 4 ID</span></p>
                        </div>
                    </div>

                    <div class="debtor-row">
                        <div class="debtor-field-1">
                            <p class="debtor-label debtor-label-add">Address:<span
                                    class="debtor-value debtor-value-add">DB 4 Address</span></p>
                        </div>

                        <div class="debtor-field-2">
                            <p class="debtor-label">Contact No.:<span class="debtor-value">DB 4 Contact</span></p>
                        </div>
                    </div>

                    <div class="debtor-remarks">
                        <p class="debtor-label">Remarks:<span class="remarks-line-1">ABC</span> <br />
                            <span class="remarks-line-2">XYZ</span>
                        </p>
                    </div>

                    <div class="debtor-final-summary">
                        <p class="debtor-label">Final Summary:<span class="summary-line-1">ABC</span> <br />
                            <span class="summary-line-2">XYZ</span>
                        </p>
                    </div>
                </div>



                <div class="endorse-section">
                    <div class="endorse-left">
                        <div class="endorse-title">CLIENT ENDORSEMENT</div>

                        <p><span class="endorse-label-1">Persons' Name:</span> <span class="endorse-value-red">PIC
                                NAME</span></p>
                        <p><span class="endorse-label-2">Clients' Name:</span> <span class="endorse-value-red">CL
                                NAME</span></p>
                        <p><span class="endorse-label-3">NRIC No./UEN:</span> <span class="endorse-value-red">CL
                                ID</span></p>

                        <p class="endorse-sign">Signature/Stamp:</p>
                    </div>

                    <div class="endorse-right">
                        <p>
                            <span class="endorse-label">Date of Warrant to Act:</span>
                            <span class="endorse-date"><b>11 November 2025</b></span>
                        </p>
                    </div>
                </div>

            </div>


        </div>
    </div>
    </div>

    <footer class="warrant-footer">
        111 North Bridge Road, #21-01, S' 179098 | 81 Tagore Lane, #04-07, S'787502<br/>
        +65 8505 5484 | hello@securre.net | www.securre.net |  202331790G | L/DCA/2024/000179
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
