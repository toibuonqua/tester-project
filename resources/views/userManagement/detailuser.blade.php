@extends('layout.master')
@section('title', 'Detail User')

{{ $unknown = "Unknown" }}


@section('content')

    <div>
        <nav>
            <div class="container-fluid">
            <span class="navbar-brand mb-0 h1"><p class="text-child-page" >{{ $title }}</p></span>
            </div>
        </nav>
    </div>

    <div class="display-child-page">

        {{-- Field Họ và tên --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-auto">
                <label>Họ và tên:</label>
                </div>
                <div class="col-auto">
                <label>{{ $unknown }}</label>
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
                <label>{{ $unknown }}</label>
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
                <label>{{ $unknown }}</label>
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
                <label>{{ $unknown }}</label>
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
                <label>{{ $unknown }}</label>
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
                <label>{{ $unknown }}</label>
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
                        <input type="checkbox" checked>
                        <span class="slider round"></span>
                      </label>
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
