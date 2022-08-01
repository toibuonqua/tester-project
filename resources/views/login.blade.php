@extends('layout.main')

@section('static')
    @parent

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

@endsection


@section('page')

    @include('common.block.flash-message')

    <div class="background">

        <div class="jumbotron jumbotron-fluid jumbotron-blur">
            <div class="container">
                <h1 class="display-5 center-text">{{ __('title.portal') }}</h1>
            </div>
        </div>

        <form class="login-box col-sm-3" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="input-group mb-3">
                <input type="text" class="form-control" value="{{ $username ?? old('username') }}"
                    placeholder="{{ __('title.username') }}" aria-label="Username" name="username">
            </div>

            <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="{{ __('title.password') }}"
                    aria-label="Password" name="password">
            </div>

            <div class="input-group mb-3">
                <input type="submit" value="{{ __('title.login') }}" class="btn btn-success btn-md btn-block">
            </div>

            @foreach ($providers ?? [] as $provider)
                <div class="input-group">
                    <a href="{{ $urlGmailApp }}"
                        class="btn btn-secondary btn-md btn-block">{{ __("title.login-as-$provider") }}</a>
                </div>
            @endforeach
        </form>
    </div>
@endsection
