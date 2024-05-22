<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ Storage::url('images/logo/favicon_c_new.png') }}">
    <link rel="stylesheet" href="/css/404_style.css">
    <title>101</title>
</head>

<body>
    <div class="content">
        <canvas class="snow" id="snow"></canvas>
        <div class="main-text">
            <h1>Our Website {{ $pesan }}<br>Sorry, we`re working hard to finishing.</h1>
            <a href="{{ url('/') }}" class="home-link">Hitch a ride back home.</a>
        </div>
        <div class="ground">
            <div class="mound">
                <div class="mound_text">101</div>
                <div class="mound_spade"></div>
            </div>
        </div>
    </div>
    <script src="/js/404.js"></script>
</body>

</html>
