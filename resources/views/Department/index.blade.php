@extends('layout.master')
@section('title', 'Department Management')
@section('nav-name-title', __('title.department-management'))

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
            <form class="d-flex" method="get" action="{{ route('department.search') }}">
            @csrf
            @method('GET')
                <input style="width: 380px" class="form-control me-3" name="query" type="text" value="{{ session('query') }}" placeholder="Nhập từ khóa cần tìm kiếm">
                <button style="width: 180px" class="btn btn-outline-success" type="submit">{{ __('title.search') }}</button>
            </form>
          </div>

          <div class="fix-space">
                <a href="{{ route('department.add') }}"><button type="button" class="btn btn-success">{{ __('title.add-new') }}</button></a>
          </div>

          <form method="get" action="{{ route('department.export') }}">
          @csrf
          @method('GET')
            <div class="fix-space">
                <button type="submit" class="btn btn-success">{{ __('title.export-excel') }}</button>
            </div>
          </form>

        </div>
    </nav>

    {{-- show table accounts --}}
    @include('common.block.table', [
        'fields' => [
            'department' => 'name',
            'time_create' => 'created_at',
            'time_update' => 'updated_at',
            'modify' => 'pattern.modified',
            'view' => 'pattern.view',
            'delete' => 'pattern.delete',
        ],
        'items' => $departments,
        'view_route' => 'department.detail',
        'edit_route' => 'department.modify',
        'delete_route' => 'department.delete',
        $notice_delete = __('title.notice-delete-department')
    ])

    @if ($departments->isEmpty())
        <br>
        <h4 style="font-family: 'Nunito', sans-serif; text-align: center; margin-top: 10%">{{ __('title.cant-find-result') }}</h4>
        <br>
    @endif

    <div class="display-pagi">
        {{ $departments->links() }}
    </div>

</div>

@endsection

