@extends('admin/layouts.app')

@section('title', __('admin.edit_category') . ': ' . $category->name)

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
        <div class="title">{{ __('admin.edit_category') }}</div>
    </div>
    <div class="panel">
        <form action="{{ route('categories.update', $category->id) }}" method="post">
            <input type="hidden" name="_method" value="PUT">
            {{ csrf_field() }}
            <div class="body">
                <div class="field {{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="field-label">{{ __('admin.name') }}</label>
                    <div class="control">
                        <input name="name" type="text" value="{{ old('name', $category->name) }}">
                        @if ($errors->has('name'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field {{ $errors->has('slug') ? ' has-error' : '' }}">
                    <label class="field-label">{{ __('admin.slug') }}</label>
                    <div class="control">
                        <input name="slug" type="text" value="{{ old('slug', $category->slug) }}">
                        @if ($errors->has('slug'))
                            <span class="help-block">{{ $errors->first('slug') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field {{ $errors->has('description') ? ' has-error' : '' }}">
                    <label class="field-label">{{ __('admin.description') }}</label>
                    <div class="control">
                        <textarea name="description" rows="5">{{ old('description', $category->description) }}</textarea>
                        @if ($errors->has('description'))
                            <span class="help-block">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field {{ $errors->has('color') ? ' has-error' : '' }}">
                    <label class="field-label">{{ __('admin.color') }}</label>
                    <div class="control">
                        <input name="color" type="text" class="color" value="{{ old('color', $category->color) }}">
                        @if ($errors->has('color'))
                            <span class="help-block">{{ $errors->first('color') }}</span>
                        @endif
                    </div>
                </div>
                <div class="field {{ $errors->has('image') ? ' has-error' : '' }}">
                    <label class="field-label">{{ __('admin.image') }}</label>
                    <div class="control">
                        <input name="image" type="text" value="{{ old('image', $category->image) }}">
                        @if ($errors->has('image'))
                            <span class="help-block">{{ $errors->first('image') }}</span>
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