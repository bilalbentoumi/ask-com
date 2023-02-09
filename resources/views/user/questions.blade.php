<script>

    $(document).ready(function () {

        var current = 1;
        var last = parseInt($("[name='lastpage']").val());

        function loadmore() {
            $.get('{{ route($route) }}', {
                page: current
            }, function (data){
                $('.questions-stack').append(data);
                refresh();
                if (current == last)
                    $('#loadmore').hide();
                current++;
                $("[name='current']").val(current);
            });
        }

        loadmore();

        $('#loadmore').click(function () {
            loadmore();
        });
    });

</script>


<input type="hidden" value="{{ $last }}" name="lastpage">
@if(Route::is('questions.interested'))
    <span>{{ __('lang.show_questions_by_interests') }}: </span>
    {{ Auth::user()->interests_string() }}
@endif
<div class="questions-stack"></div>
<div class="btn btn-primary w-100" id="loadmore">{{ __('lang.loadmore') }}</div>