@extends('layouts.app')

@section('css')
<link href="/css/leaderboard.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <br />
    <div class="row hide-on-large-only">
        <div class="col s10 offset-s1">
            @foreach ($humans as $human)
                <div class="card">
                    <div class="card-content">
                        <h4><a href="/profile/{{ $human->id }}">{{ ucfirst($human->first_name) . ' ' . ucfirst($human->last_name) }}</a></h4>
                        <p>Classification: 1</p>
                        <p>Catch count: 7</p>
                        <p>Runs: 7</p>
                        <p>Total Run Penalties: 7</p>
                        <p>Total Raw Time: 70.64s</p>
                        <p>Time With Penalties: 80.00s</p>
                        <p>Catch Percentage: 100.00%</p>
                        <p>Average Time: 12.23s</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="row hide-on-med-and-down">
        <div class="col l10 offset-l1">
          <div class="card">
            <div class="card-content">
                <table>
                    <thead>
                        <tr>
                            <th>Classification</th>
                            <th>Name</th>
                            <th>Catch Count</th>
                            <th>Runs</th>
                            <th>Penalties</th>
                            <th>Total Run Penalties</th>
                            <th>Total Raw Time</th>
                            <th>Time With Penalties</th>
                            <th>Catch Percentage</th>
                            <th>Average Time</th>
                        </tr>
                    </thead>
            
                    <tbody>
                        @foreach ($humans as $human)
                            <tr>
                                <td>1</td>
                                <td><a href="/profile/{{ $human->id }}">{{ $human->first_name . ' ' . $human->last_name }}</a></td>
                                <td>7</td>
                                <td>7</td>
                                <td>5</td>
                                <td>15</td>
                                <td>70.64s</td>
                                <td>80.00s</td>
                                <td>100.00%</td>
                                <td>12.23s</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
          </div>
        </div>
    </div>
@endsection

<!-- <div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    @endif

    <div class="content">
        <div class="title m-b-md">
            Laravel
        </div>

        <div class="links">
            <a href="https://laravel.com/docs">Documentation</a>
            <a href="https://laracasts.com">Laracasts</a>
            <a href="https://laravel-news.com">News</a>
            <a href="https://forge.laravel.com">Forge</a>
            <a href="https://github.com/laravel/laravel">GitHub</a>
        </div>
    </div>
</div>
     -->