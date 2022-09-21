@extends('layout.master')
@section('title', 'Add User')
@section('nav-name-title', __('title.user-management'))
@section('content')

@include('common.block.title1', [$title = __('title.add-user')])

<form id="add_user" method="post" action="{{ route('user.store') }}">

    @csrf

    <br>

    <div style="margin-left: 5%; display:flex">

        <div class="container">

            {{-- username --}}
            <div class="row">
                <div class="col-3"><label>{{ __('title.fullname') }} * :</label></div>
                <div class="col-5"><input class="form-control" name="username" type="text"></div>
            </div>

            <br><br>

            {{-- email --}}
            <div class="row">
                <div class="col-3"><label>{{ __('title.email') }} * :</label></div>
                <div class="col-5"><input class="form-control" name="email" type="text"></div>
            </div>

            <br><br>

            {{-- Phone number --}}
            <div class="row">
                <div class="col-3"></div>
                <div class="col-5"></div>
            </div>
            <div class="row">
                <div class="col-3"><label>{{ __('title.phone-number') }} * :</label></div>
                <div class="col-5"><input class="form-control" name="phone_number" type="text"></div>
            </div>

        </div>

        <div class="container">

            {{-- Department --}}
            @include('common.block.select', [
                    'name' => 'department_id',
                    'options' => $departments ?? [],
                    'valueField' => 'id',
                    'displayField' => 'name',
            ])

            <br><br>

            {{-- Role --}}
            @include('common.block.select', [
                    'name' => 'role_id',
                    'options' => $roles ?? [],
                    'valueField' => 'id',
                    'displayField' => 'name',
            ])

            <br><br>

            {{-- Code user --}}
            <div class="row">
                <div class="col-3"></div>
                <div class="col-5"></div>
            </div>
            <div class="row">
                <div class="col-3"><label>{{ __('title.code-user') }} * :</label></div>
                <div class="col-5"><input class="form-control" name="code_user" type="text"></div>
            </div>

        </div>

    </div>

    <br>

    <div class="display-but">

        <div style="margin-top: 50px">
            <a href="{{ route('homepage') }}" style="width: 180px" class="btn btn-outline-success">{{ __('title.cancel') }}</a>
        </div>

        <div style="margin-top: 50px">
            <button style="width: 180px" class="btn btn-outline-success" type="button" data-bs-toggle="modal" data-bs-target="#myModal">{{ __('title.save') }}</button>
        </div>

    </div>

</form>

@include('common.modal.confirm_option', [
    $id_modal = "myModal",
    $content = __('title.notice-add-user'),
    $id_form = "add_user",
    $name_but = __('title.add'),
])

<br>

@include('common.block.flash-message')

@endsection
