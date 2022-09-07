@extends('layout.master')
@section('title', 'New Arrival Management')
@section('nav-name-title', __('title.arrival-management'))

@section('content')
<div class="container">
    <div class="row">
        <div>
            <h1>Page new arrival management</h1>
        </div>
    </div>
</div>
<div>
    @if (session('error'))
        <h2 style="color: red; font-family: 'Nunito', sans-serif;">{{ session('error') }}</h2>
    @endif
</div>
@endsection
