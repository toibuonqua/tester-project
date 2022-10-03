@extends('layout.master')
@section('title', 'Work Space Management')
@section('nav-name-title', __('title.work-management'))

@section('content')

{{-- Thanh search và các button --}}
<div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div style="width: 100%" class="display-search">

          <div class="row">
            <form class="d-flex" method="get" action="{{ route('worksm.search') }}">
            @csrf
                <input style="width: 380px" class="form-control me-3" name="query" type="text" value="{{ session('query') }}" placeholder="Nhập từ khóa cần tìm kiếm">
                <button style="width: 180px" class="btn btn-outline-success" type="submit">{{ __('title.search') }}</button>
            </form>
          </div>

          <div class="fix-space">
                <a href="{{ route('worksm.add') }}"><button type="button" class="btn btn-success">{{ __('title.add-new') }}</button></a>
          </div>

          <form method="get" action="{{ route('worksm.export') }}">
            @csrf
            <div class="fix-space">
                    <button type="submit" class="btn btn-success">{{ __('title.export-excel') }}</button>
            </div>
          </form>

        </div>
    </nav>

    {{-- show table workareas --}}
    @include('common.block.table', [
        'fields' => [
            'code-work-area' => 'work_areas_code',
            'name-work-area' => 'name',
            'creater' => 'pattern.link',
            'time_create' => 'created_at',
            'modify' => 'pattern.modified',
            'view' => 'pattern.view',
            'delete' => 'pattern.delete',
        ],
        'items' => $workareas,
        'view_route' => 'worksm.detail',
        'edit_route' => 'worksm.modify',
        'delete_route' => 'worksm.delete',
        'link_route' => 'info.user',
        'text_link' => 'creater',
        'id_link' => 'createrId',
        $notice_delete = __('title.notice-delete-work-area')
    ])

    @if ($workareas->isEmpty())
    <br>
    <h4 style="font-family: 'Nunito', sans-serif; text-align: center; margin-top: 10%">{{ __('title.cant-find-result') }}</h4>
    <br>
    @endif

    <div class="display-pagi">
        {{ $workareas->links() }}
    </div>

    @if ($exception)

        @include('common.singleMessage', [
            $message = $exception,
            $homepage = 'worksm.homepage',
            $text = __('title.back')
        ])

    @endif


</div>

@endsection
