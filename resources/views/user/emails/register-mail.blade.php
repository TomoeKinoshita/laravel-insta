<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <title>Document</title> --}}
</head>
<body>
    <p>Hello, {{ $name }}!</p> {{-- A variable $name is from an array $details of RegisterController. --}}
    <p>Thank you for registering at Kred IG. To start, go to our <a href="{{ $appURL }}">website</a>.</p>
                        {{-- A variable $appURL is also from an array $details of RegisterController, and it is originally from "APP_URL=http://localhost" in .env file. --}}
    <p>Welcome!</p>

</body>
</html>
