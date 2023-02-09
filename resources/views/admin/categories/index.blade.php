@extends('admin/layouts.app')

@section('title', __('admin.categories'))

@section('content')
    <div class="toolbar">
        <div class="title">{{ __('admin.categories') }}</div>
        <div class="search">
            <i data-feather="search"></i>
            <input type="text" id="tableSearch" placeholder="{{ __('admin.search') }}">
        </div>
        <div class="fill"></div>
        <a class="btn btn-primary" href="{{ route('categories.create') }}">{{ __('admin.create_category') }}</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>{{ __('admin.id') }}</th>
                <th>{{ __('admin.icon') }}</th>
                <th>{{ __('admin.name') }}</th>
                <th>{{ __('admin.slug') }}</th>
                <th>{{ __('admin.questions') }}</th>
                <th>{{ __('admin.control') }}</th>
            </tr>
        </thead>
        <tbody>
        @forelse($categories as $category)
            <tr>
                <td class="center">{{ $category->id }}</td>
                <td><div class="cat-icon" style="background-color: {{ $category->color }}"><img src="{{ $category->image }}"></div></td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->slug }}</td>
                <td>{{ $category->questions->count() }}</td>
                <td>
                    <a data-tippy-content="{{ __('admin.view') }}" class="action-btn" href="{{ route('categories.show', $category->id) }}"><i data-feather="eye"></i></a>
                    <a data-tippy-content="{{ __('admin.edit') }}" class="action-btn" href="{{ route('categories.edit', $category->id) }}"><i data-feather="edit"></i></a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
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