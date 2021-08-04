@extends('admin/layouts.app')

@section('title', __('admin.questions'))

@push('scripts')
    <script src="{{ @asset('js/chart.2.6.0.min.js') }}"></script>
@endpush

@push('js')
    <script>
        $(document).ready(function () {
            new Chart($('#new_questions'), {
                type: 'line',
                data: {
                    labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
                    datasets: [{
                        data: [14, 67, 45, 68, 92, 23, 77, 3, 34, 87, 10, 92],
                        backgroundColor: "#f5fafd",
                        borderColor: "#79b5e8",
                        pointBackgroundColor: "#52a2e1"
                    }]
                },
                options: {
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display:false,
                                drawBorder: false,
                            },
                            ticks: {
                                display: false
                            }
                        }],
                        yAxes: [{
                            gridLines: {
                                display:false,
                                drawBorder: false,
                            },
                            ticks: {
                                display: false
                            }
                        }]
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.yLabel;
                            }
                        }
                    },
                    layout: {
                        padding: {
                            left: -10,
                            right: 0,
                            top: 0,
                            bottom: -10
                        },
                        position: 'top'
                    }
                }
            });

            new Chart($('#solved_questions'), {
                type: 'doughnut',
                data: {
                    labels: ['{{ __('admin.solved') }}', '{{ __('admin.unsolved') }}'],
                    datasets: [{
                        data: ['{{ Stats::solved_questions_percent() }}', '{{ Stats::unsolved_questions_percent() }}'],
                        backgroundColor: ["#a3ccef", "#f98f36"],
                        borderColor: "transparent",
                        weight: 50
                    }]
                },
                options: {
                    legend: {
                        display: false
                    }
                }
            });
        });
    </script>
@endpush

@section('content')
    <div class="stats">
        <div class="card">
            <div class="card-header">
                <div class="title">{{ __('admin.total_questions') }}</div>
            </div>
            <div class="card-body">
                <span class="count">{{ Stats::total_questions() }}</span>
            </div>
            <div class="card-footer">
                <span class="increase"><i data-feather="trending-up"></i> 3.41% Increase</span>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="title">{{ __('admin.new_questions') }} ({{ __('admin.today') }})</div>
            </div>
            <div class="card-body">
                <span class="count">{{ Stats::new_questions('today') }}</span>
            </div>
            <div class="card-footer">
                <canvas id="new_questions" style="width: 100%; height: 40px"></canvas>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="title">{{ __('admin.solved_questions') }}</div>
            </div>
            <div class="card-body">
                <div style="flex: 1">
                    <div class="status active">
                        {{ __('admin.solved') }} ({{ Stats::solved_questions() }} - {{ Stats::solved_questions_percent() }}%)
                    </div>
                    <div class="status inactive">
                        {{ __('admin.unsolved') }} ({{ Stats::unsolved_questions() }} - {{ Stats::unsolved_questions_percent() }}%)
                    </div>
                </div>
                <div style="width: 70px; height: 70px">
                    <canvas id="solved_questions"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="toolbar">
        <div class="title">{{ __('admin.questions') }}</div>
        <div class="search">
            <i data-feather="search"></i>
            <input type="text" id="tableSearch" placeholder="{{ __('admin.search') }}">
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>{{ __('admin.id') }}</th>
                <th>{{ __('admin.status') }}</th>
                <th>{{ __('admin.title') }}</th>
                <th>{{ __('admin.author') }}</th>
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
                <td><a href="{{ route('users.show', $question->user->id) }}">{{ $question->user->fullname }}</a></td>
                <td><a href="{{ route('categories.show', $question->category->id) }}">{{ $question->category->name }}</a></td>
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
                <td colspan="100%" style="text-align: center; padding: 20px">{{ __('admin.no_data') }}</td>
            </tr>
        @endforelse
        </tbody>
    </table>
@endsection