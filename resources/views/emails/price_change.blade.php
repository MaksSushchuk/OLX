<!DOCTYPE html>
<html>
<head>
    <title>Price Change Notification</title>
</head>
<body>
<h1>Price Change Alert</h1>
<p>Hello,</p>
<p>The price for the advertisement you are tracking has changed!</p>

<p><strong>Advertisement URL:</strong> <a href="{{ $url }}" target="_blank">{{ $url }}</a></p>
<p><strong>New Price:</strong> {{ $price }} UAH</p>

<p>We recommend you to check it out as soon as possible.</p>
<br>
<p>Thank you for using our service!</p>
<p>The Price Tracker Team</p>
</body>
</html>
