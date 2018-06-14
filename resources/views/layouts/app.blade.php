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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
        <link href="https://vjs.zencdn.net/6.6.3/video-js.css" rel="stylesheet">
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
        <div id="app">
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
                @if (isset($isLoggedIn) && $isLoggedIn)
                <a href="#!" class="hide-on-med-and-up">SMART ARENA</a>
                <a href="#" data-target="mobile-demo" class="hide-on-med-and-up sidenav-trigger"><i class="material-icons">menu</i></a>
                @endif
                <ul id="nav-mobile" class="hide-on-small-only left">
                    <li class="hide-on-med-and-down"><a href="/">SMART ARENA</a></li>
                    <li><a href="/">LEADERBOARDS</a></li>
                </ul>
                @if (isset($isLoggedIn) && $isLoggedIn) 
                    <ul id="nav-mobile" class=" right">
                        @if ($user->human)
                        <li><a href="/videos/new">Upload Video</a></li>
                        <li><a href="/profile/{{ $user->human->id }}">My Profile</a></li>
                        @endif
                        <li><a class="hide-on-small-only dropdown-button" href="#" data-target="dropdown1">{{ $user->name }}<i class="material-icons right">arrow_drop_down</i></a></li>
                    </ul>
                @else
                    <ul id="nav-mobile" class="right">
                        <li><a href="/register">Create Your Account</a></li>
                        <li><a href="/login">Log in</a></li>
                    </ul>
                @endif
                </div>
            </nav>
            @if (isset($isLoggedIn) && $isLoggedIn) 
            <ul class="sidenav" id="mobile-demo">
                @if ($user->human)
                <li><a href="/profile/{{ $user->human->id }}">My Profile</a></li>
                @endif
                @if (isset($user) && $user->role == "admin")
                <li><a href="/massupload/humans">Mass Upload Humans</a></li>
                <li><a href="/massupload/runs">Mass Upload Runs</a></li>
                <li><a href="/userhumanlinker">User Human Linker</a></li>
                <li><a href="/createhuman">Create Human</a></li>
                @endif
                <li><a href="/logout">Logout</a></li>
            </ul>
            @endif
            @yield('content')
        </div>
    </body>
    <!-- <script src="/js/manifest.js"></script>
    <script src="/js/vendor.js"></script> -->
    <script src="/js/lib/jquery.min.js"></script>
    <script src="https://vjs.zencdn.net/6.6.3/video.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    @yield('javascript')
    <script src="/js/app.js"></script>
</html>
