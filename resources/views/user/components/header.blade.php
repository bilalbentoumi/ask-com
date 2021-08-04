<div class="navbar">
    <div class="row">
        <div class="navbar-container">
            <div class="navbar-header">
                <div class="nav-btn toggle-search mobile">
                    <i data-feather="search"></i>
                    <span class="label">{{ __('lang.search') }}</span>
                </div>
                <a href="{{ route('home') }}" class="logo">
                    @if(LaravelLocalization::getCurrentLocale() == 'en')
                        <span class="name">Es2al</span>
                        <span class="com">.com</span>
                    @else
                        <span class="name">إسأل</span>
                        <span class="com">.كوم</span>
                    @endif
                </a>
                <div class="nav-btn mobile toggle-navbar">
                    <i data-feather="menu"></i>
                    <span class="label">{{ __('lang.menu') }}</span>
                </div>
            </div>
            <div class="search-wrapper">
                <div class="search">
                    <div class="s-icon">
                        <i data-feather="search"></i>
                    </div>
                    <input type="text" name="keywords" placeholder="{{ __('lang.search') }} ...">
                    <div class="close-search toggle-search mobile">
                        <i data-feather="x"></i>
                    </div>
                    <div class="result"></div>
                </div>
            </div>
            <div class="spacer"></div>
            <div class="navbar-nav">
                <a class="nav-btn large" href="{{ route('categories') }}">{{ __('lang.categories') }}</a>
                <a class="nav-btn large" href="{{ route('tags') }}">{{ __('lang.tags') }}</a>
                @if(Auth::user())
                    <div class="dropdown">
                        <div class="nav-btn dropdown-btn">
                            @if(Helper::notifications_count())
                                <span class="count">{{ Helper::notifications_count() }}</span>
                            @endif
                            <i data-feather="bell"></i>
                            <span class="label mobile">{{ __('lang.notifications') }}</span>
                        </div>
                        <div class="dropdown-menu notifications">
                            @forelse(Helper::notifications() as $notification)
                                <div class="dropdown-item @if(!$notification->read) not-read @endif">
                                    <img class="user-pic" src="{{ $notification->nuser->picurl }}" alt="">
                                    <div class="info">
                                        <a href="{{ $notification->url }}" notid="{{ $notification->id }}">
                                            @if($notification->type == 'answer')
                                                {{ sprintf(__('lang.notifications_answer'), $notification->nuser->fullname, $notification->title) }}
                                            @elseif($notification->type == 'best')
                                                {{ sprintf(__('lang.notifications_best'), $notification->nuser->fullname, $notification->title) }}
                                            @elseif($notification->type == 'comment')
                                                {{ sprintf(__('lang.notifications_comment'), $notification->nuser->fullname, $notification->title) }}
                                            @endif
                                        </a>
                                        <p style="color: #0006; font-size: 12px">{{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                    @if(!$notification->read)
                                        <div class="status" notid="{{ $notification->id }}" data-tippy-content="{{ __('lang.notifications_mark_as_read') }}"></div>
                                    @endif
                                </div>
                            @empty
                                لا يوجد إشعارات
                            @endforelse
                        </div>
                    </div>
                @endif
                <div class="dropdown">
                    <div class="dropdown-btn nav-btn dropdown-btn">
                        <span class="badge">{{ LaravelLocalization::getCurrentLocale() }}</span>
                        <i data-feather="globe"></i>
                        <span class="label mobile">{{ __('lang.language') }}</span>
                    </div>
                    <div class="dropdown-menu">
                        <a href="{{ LaravelLocalization::getLocalizedURL('ar', null, [], true) }}"
                           class="dropdown-item @if(LaravelLocalization::getCurrentLocale() == 'ar') active @endif">
                            <span>العربية</span>
                        </a>
                        <a href="{{ LaravelLocalization::getLocalizedURL('en', null, [], true) }}"
                           class="dropdown-item @if(LaravelLocalization::getCurrentLocale() == 'en') active @endif">
                            <span>English</span>
                        </a>
                    </div>
                </div>
                @if(Auth::user())
                    <a class="nav-btn mobile" href="{{ route('profile', Auth::user()->id) }}">
                        <i data-feather="user"></i>
                        <span class="label mobile">{{ __('lang.profile') }}</span>
                    </a>
                    <a class="nav-btn mobile" href="{{ route('settings.general') }}">
                        <i data-feather="settings"></i>
                        <span class="label mobile">{{ __('lang.settings') }}</span>
                    </a>
                    <a class="nav-btn mobile" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i data-feather="power"></i>
                        <span class="label mobile">{{ __('lang.logout') }}</span>
                    </a>
                @else
                    <a class="nav-btn mobile" href="{{ route('tags') }}">
                        <i data-feather="tag"></i>
                        <span class="label mobile">{{ __('lang.tags') }}</span>
                    </a>
                    <a class="nav-btn mobile" href="{{ route('categories') }}">
                        <i data-feather="folder"></i>
                        <span class="label mobile">{{ __('lang.categories') }}</span>
                    </a>
                    <a class="nav-btn mobile" href="{{ route('register') }}">
                        <i data-feather="user"></i>
                        <span class="label mobile">{{ __('lang.register') }}</span>
                    </a>
                    <a class="nav-btn mobile" href="{{ route('login') }}">
                        <i data-feather="power"></i>
                        <span class="label mobile">{{ __('lang.login') }}</span>
                    </a>
                @endif
                <div class="dropdown large">
                    <div class="nav-btn dropdown-btn">
                        <i data-feather="user"></i>
                        @if(Auth::user())
                            <span class="label">{{ Auth::user()->fullname }}</span>
                        @endif
                        <i data-feather="chevron-down"></i>
                    </div>
                    <div class="dropdown-menu">
                        @if(Auth::user())
                            <a class="dropdown-item" href="{{ route('profile', Auth::user()->id) }}"><i data-feather="user"></i><span>{{ __('lang.profile') }}</span></a>
                            <a class="dropdown-item" href="{{ route('settings.general') }}"><i data-feather="settings"></i><span>{{ __('lang.settings') }}</span></a>
                            <div class="dropdown-devider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i data-feather="power"></i><span>{{ __('lang.logout') }}</span></a>
                        @else
                            <a class="dropdown-item" href="{{ route('login') }}"><i data-feather="log-in"></i><span>{{ __('lang.login') }}</span></a>
                            <a class="dropdown-item" href="{{ route('register') }}"><i data-feather="user"></i><span>{{ __('lang.register') }}</span></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>