<!DOCTYPE html>
<html>
    <head>
        <title>Hasis</title>
    </head>
    <body>
        <h1>{{ $mailData['title'] }}</h1>
        <p>{{ $mailData['body']['message'] }}</p>
        <p></p>
        <p><strong>{{ $mailData['body']['username'] }}</strong></p>
    </body>
</html>