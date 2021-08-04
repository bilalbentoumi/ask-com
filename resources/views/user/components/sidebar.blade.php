<div class="sidebar p-10-m">
    @if(Route::is('question.show') && $related->count() > 0)
    <div class="widget" id="related-questions">
        <div class="widget-header">
            <span class="widget-title">
                <i data-feather="users"></i>
                <h2>{{ __('lang.related_questions') }}</h2>
            </span>
        </div>
        <div class="widget-body">
            @forelse($related as $question)
                <div class="item">
                    <a href="{{ $question->url }}">{{ $question->title }}</a>
                    <span><i data-feather="eye"></i>{{ $question->views }} {{ $question->views == 1 || $question->views == 2 || $question->views > 10 ? __('lang.view') : __('lang.views') }}</span>
                </div>
            @empty
                <p style="padding: 15px;">{{ __('lang.no_data') }}</p>
            @endforelse
        </div>
    </div>
    @endif
    <div class="widget" id="top-users">
        <div class="widget-header">
            <span class="widget-title">
                <i data-feather="users"></i>
                <h2>{{ __('lang.top_users') }}</h2>
            </span>
        </div>
        <div class="widget-body">
            <div class="tabs-header">
                <div class="tab-btn active" data="week" default="">{{ __('lang.week') }}</div>
                <div class="tab-btn" data="month">{{ __('lang.month') }}</div>
                <div class="tab-btn" data="year">{{ __('lang.year') }}</div>
                <div class="tab-btn" data="all">{{ __('lang.all_time') }}</div>
            </div>
            <div class="tab-container"></div>
        </div>
    </div>
    <div class="widget" id="hot-questions">
        <div class="widget-header">
            <span class="widget-title">
                <i data-feather="trending-up"></i>
                <h2>{{ __('lang.hot_questions') }}</h2>
            </span>
        </div>
        <div class="widget-body">
            @forelse(Stats::hot_questions() as $question)
                <div class="item">
                    <a href="{{ $question->url }}">{{ $question->title }}</a>
                    <span><i data-feather="eye"></i>{{ $question->views }} {{ $question->views == 1 || $question->views == 2 || $question->views > 10 ? __('lang.view') : __('lang.views') }}</span>
                </div>
            @empty
                <p style="padding: 15px;">{{ __('lang.no_data') }}</p>
            @endforelse
        </div>
    </div>
    <div class="widget" id="categories">
        <div class="widget-header">
            <span class="widget-title">
                <i data-feather="folder"></i>
                <h2>{{ __('lang.categories') }}</h2>
            </span>
        </div>
        <div class="widget-body">
            @forelse(Helper::categories() as $category)
                <div class="item">
                    <div class="info">
                        <a href="{{ route('questions.category', $category->slug) }}">{{ $category->name }}</a>
                        <span>{{ $category->questions->count() }} {{ __('lang.questions') }}</span>
                    </div>
                    <div class="spacer"></div>
                    <div class="cat-icon" style="background: {{ $category->color }}">
                        <img src="{{ $category->image }}">
                    </div>
                </div>
            @empty
                <p style="padding: 15px;">{{ __('lang.no_data') }}</p>
            @endforelse
        </div>
    </div>
    <div class="widget" id="tags">
        <div class="widget-header">
            <span class="widget-title">
                <i data-feather="folder"></i>
                <h2>{{ __('lang.tags') }}</h2>
            </span>
        </div>
        <div class="widget-body">
            @forelse(Helper::tags() as $tag)
                <a href="{{ route('questions.tag', $tag->name) }}" class="tag">{{ $tag->name }} ({{ $tag->questions()->count() }})</a>
            @empty
                <p style="padding: 15px;">{{ __('lang.no_data') }}</p>
            @endforelse
        </div>
    </div>
</div>

<script>
    $('#top-users .tab-btn').click(function () {
        $(this).addClass('active').siblings().removeClass('active');
        var period = $(this).attr('data');
        $.get('{{ route('sidebar.topusers') }}', {
            period: period
        }, function (data) {
            $('#top-users .tab-container').html(data);
        });
    });
    $('[default]').click();
</script>