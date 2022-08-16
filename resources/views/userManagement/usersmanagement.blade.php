@extends('layout.master')
@section('title', 'User Management')
@section('nav-name-title', __('title.user-management'))

@section('content')
{{-- Thanh search và các button --}}
<div>

    <nav class="navbar navbar-light bg-light">
        <div class="display">
          <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Tìm kiếm">
            <button style="width: 180px" class="btn btn-outline-success" type="submit">Tìm kiếm</button>
          </form>

          <div class="fix-space">
            <a href="{{ route('adduser') }}"><button type="button" class="btn btn-success">Thêm mới</button></a>
          </div>

          <div class="fix-space">
            <button type="button" class="btn btn-success">Xuất file</button>
          </div>
        </div>
    </nav>

    @include('common.block.table1')

</div>

@endsection
