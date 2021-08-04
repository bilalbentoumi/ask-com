@if($admins->count())
    <span>{{ __('admin.admins') }}</span>
    @foreach($admins as $admin)
        <a class="item" href="{{ route('admins.show', $admin->id) }}">
            <p>{{ $admin->fullname }} ({{ $admin->email }})</p>
        </a>
    @endforeach
@endif
@if($users->count())
    <span>{{ __('admin.users') }}</span>
    @foreach($users as $user)
        <a class="item" href="{{ route('users.show', $user->id) }}">
            <img class="user-pic" src="{{ $user->picurl }}">
            <p>{{ $user->fullname }} ({{ $user->email }})</p>
        </a>
    @endforeach
@endif
@if($questions->count())
    <span>{{ __('admin.questions') }}</span>
    @foreach($questions as $question)
        <a class="item" href="{{ route('questions.show', $question->id) }}">
            <img class="user-pic" src="{{ $question->user->picurl }}">
            <p>{{ $question->title }}</p>
        </a>
    @endforeach
@endif
@if($categories->count())
    <span>{{ __('admin.categories') }}</span>
    @foreach($categories as $category)
        <a class="item" href="{{ route('categories.show', $category->id) }}">
            <div class="cat-icon" style="background-color: {{ $category->color }}"><img src="{{ $category->image }}"></div>
            <p>{{ $category->name }}</p>
        </a>
    @endforeach
@endif