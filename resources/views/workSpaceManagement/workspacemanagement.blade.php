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
                <input class="form-control me-2" name="query" type="text" placeholder="Tìm kiếm">
                <button style="width: 180px" class="btn btn-outline-success" type="submit">Tìm kiếm</button>
            </form>
          </div>

          <div class="fix-space">
                <a href="{{ route('worksm.add') }}"><button type="button" class="btn btn-success">Thêm mới</button></a>
          </div>

          <div class="fix-space">
                <button type="button" class="btn btn-success">Xuất file</button>
          </div>


        </div>
    </nav>

    @if ($workareas->isEmpty())

        <h4 style="font-family: 'Nunito', sans-serif">{{ __('title.unvalued_key') }}</h4>

    @else

        {{-- show table workareas --}}
        @include('common.block.table', [
            'fields' => [
                'code-work-area' => 'work_areas_code',
                'name-work-area' => 'name',
                'time_create' => 'created_at',
                'modify' => 'pattern.modified',
                'view' => 'pattern.view',
                'delete' => 'pattern.delete',
            ],
            'items' => $workareas,
            'view_route' => 'worksm.detail',
            'edit_route' => 'worksm.modify',
            'delete_route' => 'worksm.delete',
            $notice_delete = __('title.notice-delete-work-area')
        ]);
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

    @endif

</div>

@endsection