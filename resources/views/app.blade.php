@extends('layouts.app')

@section('javascript')
<script>
    window.user = @json($user);
</script>
@endsection

@section('content')
    <router-view></router-view>
@endsection