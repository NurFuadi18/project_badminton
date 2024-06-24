<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Your custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <style>
        body {
            padding: 0;
            margin: 0;
            font-family: Helvetica, Arial, sans-serif;
        }

        .vid-container {
            position: relative;
            height: 100vh;
            overflow: hidden;
        }

        .bgvid {
            position: absolute;
            left: 0;
            top: 0;
            width: 100vw;
            height: 100vh;
            object-fit: cover;
            z-index: -1;
        }

        .inner-container {
            width: 400px;
            height: auto;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            overflow: hidden;
            padding: 20px;
            border-radius: 10px;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .box {
            color: #fff;
            text-align: center;
        }

        .box h1 {
            margin: 20px 0;
            font-size: 30px;
        }

        .box input {
            width: 100%;
            margin: 10px 0;
            padding: 15px;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            border: none;
            border-radius: 5px;
            outline: none;
        }

        .box input::placeholder {
            color: #ddd; 
        }

        .box button {
            background: #273a73;
            border: none;
            color: #fff;
            padding: 10px 0;
            font-size: 20px;
            width: 100%;
            margin: 20px 0;
            border-radius: 5px;
            cursor: pointer;
            outline: none;
        }

        .box button:hover {
            background: #8fa1d9;
        }

        .box p {
            font-size: 14px;
            color: #ccc;
        }

        .box p a {
            color: #fff;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="vid-container">
    <video class="bgvid" autoplay loop muted>
        <source src="{{ asset('videos/backloginfix.mp4') }}" type="video/mp4">
    </video>
    <div class="inner-container">
        <div class="box">
            <h1>Login</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first('error') }}
                </div>
            @endif
            <form action="postlogin" method="POST">
                {{ csrf_field() }}
                <input type="text" name="email" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <p>Not a member? <a href="{{ route('register') }}">Sign Up</a></p>
        </div>
    </div>
</div>

</body>
</html>
