@extends('layout.master')
@section('title', 'User Management')
@section('nav-name-title', __('title.user-management'))

@section('content')

{{-- flasher message --}}
@if (session()->has('success'))
    <div class="fixed bg-green-600 text-white py-2 px-4 rounded-xl bottom-3 right-3 text-sm">
        <p>{{ session()->get('success') }}</p>
    </div>
@endif

{{-- Thanh search và các button --}}
<div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div style="width: 100%" class="display-search">

          <div class="row">
            <form class="d-flex" method="get" action="{{ route('user.search') }}">
            @csrf
                <input style="width: 100%" class="form-control me-2" name="query" type="text" placeholder="{{ __('title.search') }}">
                <button style="width: 180px" class="btn btn-outline-success" type="submit">{{ __('title.search') }}</button>
            </form>
          </div>

          <div class="fix-space">
                <a href="{{ route('user.add') }}"><button type="button" class="btn btn-success">{{ __('title.add-new') }}</button></a>
          </div>

          <form method="get" action="{{ route('user.export') }}">
          @csrf
            <div class="fix-space">
                <button type="submit" class="btn btn-success">{{ __('title.export-excel') }}</button>
            </div>
          </form>

        </div>
    </nav>

    {{-- show table accounts --}}
    @include('common.block.table', [
        'fields' => [
            'fullname' => 'username',
            'email' => 'email',
            'department' => 'department_name',
            'role' => 'role_name',
            'work-area' => 'workarea_code',
            'time_create' => 'created_at',
            'time_update' => 'updated_at',
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
    ])

    @if ($accounts->isEmpty())
        <br>
        <h4 style="font-family: 'Nunito', sans-serif; text-align: center; margin-top: 10%">{{ __('title.unvalued_key') }}</h4>
        <br>
    @endif

    <div class="display-pagi">
        {{ $accounts->links() }}
    </div>



</div>

@endsection
