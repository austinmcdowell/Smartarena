<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>SmartArena</title>

        <!-- Fonts -->
        <!-- <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css"> -->
        <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css"> -->
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css"> -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/app.css" text="text/css">
        <!-- <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script> -->
        @yield('css')
        <!-- Styles -->
    </head>
    <body>
        <div id="app">
            <div class="navbar navbar-expand-lg navbar-light bg-light sa-nav">
                <router-link to="/" class="navbar-brand">SmartArena</router-link>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <router-link to="/" class="nav-link">Leaderboards <span class="sr-only">(current)</span></router-link>
                        </li>
                    </ul>


                    @if (isset($isLoggedIn) && $isLoggedIn) 
                    <ul class="navbar-nav">
                        @if ($user->human)
                        <li class="nav-item"><router-link to="/videos/new" class="nav-link">Upload Video</router-link></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $user->name }}</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <router-link class="dropdown-item" to="/profile">My Profile</a>
                            <!-- <a class="dropdown-item" href="#">Another action</a> -->
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Log Out</a> 
                            </div>
                        </li>
                        @endif
                    </ul>
                    @else
                    <ul id="nav-mobile" class="navbar-nav">
                        <li class="nav-item"><a href="/register" class="nav-link">Create Your Account</a></li>
                        <li class="nav-item"><a href="/login" class="nav-link">Log in</a></li>
                    </ul>
                    @endif
                </div>
            </div>

            

            <!-- @if (isset($isLoggedIn) && $isLoggedIn) 
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
            @endif -->

            <!-- <ul id="dropdown1" class="dropdown-content">
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
            </nav> -->

            @yield('content')
        </div>
    </body>
    <!-- <script src="/js/manifest.js"></script>
    <script src="/js/vendor.js"></script> -->
    <script src="/js/lib/jquery.min.js"></script>
    <script src="https://vjs.zencdn.net/6.6.3/video.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
    @yield('javascript')
    <script src="/js/app.js"></script>
</html>
