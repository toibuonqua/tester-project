@extends('layout.master')
@section('title', 'User Management')
@section('nav-name-title', __('title.account-info'))

@section('content')

<br><br>

<div class="text-des" style="margin-left: 5%; display:flex">

    <div class="container">

        {{-- username --}}
        <div class="row">
            <div class="col-4"><label>{{ __('title.fullname') }} :</label></div>
            <div class="col-auto"><label>{{ $account->username }}</label></div>
        </div>

        <br><br>

        {{-- email --}}
        <div class="row">
            <div class="col-4"><label>{{ __('title.email') }} :</label></div>
            <div class="col-auto"><label>{{ $account->email }}</label></div>
        </div>

        <br><br>

        {{-- Phone number --}}
        <div class="row">
            <div class="col-4"><label>{{ __('title.phone-number') }} :</label></div>
            <div class="col-auto"><label>{{ $account->phone_number }}</label></div>
        </div>

    </div>

    <div class="container">

        {{-- Department --}}
        <div class="row">
            <div class="col-4"><label>{{ __('title.department') }} :</label></div>
            <div class="col-auto"><label>{{ $account->department->name }}</label></div>
        </div>

        <br><br>

        {{-- Role --}}
        <div class="row">
            <div class="col-4"><label>{{ __('title.role') }} :</label></div>
            <div class="col-auto"><label>{{ $account->role->name }}</label></div>
        </div>

        <br><br>

        {{-- Code user --}}
        <div class="row">
            <div class="col-4"><label>{{ __('title.code-user') }} :</label></div>
            <div class="col-auto"><label>{{ $account->code_user }}</label></div>
        </div>

    </div>

</div>

@endsection
