<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 600px;
            margin: 20px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            color: #2C3E50;
        }
        h2 {
            font-size: 20px;
            color: #34495E;
        }
        p {
            margin-bottom: 14px;
            line-height: 1.6;
        }
        .highlight {
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #95a5a6;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>⏰ Overdue Book Notice</h1>

        <p>Hello <strong>{{ $data->user_name }}</strong>,</p>

        <p>We noticed that the book you borrowed from <strong>BOOKBACK</strong> is now <strong>OVERDUE</strong>.</p>

        <hr>

        <h2>📖 Book Details</h2>
        <p><span class="highlight">Title:</span> {{ $data->book_title }}</p>
        <p><span class="highlight">Due Date:</span> <span style="color: red;"><strong>{{ \Carbon\Carbon::parse($data->due_date)->format('F j, Y') }}</strong></span></p>

        <hr>

        <p>Please return the book as soon as possible to minimize any late fees or further penalties.</p>
        <p>If you've already returned it, kindly disregard this message.</p>

        <p>We appreciate your attention to this matter and your continued support of <strong>BOOKBACK</strong>.</p>

        <div class="footer">
            <p>Sincerely,<br><strong>BOOKBACK</strong></p>
        </div>
    </div>
</body>
</html>
