@forelse($questions as $question)
    <div class="question">
        <a href="{{ route('profile', $question->user->id) }}">
            <img class="user-pic large" src="{{ $question->user->picurl }}" data-tippy-content="{{ $question->user->fullname }}">
        </a>
        <div class="info">
            <a href="{{ $question->url }}"><h2 class="question-title">{{ $question->title }}</h2></a>
            <span class="askedby"><a href="{{ route('profile', $question->user->id) }}">{{ $question->user->fullname }}</a> {{ __('lang.asked') }} {{ $question->created_at->diffForHumans() }}</span>
            {{--<p class="summary">{{ $question->summary }}</p>--}}
            <div class="question-tags">
                <i data-feather="tag"></i>
                @foreach($question->tags as $tag)
                    <a href="{{ route('questions.tag', $tag->name) }}">{{ $tag->name }}</a>
                @endforeach
            </div>
            <div class="meta">
                <span class="meta-item status @if($question->hasBestAnswer()) solved @else unsolved @endif">
                    @if($question->hasBestAnswer())
                        <i data-feather="check"></i>
                        <span class="text">{{ __('lang.solved') }}</span>
                    @else
                        <i data-feather="help-circle"></i>
                        <span class="text">{{ __('lang.unsolved') }}</span>
                    @endif
                </span>
                <span class="meta-item category">
                    <a href="{{ route('questions.category', $question->category->slug) }}">
                        <i data-feather="folder"></i>
                        <span class="text">{{ $question->category->name }}</span>
                    </a>
                </span>
                <span class="meta-item time" data-tippy-content="{{ $question->created_at->format('M d, Y - h:i') }}">
                    <i data-feather="clock"></i>
                    <span class="text">{{ $question->created_at->diffForHumans() }}</span>
                </span>
                <span class="meta-item answers">
                    <i data-feather="message-square"></i>
                    <span class="count">{{ $question->answers->count() }}</span>
                    <span class="text">{{ $question->answers->count() == 1 || $question->answers->count() == 2 || $question->answers->count() > 10 ? __('lang.answer') : __('lang.answers') }}</span>
                </span>
                <span class="meta-item views"><i data-feather="eye"></i>
                    <span class="count">{{ $question->views }}</span>
                    <span class="text">{{ $question->views == 1 || $question->views == 2 || $question->views > 10 ? __('lang.view') : __('lang.views') }}</span>
                </span>
            </div>
        </div>
    </div>
@empty
    <p style="padding: 15px;">{{ __('lang.no_data') }}</p>
@endforelse