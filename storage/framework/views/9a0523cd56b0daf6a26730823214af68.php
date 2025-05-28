<!DOCTYPE html>
<html>
<head>
    <title>Inspection Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            padding: 20px;
        }

        .email-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .email-header h2 {
            color: #4CAF50;
            font-size: 24px;
        }

        .email-content {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .email-content ul {
            padding-left: 20px;
            list-style-type: none;
        }

        .email-content li {
            margin-bottom: 10px;
        }

        .footer {
            font-size: 14px;
            color: #777;
            text-align: center;
        }

        .footer p {
            margin: 0;
        }

        .highlight {
            font-weight: bold;
            color: #333;
        }

        .thank-you {
            color: #4CAF50;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h2>Inspection Date & Time Confirmed</h2>
        </div>

        <div class="email-content">
            <p>Dear <span class="highlight"><?php echo e($owner); ?></span>,</p>

            <p>Your car inspection date and time has been <span class="highlight">confirmed</span> as follows:</p>

            <ul>
                <li><span class="highlight">Date:</span> <?php echo e($date); ?></li>
                <li><span class="highlight">Time:</span> <?php echo e($time); ?></li>
                <li><span class="highlight">Location:</span> <?php echo e($location); ?></li>
            </ul>

            <p>Please be on time. If you have any questions, feel free to contact us.</p>
        </div>

        <div class="footer">
            <p>Thank you,</p>
            <p class="thank-you">The Inspection Team</p>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\Sangay Ngedup\Documents\GitHub\FinalProject\resources\views/emails/inspection_confirmed.blade.php ENDPATH**/ ?>