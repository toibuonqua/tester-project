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
            <a href="{{ route('user.add') }}"><button type="button" class="btn btn-success">Thêm mới</button></a>
          </div>

          <div class="fix-space">
            <button type="button" class="btn btn-success">Xuất file</button>
          </div>
        </div>
    </nav>

    {{-- show table accounts --}}
    @include('common.block.table', [
        'fields' => [
            'fullname' => 'username',
            'email' => 'email',
            'department' => 'department_id',
            'role' => 'role_id',
            'work-area' => 'workarea_id',
            'time_create' => 'created_at',
            'modify' => 'pattern.modified',
            'view' => 'pattern.view',
            'status' => 'pattern.status',
            'db-password' => 'pattern.reset',
        ],
        'items' => $accounts,
        'edit_route' => 'user.modify',
        'view_route' => 'user.detail',
        'status_route' => 'homepage',
        'reset_route' => 'homepage',
    ]);

</div>

@endsection
