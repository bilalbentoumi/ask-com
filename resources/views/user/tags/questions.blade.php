@extends('user.layouts.app')

@section('title', Settings::get('sitename') . ' - ' . $tag->name)

@push('js')
    <script>
        $(document).ready(function () {

            var current = 1;
            var last = parseInt($("[name='lastpage']").val());

            function loadmore() {
                $.get('{{ route($route) }}', {
                    page: current,
                    name: '{{ $tag->name }}'
                }, function (data){
                    $('.questions-stack').append(data);
                    refresh();
                    if (current == last)
                        $('#loadmore').hide();
                    current++;
                    $("[name='current']").val(current);
                });
            }

            loadmore();

            $('#loadmore').click(function () {
                loadmore();
            });

        });
    </script>
@endpush

@section('content')
    <div class="body-wrapper">
        <div class="main row">
            <div class="main-grid">
                <div class="primary p-10-m">
                    <span class="page-title">
                        <i data-feather="zap"></i>
                        <h2>{{ __('lang.tags') }}: {{ $tag->name }}</h2>
                    </span>
                    <div class="questions">
                        <input type="hidden" value="{{ $last }}" name="lastpage">
                        <div class="questions-stack"></div>
                        <div class="btn btn-primary w-100" id="loadmore">{{ __('lang.loadmore') }}</div>
                    </div>
                </div>
                @include('user.components.sidebar')
            </div>
        </div>
    </div>
@endsection