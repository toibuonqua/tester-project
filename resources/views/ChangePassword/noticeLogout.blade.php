@extends('layout.bootstrap')
@section('title', __('title.back-login'))

@section('content')

    <div style="justify-content:center">

        <div style="text-align: center; width: 50%; margin-left: 25%" class="alert alert-info" role="alert">
            {{ session('notice-login') }}
        </div>
        <div class="text-center">
            <form action="{{ route('user.logout') }}">
                @csrf
                <button type="submit" class="btn btn-success">{{ __('title.login') }}</button>
            </form>
        </div>

    </div>

@endsection


