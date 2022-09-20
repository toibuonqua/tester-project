@extends('layout.master')
@section('title', __('title.change-password'))
@section('nav-name-title', __('title.change-password'))

@section('content')

<br><br>

<form method="POST" action="{{ route('password.update') }}">

    @csrf
    @method('POST')

    <div class="container">

        {{-- Email --}}
        <div class="row">
        <div class="col-2"><label>{{ __('title.email') }}:</label></div>
        <div class="col-3"><label>{{ $email }}</label></div>
        </div>

        <br>

        {{-- old password --}}
        <div class="row">
            <div class="col-2"><label>{{ __('title.old-password') }}:</label></div>
            <div class="col-3"><input class="form-control" name="old-password" type="password"></div>
        </div>
        <div class="row">
            <div class="col-2"></div>
            <div class="col-3">
                @if (session('error-old-pw'))
                    <p class="text-error">{{ session('error-old-pw') }}</p>
                @endif
            </div>
        </div>

        <br>

        {{-- new password --}}
        <div class="row">
            <div class="col-2"><label>{{ __('title.new-password') }}:</label></div>
            <div class="col-3"><input class="form-control" name="new-password" type="password"></div>
        </div>

        <br>

        {{--Confirm new password --}}
        <div class="row">
            <div class="col-2"><label>{{ __('title.confirm-password') }}:</label></div>
            <div class="col-3"><input class="form-control" name="confirm-new-password" type="password"></div>
        </div>
        <div class="row">
            <div class="col-2"></div>
            <div class="col-3">
                @if (session('error-confirm'))
                    <p class="text-error">{{ session('error-confirm') }}</p>
                @endif
            </div>
        </div>

    </div>

    <div class="display-but">

        <div style="margin-top: 50px">
            <a href="{{ route('homepage') }}" style="width: 180px" class="btn btn-outline-success">{{ __('title.cancel') }}</a>
        </div>

        <div style="margin-top: 50px">
            <button style="width: 180px" class="btn btn-outline-success" onclick="return confirm('{{ __('title.notice-change-password') }}')" type="submit">{{ __('title.change-password') }}</button>
        </div>

    </div>

</form>

<br>

@include('common.block.flash-message')

@endsection
