@extends('layout.master')
@section('title', __('title.add-work-area'))
@section('nav-name-title', __('title.work-management'))
@section('content')

    @include('common.block.title1')

<form method="post" action="{{ route('worksm.store') }}">

    @csrf

    {{-- @if ($e != isEmpty())
        {{ $e -> getMessage() }}
    @endif --}}

    <div class="display-child-page">

        {{-- Mã KVLV --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-6 col-md-4">
                <label>{{ __('title.code-work-area') }}:</label>
                </div>
                <div class="col-md-8">
                <input type="text" name="work_areas_code" class="form-control">
                </div>
            </div>
        </div>
    </div>

    <div class="display-child-page">

        {{-- Tên KVLV --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-6 col-md-4">
                <label>{{ __('title.name-work-area') }}:</label>
                </div>
                <div class="col-md-8">
                <input type="text" name="name" class="form-control">
                </div>
            </div>
        </div>
    </div>


    <div class="display-but">

        <div style="margin-top: 50px">
            <a href="{{ route('worksm.homepage') }}" style="width: 180px" class="btn btn-outline-success">Hủy</a>
        </div>

        <div style="margin-top: 50px">
            <button style="width: 180px" class="btn btn-outline-success" onclick="return confirm('{{ __('title.notice-add-work-area') }}')" type="submit">Lưu</button>
        </div>

    </div>

</form>

@include('common.block.flash-message')

@endsection