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

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>SmartArena</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
        <!-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css"> -->
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css"> -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
        <link rel="stylesheet" href="/css/app.css" text="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
        @yield('css')
        <!-- Styles -->
    </head>
    <body>
        <div id="app">
            <div class="navbar navbar-expand-lg navbar-light sa-nav">
                <a href="/" class="navbar-brand sa-brand green">SmartArena</a>
                <a href="/" class="navbar-brand sa-brand-short green">SA</a>
                <search-bar class="desktop-search"></search-bar>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                        </li>
                    </ul>


                    @if (isset($isLoggedIn) && $isLoggedIn) 
                    <ul class="navbar-nav">
                        @if ($user->human)
                        <search-bar class="mobile-search"></search-bar>
                        <search-results class="results-mobile"></search-results>
                        <div class="nav-profile-pic"></div>

                        @if ($user->role == "admin")
                        <a class="btn mobile-profile-btn" href="/#/admin">Admin</a>
                        @endif
                        <a class="btn mobile-profile-btn" href="/#/profile/{{ $user->human->id }}">My Profile</a>
                        <a class="btn mobile-upload-btn" href="/#/video/new">Upload Video</a>
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

            <search-results class="results-desktop"></search-results>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 content">
                        <video-component></video-component>
                    </div>
                </div>
            </div>
            
            
        </div>
    </body>
    <!-- <script src="/js/manifest.js"></script>
    <script src="/js/vendor.js"></script> -->
    <script src="/js/lib/jquery.min.js"></script>
    <script src="https://vjs.zencdn.net/6.6.3/video.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    @yield('javascript')
    <script src="/js/video.js"></script>
</html>
