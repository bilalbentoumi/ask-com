@extends('admin/layouts.app')

@section('title', __('admin.edit_answer'))

@section('content')
    <div class="toolbar">
        <div class="title">{{ __('admin.edit_answer') }}</div>
    </div>
    <div class="panel">
        <form action="{{ route('answers.update', $answer->id) }}" method="post">
            <input type="hidden" name="_method" value="PUT">
            {{ csrf_field() }}
            <div class="flex-row">
                <div class="field {{ $errors->has('answer_content') ? ' has-error' : '' }}">
                    <label class="field-label">{{ __('admin.answer_content') }}</label>
                    <div class="control">
                        <textarea name="first_name">{{ old('answer_content', $answer->content) }}</textarea>
                        @if ($errors->has('answer_content'))
                            <span class="help-block">{{ $errors->first('answer_content') }}</span>
                        @endif
                    </div>
                </div>
                <div class="footer">
                    <button type="submit" name="submit" class="btn btn-primary">{{ __('admin.save') }}</button>
                </div>
            </div>
        </form>
    </div>
@endsection