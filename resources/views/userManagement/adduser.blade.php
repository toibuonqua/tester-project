@extends('layout.master')
@section('title', 'Add User')
@section('nav-name-title', __('title.user-management'))
@section('content')

    @include('common.block.title1')

    <div class="display-child-page">

        {{-- Field Họ và tên --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-6 col-md-4">
                <label>Họ và tên</label>
                </div>
                <div class="col-md-8">
                <input type="text" class="form-control">
                </div>
            </div>
        </div>

        {{-- Phòng ban --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-auto">
                <label>Phòng ban</label>
                </div>
                <div class="col-auto">
                    <select class="form-select">
                      <option>{{  __('title.select') }}</option>
                      <option>Phòng ban 1</option>
                      <option>Phòng ban 2</option>
                    </select>
                </div>
            </div>
        </div>

    </div>

    <div class="display-child-page">

        {{-- Email --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-6 col-md-4">
                <label>Email</label>
                </div>
                <div class="col-md-8">
                <input type="text" class="form-control">
                </div>
            </div>
        </div>

        {{-- Chức danh --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-auto">
                <label class="col-form-label">Chức danh</label>
                </div>
                <div class="col-auto">
                    <select class="form-select">
                      <option>{{  __('title.select') }}</option>
                      <option>Admin/IT</option>
                      <option>Quản lý nhập hàng</option>
                      <option>Quản lý xuất hàng</option>
                    </select>
                </div>
            </div>
        </div>

    </div>

    <div class="display-child-page">

        {{-- SDT --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-6 col-md-4">
                <label>SĐT</label>
                </div>
                <div class="col-md-8">
                <input type="text" class="form-control">
                </div>
            </div>
        </div>

        {{-- Mã người dùng --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-6 col-md-4">
                <label class="col-form-label">Mã người dùng</label>
                </div>
                <div class="col-md-8">
                <input type="text" class="form-control">
                </div>
            </div>
        </div>

    </div>

    <div class="display-but">

        <div style="margin-top: 50px" class="display-child-page">
            <button style="width: 180px" class="btn btn-outline-success" type="submit">Hủy</button>
        </div>

        <div style="margin-top: 50px" class="display-child-page">
            <button style="width: 180px" class="btn btn-outline-success" type="submit">Lưu</button>
        </div>

    </div>

@endsection
