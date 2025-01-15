<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }

        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid #ddd;
        }

        .header {
            background: #007bff;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 20px;
        }

        .content h2 {
            color: #007bff;
        }

        .content p {
            font-size: 16px;
            line-height: 1.6;
            margin: 10px 0;
        }

        .footer {
            background: #f1f1f1;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #777;
        }

        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            color: white;
            background: #28a745;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .button:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Appointment Confirmation</h1>
        </div>
        <div class="content">
            <h2>Hello {{ $patientName }},</h2>
            <p>We are pleased to inform you that your appointment has been confirmed. Here are the details:</p>
            <ul>
                <li><strong>Doctor:</strong> {{ $doctorName }}</li>
                <li><strong>Date:</strong> {{ $appointmentDate }}</li>
                <li><strong>Clinic:</strong> {{ $clinicName }}</li>
            </ul>
            {{-- <p>If you have any questions, please contact us at <a href="mailto:{{ $details['clinic_email'] }}">{{ $details['clinic_email'] }}</a>.</p> --}}
            <a href="{{ $appointment_url }}" class="button">View Appointment</a>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ $clinicName }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
