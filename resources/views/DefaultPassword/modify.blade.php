@extends('layout.master')
@section('title', __('title.default-password'))
@section('nav-name-title', __('title.default-password'))

@section('content')

@include('common.block.title1', [
    $title = __('title.default-password-modify')
])

<br>

<form id="update" method="post" action="{{ route('dfpassword.update') }}">
@csrf
@method('POST')

    <div class="container">

        <div class="row">
        <div class="col-3"><label>{{ __('title.default-password') }}:</label></div>
        <div class="col-3"><label>{{ $pwdefault->password }}</label></div>
        </div>

        <br>

        <div class="row">
            <div class="col-3"><label>{{ __('title.default-password-new') }}:</label></div>
            <div class="col-3"><input class="form-control" name="new-password-default" type="password"></div>
        </div>

        <br>

        <div class="row">
            <div class="col-3"><label>{{ __('title.default-password-new-confirm') }}:</label></div>
            <div class="col-3"><input class="form-control" name="new-password-default-confirm" type="password"></div>
        </div>

        <div class="row">
            <div class="col-3"></div>
            <div class="col-3">
                @if (session('validate'))
                    <p class="text-error">{{ session('validate') }}</p>
                @endif
            </div>
        </div>

        <br><br>

        <div class="display-but">

            <div style="margin-top: 50px">
                <a href="{{ route('homepage') }}" style="width: 180px" class="btn btn-outline-success">{{ __('title.back') }}</a>
            </div>

            <div style="margin-top: 50px">
                <button style="width: 180px" class="btn btn-outline-success" type="button" data-bs-toggle="modal" data-bs-target="#MyModal">{{ __('title.modify') }}</a>
            </div>

        </div>

    </div>

</form>

@include('common.modal.confirm_option', [
    $id_modal = "MyModal",
    $id_form = "update",
    $content = __('title.notice-update-new-default-password'),
    $name_but = __('title.modify')
])

<br>

@include('common.block.flash-message')

@endsection
