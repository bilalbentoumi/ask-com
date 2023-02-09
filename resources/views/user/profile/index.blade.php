@extends('user.layouts.app')

@section('title', $user->fullname . ' - ' . __('lang.profile'))

@if(Auth::user() && Auth::user()->id == $user->id)
    @push('js')
        <script>
            $(document).ready(function () {

                /* Upload Picture */
                $("[name='picture']").change(function () {
                    $('#change_picture').submit();
                });

                $('#change_picture').on('submit', function(event){
                    event.preventDefault();
                    $.ajax({
                        url:"{{ route('profile.picture') }}",
                        method:"POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success:function(data) {
                            location.reload();
                        }, error: function (xhr, status, error) {
                            alert(error);
                        }
                    });
                });

                /* Upload Cover */
                $("[name='cover']").change(function () {
                    $('#change_cover').submit();
                });

                $('#change_cover').on('submit', function(event){
                    event.preventDefault();
                    $.ajax({
                        url:"{{ route('profile.cover') }}",
                        method:"POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success:function(data) {
                            location.reload();
                        }, error: function (xhr, status, error) {
                            alert(error);
                        }
                    })
                });

            });
        </script>
    @endpush
@endif

@section('content')
    <div class="profile-cover" style="background-image: url('{{ $user->coverurl }}'); ">
        <div class="row row-flex center relative">
            <div class="profile-picture">
                <img src="{{ $user->picurl }}">
                @if(Auth::user() && Auth::user()->id == $user->id)
                    <div class="change-picture"><i data-feather="camera"></i></div>
                    <form id="change_picture" action="{{ route('profile.picture') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="picture" accept="image/*" data-tippy-content="{{ __('lang.change_profile_picture') }}"/>
                    </form>
                @endif
            </div>
            <div class="profile-info">
                <h4>{{ $user->first_name . ' ' . $user->last_name }}</h4>
                <span class="profile-link">{{ $user->pointscount }} {{ __('lang.points') }}</span>
                @if(Auth::user() && Auth::user()->id == $user->id)
                    <a href="{{ route('settings.general') }}" class="edit-btn">
                        <i data-feather="edit-3"></i>
                        <span>{{ __('lang.profile_settings') }}</span>
                    </a>
                @endif
            </div>
            @if(Auth::user() && Auth::user()->id == $user->id)
                <div class="cover-image">
                    <i data-feather="camera"></i>
                    <form id="change_cover" action="{{ route('profile.picture') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="cover" accept="image/*" data-tippy-content="{{ __('lang.change_cover_image') }}"/>
                    </form>
                </div>
            @endif
        </div>
    </div>
    <div class="body-wrapper">
        <div class="row p-10-m">
            <div class="profile-grid">
                <div class="panel about">
                    <div class="panel-header">
                        <h2>{{ __('lang.about') }}</h2>
                    </div>
                    <div class="panel-body">
                        <div class="bio">
                            <h4>{{ __('lang.biography') }}</h4>
                            <p>{{ $user->bio }}</p>
                        </div>
                        <div class="social-media">
                            <h4>{{ __('lang.follow_me_on') }}</h4>
                            @if($user->facebook)
                                <a href="{{ $user->facebook }}" class="sm-item facebook"><i data-feather="facebook"></i></a>
                            @endif
                            @if($user->twitter)
                                <a href="{{ $user->twitter }}" class="sm-item twitter"><i data-feather="twitter"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="panel questions">
                    <div class="panel-header">
                        <h2>{{ __('lang.last_questions_by_user') . ' ' . $user->fullname }}</h2>
                    </div>
                    <div class="panel-body">
                        <div class="questions">
                            @forelse($user->questions as $question)
                                <div>
                                    <a href="{{ $question->url }}">{{ $question->title }}</a>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="panel stats">
                    <div class="panel-header">
                        <h2>{{ __('lang.stats') }}</h2>
                    </div>
                    <div class="panel-body">
                        <div><b>{{ __('lang.questions') }}: {{ $user->questions->count() }}</b></div>
                        <div><b>{{ __('lang.answers') }}: {{ $user->answers->count() }}</b></div>
                        <div><b>{{ __('lang.points') }}: {{ $user->pointscount }}</b></div>
                        <div><b>{{ __('lang.best_answers') }}: {{ $user->bestanswers->count() }}</b></div>
                    </div>
                </div>
                <div class="panel interests">
                    <div class="panel-header">
                        <h2>{{ __('lang.interests') }}</h2>
                    </div>
                    <div class="panel-body">
                        {{ $user->interests_string() }}
                    </div>
                </div>
                <div class="panel answers">
                    <div class="panel-header">
                        <h2>{{ __('lang.last_answers') }}</h2>
                    </div>
                    <div class="panel-body">
                        <div class="answers">
                            @forelse($user->answers as $answer)
                                <div>
                                    <p>{{ __('lang.answerd') }} <a href="{{ $answer->question->url }}" data-tippy-content="{{ $answer->question->title }}">{{ mb_substr($answer->question->title, 0, 30) }} ...</a></p>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection