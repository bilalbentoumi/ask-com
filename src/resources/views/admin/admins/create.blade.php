@extends('admin/layouts.app')

@section('title', __('admin.create_admin'))

@section('content')
    <div class="toolbar">
        <div class="title">{{ __('admin.create_admin') }}</div>
    </div>
    <div class="panel">
        <form action="{{ route('admins.store') }}" method="post">
        {{ csrf_field() }}
        <div class="flex-row">
            <div class="field {{ $errors->has('first_name') ? ' has-error' : '' }}">
                <label class="field-label">{{ __('admin.first_name') }}</label>
                <div class="control">
                    <input name="first_name" type="text" value="{{ old('first_name') }}">
                    @if ($errors->has('first_name'))
                        <span class="help-block">{{ $errors->first('first_name') }}</span>
                    @endif
                </div>
            </div>
            <div class="field {{ $errors->has('last_name') ? ' has-error' : '' }}">
                <label class="field-label">{{ __('admin.last_name') }}</label>
                <div class="control">
                    <input name="last_name" type="text" value="{{ old('last_name') }}">
                    @if ($errors->has('last_name'))
                        <span class="help-block">{{ $errors->first('last_name') }}</span>
                    @endif
                </div>
            </div>
            <div class="field {{ $errors->has('email') ? ' has-error' : '' }}">
                <label class="field-label">{{ __('admin.email') }}</label>
                <div class="control">
                    <input name="email" type="text" value="{{ old('email') }}">
                    @if ($errors->has('email'))
                        <span class="help-block">{{ $errors->first('email') }}</span>
                    @endif
                </div>
            </div>
            <div class="field {{ $errors->has('password') ? ' has-error' : '' }}">
                <label class="field-label">{{ __('admin.password') }}</label>
                <div class="control">
                    <input name="password" type="password" value="{{ old('password') }}">
                    @if ($errors->has('password'))
                        <span class="help-block">{{ $errors->first('password') }}</span>
                    @endif
                </div>
            </div>
            <div class="footer">
                <button type="submit" name="create_another" class="btn btn-primary">{{ __('admin.create_and_add_another') }}</button>
                <button type="submit" name="create" class="btn btn-primary">{{ __('admin.create') }}</button>
            </div>
        </div>
    </form>
    </div>
@endsection