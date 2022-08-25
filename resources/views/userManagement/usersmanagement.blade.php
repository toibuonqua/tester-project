@extends('layout.master')
@section('title', 'User Management')
@section('nav-name-title', __('title.user-management'))

@section('content')
{{-- Thanh search và các button --}}
<div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="display-search">

          <div class="row">
            <form class="d-flex" method="get" action="{{ route('user.search') }}">
            @csrf
                <input class="form-control me-2" name="query" type="text" placeholder="Tìm kiếm">
                <button style="width: 180px" class="btn btn-outline-success" type="submit">Tìm kiếm</button>
            </form>
          </div>

          <div class="fix-space">
                <a href="{{ route('user.add') }}"><button type="button" class="btn btn-success">Thêm mới</button></a>
          </div>

          <div class="fix-space">
                <button type="button" class="btn btn-success">Xuất file</button>
          </div>


        </div>
    </nav>

    @if ($accounts->isEmpty())

        <h4 style="font-family: 'Nunito', sans-serif">{{ __('title.unvalued_key') }}</h4>

    @else

        {{-- show table accounts --}}
        @include('common.block.table', [
            'fields' => [
                'fullname' => 'username',
                'email' => 'email',
                'department' => 'department_name',
                'role' => 'role_name',
                'work-area' => 'workarea_code',
                'status' => 'status',
                'time_create' => 'created_at',
                'modify' => 'pattern.modified',
                'view' => 'pattern.view',
                'action' => 'pattern.status',
                'db-password' => 'pattern.reset',
            ],
            'items' => $accounts,
            'edit_route' => 'user.modify',
            'view_route' => 'user.detail',
            'status_route' => 'user.active',
            'reset_route' => 'user.resetpw',
            $notice_active = __('title.notice-change-active'),
            $notice_reset_pw = __('title.notice-reset-password'),
        ]);
        <div class="display-pagi">
            {{ $accounts->links() }}
        </div>

    @endif

</div>

@endsection
