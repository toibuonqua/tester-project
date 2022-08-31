@extends('layout.master')
@section('title', 'Add User')
@section('nav-name-title', __('title.user-management'))
@section('content')

@include('common.block.title1', [$title = __('title.add-user')])

<form method="post" action="{{ route('user.store') }}">

    @csrf


    <div class="display-child-page">

        {{-- Field Họ và tên --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-md-4">
                <label>Họ và tên:</label>
                </div>
                <div class="col-md-8">
                <input type="text" name="username" class="form-control">
                </div>
            </div>
        </div>

        {{-- Phòng ban --}}
        <div class="config-posi">
            @include('common.block.select', [
                'name' => 'department_id',
                'options' => $departments ?? [],
                'valueField' => 'id',
                'displayField' => 'name',
            ])
        </div>

    </div>

    <div class="display-child-page">

        {{-- Email --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-md-4">
                <label>Email:</label>
                </div>
                <div class="col-md-8">
                <input type="text" name="email" class="form-control">
                </div>
            </div>
        </div>

        {{-- Chức danh --}}
        <div class="config-posi">
            @include('common.block.select', [
                'name' => 'role_id',
                'options' => $roles ?? [],
                'valueField' => 'id',
                'displayField' => 'name',
            ])
        </div>

    </div>

    <div class="display-child-page">

        {{-- SDT --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-md-4">
                <label>SĐT:</label>
                </div>
                <div class="col-md-8">
                <input type="text" name='phone_number' class="form-control">
                </div>
            </div>
        </div>

        {{-- Mã người dùng --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-md-4">
                <label class="col-form-label">Mã người dùng:</label>
                </div>
                <div class="col-md-5">
                <input type="text" name="code_user" class="form-control">
                </div>
            </div>
        </div>

    </div>

    <div class="display-but">

        <div style="margin-top: 50px">
            <a href="{{ route('homepage') }}" style="width: 180px" class="btn btn-outline-success">{{ __('title.cancel') }}</a>
        </div>

        <div style="margin-top: 50px">
            <button style="width: 180px" class="btn btn-outline-success" onclick="return confirm('{{ __('title.notice-add-user') }}')" type="submit">{{ __('title.save') }}</button>
        </div>

    </div>

</form>

@include('common.block.flash-message')

@endsection
