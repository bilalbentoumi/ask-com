@extends('admin/layouts.app')

@section('title', __('admin.edit_admin') . ': ' . $admin->name)

@section('content')
    <div class="toolbar">
        <div class="title">{{ __('admin.edit_admin') }}</div>
    </div>
    <div class="panel">
        <form action="{{ route('admins.update', $admin->id) }}" method="post">
            <input type="hidden" name="_method" value="PUT">
            {{ csrf_field() }}
            <div class="flex-row">
                <div class="field {{ $errors->has('first_name') ? ' has-error' : '' }}">
                    <label class="field-label">{{ __('admin.first_name') }}</label>
                    <div class="control">
                        <input name="first_name" type="text" value="{{ old('first_name', $admin->first_name) }}">
                        @if ($errors->has('first_name'))
                            <span class="help-block">{{ $errors->first('first_name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field {{ $errors->has('last_name') ? ' has-error' : '' }}">
                    <label class="field-label">{{ __('admin.last_name') }}</label>
                    <div class="control">
                        <input name="last_name" type="text" value="{{ old('last_name', $admin->last_name) }}">
                        @if ($errors->has('last_name'))
                            <span class="help-block">{{ $errors->first('last_name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field {{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="field-label">{{ __('admin.email') }}</label>
                    <div class="control">
                        <input name="email" type="text" value="{{ old('email', $admin->email) }}">
                        @if ($errors->has('email'))
                            <span class="help-block">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="field-label">{{ __('admin.password') }}</label>
                    <div class="control">
                        <input name="password" type="password">
                        @if ($errors->has('password'))
                            <span class="help-block">{{ $errors->first('password') }}</span>
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