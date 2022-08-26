@extends('layout.master')
@section('title', __('title.change-password'))
@section('nav-name-title', __('title.change-password'))

@section('content')


    <div class="display-child-page">

        {{-- Email --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-auto">
                <label>Email:</label>
                </div>
                <div class="col-auto">
                <label>None</label>
                </div>
            </div>
        </div>

    </div>

    <div class="display-child-page">

        {{-- Mật khẩu cũ --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-auto">
                <label>Mật khẩu cũ: </label>
                </div>
                <div class="col-auto">
                <input type="text" name="old-password" class="form-control">
                </div>
            </div>
        </div>

    </div>

    <div class="display-child-page">

        {{-- Mật khẩu mới --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-auto">
                <label>Mật khẩu mới: </label>
                </div>
                <div class="col-auto">
                <input type="text" name="new-password" class="form-control">
                </div>
            </div>
        </div>

    </div>

    <div class="display-child-page">

        {{-- Xác nhận mật khẩu mới --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-auto">
                <label>Xác nhận mật khẩu mới: </label>
                </div>
                <div class="col-auto">
                <input type="text" name="confirm-new-password" class="form-control">
                </div>
            </div>
        </div>

    </div>

    <div class="display-but">

        <div style="margin-top: 50px" class="display-child-page">
            <a href="{{ route('homepage') }}" style="width: 180px" class="btn btn-outline-success">{{ __('title.cancel') }}</a>
        </div>

        <div style="margin-top: 50px" class="display-child-page">
            <button style="width: 180px" class="btn btn-outline-success" onclick="return confirm('{{ __('title.notice-change-password') }}')" type="submit">{{ __('title.change-password') }}</button>
        </div>

    </div>

@endsection
