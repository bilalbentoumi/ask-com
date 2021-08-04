@extends('admin/layouts.app')

@section('title', __('admin.admin_details') . ': ' . $admin->name)

@section('content')
    <div class="toolbar">
        <div class="ptitle">{{ __('admin.admin_details') }}</div>
        <div class="fill"></div>
        <form action="{{ route('admins.destroy', $admin->id) }}" method="POST"
              style="display: inline"
              onsubmit="return confirm('{{ __('admin.are_you_sure') }}');">
            <input type="hidden" name="_method" value="DELETE">
            {{ csrf_field() }}
            <button data-tippy-content="{{ __('admin.delete') }}" class="btn btn-secondary icon"><i data-feather="trash-2"></i></button>
        </form>
        <a data-tippy-content="{{ __('admin.edit') }}" class="btn btn-primary icon" href="{{ route('admins.edit', $admin->id) }}"><i data-feather="edit"></i></a>
    </div>
    <div class="panel">
        <div class="info">
            <label>{{ __('admin.id') }}</label>
            <div>{{ $admin->id }}</div>
        </div>
        <div class="info">
            <label>{{ __('admin.name') }}</label>
            <div>{{ $admin->name }}</div>
        </div>
        <div class="info">
            <label>{{ __('admin.email') }}</label>
            <div>{{ $admin->email }}</div>
        </div>
        <div class="info">
            <label>{{ __('admin.created_at') }}</label>
            <div>{{ $admin->created_at }}</div>
        </div>
    </div>
@endsection