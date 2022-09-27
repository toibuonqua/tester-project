@extends('layout.master')
@section('title', 'Add department')
@section('nav-name-title', __('title.department-management'))

@section('content')

@include('common.block.title1', [$title = __('title.detail-department')])

<div class="container">

    {{-- Department name --}}
    <div class="row">
        <div class="col-2"><label>{{ __('title.department') }} :</label></div>
        <div class="col-auto"><label>{{ $department->name }}</label></div>
    </div>

    <br>

    {{-- Employee in department --}}
    <div class="row">
        <div class="col-2"><label>Nhân sự trong phòng ban:</label></div>
        <div class="col-auto"><label>{{ $department->employee }} nhân sự</label></div>
    </div>

</div>

<br><br>

<div class="display-but">

    <div style="margin-top: 50px">
        <a href="{{ route('department.homepage') }}" style="width: 180px" class="btn btn-outline-success" type="button">{{ __('title.cancel') }}</a>
    </div>

    <div style="margin-top: 50px">
        <a href="{{ route('department.modify', ['id' => $department->id]) }}" style="width: 180px" class="btn btn-outline-success" type="button">{{ __('title.modify') }}</a>
    </div>

</div>


@endsection
