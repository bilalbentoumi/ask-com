@extends('admin/layouts.app')

@section('title', __('admin.reports'))

@section('content')
    <div class="toolbar">
        <div class="title">{{ __('admin.reports') }}</div>
        <div class="search">
            <i data-feather="search"></i>
            <input type="text" id="tableSearch" placeholder="{{ __('admin.search') }}">
        </div>
    </div>
    <table>
        <thead>
        <tr>
            <th>{{ __('admin.id') }}</th>
            <th>{{ __('admin.report_type') }}</th>
            <th>{{ __('admin.reports_count') }}</th>
            <th>{{ __('admin.control') }}</th>
        </tr>
        </thead>
        <tbody>
        @forelse($reports as $report)
            <tr>
                <td class="center">{{ $report->id }}</td>
                <td>{{ __('admin.' . $report->type . '_report') }}</td>
                <td>
                    @if($report->type == 'answer')
                        {{ $report->answer->reports->count() }}
                    @elseif($report->type == 'question')
                        {{ $report->question->reports->count() }}
                    @elseif($report->type == 'comment')
                        {{ $report->comment->reports->count() }}
                    @endif
                </td>
                <td>
                    <a data-tippy-content="{{ __('admin.view') }}" class="action-btn" href="{{ route('reports.show', $report->id) }}"><i data-feather="eye"></i></a>
                    <form action="{{ route('reports.deleteReport', $report->id) }}" method="POST"
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
@endsection