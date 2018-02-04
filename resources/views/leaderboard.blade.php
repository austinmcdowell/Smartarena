@extends('layouts.app')

@section('content')
    <br />
    <div class="row">
        <div class="col s10 offset-s1">
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
                        <tr>
                            <td>1</td>
                            <td>Austin McDowell</td>
                            <td>7</td>
                            <td>7</td>
                            <td>5</td>
                            <td>15</td>
                            <td>70.64s</td>
                            <td>80.00s</td>
                            <td>100.00%</td>
                            <td>12.23s</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Austin McDowell</td>
                            <td>7</td>
                            <td>7</td>
                            <td>5</td>
                            <td>15</td>
                            <td>70.64s</td>
                            <td>80.00s</td>
                            <td>100.00%</td>
                            <td>12.23s</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Austin McDowell</td>
                            <td>7</td>
                            <td>7</td>
                            <td>5</td>
                            <td>15</td>
                            <td>70.64s</td>
                            <td>80.00s</td>
                            <td>100.00%</td>
                            <td>12.23s</td>
                        </tr>
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