<html dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">
<head>
    <title>@yield('title')</title>
    <meta content='width=device-width, initial-scale=1.0, user-scalable=no' name='viewport'/>
    <link rel="icon" type="image/svg" href="{{ @asset('favicon.svg') }}">
    <!-- CSS -->
    <link rel="stylesheet" href="{{ @asset('fonts/Swissra/Swissra.css') }}">
    <link rel="stylesheet" href="{{ @asset('fonts/NotoKufiArabic/NotoKufiArabic.css') }}">
    <link rel="stylesheet" href="{{ @asset('fonts/NotoNaskhArabic/NotoNaskhArabic.css') }}">
    <link rel="stylesheet" href="{{ @asset('fonts/Nunito/Nunito.css') }}">
    <link rel="stylesheet" href="{{ @asset('css/layout.css') }}">
    <link rel="stylesheet" href="{{ @asset('css/style.' . LaravelLocalization::getCurrentLocaleDirection() . '.css') }}">
    @stack('css')

    <!-- SCRIPTS -->
    <script src="{{ @asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ @asset('js/jquery-ui.js') }}"></script>
    <script src="{{ @asset('js/feather.min.js') }}"></script>
    <script src="{{ @asset('js/popper.min.js') }}"></script>
    <script src="{{ @asset('js/tippy.min.js') }}"></script>
    <script src="{{ @asset('datatables/jquery.dataTables.min.' . LaravelLocalization::getCurrentLocale() . '.js') }}"></script>
    <script src="{{ @asset('js/validation.' . LaravelLocalization::getCurrentLocale() . '.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
    @stack('scripts')

</head>
<body>
    @include('user.components.header')
    <div class="wrapper">
        @yield('content')
        @include('user.components.footer')
    </div>
    @if(Auth::guard('admin')->check())
        <div class="admin-alert">
            {{ __('lang.logged_in_as_admin') }}
        </div>
    @endif
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <div id="toast"></div>
    <div id="overlay"></div>
    @if(Auth::user())
        <a href="{{ route('user.questions.create') }}" class="post-question" data-tippy-content="{{ __('lang.post_question') }}">
            <i data-feather="edit-2"></i>
        </a>
    @endif
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

        /* Search */
        $('.navbar .search input').on('keyup', function(){
            if ($(this).val() != '') {
                $.get('{{ route('user.search') }}', {
                    keyword: $(this).val()
                }, function (data) {
                    $('.navbar .search .result').html(data);
                    $('.navbar .search .result').css('display', 'block');
                    refresh();
                });
            } else {
                $('.navbar .search .result').css('display', 'none');
            }
        });

        /* Select Input Content */
        $('.field-label').click(function () {
            $(this).parent().find('input, textarea, select').select();
        });

        // Dropdown
        $('.dropdown .dropdown-btn').click(function () {
            $('.dropdown-menu').not($(this).parent().find('.dropdown-menu')).removeClass('show');
            $('.dropdown').not($(this).parent()).removeClass('active');
            $(this).parent().find('.dropdown-menu').toggleClass('show');
            $(this).parent().toggleClass('active');
            $('#overlay').toggleClass('show');
        });
        $(document).mouseup(function(e) {
            var dropdown_menu = $(".dropdown .dropdown-menu");
            var dropdown_btn = dropdown_menu.parent().find('.dropdown-btn');
            if (!dropdown_menu.is(e.target) && dropdown_menu.has(e.target).length === 0 && !dropdown_btn.is(e.target) && dropdown_btn.has(e.target).length === 0){
                dropdown_menu.removeClass('show');
                dropdown_btn.parent().removeClass('active');
                $('#overlay').removeClass('show');
            }
        });

        /* Navbar Toggle */
        $('.toggle-navbar').on('click', function () {
            $('.navbar-nav').toggleClass('show');
        });

        /* Search */
        $('.toggle-search').on('click', function () {
            $('.search-wrapper').toggleClass('show');
            $('.navbar-nav').removeClass('show');
        });

        // Notifications
        $('.notifications .dropdown-item .info a').click(function (event) {
            event.preventDefault();
            var id = $(this).attr('notid');
            var url = $(this).attr('href');
            $.post('{{ route('notifications.read') }}', {
                _token: '{{ csrf_token() }}',
                id: id
            }, function(data, status){
                window.location.href = url;
            });
        });
        $('.notifications .dropdown-item .status').click(function (event) {
            var id = $(this).attr('notid');
            var icon = $(this);
            $.post('{{ route('notifications.read') }}', {
                _token: '{{ csrf_token() }}',
                id: id
            }, function(data, status){
                icon.parent().removeClass('not-read');
                icon.css('opacity', '0');
                icon.css('visibility', 'hidden');
            });
        });

        /* Sticky Widget */
        if ($('#sticky').length) {

            var sticky = $('#sticky');
            var stickyTop = sticky.offset().top;
            var marginTop = 80;

            $(window).scroll(function(){

                var stickyHeight = sticky.height();
                var stickyWidth = sticky.width();

                var sidebarElementsHeight = 0;
                $('.settings-sidebar').children().each(function(){
                    sidebarElementsHeight = sidebarElementsHeight + $(this).height();
                });

                var limit = $('.footer').offset().top - stickyHeight - 20 - marginTop;

                var windowTop = $(window).scrollTop();

                if ((stickyTop - marginTop) < windowTop && $('.settings-sidebar').height() > (sidebarElementsHeight + 100)){
                    sticky.css({position: 'fixed', top: 0 + marginTop, width: stickyWidth});
                }
                else {
                    sticky.css({position: 'static', width: 'auto'});
                }

                if (limit < windowTop) {
                    var diff = limit - windowTop + marginTop;
                    sticky.css({top: diff});
                }
            });
        }

    });

</script>

@if(Session::has('success'))
    <script>showToast('{{ Session::get('success') }}', 'success');</script>
@elseif(Session::has('error'))
    <script>showToast('{{ Session::get('error')[1] }}', 'error');</script>
@endif

@stack('js')
