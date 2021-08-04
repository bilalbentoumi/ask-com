@extends('admin/layouts.app')

@section('title', __('admin.report_details'))

@section('content')
    <div class="toolbar">
        <div class="ptitle">{{ __('admin.report_details') }}</div>
        <div class="fill"></div>
    </div>
    <div class="panel">
        <div class="info">
            <label>{{ __('admin.reporter') }}</label>
            <div>
                @if($report->type == 'answer')
                    @foreach($report->answer->reports as $key => $report)
                        <a href="{{ route('users.show', $report->user->id) }}">{{ $report->user->fullname }}</a>
                        @if($key != $report->answer->reports->count() - 1), @endif
                    @endforeach
                @elseif($report->type == 'question')
                    @foreach($report->question->reports as $key => $report)
                        <a href="{{ route('users.show', $report->user->id) }}">{{ $report->user->fullname }}</a>
                        @if($key < $report->question->reports->count() - 1), @endif
                    @endforeach
                @elseif($report->type == 'comment')
                    @foreach($report->comment->reports as $key => $report)
                        <a href="{{ route('users.show', $report->user->id) }}">{{ $report->user->fullname }}</a>
                        @if($key != $report->comment->reports->count() - 1), @endif
                    @endforeach
                @endif
            </div>
        </div>
        @if($report->type == 'question')
            <div class="info">
                <label>{{ __('admin.title') }}</label>
                <div>{{ $report->question->title }}</div>
            </div>
        @endif
        <div class="info">
            <label>{{ __('admin.content') }}</label>
            <div>
                @if($report->type == 'answer')
                    {!! $report->answer->content !!}
                @elseif($report->type == 'question')
                    {!! $report->question->content !!}
                @elseif($report->type == 'comment')
                    {!! $report->comment->content !!}
                @endif
            </div>
        </div>
            <div class="info">
            <label>{{ __('admin.author') }}</label>
            <div>
                @if($report->type == 'answer')
                    {!! $report->answer->user->fullname !!}
                @elseif($report->type == 'question')
                    {!! $report->question->user->fullname !!}
                @elseif($report->type == 'comment')
                    {!! $report->comment->user->fullname !!}
                @endif
            </div>
        </div>
        <div class="info">
            <label>{{ __('admin.created_at') }}</label>
            <div>
                @if($report->type == 'answer')
                    {!! $report->answer->created_at !!}
                @elseif($report->type == 'question')
                    {!! $report->question->created_at !!}
                @elseif($report->type == 'comment')
                    {!! $report->comment->created_at !!}
                @endif
            </div>
        </div>
        <div class="footer">
            <a href="{{ route('reports.edit', $report->id) }}" name="edit" class="btn btn-primary">{{ __('admin.edit') }}</a>
            <a href="{{ route('reports.delete', $report->id) }}" name="delete" class="btn btn-primary">{{ __('admin.delete') }}</a>
            <a href="{{ route('reports.delete', [$report, true]) }}" name="delete_and_block_user" class="btn btn-primary">{{ __('admin.delete_and_block_user') }}</a>
        </div>
    </div>
@endsection