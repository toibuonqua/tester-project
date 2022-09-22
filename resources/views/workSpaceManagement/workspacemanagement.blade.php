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
                <input class="form-control me-2" name="query" type="text" placeholder="{{ __('title.search') }}">
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
    ])

    @if ($workareas->isEmpty())
    <br>
    <h4 style="font-family: 'Nunito', sans-serif; text-align: center; margin-top: 10%">{{ __('title.unvalued_key') }}</h4>
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
