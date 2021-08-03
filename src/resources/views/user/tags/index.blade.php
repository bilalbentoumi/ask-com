@extends('user.layouts.app')

@section('title', Settings::get('sitename') . ' - ' . __('lang.tags'))

@section('content')
    <div class="body-wrapper">
        <div class="row p-10-m">
            <div class="primary">
                <span class="page-title">
                    <i data-feather="tag"></i>
                    <h2>{{ __('lang.tags') }}</h2>
                </span>
                <div class="tags">
                    @forelse($tags as $tag)
                        <a href="{{ route('questions.tag', $tag->name) }}" class="tag">
                            <h2>{{ $tag->name }}</h2>
                            <span>{{ $tag->questions()->count() }} {{ $tag->questions()->count() == 1 || $tag->questions()->count() == 2 || $tag->questions()->count() > 10 ? __('lang.question') : __('lang.questions') }}</span>
                        </a>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection