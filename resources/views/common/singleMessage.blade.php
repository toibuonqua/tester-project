@extends('layout.main')

@section('page')
<div class="alert alert-info" role="alert">
    {{ $message ?? '' }}
</div>
<div class="text-center">
    <a href="{{ route('home') }}" class="btn btn-primary">Back to login</a> 
</div>
@endsection