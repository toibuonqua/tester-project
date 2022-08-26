@extends('layout.master')
@section('title', 'Detail User')
@section('nav-name-title', __('title.user-management'))
@section('content')

    @include('common.block.title1')

    <div class="display-child-page">

        {{-- Field Họ và tên --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-auto">
                <label>Họ và tên:</label>
                </div>
                <div class="col-auto">
                <label>{{ $account->username }}</label>
                </div>
            </div>
        </div>

        {{-- Phòng ban --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-auto">
                <label>Phòng ban:</label>
                </div>
                <div class="col-auto">
                <label>{{ $department->name }}</label>
                </div>
            </div>
        </div>

    </div>

    <div class="display-child-page">

        {{-- Email --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-auto">
                <label>Email:</label>
                </div>
                <div class="col-auto">
                <label>{{ $account->email }}</label>
                </div>
            </div>
        </div>

        {{-- Chức danh --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-auto">
                <label>Chức danh:</label>
                </div>
                <div class="col-auto">
                <label>{{ $role->name }}</label>
                </div>
            </div>
        </div>

    </div>

    <div class="display-child-page">

        {{-- SDT --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-auto">
                <label>SĐT:</label>
                </div>
                <div class="col-auto">
                <label>{{ $account->phone_number }}</label>
                </div>
            </div>
        </div>

        {{-- Mã người dùng --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-auto">
                <label>Mã người dùng:</label>
                </div>
                <div class="col-auto">
                <label>{{ $account->code_user }}</label>
                </div>
            </div>
        </div>

    </div>

    <div class="display-child-page">

        <div style="justify-content: flex-start" class="config-posi">
            <div class="row">
                <div class="col-auto">
                <label>Trạng thái</label>
                </div>
                <div class="col-auto">
                    <label class="switch">
                        @if ($account->status === 'active')
                            <input name='status' type="checkbox" checked>
                        @else
                            <input name='status' type="checkbox">
                        @endif
                        <span class="slider round"></span>
                    </label>
                </div>
            </div>
        </div>

    </div>

    <div class="display-but">

        <div style="margin-top: 50px" class="display-child-page">
            <a href="{{ route('homepage') }}" style="width: 180px" class="btn btn-outline-success">{{ __('title.cancel') }}</a>
        </div>

        <div style="margin-top: 50px" class="display-child-page">
            <button style="width: 180px" class="btn btn-outline-success" type="submit">{{ __('title.save') }}</button>
        </div>

    </div>

@endsection
