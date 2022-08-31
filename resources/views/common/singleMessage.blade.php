@extends('layout.master')

@section('content')
<div class="alert alert-info" role="alert">
    {{ $message ?? '' }}
</div>
<div class="text-center">
    <a href="{{ route($homepage) }}" class="btn btn-success">{{ $text }}</a>
</div>
@endsection
