@extends('layout.bootstrap')
@section('title', 'Reset Admin')

@section('content')

    <section class="vh-100">
        <div class="container py-5 h-100">
        <div class="row d-flex align-items-center justify-content-center h-100">

            <div class="col-md-8 col-lg-7 col-xl-6">
            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
                class="img-fluid" alt="Phone image">
            </div>

            <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">

              <form id="resetadmin" method="get" action="{{ route('ra.confirm') }}">
                @csrf
                @method("GET")

                <div style="display: flex; justify-content: center" class="col-md-12 logo_outer">
                    <img src="img/logo.png" />
                </div>

                <br>

                <label class="text-des" style="display: flex; justify-content: center">Xác thực quyền hạn</label>
                <label style="display: flex; justify-content: center">nhập mật khẩu để xác thực bạn có quyền làm mới dữ liệu hệ thống</label>

                <br><br>

                <!-- Password input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="form1Example23">{{ __('title.password') }}:</label>
                    <input type="password" name="password" id="form1Example23" class="form-control form-control-lg" />
                </div>

                <div class="d-flex justify-content-around align-items-center mb-4">

                <!-- Submit button -->
                <button type="button" style="width: 100%" class="btn btn-primary btn-lg btn-block" data-bs-toggle="modal" data-bs-target="#MyModal">{{ __('title.confirm') }}</button>

              </form>

              @include('common.modal.confirm_option', [
                $id_modal = 'MyModal',
                $id_form = 'resetadmin',
                $content = __('title.notice-reset-system'),
                $name_but = __('title.confirm'),
              ])

            </div>

        </div>
        </div>
    </section>

@endsection
