@extends('user.layouts.app')

@section('title', $question->title)

@push('css')
<link href="{{ @asset('tag-it/css/jquery.tagit-rtl.css') }}" rel="stylesheet" type="text/css">
<link href="{{ @asset('tag-it/css/tagit.ui-rtl.css') }}" rel="stylesheet" type="text/css">
@endpush

@push('scripts')
    <script src="{{ @asset('tag-it/js/tag-it.js') }}"></script>
    <script src="{{ @asset('ckeditor/ckeditor.js') }}"></script>
@endpush

@if(Auth::user() || Auth::guard('admin')->check())
@push('js')
    <script>

        /* Answers */
        $('.edit-answer').click(function () {
            $(this).closest('.answer').find('.content').addClass('hide');
            $(this).closest('.answer').find('.edit-answer-form').addClass('show');
            $(this).parent().parent().find('.dropdown-btn').click();
        });

        $('.cancel-edit-answer').click(function () {
            $(this).closest('.answer').find('.content').removeClass('hide');
            $(this).closest('.answer').find('.edit-answer-form').removeClass('show');
        });

        /* Comments */
        $('.add-comment').click(function () {
            $(this).parent().find('.comment-form').addClass('show');
        });

        $('.edit-comment').click(function () {
            $(this).closest('.comment').find('.comment_content').addClass('hide');
            $(this).closest('.comment').find('.edit-comment-form').addClass('show');
            $(this).parent().parent().find('.dropdown-btn').click();
        });

        $('.cancel-edit-comment').click(function () {
            $(this).closest('.comment').find('.comment_content').removeClass('hide');
            $(this).closest('.comment').find('.edit-comment-form').removeClass('show');
        });

        /* Votes */
        $('.vote-btn').click(function () {

            var btn = $(this);
            var count = btn.parent().find('.count');
            var type = btn.attr('type');

            var question_id = null;
            var answer_id = null;
            if (btn.attr('question_id')) {
                question_id = btn.attr('question_id');
            } else if (btn.attr('answer_id')) {
                answer_id = btn.attr('answer_id');
            }

            $.post('{{ route('makeVote') }}', {
                _token: '{{ csrf_token() }}',
                question_id: question_id,
                answer_id: answer_id,
                type: type
            }, function (data) {
                if (data) {
                    count.html(data);
                    if (btn.hasClass('disabled')) {
                        btn.parent().find('.vote-btn').removeClass('disabled');
                        btn.removeClass('disabled');
                    } else {
                        btn.parent().find('.vote-btn').removeClass('disabled');
                        btn.addClass('disabled');
                    }
                }
            });
        });

        $("textarea").each(function(){
            CKEDITOR.replace(this, {
                language: '{{ LaravelLocalization::getCurrentLocale() }}'
            });
        });

    </script>
@endpush
@endif

@section('content')
    <div class="body-wrapper">
            <div class="main row">
                <div class="main-grid">
                    <div class="primary p-10-m">
                        <span class="page-title">
                            <i data-feather="help-circle"></i>
                            <h2>{{ $question->title }}</h2>
                        </span>
                        <div class="question-wrapper" question_id="{{ $question->id }}">
                            <div class="mobile-header mobile">
                                <a href="{{ route('profile', $question->user->id) }}"><img class="user-pic" src="{{ $question->user->picurl }}"></a>
                                <span class="askedby"><a href="{{ route('profile', $question->user->id) }}">{{ $question->user->fullname }}</a> {{ __('lang.asked') }} {{ $question->created_at->diffForHumans() }}</span>
                            </div>
                            <a href="{{ route('profile', $question->user->id) }}">
                                <img class="user-pic large" src="{{ $question->user->picurl }}" data-tippy-content="{{ $question->user->fullname }}">
                            </a>
                            <div class="question">
                                <div class="info">
                                    <div class="meta">
                                        <span class="meta-item author large">
                                            <a href="{{ route('profile', $question->user->id) }}">
                                                <i data-feather="user"></i>
                                                <span class="text">{{ $question->user->fullname }}</span>
                                            </a>
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
                                        <span class="meta-item views">
                                            <i data-feather="eye"></i>
                                            <span class="count">{{ $question->views }}</span>
                                            <span class="text">{{ $question->views == 1 || $question->views == 2 || $question->views > 10 ? __('lang.view') : __('lang.views') }}</span>
                                        </span>
                                        <div class="spacer"></div>
                                        @if(Auth::guard('admin')->check() || Auth::user() && Auth::user()->id == $question->user->id)
                                            <div class="dropdown">
                                                <div class="action-btn dropdown-btn">
                                                    <i data-feather="more-vertical"></i>
                                                </div>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('user.questions.edit', $question->id) }}"><i data-feather="edit"></i><span>{{ __('lang.edit') }}</span></a>
                                                    <form action="{{ route('user.questions.destroy', $question->id) }}" method="POST"
                                                          style="display: inline"
                                                          onsubmit="return confirm('{{ __('lang.are_you_sure') }}');">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        {{ csrf_field() }}
                                                        <button class="dropdown-item"><i data-feather="trash-2"></i><span>{{ __('lang.delete') }}</span></button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="content">{!! $question->content !!}</div>
                                    <div class="row-flex">
                                        <div class="question-tags">
                                            <i data-feather="tag"></i>
                                            @foreach($question->tags as $tag)
                                                <a href="{{ route('questions.tag', $tag->name) }}">{{ $tag->name }}</a>
                                            @endforeach
                                        </div>
                                        <div class="spacer"></div>
                                        @if(Auth::user() && Auth::user()->id != $question->user->id)
                                            @if(!Auth::user()->reported($question))
                                                <form action="{{ route('report.question') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                                                    <button class="btn btn-primary best-answer-btn end">
                                                        <i data-feather="alert-circle"></i>{{ __('lang.report') }}
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="vote">
                                @if (Auth::user())
                                    <button data-tippy-content="{{ __('lang.up_vote_question') }}"
                                            question_id="{{ $question->id }}"
                                            type="up"
                                            class="vote-btn up @if($question->voteType() == 'up') disabled @endif">
                                        <i data-feather="chevron-up"></i>
                                    </button>
                                    <span class="count">{{ $question->votesSum }}</span>
                                    <button data-tippy-content="{{ __('lang.down_vote_question') }}"
                                            question_id="{{ $question->id }}"
                                            type="down"
                                            class="vote-btn down @if($question->voteType() == 'down') disabled @endif">
                                        <i data-feather="chevron-down"></i>
                                    </button>
                                @else
                                    <button data-tippy-content="{{ __('lang.login_to_vote') }}"
                                            class="vote-btn">
                                        <i data-feather="chevron-up"></i>
                                    </button>
                                    <span class="count">{{ $question->votesSum }}</span>
                                    <button data-tippy-content="{{ __('lang.login_to_vote') }}"
                                            class="vote-btn">
                                        <i data-feather="chevron-down"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <span class="page-title">
                            <i data-feather="message-square"></i>
                            @if($question->answers->count() == 0)
                                <h2>{{ __('lang.no_answers') }}</h2>
                            @else
                                <h2>{{ __('lang.answers') }}: {{ $question->answers->count() }}</h2>
                            @endif
                        </span>
                        @foreach($answers as $answer)
                            <div class="answer-wrapper" answer_id="{{ $answer->id }}">
                                <div class="mobile-header mobile">
                                    <a href="{{ route('profile', $answer->user->id) }}"><img class="user-pic" src="{{ $answer->user->picurl }}"></a>
                                    <span class="askedby"><a href="">{{ $answer->user->fullname }}</a></span>
                                    <div class="vote"></div>
                                </div>
                                <a href="{{ route('profile', $answer->user->id) }}">
                                    <img class="user-pic large" src="{{ $answer->user->picurl }}" data-tippy-content="{{ $answer->user->fullname }}">
                                </a>
                                <div class="answer">
                                    <div class="info">
                                        <div class="meta">
                                            <span class="meta-item author large">
                                                <a href="{{ route('profile', $answer->user->id) }}">
                                                    <i data-feather="user"></i>
                                                    <span class="text">{{ $answer->user->fullname }}</span>
                                                </a>
                                            </span>
                                            <span class="meta-item time" data-tippy-content="{{ $answer->created_at->format('M d, Y - h:i') }}">
                                                <i data-feather="clock"></i>
                                                <span class="text">{{ $answer->created_at->diffForHumans() }}</span>
                                            </span>
                                            @if($answer->best)
                                                <span class="meta-item solved">
                                                    <i data-feather="check"></i>
                                                    <span class="text">{{ __('lang.best_answer') }}</span>
                                                </span>
                                            @endif
                                            <div class="spacer"></div>
                                            @if(Auth::guard('admin')->check() || Auth::user() && Auth::user()->id == $answer->user->id)
                                                <div class="dropdown">
                                                    <div class="action-btn dropdown-btn">
                                                        <i data-feather="more-vertical"></i>
                                                    </div>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item edit-answer"><i data-feather="edit"></i><span>{{ __('lang.edit') }}</span></a>
                                                        <form action="{{ route('user.answers.destroy', $answer->id) }}" method="POST"
                                                              style="display: inline"
                                                              onsubmit="return confirm('{{ __('lang.are_you_sure') }}');">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            {{ csrf_field() }}
                                                            <button class="dropdown-item"><i data-feather="trash-2"></i><span>{{ __('lang.delete') }}</span></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="content">{!! $answer->content !!}</div>
                                        @if(Auth::guard('admin')->check() || Auth::user() && Auth::user()->id == $answer->user->id)
                                            <div class="edit-answer-form">
                                                <form action="{{ route('user.answers.update', $answer->id) }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <textarea name="answer_content" rows="4">{{ $answer->content }}</textarea>
                                                    <button class="btn btn-primary">{{ __('lang.save') }}</button>
                                                    <div class="btn cancel-edit-answer">{{ __('lang.cancel') }}</div>
                                                </form>
                                            </div>
                                        @endif
                                        <div class="comments">
                                            <h4>{{ __('lang.comments') }}</h4>
                                            @forelse($answer->comments as $comment)
                                                <div class="comment">
                                                    <img src="{{ $comment->user->picurl }}" alt="" class="user-pic">
                                                    <div class="comment-wrapper">
                                                        <div class="inf">
                                                            <a href="{{ route('profile', $comment->user->id) }}">{{ $comment->user->fullname }}</a>
                                                            {{ __('lang.commented') }} {{ $comment->created_at->diffForHumans() }}
                                                            @if(Auth::guard('admin')->check() || Auth::user() && Auth::user()->id == $comment->user->id)
                                                                <div class="dropdown end">
                                                                    <div class="action-btn dropdown-btn">
                                                                        <i data-feather="more-vertical"></i>
                                                                    </div>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item edit-comment"><i data-feather="edit"></i><span>{{ __('lang.edit') }}</span></a>
                                                                        <form action="{{ route('user.comments.destroy', $comment->id) }}" method="POST"
                                                                              style="display: inline"
                                                                              onsubmit="return confirm('{{ __('lang.are_you_sure') }}');">
                                                                            {{ csrf_field() }}
                                                                            <input type="hidden" name="_method" value="DELETE">
                                                                            <button class="dropdown-item"><i data-feather="trash-2"></i><span>{{ __('lang.delete') }}</span></button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="content">{!! $comment->content !!}</div>
                                                        <div class="edit-comment-form">
                                                            <form action="{{ route('user.comments.update', $comment->id) }}" method="post">
                                                                @method('PUT')
                                                                @csrf
                                                                <textarea name="comment_content" rows="4">{{ $comment->content }}</textarea>
                                                                <button class="btn btn-primary">{{ __('lang.save') }}</button>
                                                                <div class="btn cancel-edit-comment">{{ __('lang.cancel') }}</div>
                                                            </form>
                                                        </div>
                                                        @if(Auth::user() && Auth::user()->id != $comment->user->id)
                                                            @if(!Auth::user()->reported($comment))
                                                                <form action="{{ route('report.question') }}" method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                                                    <button class="btn btn-primary best-answer-btn end">
                                                                        <i data-feather="alert-circle"></i>{{ __('lang.report') }}
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            @empty
                                                <p style="padding: 15px 0;">{{ __('lang.no_comments') }}</p>
                                            @endforelse
                                            @if(Auth::user())
                                                <a class="add-comment btn">{{ __('lang.comment') }}</a>
                                                <div class="comment-form">
                                                    <form action="{{ route('user.comments.store') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="answer_id" value="{{ $answer->id }}">
                                                        <textarea name="comment_content" rows="4"></textarea>
                                                        <button class="btn btn-primary save">{{ __('lang.save') }}</button>
                                                    </form>
                                                </div>
                                            @endif()
                                        </div>
                                        <div class="row-flex">
                                            <div class="spacer"></div>
                                            @if(Auth::user() && Auth::user()->id != $answer->user->id)
                                                @if(!Auth::user()->reported($answer))
                                                    <form action="{{ route('report.question') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="answer_id" value="{{ $answer->id }}">
                                                        <button class="btn btn-primary best-answer-btn end">
                                                            <i data-feather="alert-circle"></i>{{ __('lang.report') }}
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                            @if(Auth::user() && $question->user->id == Auth::user()->id)
                                                <form method="POST" action="{{ route('answers.best') }}">
                                                    @csrf
                                                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                                                    <input type="hidden" name="answer_id" value="{{ $answer->id }}">
                                                    <button class="btn best-answer-btn end @if($answer->best) unmark @else mark @endif">
                                                        @if($answer->best)
                                                            <i data-feather="x"></i>
                                                            {{ __('lang.unmark_as_best_answer') }}
                                                        @else
                                                            <i data-feather="check"></i>
                                                            {{ __('lang.mark_as_best_answer') }}
                                                        @endif
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="vote">
                                    @if (Auth::user())
                                        <button data-tippy-content="{{ __('lang.up_vote_answer') }}"
                                                answer_id="{{ $answer->id }}"
                                                type="up"
                                                class="vote-btn up @if($answer->voteType() == 'up') disabled @endif">
                                            <i data-feather="chevron-up"></i>
                                        </button>
                                        <span class="count">{{ $answer->votesSum }}</span>
                                        <button data-tippy-content="{{ __('lang.down_vote_answer') }}"
                                                answer_id="{{ $answer->id }}"
                                                type="down"
                                                class="vote-btn down @if($answer->voteType() == 'down') disabled @endif">
                                            <i data-feather="chevron-down"></i>
                                        </button>
                                    @else
                                        <button data-tippy-content="{{ __('lang.login_to_vote') }}"
                                                class="vote-btn">
                                            <i data-feather="chevron-up"></i>
                                        </button>
                                        <span class="count">{{ $answer->votesSum }}</span>
                                        <button data-tippy-content="{{ __('lang.login_to_vote') }}"
                                                class="vote-btn">
                                            <i data-feather="chevron-down"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        @if(Auth::user())
                            <span class="page-title">
                                <i data-feather="message-square"></i>
                                <h2>{{ __('lang.add_answer') }}</h2>
                            </span>
                            <div class="answer-form">
                                <img class="user-pic" src="{{ Auth::user()->picurl }}">
                                <div class="editor">
                                    <form method="POST" action="{{ route('answers.store') }}">
                                        @csrf
                                        <input type="hidden" name="question_id" value="{{ $question->id }}">
                                        <textarea name="answer_content" class="editor"></textarea>
                                        <button type="submit" class="btn btn-primary">{{ __('lang.add') }}</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="answer-auth panel">
                                <div class="panel-header">
                                    <h3>{{ __('lang.login_to_add_answer') }}</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="grid">
                                        <div class="register">
                                            <h4>{{ __('lang.create_new_account') }}</h4>
                                            <p>{{ __('lang.register_takes_few_seconds') }}</p>
                                            <a href="{{ route('register') }}" class="btn btn-primary">{{ __('lang.sign_up') }}</a>
                                        </div>
                                        <div class="login">
                                            <h4>{{ __('lang.login') }}</h4>
                                            <p>{{ __('lang.already_have_account') }}</p>
                                            <a href="{{ route('login') }}" class="btn btn-primary">{{ __('lang.sign_in') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @include('user.components.sidebar')
                </div>
            </div>
        </div>
@endsection
