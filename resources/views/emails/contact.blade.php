<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Contact Message</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f5f7;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 1px solid #e1e4e8;
        }
        .header {
            background-color: #0f766e;
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px;
        }
        .field {
            margin-bottom: 20px;
        }
        .label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #9ea8b6;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .value {
            font-size: 16px;
            color: #2d3748;
            line-height: 1.5;
        }
        .footer {
            background-color: #fafbfc;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #a0aec0;
            border-top: 1px solid #edf2f7;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Contact Message</h2>
        </div>
        <div class="content">
            <div class="field">
                <div class="label">Name</div>
                <div class="value">{{ $data['name'] }}</div>
            </div>
            <div class="field">
                <div class="label">Email Address</div>
                <div class="value"><a href="mailto:{{ $data['email'] }}" style="color: #0f766e; text-decoration: none;">{{ $data['email'] }}</a></div>
            </div>
            <div class="field">
                <div class="label">Subject</div>
                <div class="value">{{ $data['subject'] }}</div>
            </div>
            <div class="field">
                <div class="label">Message</div>
                <div class="value" style="white-space: pre-wrap; background-color: #f7fafc; padding: 15px; border-radius: 6px; border: 1px solid #edf2f7;">{{ $data['message'] }}</div>
            </div>
        </div>
        <div class="footer">
            This message was sent from the contact form on Bloc-Infra ({{ url('/') }}).
        </div>
    </div>
</body>
</html>
