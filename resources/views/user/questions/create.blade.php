@extends('user.layouts.app')

@section('title', __('lang.create_question'))

@push('css')
    <link href="{{ @asset('tag-it/css/jquery.tagit-rtl.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ @asset('tag-it/css/tagit.ui-rtl.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ @asset('selectric/selectric.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('scripts')
    <script src="{{ @asset('tag-it/js/tag-it.js') }}"></script>
    <script src="{{ @asset('selectric/jquery.selectric.js') }}"></script>
    <script src="{{ @asset('ckeditor/ckeditor.js') }}"></script>
@endpush

@push('js')
    <script>
        $(document).ready(function () {

            CKEDITOR.replace('question_content', {
                language: '{{ LaravelLocalization::getCurrentLocale() }}'
            });

            $(".tags").tagit({
                availableTags: [@foreach($tags as $tag) '{{ $tag->name }}', @endforeach]
            });

            $('select').selectric();

            $("form").validate({
                rules: {
                    title: {
                        required: true,
                    },
                },
                messages: {
                    title: {
                        required: messages.required,
                    },
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });

        });
    </script>
@endpush

@section('content')
    <div class="body-wrapper">
        <div class="main row">
            <div class="main-grid">
                <div class="primary">
                    <span class="page-title">
                        <i data-feather="edit-2"></i>
                        <h2>{{ __('lang.create_question') }}</h2>
                    </span>
                    <div class="panel">
                        <div class="panel-header">
                            <h2>{{ __('lang.create_question') }}</h2>
                        </div>
                        <div class="panel-body">
                            <form method="POST" action="{{ route('user.questions.store') }}">
                            @csrf
                            <div class="field {{ $errors->has('title') ? 'has-error' : '' }}">
                                <label class="field-label">{{ __('lang.title') }}</label>
                                <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}">
                                @if ($errors->has('title'))
                                    <span class="help-block">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                            <div class="field {{ $errors->has('category') ? 'has-error' : '' }}">
                                <label class="field-label">{{ __('lang.category') }}</label>
                                <select name="category">
                                    @forelse($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @empty
                                        لا يوجد تصنيفات
                                    @endforelse
                                </select>
                                @if ($errors->has('category'))
                                    <span class="help-block">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                            <div class="field {{ $errors->has('tags') ? 'has-error' : '' }}">
                                <label class="field-label">{{ __('lang.tags') }}</label>
                                <input type="text" class="tags form-control{{ $errors->has('tag-it') ? ' is-invalid' : '' }}" name="tags" value="{{ old('tags') }}">
                                @if ($errors->has('tags'))
                                    <span class="help-block">{{ $errors->first('tags') }}</span>
                                @endif
                            </div>
                            <div class="field {{ $errors->has('question_content') ? 'has-error' : '' }}">
                                <label class="field-label">{{ __('lang.content') }}</label>
                                <textarea name="question_content">{{ old('question_content') }}</textarea>
                                @if ($errors->has('question_content'))
                                    <span class="help-block">{{ $errors->first('question_content') }}</span>
                                @endif
                            </div>
                            <div class="field">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('lang.add') }}
                                </button>
                                <a href="{{ route('home') }}" type="submit" class="btn btn-secondary">
                                    {{ __('lang.cancel') }}
                                </a>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
                <div class="sidebar">
                    @include('user.components.sidebar')
                </div>
            </div>
        </div>
    </div>
@endsection