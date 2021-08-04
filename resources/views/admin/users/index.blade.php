@extends('admin/layouts.app')

@section('title',  __('admin.users'))

@push('scripts')
    <script src="{{ @asset('js/chart.2.6.0.min.js') }}"></script>
@endpush

@push('js')
    <script>
        $(document).ready(function () {
            new Chart($('#new_users'), {
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

            new Chart($('#active_users'), {
                type: 'doughnut',
                data: {
                    labels: ['{{ __('admin.active') }}', '{{ __('admin.inactive') }}'],
                    datasets: [{
                        data: ['{{ Stats::active_users_percent() }}', '{{ Stats::inactive_users_percent() }}'],
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
                <div class="title">{{ __('admin.new_users') }} ({{ __('admin.week') }})</div>
            </div>
            <div class="card-body">
                <span class="count">{{ Stats::new_users('week') }}</span>
            </div>
            <div class="card-footer">
                <canvas id="new_users" style="width: 100%; height: 40px"></canvas>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="title">{{ __('admin.active_users') }}</div>
            </div>
            <div class="card-body">
                <div style="flex: 1">
                    <div class="status active">
                        {{ __('admin.active') }} ({{ Stats::active_users() }} - {{ Stats::active_users_percent() }}%)
                    </div>
                    <div class="status inactive">
                        {{ __('admin.inactive') }} ({{ Stats::inactive_users() }} - {{ Stats::inactive_users_percent() }}%)
                    </div>
                </div>
                <div style="width: 70px; height: 70px">
                    <canvas id="active_users"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="toolbar">
        <div class="title">{{ __('admin.users') }}</div>
        <div class="search">
            <i data-feather="search"></i>
            <input type="text" id="tableSearch" placeholder="{{ __('admin.search') }}">
        </div>
    </div>
    <table>
            <thead>
            <tr>
                <th>{{ __('admin.id') }}</th>
                <th>{{ __('admin.picture') }}</th>
                <th>{{ __('admin.name') }}</th>
                <th>{{ __('admin.email') }}</th>
                <th>{{ __('admin.status') }}</th>
                <th>{{ __('admin.control') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td class="center">{{ $user->id }}</td>
                    <td><img class="user-pic" src="{{ $user->picurl }}"></td>
                    <td>{{ $user->fullname }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->status)
                            <span class="status active">{{ __('admin.active') }}</span>
                        @else
                            <span class="status inactive">{{ __('admin.inactive') }}</span>
                        @endif
                    </td>
                    <td>
                        <a data-tippy-content="{{ __('admin.view') }}" class="action-btn" href="{{ route('users.show', $user->id) }}"><i data-feather="eye"></i></a>
                        <a data-tippy-content="{{ __('admin.edit') }}" class="action-btn" href="{{ route('users.edit', $user->id) }}"><i data-feather="edit"></i></a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                              style="display: inline"
                              onsubmit="return confirm('Are you sure?');">
                            <input type="hidden" name="_method" value="DELETE">
                            {{ csrf_field() }}
                            <button data-tippy-content="{{ __('admin.delete') }}" class="action-btn"><i data-feather="trash-2"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="100%" style="text-align: center">{{ __('admin.no_data') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
@endsection