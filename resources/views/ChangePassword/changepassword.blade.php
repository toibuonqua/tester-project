@extends('layout.master')
@section('title', __('title.change-password'))
@section('nav-name-title', __('title.change-password'))

@section('content')

<form method="POST" action="{{ route('password.update') }}">

    @csrf
    @method('POST')

    <div class="display-child-page">

        {{-- Email --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-md-5">
                <label>{{ __('title.email') }}:</label>
                </div>
                <div class="col-md-7">
                <label>{{ $email }}</label>
                </div>
            </div>
        </div>

    </div>

    <div class="display-child-page">

        {{-- Mật khẩu cũ --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-md-5">
                <label>{{ __('title.old-password') }}:</label>
                </div>
                <div class="col-md-7">
                <input type="password" name="old-password" class="form-control">
                @if (session('error-old-pw'))
                    <p class="text-error">{{ session('error-old-pw') }}</p>
                @endif
                </div>
            </div>
        </div>

    </div>

    <div class="display-child-page">

        {{-- Mật khẩu mới --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-md-5">
                <label>{{ __('title.new-password') }}:</label>
                </div>
                <div class="col-md-7">
                <input type="password" name="new-password" class="form-control">
                </div>
            </div>
        </div>

    </div>

    <div class="display-child-page">

        {{-- Xác nhận mật khẩu mới --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-md-5">
                <label>{{ __('title.confirm-password') }}:</label>
                </div>
                <div class="col-md-7">
                <input type="password" name="confirm-new-password" class="form-control">
                @if (session('error-confirm'))
                    <p class="text-error">{{ session('error-confirm') }}</p>
                @endif
                </div>
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

@include('common.block.flash-message')

@endsection
