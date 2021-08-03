<html dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <title>@yield('title')</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ @asset('fonts/Swissra/Swissra.css') }}">
    <link rel="stylesheet" href="{{ @asset('fonts/NotoKufiArabic/NotoKufiArabic.css') }}">
    <link rel="stylesheet" href="{{ @asset('fonts/NotoNaskhArabic/NotoNaskhArabic.css') }}">
    <link rel="stylesheet" href="{{ @asset('fonts/Nunito/Nunito.css') }}">
    <link rel="stylesheet" href="{{ @asset('css/framework.css') }}">
    <link rel="stylesheet" href="{{ @asset('css/admin.' . LaravelLocalization::getCurrentLocaleDirection() . '.css') }}">
    {{--<link rel="stylesheet" href="{{ @asset('datatables/jquery.dataTables.min.rtl.css') }}">--}}
    @stack('css')

    <!-- Scripts -->
    <script src="{{ @asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ @asset('js/jquery-ui.js') }}"></script>
    <script src="{{ @asset('js/feather.min.js') }}"></script>
    <script src="{{ @asset('js/popper.min.js') }}"></script>
    <script src="{{ @asset('js/tippy.min.js') }}"></script>
    <script src="{{ @asset('dataTables/jquery.dataTables.min.' . LaravelLocalization::getCurrentLocale() . '.js') }}"></script>
    <script src="{{ @asset('js/validation.' . LaravelLocalization::getCurrentLocale() . '.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
    @stack('scripts')
</head>
<body>
<div class="wrapper">
    <div class="sidebar">
        <div class="header">
			<a href="{{ route('admin.home') }}" class="logo">
                <div class="icon"></div>
                <div class="text">
                    <span class="name">
                        @if(LaravelLocalization::getCurrentLocale() == 'en')
                            <span class="es2al">Es2al</span>
                            <span class="com">.com</span>
                        @elseif(LaravelLocalization::getCurrentLocale() == 'ar')
                            <span class="es2al">إسأل</span>
                            <span class="com">.كوم</span>
                        @endif
                    </span>
                    <span class="slug">{{ __('admin.dashboard') }}</span>
                </div>
			</a>
        </div>
        <label>{{ __('admin.main') }}</label>
        <ul>
            <li class="nav-item">
                <a href="{{ route('admin.home') }}" class="nav-link {{ route::is('admin.home') ? 'active' : '' }}">
                    <i data-feather="home"></i>{{ __('admin.home') }}
                </a>
            </li>
        </ul>
        <label>{{ __('admin.primary') }}</label>
        <ul>
            <li class="nav-item">
                <a href="{{ route('categories.index') }}" class="nav-link {{ route::is('categories.*') ? 'active' : '' }}">
                    <i data-feather="folder"></i>{{ __('admin.categories') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('questions.index') }}" class="nav-link {{ route::is('questions.*') ? 'active' : '' }}">
                    <i data-feather="help-circle"></i>{{ __('admin.questions') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admins.index') }}" class="nav-link {{ route::is('admins.*') ? 'active' : '' }}">
                    <i data-feather="award"></i>{{ __('admin.admins') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link {{ route::is('users.*') ? 'active' : '' }}">
                    <i data-feather="users"></i>{{ __('admin.users') }}
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('reports.index') }}" class="nav-link {{ route::is('reports.*') ? 'active' : '' }}">
                    <i data-feather="alert-circle"></i>{{ __('admin.reports') }}
                    @if(\App\Report::reports()->count() != 0)
                        <span class="count">{{ \App\Report::reports()->count() }}</span>
                    @endif

                </a>
            </li>
        </ul>
        <label>{{ __('admin.system') }}</label>
        <ul>
            <li class="nav-item">
                <a href="{{ route('admin.settings') }}" class="nav-link {{ route::is('admin.settings') ? 'active' : '' }}">
                    <i data-feather="settings"></i>{{ __('admin.settings') }}
                </a>
            </li>
        </ul>
        <div class="footer">
            <a href="{{ route('admin.home') }}" data-tippy-content="{{ __('admin.home') }}"><i data-feather="home"></i></a>
            <a href="{{ route('admin.settings') }}" data-tippy-content="{{ __('admin.settings') }}"><i data-feather="settings"></i></a>
            <a href="{{ route('admin.logout') }}"
               data-tippy-content="{{ __('admin.logout') }}"
               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i data-feather="log-out"></i>
            </a>
        </div>
    </div>
    <div class="primary">
        <div class="navbar">
            <h2 class="page-title">{{ __('admin.dashboard') }}</h2>
            <div class="search">
                <input type="text" name="keyword" placeholder="{{ __('admin.search') }}">
                <div class="result"></div>
            </div>
            <div class="fill"></div>
            <a href="{{ route('home') }}" target="_blank">
                <i data-feather="eye"></i>
                {{ __('admin.preview') }}
            </a>
            <div class="dropdown">
                <div class="btn dropdown-btn">
                    <span>{{ Auth::user()->fullname }}</span>
                    <i data-feather="chevron-down"></i>
                </div>
                <div class="dropdown-menu">
                    <a href="{{ route('admin.logout') }}" class="dropdown-item"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i data-feather="power"></i>
                        <span>{{ __('admin.logout') }}</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="scroll-container">
                @yield('content')
            </div>
        </div>
    </div>
    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <div id="toast"></div>
</div>
</body>
</html>

<script>

    function showToast(text, type) {
        $('#toast').html(text).addClass(type).addClass('show');
        setTimeout(function(){
            $('#toast').html(text).removeClass('show');
        }, 3000);
    }

    function refresh() {
        feather.replace();
        tippy('[data-tippy-content]', {
            arrow: true
        });
    }

    $(document).ready(function () {

        refresh();

        // Dropdown
        $('.dropdown .dropdown-btn').click(function () {
            $('.dropdown-menu').not($(this).parent().find('.dropdown-menu')).removeClass('show');
            $('.dropdown').not($(this).parent()).removeClass('active');
            $(this).parent().find('.dropdown-menu').toggleClass('show');
            $(this).parent().toggleClass('active');
        });
        $(document).mouseup(function(e) {
            var dropdown_menu = $(".dropdown .dropdown-menu");
            var dropdown_btn = dropdown_menu.parent().find('.dropdown-btn');
            if (!dropdown_menu.is(e.target) && dropdown_menu.has(e.target).length === 0 && !dropdown_btn.is(e.target) && dropdown_btn.has(e.target).length === 0){
                dropdown_menu.removeClass('show');
                dropdown_btn.parent().removeClass('active');
            }
        });

        /* Select Input Content */
        $('.field-label').click(function () {
            $(this).parent().find('input, textarea, select').select();
        });

        /* Datatables */
        oTable = $('table').DataTable({
            "dom": '<"toolbar">frtip',
            "columnDefs": [
                { "targets": [1], "orderable": false }
            ],
            "pageLength": 5
        });
        $('#tableSearch').keyup(function(){
            oTable.search($(this).val()).draw();
        });
        $('#DataTables_Table_0_previous, #DataTables_Table_0_next').click(function () {
            feather.replace();
        });

        /* Ajax Search */
        $('.navbar .search input').on('keyup', function(){
            if ($(this).val() != '') {
                $.get('{{ route('admin.search') }}', {
                    keyword: $(this).val()
                }, function (data) {
                    $('.navbar .search .result').html(data);
                    $('.navbar .search .result').css('display', 'block');
                });
            } else {
                $('.navbar .search .result').css('display', 'none');
            }
        });

        @if(LaravelLocalization::getCurrentLocale() == 'ar')
            $.validate({
                language : ar,
                modules : 'security'
            });
        @else
            $.validate({
                language : 'en',
                modules : 'security'
            });
        @endif

    });

</script>

@if(Session::has('success'))
    <script>showToast('{{ Session::get('success') }}', 'success');</script>
@elseif(Session::has('error'))
    <script>showToast('{{ Session::get('error')[1] }}', 'error');</script>
@endif

@stack('js')