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
                <div class="col-3"></div>
                <div class="col-5">
                    @error('username')
                        <span class="text-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-3"><label>{{ __('title.fullname') }} * :</div>
                <div class="col-5"><input maxlength="200" class="form-control" name="username" type="text"></div>
                <div class="col-auto">
                    <p data-bs-toggle="tooltip" data-bs-placement="right" title="trường bắt buộc">
                        <img src="{{ asset('img/info.png') }}" alt="" width="18" height="18">
                    </p>
                </div>
            </div>

            <br><br>

            {{-- email --}}
            <div class="row">
                <div class="col-3"></div>
                <div class="col-5">
                    @error('email')
                        <span class="text-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-3"><label>{{ __('title.email') }} * :</label></div>
                <div class="col-5"><input maxlength="100" class="form-control" name="email" type="text"></div>
                <div class="col-auto">
                    <p data-bs-toggle="tooltip" data-bs-placement="right" title="trường bắt buộc">
                        <img src="{{ asset('img/info.png') }}" alt="" width="18" height="18">
                    </p>
                </div>
            </div>

            <br><br>

            {{-- Phone number --}}
            <div class="row">
                <div class="col-3"></div>
                <div class="col-5">
                    @error('phone_number')
                        <span class="text-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-3"><label>{{ __('title.phone-number') }} * :</label></div>
                <div class="col-5"><input maxlength="30" class="form-control" name="phone_number" type="text"></div>
                <div class="col-auto">
                    <p data-bs-toggle="tooltip" data-bs-placement="right" title="trường bắt buộc">
                        <img src="{{ asset('img/info.png') }}" alt="" width="18" height="18">
                    </p>
                </div>
            </div>

        </div>

        <div class="container">

            {{-- Department --}}

            @include('common.block.select', [
                    'name' => 'department_id',
                    'options' => $departments ?? [],
                    'valueField' => 'id',
                    'displayField' => 'name',
                    'display' => 'block',
            ])

            <br><br>

            {{-- Role --}}
            @include('common.block.select', [
                    'name' => 'role_id',
                    'options' => $roles ?? [],
                    'valueField' => 'id',
                    'displayField' => 'name',
                    'display' => 'block',
            ])

            <br><br>

            {{-- Workarea --}}
            @include('common.block.select', [
                'name' => 'workarea_id',
                'options' => $workareas ?? [],
                'valueField' => 'id',
                'displayField' => 'work_areas_code',
                'display' => 'block',
            ])

            <br><br>

            {{-- Code user --}}
            <div class="row">
                <div class="col-3"></div>
                <div class="col-5">
                    @error('code_user')
                        <span class="text-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-3"><label>{{ __('title.code-user') }} * :</label></div>
                <div class="col-5"><input maxlength="4" class="form-control" name="code_user" type="text"></div>
                <div class="col-auto">
                    <p data-bs-toggle="tooltip" data-bs-placement="right" title="trường bắt buộc, phải là số">
                        <img src="{{ asset('img/info.png') }}" alt="" width="18" height="18">
                    </p>
                </div>
            </div>

        </div>

    </div>

    <br>

    <div class="display-but">

        <div style="margin-top: 50px">
            <a href="{{ route('user.add') }}" style="width: 180px" class="btn btn-outline-success">{{ __('title.cancel') }}</a>
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
