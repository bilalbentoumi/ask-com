@extends('user.layouts.settings')

@section('title', Settings::get('sitename') . ' - ' . __('lang.myquestions'))

@section('settingcontent')
    <div class="panel">
        <div class="panel-header">
            <h2>{{ __('lang.myquestions') }}</h2>
        </div>
        <div class="panel-body row-flex">
            <table>
                <thead>
                <tr>
                    <th>{{ __('admin.id') }}</th>
                    <th>{{ __('admin.status') }}</th>
                    <th>{{ __('admin.title') }}</th>
                    <th>{{ __('admin.category') }}</th>
                    <th>{{ __('admin.answers') }}</th>
                    <th>{{ __('admin.control') }}</th>
                </tr>
                </thead>
                <tbody>
                @forelse($questions as $question)
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
                        <td><a href="{{ route('questions.category', $question->category->slug) }}">{{ $question->category->name }}</a></td>
                        <td>{{ $question->answers->count() }}</td>
                        <td>
                            <a data-tippy-content="{{ __('admin.view') }}" class="action-btn" href="{{ $question->url }}"><i data-feather="eye"></i></a>
                            <a data-tippy-content="{{ __('admin.edit') }}" class="action-btn" href="{{ route('user.questions.edit', $question->id) }}"><i data-feather="edit"></i></a>
                            <form action="{{ route('user.questions.destroy', $question->id) }}" method="POST"
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
                        <td colspan="100%" style="text-align: center; padding: 20px">{{ __('admin.no_data') }}</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <style>
        .footer {
            margin-top: 170px;
        }
    </style>
@endsection