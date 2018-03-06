@extends('layouts.app')

@section('css')
<link href="/css/leaderboard.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <br />
    <div class="row">
        <div class="col s6 offset-s3 awards center-align">

            @if (isset($most_runs_badge))
            <div class="award most-runs">
                <div class="circle"></div>
                <div class='full-name'>{{ $most_runs_badge['human_name'] }}</div>
                <div class='description'>({{ $most_runs_badge['count'] }}) Most Runs</div>
            </div>
            @endif

            @if (isset($most_efficient_badge))
            <div class="award most-efficient">
                <div class="circle"></div>
                <div class='full-name'>{{ $most_efficient_badge['human_name'] }}</div>
                <div class='description'>Most Efficient</div>
            </div>
            @endif

            @if (isset($shortest_average_time_badge))
            <div class="award shortest-average-time">
                <div class="circle"></div>
                <div class='full-name'>{{ $shortest_average_time_badge['human_name'] }}</div>
                <div class='description'>Best Average Time: {{ $shortest_average_time_badge['count'] }}</div>
            </div>
            @endif

        </div>
    </div>
    <div class="row hide-on-large-only">
        <div class="col s10 offset-s1">
            @foreach ($humans as $human)
                <div class="card">
                    <div class="card-content">
                        <h4><a href="/profile/{{ $human->id }}">{{ ucfirst($human->first_name) . ' ' . ucfirst($human->last_name) }}</a></h4>
                        <p>Classification: {{ $human->classification }}</p>
                        <p>Catch count: {{ $stats[$human->id]['catch_count'] }}</p>
                        <p>Runs: {{ $stats[$human->id]['run_count'] }}</p>
                        <p>Total Run Penalties: {{ $stats[$human->id]['total_penalties'] }}</p>
                        <p>Total Raw Time: {{ $stats[$human->id]['total_raw_time'] }}s</p>
                        <p>Time With Penalties: {{ $stats[$human->id]['time_with_penalties'] }}s</p>
                        <p>Catch Percentage: {{ $stats[$human->id]['catch_percentage'] }}%</p>
                        <p>Average Time: {{ $stats[$human->id]['sum_of_average_time'] }}s</p>
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
                                <td>{{ $human->classification }}</td>
                                <td><a href="/profile/{{ $human->id }}">{{ $human->first_name . ' ' . $human->last_name }}</a></td>
                                <td>{{ $stats[$human->id]['catch_count'] }}</td>
                                <td>{{ $stats[$human->id]['run_count'] }}</td>
                                <td>{{ $stats[$human->id]['penalties'] }}</td>
                                <td>{{ $stats[$human->id]['total_penalties'] }}</td>
                                <td>{{ $stats[$human->id]['total_raw_time'] }}s</td>
                                <td>{{ $stats[$human->id]['time_with_penalties'] }}s</td>
                                <td>{{ $stats[$human->id]['catch_percentage'] }}%</td>
                                <td>{{ $stats[$human->id]['sum_of_average_time'] }}s</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
          </div>
        </div>
    </div>
@endsection