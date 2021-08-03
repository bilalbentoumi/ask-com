@extends('admin/layouts.app')

@section('title', __('admin.admins'))

@section('content')
    <div class="toolbar">
        <div class="title">{{ __('admin.admins') }}</div>
        <div class="search">
            <i data-feather="search"></i>
            <input type="text" id="tableSearch" placeholder="{{ __('admin.search') }}">
        </div>
        <div class="fill"></div>
        <a class="btn btn-primary" href="{{ route('admins.create') }}">{{ __('admin.create_admin') }}</a>
    </div>
    <table>
            <thead>
            <tr>
                <th>{{ __('admin.id') }}</th>
                <th>{{ __('admin.name') }}</th>
                <th>{{ __('admin.email') }}</th>
                <th>{{ __('admin.control') }}</th>
            </tr>
            </thead>
            <tbody>
            @forelse($admins as $admin)
                <tr>
                    <td class="center">{{ $admin->id }}</td>
                    <td>{{ $admin->first_name . ' ' . $admin->last_name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>
                        <a data-tippy-content="{{ __('admin.view') }}" class="action-btn" href="{{ route('admins.show', $admin->id) }}"><i data-feather="eye"></i></a>
                        <a data-tippy-content="{{ __('admin.edit') }}" class="action-btn" href="{{ route('admins.edit', $admin->id) }}"><i data-feather="edit"></i></a>
                        <form action="{{ route('admins.destroy', $admin->id) }}" method="POST"
                              style="display: inline"
                              onsubmit="return confirm('{{ __('admin.are_you_sure') }}');">
                            <input type="hidden" name="_method" value="DELETE">
                            {{ csrf_field() }}
                            <button data-tippy-content="{{ __('admin.delete') }}" class="action-btn"><i data-feather="trash-2"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="100%" style="text-align: center; padding: 20px">{{ __('admin.no_data') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>
@endsection