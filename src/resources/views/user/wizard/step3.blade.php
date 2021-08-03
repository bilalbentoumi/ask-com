@extends('user.layouts.app')

@section('title', 'إسأل.كوم')

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

@section('content')
    <div class="body-wrapper">
        <div class="main row">
            <div class="panel wizard">
                <div class="panel-header">
                    <div class="wizard-steps">
                        <div class="wizard-step">1</div>
                        <div class="wizard-step">2</div>
                        <div class="wizard-step active">3</div>
                    </div>
                </div>
                <form action="{{ route('wizard.step3.store') }}" method="post">
                    @csrf
                    <div class="panel-body">
                        <div class="content row-flex margin-auto">
                        <div class="field col-100">
                            <h2>{{ __('lang.additional_informations') }}</h2>
                        </div>
                        <div class="field col-100 {{ $errors->has('bio') ? 'has-error' : '' }}">
                            <label class="field-label">{{ __('lang.biography') }}</label>
                            <div class="control">
                                <textarea name="bio">{{ old('bio') }}</textarea>
                                @if ($errors->has('bio'))
                                    <span class="help-block">{{ $errors->first('bio') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="field col-100 {{ $errors->has('interests') ? 'has-error' : '' }}">
                            <label class="field-label">{{ __('lang.interests') }}</label>
                            <div class="control">
                                <input name="interests" class="interests" type="text" value="{{ old('interests') }}">
                                @if ($errors->has('interests'))
                                    <span class="help-block">{{ $errors->first('interests') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="field col-100">
                            <button onclick="event.preventDefault();location.href = '{{ route('wizard.step2') }}'" class="btn btn-primary start">{{ __('lang.previous') }}</button>
                            <button type="submit" name="submit" class="btn btn-primary end">{{ __('lang.finish') }}</button>
                        </div>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection