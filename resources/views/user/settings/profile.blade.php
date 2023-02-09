@extends('user.layouts.settings')

@section('title', Settings::get('sitename') . ' - ' . __('lang.profile_settings'))

@push('css')
    <link href="{{ @asset('tag-it/css/jquery.tagit-rtl.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ @asset('tag-it/css/tagit.ui-rtl.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('scripts')
    <script src="{{ @asset('tag-it/js/tag-it.js') }}"></script>
@endpush

@push('js')
    <script>
        $(".interests").tagit({
            availableTags: [@foreach($tags as $tag) '{{ $tag->name }}', @endforeach]
        });
    </script>
@endpush

@section('settingcontent')
    <div class="panel">
        <div class="panel-header">
            <h2>{{ __('lang.profile_settings') }}</h2>
        </div>
        <form method="POST" action="{{ route('settings.profile.update') }}">
            <input type="hidden" name="_method" value="PUT">
            {{ csrf_field() }}
            <div class="panel-body row-flex">
                <div class="field col-100 {{ $errors->has('bio') ? 'has-error' : '' }}">
                    <label class="field-label">{{ __('lang.biography') }}</label>
                    <div class="control">
                        <textarea name="bio">{{ old('bio', Auth::user()->bio) }}</textarea>
                        @if ($errors->has('bio'))
                            <span class="help-block">
                                <strong>{{ $errors->first('bio') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="field col-100 {{ $errors->has('interests') ? 'has-error' : '' }}">
                    <label class="field-label">{{ __('lang.interests') }}</label>
                    <div class="control">
                        <input name="interests" class="interests" type="text" value="{{ old('interests', Auth::user()->interests_string()) }}">
                        @if ($errors->has('interests'))
                            <span class="help-block">
                                <strong>{{ $errors->first('interests') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="field col-100 {{ $errors->has('facebook') ? 'has-error' : '' }}">
                    <label class="field-label">{{ __('lang.facebook') }}</label>
                    <div class="control">
                        <input name="facebook" type="text" value="{{ old('facebook', Auth::user()->facebook) }}">
                        @if ($errors->has('facebook'))
                            <span class="help-block">
                                <strong>{{ $errors->first('facebook') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="field col-100 {{ $errors->has('twitter') ? 'has-error' : '' }}">
                    <label class="field-label">{{ __('lang.twitter') }}</label>
                    <div class="control">
                        <input name="twitter" type="text" value="{{ old('twitter', Auth::user()->twitter) }}">
                        @if ($errors->has('twitter'))
                            <span class="help-block">
                                <strong>{{ $errors->first('twitter') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="field col-100">
                    <button type="submit" name="submit" class="btn btn-primary">{{ __('lang.save') }}</button>
                </div>
            </div>
        </form>
    </div>
    <style>
        .footer {
            margin-top: 170px;
        }
    </style>
@endsection