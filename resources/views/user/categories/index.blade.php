@extends('user.layouts.app')

@section('title', Settings::get('sitename') . ' - ' . __('lang.categories'))

@section('content')
    <div class="body-wrapper">
        <div class="row p-10-m">
            <span class="page-title">
                <i data-feather="folder"></i>
                <h2>{{ __('lang.categories') }}</h2>
            </span>
            <div class="primary">
                <div class="categories">
                    @forelse($categories as $category)
                        <div class="item">
                            <div class="cat-image" style="background: {{ $category->color }}" onclick="location.href='{{ route('questions.category', $category->slug) }}';">
                                <img src="{{ $category->image }}" alt="">
                                <div class="cat-count">{{ $category->questions->count() }} {{ $category->questions()->count() == 1 || $category->questions()->count() == 2 || $category->questions()->count() > 10 ? __('lang.question') : __('lang.questions') }}</div>
                            </div>
                            <div class="cat-name">
                                <a class="cat-link" href="{{ route('questions.category', $category->slug) }}"><h2>{{ $category->name }}</h2></a>
                            </div>
                            <div class="cat-description">
                                <p>{{ $category->description }}</p>
                            </div>
                        </div>
                    @empty
                        <h2>{{ __('lang.no_categories') }}</h2>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
