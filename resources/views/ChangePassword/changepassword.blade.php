@extends('layout.master')
@section('title', __('title.change-password'))
@section('nav-name-title', __('title.change-password'))

@section('content')

<br><br>

<form id="changepw" method="POST" action="{{ route('password.update') }}">

    @csrf
    @method('POST')

    <div class="container">

        {{-- Email --}}
        <div class="row">
        <div class="col-2"><label>{{ __('title.email') }}:</label></div>
        <div class="col-3"><label>{{ $email }}</label></div>
        </div>

        <br><br>

        {{-- old password --}}
        <div class="row">
            <div class="col-2"></div>
            <div class="col-auto">
                @error('old-password')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-2"><label>{{ __('title.old-password') }}:</label></div>
            <div class="col-3">
                <div class="input-group mb-3">

                    <input name="old-password" type="password" maxlength="200" class="form-control"
                        id="old-password" aria-label="password" aria-describedby="basic-addon1" />

                    <div class="input-group-append">
                        <span class="input-group-text" onclick="password_show_hide(idInput='old-password', showEye='show_eye_1', hideEye='hide_eye_1');">
                            <i class="fas fa-eye-slash" id="hide_eye_1"></i>
                            <i class="fas fa-eye d-none" id="show_eye_1"></i>
                        </span>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-2"></div>
            <div id="old-password-validate" class="col-auto text-error">
                @if (session('error-old-pw'))
                    <p class="text-error">{{ session('error-old-pw') }}</p>
                @else
                    <p class="text-error"></p>
                @endif
            </div>
        </div>

        <br>

        {{-- new password --}}
        <div class="row">
            <div class="col-2"></div>
            <div class="col-auto">
                @error('new-password')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-2"><label>{{ __('title.new-password') }}:</label></div>
            <div class="col-3">
                <div class="input-group mb-3">

                    <input name="new-password" type="password" maxlength="200" class="form-control"
                        id="new-password" aria-label="password" aria-describedby="basic-addon1" />

                    <div class="input-group-append">
                        <span class="input-group-text" onclick="password_show_hide(idInput='new-password', showEye='show_eye_2', hideEye='hide_eye_2');">
                            <i class="fas fa-eye-slash" id="hide_eye_2"></i>
                            <i class="fas fa-eye d-none" id="show_eye_2"></i>
                        </span>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-2"></div>
            <div id="new-password-validate" class="col-auto text-error">
                @if (session('error-new-pw'))
                    <p class="text-error">{{ session('error-new-pw') }}</p>
                @else
                    <p class="text-error"></p>
                @endif
            </div>
        </div>

        <br>

        {{--Confirm new password --}}
        <div class="row">
            <div class="col-2"></div>
            <div class="col-auto">
                @error('confirm-new-password')
                    <span class="text-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-2"><label>{{ __('title.confirm-password') }}:</label></div>
            <div class="col-3">
                <div class="input-group mb-3">

                    <input name="confirm-new-password" type="password" maxlength="200" class="form-control"
                        id="confirm-new-password" aria-label="password" aria-describedby="basic-addon1" />

                    <div class="input-group-append">
                        <span class="input-group-text" onclick="password_show_hide(idInput='confirm-new-password', showEye='show_eye_3', hideEye='hide_eye_3');">
                            <i class="fas fa-eye-slash" id="hide_eye_3"></i>
                            <i class="fas fa-eye d-none" id="show_eye_3"></i>
                        </span>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-2"></div>
            <div id="confirm-new-password-validate" class="col-auto text-error">
                @if (session('error-confirm'))
                    <p class="text-error">{{ session('error-confirm') }}</p>
                @else
                    <p class="text-error"></p>
                @endif
            </div>
        </div>

    </div>

    <div class="display-but">

        <div style="margin-top: 50px">
            <a href="{{ route('homepage') }}" style="width: 180px" class="btn btn-outline-success">{{ __('title.cancel') }}</a>
        </div>

        <div style="margin-top: 50px">
            <button style="width: 180px" class="btn btn-outline-success" type="button" onclick="submit_password()">{{ __('title.change-password') }}</button>
        </div>

    </div>

    {{-- button submit --}}
    <input id="submitPassword" style="display: none" type="button" data-bs-toggle="modal" data-bs-target="#changePwModal">

    <br><br>

    <div style="width: 100%" class="container">
        <div class="row">
            <label class="text-des">Lưu ý :</label>
        </div>
        <div>
            <label>- Mật khẩu gồm ít nhất 8 ký tự trong đó cả chữ hoa, chữ thường, số và ký tự đặc biệt [!@#$&*]</label>
        </div>
        <div>
            <label>- Mật khẩu mới không được giống mật khẩu cũ</label>
        </div>
    </div>

</form>

@include('common.modal.confirm_option', [
    $id_modal = "changePwModal",
    $id_form = "changepw",
    $content = __('title.notice-change-password'),
    $name_but = __('title.change')
])

<br>

@include('common.block.flash-message')

@endsection
