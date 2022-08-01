@extends('layout.admin-dashboard')

@section('static')
    @parent
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
@endsection


@section('page')


    <h3 class="title">{{ __('title.system-config-management') }}</h3>

    <div class="container white-box">
        <div class="row mb-3">
            <div class="col-sm-12">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() === 'activate-user-config' ? 'btn btn-primary' : '' }}"
                            aria-current="page" href="{{ route('activate-user-config') }}">{{ __('title.activate') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() === 'db-config' ? 'btn btn-primary' : '' }}"
                            href="{{ route('db-config') }}">{{ __('title.db-config-management') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() === 'limit-user-config' ? 'btn btn-primary' : '' }}"
                            href="{{ route('limit-user-config') }}">{{ __('title.limit-user') }}</a>
                    </li>
                    
                </ul>

                <div class="mt-3">
                    @include('common.block.flash-message')
                </div>

                <div class="tab-content">
                @section('system-config-content-page')
                @show
            </div>
        </div>
    </div>

</div>

@endsection
