@extends('admin.layouts.app')

@section('title', __('admin.dashboard'))

@section('content')
    <div class="stats">
        <div class="card">
            <div class="card-header">
                <div class="title">{{ __('admin.total_users') }}</div>
            </div>
            <div class="card-body">
                <span class="count">{{ Stats::total_users() }}</span>
            </div>
            <div class="card-footer">
                <span class="increase"><i data-feather="trending-up"></i> 3.41% Increase</span>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="title">{{ __('admin.total_questions') }}</div>
            </div>
            <div class="card-body">
                <span class="count">{{ Stats::total_questions() }}</span>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="title">{{ __('admin.total_answers') }}</div>
            </div>
            <div class="card-body">
                <span class="count">{{ Stats::total_answers() }}</span>
            </div>
        </div>
    </div>
    <div class="stats overview">
        <div class="card latest-users">
            <div class="card-header">
                <div class="title">{{ __('admin.latest_users') }}</div>
            </div>
            <div class="card-body">
                @foreach(Helper::latest_users() as $user)
                    <div class="user">
                        <img src="{{ $user->picurl }}" class="user-pic">
                        <a href="{{ route('users.show', $user->id) }}" class="name">{{ $user->fullname }}</a>
                        <div class="control"></div>
                    </div>
                @endforeach
            </div>
            <div class="card-footer"></div>
        </div>
        <div class="card latest-questions">
            <div class="card-header">
                <div class="title">{{ __('admin.latest_questions') }}</div>
            </div>
            <div class="card-body">
                @foreach(Helper::latest_questions() as $question)
                    <div class="question">
                        <a href="{{ route('users.show', $question->user->id) }}" data-tippy-content="{{ $question->user->fullname }}"><img src="{{ $question->user->picurl }}" class="user-pic"></a>
                        <a href="{{ route('questions.show', $question->id) }}" class="title">{{ $question->title }}</a>
                        <div class="control"></div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection