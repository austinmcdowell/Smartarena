<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>SmartArena</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
        <link rel="stylesheet" href="/css/app.css" text="text/css">
        <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
        @yield('css')
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <ul id="dropdown1" class="dropdown-content">
            @if (isset($user) && $user->role == "admin")
            <li><a href="/massupload/humans">Mass Upload Humans</a></li>
            <li><a href="/massupload/runs">Mass Upload Runs</a></li>
            <li><a href="/userhumanlinker">User Human Linker</a></li>
            <li><a href="/createhuman">Create Human</a></li>
            @endif
            <li><a href="/logout">Logout</a></li>
        </ul>
        <nav>
            <div class="nav-wrapper">
            <ul id="nav-mobile" class="left">
                <li class="hide-on-med-and-down"><a href="/">SMART ARENA</a></li>
                <li><a href="/">LEADERBOARDS</a></li>
            </ul>
            @if (isset($isLoggedIn) && $isLoggedIn) 
                <ul id="nav-mobile" class="right">
                    <li><a class="dropdown-button" href="#!" data-activates="dropdown1">{{ $user->name }}<i class="material-icons right">arrow_drop_down</i></a></li>
                </ul>
            @else
                <ul id="nav-mobile" class="right">
                    <li><a href="/login">Log in</a></li>
                </ul>
            @endif
            </div>
        </nav>
            @yield('content')
    </body>
    <!-- <script src="/js/manifest.js"></script>
    <script src="/js/vendor.js"></script> -->
    <script src="/js/app.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    @yield('javascript')
</html>
