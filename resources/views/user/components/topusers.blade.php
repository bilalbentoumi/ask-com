@forelse($users as $user)
    <div class="item">
        <img class="user-pic" src="{{ $user->picurl }}">
        <div class="info">
            <a href="{{ route('profile', $user->id) }}">{{ $user->fullname }}</a>
            <span>
                {{ $user->pointsc }} {{ $user->pointsc == 1 || $user->pointsc == 2 || $user->pointsc > 10 ? __('lang.point') : __('lang.points') }}
            </span>
        </div>
    </div>
@empty
    <p style="padding: 15px;">{{ __('lang.no_data') }}</p>
@endforelse