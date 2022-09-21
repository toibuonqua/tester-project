@extends('layout.master')
@section('title', __('title.detail-work-area'))
@section('nav-name-title', __('title.work-management'))
@section('content')

    @include('common.block.title1')

    <div class="display-child-page">

        {{-- Mã KVLV --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-auto">
                <label>{{ __('title.code-work-area') }} :</label>
                </div>
                <div class="col-auto">
                <label>{{ $workarea->work_areas_code }}</label>
                </div>
            </div>
        </div>

    </div>

    <div class="display-child-page">

        {{-- Tên KVLV --}}
        <div class="config-posi">
            <div class="row">
                <div class="col-auto">
                <label>{{ __('title.name-work-area') }} :</label>
                </div>
                <div class="col-auto">
                <label>{{ $workarea->name }}</label>
                </div>
            </div>
        </div>

    </div>

    <div class="display-but">

        <div style="margin-top: 50px; margin-left: 50px">
            <a href="{{ route('worksm.homepage') }}"><button style="width: 180px" class="btn btn-outline-success" type=submit>{{ __('title.back') }}</button></a>
        </div>

        <div style="margin-top: 50px; margin-left: 50px">
            <a href="{{ route('worksm.modify', ['id' => $workarea->id]) }}"><button style="width: 180px" class="btn btn-outline-success" type="submit">{{ __('title.modify') }}</button></a>
        </div>

    </div>

@endsection
