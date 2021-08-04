@extends('user.layouts.app')

@section('title', Settings::get('sitename'))

@push('js')
    <script>
        function loadquestions(mode) {
            if (mode == 'newest')  {
                $.get('{{ route('questions.newest') }}', function (data){
                    $('.questions').html(data);
                });
            } else if (mode == 'interested') {
                $.get('{{ route('questions.interested') }}', function (data){
                    $('.questions').html(data);
                });
            }
        }

        $('.filter .item').click(function () {
            if (!$(this).hasClass('active')) {
                $(this).addClass('active').siblings().removeClass('active');
                loadquestions($(this).attr('data'));
            }
        });

        $('.filter .item.default').click();
    </script>
@endpush

@section('content')
    <div class="body-wrapper">
        <div class="main row">
            <div class="main-grid">
                <div class="primary p-10-m">
                    <span class="page-title">
                        <i data-feather="zap"></i>
                        <h2>{{ __('lang.latest_questions') }}</h2>
                    </span>
                    <div class="filter">
                        @if(Auth::user() && Helper::interestedQuestions()->count() != 0)
                            <div class="item default" data="interested">{{ __('lang.by_interests') }}</div>
                        @endif
                        <div class="item @if(!Auth::user() || Helper::interestedQuestions()->count() == 0) default @endif" data="newest">{{ __('lang.all') }}</div>
                    </div>
                    <div class="questions"></div>
                </div>
                @include('user.components.sidebar')
            </div>
        </div>
    </div>
@endsection