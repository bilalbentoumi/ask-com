@extends('admin/layouts.app')

@section('title', __('admin.category_details') . ': ' . $category->name)

@section('content')
    <div class="toolbar">
        <div class="ptitle">{{ __('admin.category_details') }}</div>
        <div class="fill"></div>
        <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
              style="display: inline"
              onsubmit="return confirm('{{ __('admin.are_you_sure') }}');">
            <input type="hidden" name="_method" value="DELETE">
            {{ csrf_field() }}
            <button data-tippy-content="{{ __('admin.delete') }}" class="btn btn-secondary icon"><i data-feather="trash-2"></i></button>
        </form>
        <a data-tippy-content="{{ __('admin.edit') }}" class="btn btn-primary icon" href="{{ route('categories.edit', $category->id) }}"><i data-feather="edit"></i></a>
    </div>
    <div class="panel">
        <div class="info">
            <label>{{ __('admin.id') }}</label>
            <div>{{ $category->id }}</div>
        </div>
        <div class="info">
            <label>{{ __('admin.name') }}</label>
            <div>{{ $category->name }}</div>
        </div>
        <div class="info">
            <label>{{ __('admin.slug') }}</label>
            <div>{{ $category->slug }}</div>
        </div>
        <div class="info">
            <label>{{ __('admin.questions') }}</label>
            <div>{{ $category->questions->count() }}</div>
        </div>
        <div class="info">
            <label>{{ __('admin.icon') }}</label>
            <div>
                <div class="cat-icon" style="background-color: {{ $category->color }}"><img src="{{ $category->image }}"></div>
            </div>
        </div>
        <div class="info">
            <label>{{ __('admin.created_at') }}</label>
            <div>{{ $category->created_at }}</div>
        </div>
    </div>
    <div class="toolbar">
        <div class="title">{{ __('admin.category_questions') }}</div>
        <div class="search">
            <i data-feather="search"></i>
            <input type="text" id="tableSearch" placeholder="{{ __('admin.search') }}">
        </div>
    </div>
    <table>
        <thead>
        <tr>
            <th>{{ __('admin.id') }}</th>
            <th>{{ __('admin.solved') }}</th>
            <th>{{ __('admin.title') }}</th>
            <th>{{ __('admin.author') }}</th>
            <th>{{ __('admin.answers') }}</th>
            <th>{{ __('admin.control') }}</th>
        </tr>
        </thead>
        <tbody>
        @forelse($category->questions as $question)
            <tr>
                <td class="center">{{ $question->id }}</td>
                <td class="center">
                    @if($question->hasBestAnswer())
                        <div class="status solved"><i data-feather="check-circle"></i>{{ __('admin.solved') }}</div>
                    @else
                        <div class="status unsolved"><i data-feather="help-circle"></i>{{ __('admin.unsolved') }}</div>
                    @endif
                </td>
                <td><span data-tippy-content="{{ $question->title }}">{{ mb_substr($question->title, 0, 40) }} ...</span></td>
                <td><a href="{{ route('users.show', $question->user->id) }}">{{ $question->user->fullname }}</a></td>
                <td>{{ $question->answers->count() }}</td>
                <td>
                    <a data-tippy-content="{{ __('admin.view') }}" class="action-btn" href="{{ route('questions.show', $question->id) }}"><i data-feather="eye"></i></a>
                    <a data-tippy-content="{{ __('admin.edit') }}" class="action-btn" href="{{ route('questions.edit', $question->id) }}"><i data-feather="edit"></i></a>
                    <form action="{{ route('questions.destroy', $question->id) }}" method="POST"
                          style="display: inline"
                          onsubmit="return confirm('{{ __('admin.are_you_sure') }}');">
                        <input type="hidden" name="_method" value="DELETE">
                        {{ csrf_field() }}
                        <button data-tippy-content="{{ __('admin.delete') }}" class="action-btn"><i data-feather="trash-2"></i></button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="100%" style="text-align: center">NO DATA</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection