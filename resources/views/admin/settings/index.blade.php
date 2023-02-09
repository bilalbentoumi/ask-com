@extends('admin/layouts.app')

@section('title', __('admin.settings'))

@section('content')
    <div class="toolbar">
        <div class="title">{{ __('admin.settings') }}</div>
    </div>
    <div class="panel">
        <form action="{{ route('admin.settings.update') }}" method="post">
            <input type="hidden" name="_method" value="PUT">
            {{ csrf_field() }}
            <div class="body">
                <div class="field {{ $errors->has('sitename') ? ' has-error' : '' }}">
                    <label class="field-label">{{ __('admin.sitename') }}</label>
                    <div class="control">
                        <input name="sitename" type="text" value="{{ old('sitename', Settings::get('sitename')) }}">
                        @if ($errors->has('sitename'))
                            <span class="help-block">{{ $errors->first('sitename') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field {{ $errors->has('description') ? ' has-error' : '' }}">
                    <label class="field-label">{{ __('admin.description') }}</label>
                    <div class="control">
                        <textarea name="description">{{ old('description', Settings::get('description')) }}</textarea>
                        @if ($errors->has('description'))
                            <span class="help-block">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field {{ $errors->has('default_lang') ? ' has-error' : '' }}">
                    <label class="field-label">{{ __('admin.default_lang') }}</label>
                    <div class="control">
                        <select name="default_lang">
                            <option value="ar" @if(Settings::get('default_lang') == 'ar') selected @endif>العربية</option>
                            <option value="en" @if(Settings::get('default_lang') == 'en') selected @endif>English</option>
                        </select>
                        @if ($errors->has('default_lang'))
                            <span class="help-block">{{ $errors->first('default_lang') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field {{ $errors->has('perpage') ? ' has-error' : '' }}">
                    <label class="field-label">{{ __('admin.perpage') }}</label>
                    <div class="control">
                        <input name="perpage" type="number" value="{{ old('perpage', Settings::get('perpage')) }}">
                        @if ($errors->has('perpage'))
                            <span class="help-block">{{ $errors->first('perpage') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field {{ $errors->has('up_vote_points') ? ' has-error' : '' }}">
                    <label class="field-label">{{ __('admin.up_vote_points') }}</label>
                    <div class="control">
                        <input name="up_vote_points" type="number" value="{{ old('up_vote_points', Settings::get('up_vote_points')) }}">
                        @if ($errors->has('up_vote_points'))
                            <span class="help-block">{{ $errors->first('up_vote_points') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field {{ $errors->has('down_vote_points') ? ' has-error' : '' }}">
                    <label class="field-label">{{ __('admin.down_vote_points') }}</label>
                    <div class="control">
                        <input name="down_vote_points" type="number" value="{{ old('down_vote_points', Settings::get('down_vote_points')) }}">
                        @if ($errors->has('down_vote_points'))
                            <span class="help-block">{{ $errors->first('down_vote_points') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field {{ $errors->has('best_answer_points') ? ' has-error' : '' }}">
                    <label class="field-label">{{ __('admin.best_answer_points') }}</label>
                    <div class="control">
                        <input name="best_answer_points" type="number" value="{{ old('best_answer_points', Settings::get('best_answer_points')) }}">
                        @if ($errors->has('best_answer_points'))
                            <span class="help-block">{{ $errors->first('best_answer_points') }}</span>
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