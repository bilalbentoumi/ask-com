@extends('admin/layouts.app')

@section('title', __('admin.create_category'))

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ @asset('colorpicker/css/colorpicker.css') }}" />
@endpush

@push('scripts')
    <script type="text/javascript" src="{{ @asset('colorpicker/js/colorpicker.js') }}"></script>
@endpush

@push('js')
    <script>

        $('.color').ColorPicker({
            onSubmit: function(hsb, hex, rgb, el) {
                $(el).val('#' + hex);
                $(el).ColorPickerHide();
            },
            onBeforeShow: function () {
                $(this).ColorPickerSetColor(this.value);
            }
        }).bind('keyup', function(){
            $(this).ColorPickerSetColor(this.value);
        });

    </script>
@endpush

@section('content')
    <div class="toolbar">
        <div class="title">{{ __('admin.create_category') }}</div>
    </div>
    <div class="panel">
        <form action="{{ route('categories.store') }}" method="post">
            {{ csrf_field() }}
            <div class="body">
                <div class="field {{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="field-label">{{ __('admin.name') }}</label>
                    <div class="control">
                        <input name="name" type="text" value="{{ old('name') }}" data-validation="required">
                        @if ($errors->has('name'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field {{ $errors->has('slug') ? ' has-error' : '' }}">
                    <label class="field-label">{{ __('admin.slug') }}</label>
                    <div class="control">
                        <input name="slug" type="text" value="{{ old('slug') }}">
                        @if ($errors->has('slug'))
                            <span class="help-block">{{ $errors->first('slug') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field {{ $errors->has('description') ? ' has-error' : '' }}">
                    <label class="field-label">{{ __('admin.description') }}</label>
                    <div class="control">
                        <textarea name="description" rows="5">{{ old('description') }}</textarea>
                        @if ($errors->has('description'))
                            <span class="help-block">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field {{ $errors->has('color') ? ' has-error' : '' }}">
                    <label class="field-label">{{ __('admin.color') }}</label>
                    <div class="control">
                        <input name="color" class="color" type="text" value="{{ old('color') }}">
                        @if ($errors->has('color'))
                            <span class="help-block">{{ $errors->first('color') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field {{ $errors->has('image') ? ' has-error' : '' }}">
                    <label class="field-label">{{ __('admin.image') }}</label>
                    <div class="control">
                        <input name="image" type="text" value="{{ old('image') }}">
                        @if ($errors->has('image'))
                            <span class="help-block">{{ $errors->first('image') }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="footer">
                <button type="submit" name="create_another" class="btn btn-primary">{{ __('admin.create_and_add_another') }}</button>
                <button type="submit" name="create" class="btn btn-primary">{{ __('admin.create') }}</button>
            </div>
        </form>
    </div>
@endsection