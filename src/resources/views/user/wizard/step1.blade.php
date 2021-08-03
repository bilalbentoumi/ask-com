@extends('user.layouts.app')

@section('title', 'إسأل.كوم')

@section('content')
    <div class="body-wrapper">
        <div class="main row">
            <div class="panel wizard">
                <div class="panel-header">
                    <div class="wizard-steps">
                        <div class="wizard-step active">1</div>
                        <div class="wizard-step">2</div>
                        <div class="wizard-step">3</div>
                    </div>
                </div>
                <form action="{{ route('wizard.step1.store') }}" method="post">
                    @csrf
                    <div class="panel-body">
                        <div class="content row-flex margin-auto">
                            <div class="field col-100">
                                <h2>{{ __('lang.basic_informations') }}</h2>
                            </div>
                            <div class="field col-100 {{ $errors->has('first_name') ? 'has-error' : '' }}">
                                <label for="first_name" class="field-label">{{ __('lang.first_name') }}</label>
                                <div class="control">
                                    <input name="first_name" type="text" id="first_name" value="{{ old('first_name') }}">
                                    @if ($errors->has('first_name'))
                                        <span class="help-block">{{ $errors->first('first_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="field col-100 {{ $errors->has('last_name') ? 'has-error' : '' }}">
                                <label class="field-label">{{ __('lang.last_name') }}</label>
                                <div class="control">
                                    <input name="last_name" type="text" value="{{ old('last_name') }}">
                                    @if ($errors->has('last_name'))
                                        <span class="help-block">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="field col-100">
                                <button type="submit" name="submit" class="btn btn-primary end">{{ __('lang.next') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection