<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carpool Landing Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .jumbotron {
            background-image: url("../vendor/dist/img/background.png");
            background-size: cover;
            color: white;
            text-align: center;
            padding: 270px;
        }

        .jumbotron h1 {
            color: black;
            font-size: 48px;
            font-weight: bold;
        }

        .jumbotron p {
            color: black;
            font-size: 24px;
            margin-top: 30px;
        }

        .btn-primary {
            font-size: 18px;
            padding: 15px 30px;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="jumbotron">
        <h1>Welcome to TARUMT Carpool</h1>
        <p>Save money and reduce your carbon footprint by sharing rides with others</p>
        <a href="{{ route("register") }}" class="btn btn-primary">Join Now</a>
    </div>
</body>

</html>
