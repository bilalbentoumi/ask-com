@extends('admin/layouts.app')

@section('title', __('admin.edit_question') . ': ' . $question->title)

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
        CKEDITOR.replace('question_content', {
            language: '{{ LaravelLocalization::getCurrentLocale() }}'
        });

        $('.tags').tagit();

        $('select').selectric();
    </script>
@endpush

@section('content')
    <div class="toolbar">
        <div class="title">{{ __('admin.edit_question') }}</div>
    </div>
    <div class="panel">
        <form action="{{ route('questions.update', $question->id) }}" method="post">
            <input type="hidden" name="_method" value="PUT">
            {{ csrf_field() }}
            <div class="body">
                <div class="field {{ $errors->has('title') ? ' has-error' : '' }}">
                    <label class="field-label">{{ __('admin.title') }}</label>
                    <div class="control">
                        <input name="title" type="text" value="{{ old('title', $question->title) }}">
                        @if ($errors->has('title'))
                            <span class="help-block">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field {{ $errors->has('category') ? ' has-error' : '' }}">
                    <label class="field-label">{{ __('admin.category') }}</label>
                    <div class="control">
                        <select name="category">
                            @forelse($categories as $category)
                                <option @if(old() && old('category') == $category->id || !old() && $question->category->id == $category->id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                            @empty
                                {{ __('admin.no_data') }}
                            @endforelse
                        </select>
                        @if ($errors->has('category'))
                            <span class="invalid-feedback" role="alert">{{ $errors->first('category') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field {{ $errors->has('tags') ? ' has-error' : '' }}">
                    <label class="field-label">{{ __('admin.tags') }}</label>
                    <div class="control">
                        <input name="tags" class="tags" type="text" value="{{ old('tags', $question->tags_string()) }}">
                        @if ($errors->has('tags'))
                            <span class="help-block">{{ $errors->first('tags') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field {{ $errors->has('question_content') ? ' has-error' : '' }}">
                    <label class="field-label">{{ __('admin.content') }}</label>
                    <div class="control">
                        <textarea name="question_content" rows="5">{{ old('question_content', $question->content) }}</textarea>
                        @if ($errors->has('question_content'))
                            <span class="help-block">{{ $errors->first('question_content') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="footer">
                <button type="submit" name="submit" class="btn btn-primary">{{ __('admin.save') }}</button>
            </div>
        </form>
    </div>
@endsection