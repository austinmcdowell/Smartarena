@extends('layouts.app')

@section('css')
<link href="/css/leaderboard.css" rel="stylesheet" type="text/css">
@endsection

@section('javascript')
<script>
    window.user = @json($user);
</script>
@endsection

@section('content')
    <router-view></router-view>
@endsection