<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-123711198-1"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-123711198-1');
        </script>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-123711198-1"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-123711198-1');
        </script>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>SmartArena</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/app.css" text="text/css">
        @yield('css')
    </head>
    <body>
        <div id="app">
            <div class="navbar navbar-expand-lg navbar-light bg-light sa-nav">
                <a href="/" class="navbar-brand">SmartArena</a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <!-- <a href="/" class="nav-link">Leaderboards <span class="sr-only">(current)</span></a> -->
                        </li>
                    </ul>


                    @if (isset($isLoggedIn) && $isLoggedIn) 
                    <ul class="navbar-nav">
                        @if ($user->human)
                        <li class="nav-item"><router-link to="/videos/new" class="nav-link">Upload Video</router-link></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $user->name }}</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/profile">My Profile</a>
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

            <div style="padding-top: 5%">@yield('content')</div>
        </div>
    </body>
    <!-- <script src="/js/manifest.js"></script>
    <script src="/js/vendor.js"></script> -->
    <script src="/js/lib/jquery.min.js"></script>
    <script src="https://vjs.zencdn.net/6.6.3/video.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
    @yield('javascript')
</html>
