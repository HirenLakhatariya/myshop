<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>email</title>
</head>
<body>
    <h1>{{ $data['name'] }} wants to contact you</h1>
    <p><strong>Name:</strong> {{ $data['name'] }}</p> 
    <p><strong>Message:</strong> {{ $data['user_message'] }}</p>
    <p><strong>Phone Number:</strong> {{ $data['number'] }}</p>
</body>
</html>