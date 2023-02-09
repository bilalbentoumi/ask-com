@if($questions->count())
    @foreach($questions as $question)
        <div class="item">
            <img src="{{ $question->user->picurl }}" class="user-pic">
            <a href="{{ $question->url }}">{{ $question->title }}</a>
        </div>
    @endforeach
    <style>
        .result .item {
            display: flex;
            padding: 10px;
            border-bottom: solid 1px #EEE;
        }
        .result .item a {
            flex: 1;
            padding: 0;
            font-family: 'Nunito', 'Swissra';
            font-weight: 500;
            font-size: 14px;
        }
    </style>
@endif