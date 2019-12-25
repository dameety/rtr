<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

    <title> Restaurant </title>

    <link href="{{asset('front/img/brand/favicon.png')}}" rel="icon" type="image/png">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="{{asset('front/vendor/nucleo/css/nucleo.css')}}" rel="stylesheet">
    <link href="{{asset('front/vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link type="text/css" href="{{asset('front/css/argon.css?v=1.1.0')}}" rel="stylesheet">

    @foreach($options as $key => $option)
        @javascript($key, $option)
    @endforeach
</head>

<body>

    <div id="app"></div>

    <script src="{{asset('front/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('front/vendor/bootstrap/bootstrap.min.js')}}"></script>
    <script src="{{asset('front/vendor/headroom/headroom.min.js')}}"></script>
    <script src="{{asset('front/js/argon.js?v=1.1.0')}}"></script>
    <script src="{{ asset('front/js/vue-app.js') }}" defer></script>
</body>

</html>
