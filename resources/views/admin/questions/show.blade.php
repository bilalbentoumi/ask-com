@extends('admin/layouts.app')

@section('title', __('admin.question_details') . ': ' . $question->name)

@section('content')
    <div class="toolbar">
        <div class="ptitle">{{ __('admin.question_details') }}</div>
        <div class="fill"></div>
        <form action="{{ route('questions.destroy', $question->id) }}" method="POST"
              style="display: inline"
              onsubmit="return confirm('{{ __('admin.question_details') }}');">
            <input type="hidden" name="_method" value="DELETE">
            {{ csrf_field() }}
            <button data-tippy-content="Delete" class="btn btn-secondary icon"><i data-feather="trash-2"></i></button>
        </form>
        <a data-tippy-content="Edit" class="btn btn-primary icon" href="{{ route('questions.edit', $question->id) }}"><i data-feather="edit"></i></a>
    </div>
    <div class="panel">
        <div class="info">
            <label>{{ __('admin.id') }}</label>
            <div>{{ $question->id }}</div>
        </div>
        <div class="info">
            <label>{{ __('admin.title') }}</label>
            <div>{{ $question->title }}</div>
        </div>
        <div class="info">
            <label>{{ __('admin.author') }}</label>
            <div><a href="{{ route('users.show', $question->user->id) }}">{{ $question->user->fullname }}</a></div>
        </div>
        <div class="info">
            <label>{{ __('admin.category') }}</label>
            <div><a href="{{ route('categories.show', $question->category->id) }}">{{ $question->category->name }}</a></div>
        </div>
        <div class="info">
            <label>{{ __('admin.status') }}</label>
            <div>
                @if($question->hasBestAnswer())
                    <span class="status active">{{ __('admin.solved') }}</span>
                @else
                    <span class="status inactive">{{ __('admin.unsolved') }}</span>
                @endif
            </div>
        </div>
        <div class="info">
            <label>{{ __('admin.tags') }}</label>
            <div>{{ $question->tags_string() == '' ? 'no tags' : $question->tags_string() }}</div>
        </div>
        <div class="info">
            <label>{{ __('admin.answers') }}</label>
            <div>{{ $question->answers->count() }}</div>
        </div>
        <div class="info">
            <label>{{ __('admin.created_at') }}</label>
            <div>{{ $question->created_at }}</div>
        </div>
    </div>
@endsection