@extends('layout.admin-dashboard')

@section('static')
    @parent
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection


@section('page')
    @if ($message ?? '')
        <div class="alert alert-{{ $messageType ?? 'info' }}" role="alert">
            {{ $message ?? '' }}
        </div>
    @endif

    <h3 class="title">{{ __('title.user-management') }}</h3>

    
    <div class="table-content container">

        <div class="row mb-3">
            {!! Form::open(['url' => route('admin-dashboard'), 'class' => 'container white-box', 'enctype' => 'multipart/form-data']) !!}
    
            @include('common.block.flash-message')
    
            @include('common.block.input-text', [
                'name' => 'username',
                'value' => $username ?? null
            ])
            @include('common.block.input-text', [
                'name' => 'email',
                'value' => $email ?? null
            ])

            @include('common.block.checkbox-group', [
                'label' => 'status',
                'options' => [ 'active', 'deactive', 'pending' ],
                'checked' => $status ?? [ 'active', 'deactive', 'pending' ],
                'transform' => [
                    'active' => __('title.active'),
                    'deactive' => __('title.deactive'),
                    'pending' => __('title.pending'),
                ],
                'inputClass' => 'col-sm-2 btn-group',
                'name' => 'status'
            ])
     
            @include('common.block.between-date', [
                'name' => 'take-created-time',
                'from' => $from,
                'to' => $to
            ])
            
            @include('common.block.select', [
                'name' => 'class',
                'options' => $classes ?? [],
                'valueField' => 'id',
                'displayField' => 'name',
                'select' => $class_id ?? null
            ])
    
    
            <div class="row mb-3">
                <div class="col-sm-10 offset-sm-2">
                    <div class="form-check">
                        {{ Form::Submit(__('title.search'), ['class' => 'btn btn-primary']) }}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>

        <div class="container white-box">
            <div class="row mb-3">
                <div class="col-sm-12">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link {{ ($type ?? '') == 'user' ? 'btn btn-primary' : '' }}"
                                aria-current="page" href="{{ route('admin-dashboard', ['type' => 'user']) }}">{{ __('title.student') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ ($type ?? '') == 'class_assistant' ? 'btn btn-primary' : '' }}"
                                aria-current="page" href="{{ route('admin-dashboard', ['type' => 'class_assistant']) }}">{{ __('title.class-assistant') }}</a>
                        </li>
                    </ul>
    
                    <div class="tab-content">
                        @yield('tab-content')
                    </div>   
                </div>
            </div>
        </div>
    </div>


@endsection
