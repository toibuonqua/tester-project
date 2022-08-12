@extends('layout.master')
@section('title', 'Modify User')

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
                      <option>Chức danh 1</option>
                      <option>Chức danh 2</option>
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

    <div class="display-child-page">

        <div style="justify-content: flex-start" class="config-posi">
            <div class="row">
                <div class="col-auto">
                <label>Trạng thái</label>
                </div>
                <div class="col-auto">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                        Hoạt động
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                        <label class="form-check-label" for="flexRadioDefault2">
                        Không hoạt động
                        </label>
                    </div>
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
