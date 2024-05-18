<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>@yield('title') - {{ config('web_config')['WEB_TITLE'] }}</title>
    <meta content="C-Learning" name="description" />
    <meta content="Khai" name="author" />
    <link rel="shortcut icon" href="{{ Storage::url('images/logo/favicon_c_new.png') }}">
    <link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('assets/css/app.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('assets/css/app-dark.css') }}" rel="stylesheet" type="text/css">
    <style>
        #auth {
            padding-top: 5rem;
        }

        .input {
            border: 2px solid transparent;
            padding-left: 0.8em;
            outline: none;
            overflow: hidden;
            background-color: #eeeeee;
            border-radius: 5px;
            transition: all 0.5s;
        }

        .input:hover,
        .input:focus {
            border: 2px solid #4A9DEC;
            box-shadow: 0px 0px 0px 7px rgb(74, 157, 236, 20%);
            background-color: white;
        }

        .card-login {
            padding: 1rem;
            margin: 1.5rem;
            border-radius: 20px;
            background: #fafafa;
            box-shadow: 15px 15px 30px #cecdcd,
                -15px -15px 30px #ffffff;
        }
    </style>
</head>

<body>
    <div id="auth">
        <div class="row">
            <div class="col-12 col-md-4 mx-auto">
                @yield('content')
            </div>
        </div>
        <script src="{{ URL::asset('assets/js/bootstrap.js') }}"></script>
        <script src="{{ URL::asset('assets/js/app.js') }}"></script>
</body>

</html>
