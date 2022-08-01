@extends('layout.admin-dashboard')

@section('static')
    @parent
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
@endsection


@section('page')
    @if ($message ?? '')
        <div class="alert alert-{{ $messageType ?? 'info' }}" role="alert">
            {{ $message ?? '' }}
        </div>
    @endif

    <h3 class="title">{{ __('title.course-content-management') }}</h3>

    <div class="container white-box">
        <div class="row mb-3">
            <div class="col-sm-12">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() === 'course' ? 'btn btn-primary' : '' }}"
                            aria-current="page" href="{{ route('course') }}">{{ __('title.course') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() === 'classroom' ? 'btn btn-primary' : '' }}"
                            aria-current="page" href="{{ route('classroom') }}">{{ __('title.class') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() === 'exam' ? 'btn btn-primary' : '' }}"
                            href="{{ route('exam') }}">{{ __('title.exam') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() === 'questions' ? 'btn btn-primary' : '' }}"
                            href="{{ route('questions') }}">{{ __('title.question-set') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() === 'exam-has-result' ? 'btn btn-primary' : '' }}"
                            href="{{ route('exam-has-result') }}">{{ __('title.exam-result') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() === 'tags' ? 'btn btn-primary' : '' }}"
                            href="{{ route('tags') }}">{{ __('title.tags') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() === 'categories' ? 'btn btn-primary' : '' }}"
                           href="{{ route('categories') }}">{{ __('title.category') }}</a>
                    </li>
                </ul>


                <div class="tab-content">
                @section('course-content-page')
                @show
            </div>
        </div>
    </div>

</div>

@endsection
