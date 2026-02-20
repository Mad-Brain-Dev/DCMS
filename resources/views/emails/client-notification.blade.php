<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .content {
            width: 600px;
            margin: 0 auto;

        }

        .card {
            padding: 20px;
        }
    </style>
</head>

<body>
<div style="background-color:#f4f6f9; padding:40px 0; font-family: Arial, Helvetica, sans-serif;">
    <div style="max-width:600px; margin:0 auto; background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,0.05);">

        <!-- Header -->
        <div style="background:#0d6efd; padding:20px; text-align:center;">
            <h2 style="color:#ffffff; margin:0;">Securre Network</h2>
        </div>

        <!-- Content -->
        <div style="padding:30px; color:#333333; line-height:1.6;">

            <p>Dear {{ $client->name }},</p>

            <p>
                We would like to inform you that there has been an update regarding your case file in our Debt Collection Management System (DCMS).
            </p>

            <p>
                For confidentiality and security reasons, detailed information is not included in this email.
                Kindly log in to your DCMS client portal to review the latest update.
            </p>

            <!-- Button -->
            <div style="text-align:center; margin:30px 0;">
                <a href="https://dcms.securre.net/login"
                   style="background:#0d6efd; color:#ffffff; padding:12px 25px; text-decoration:none; border-radius:5px; font-weight:bold; display:inline-block;">
                    Access DCMS Portal
                </a>
            </div>

            <p>
                If you have any questions or require further clarification, please feel free to reply to this email or contact us via WhatsApp at <strong>+65 8505 5484</strong>.
            </p>

            <p>
                Thank you for your continued trust and confidence in our services.
            </p>

            <p style="margin-top:30px;">
                Warm regards,<br>
                <strong>Securre Network</strong><br>
                Debt Collection Management Team
            </p>

        </div>

        <!-- Footer -->
        <div style="background:#f1f1f1; padding:15px; text-align:center; font-size:12px; color:#777;">
            © {{ date('Y') }} Securre Network. All rights reserved.<br>
            This is an automated notification. Please do not share your login credentials with anyone.
        </div>

    </div>
</div>
</body>


</html>
