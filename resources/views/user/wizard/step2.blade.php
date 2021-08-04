@extends('user.layouts.app')

@section('title', 'إسأل.كوم')

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
                    url: '{{ route('wizard.step2.store') }}',
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

        });
    </script>
@endpush

@section('content')
    <div class="body-wrapper">
        <div class="main row">
            <div class="panel wizard">
                <div class="panel-header">
                    <div class="wizard-steps">
                        <div class="wizard-step">1</div>
                        <div class="wizard-step active">2</div>
                        <div class="wizard-step">3</div>
                    </div>
                </div>
                <form action="{{ route('wizard.step2.store') }}" method="post" id="change_picture" enctype="multipart/form-data">
                    @csrf
                    <div class="panel-body">
                        <div class="content row-flex margin-auto">
                        <div class="field col-100">
                            <h2>{{ __('lang.profile_picture') }}</h2>
                        </div>
                        <div class="field col-100 {{ $errors->has('picture') ? 'has-error' : '' }}">
                            <div class="profile-picture">
                                <img src="{{ Auth::user()->picurl }}">
                                <div class="change-picture"><i data-feather="camera"></i></div>
                                <input type="file" name="picture" accept="image/*" data-tippy-content="{{ __('lang.change_profile_picture') }}"/>
                            </div>
                        </div>
                        <div class="field col-100">
                            <button onclick="location.href = '{{ route('wizard.step1') }}'" class="btn btn-primary start">{{ __('lang.previous') }}</button>
                            @if(strpos(Auth::user()->picurl, "noimg") != false)
                                <a href="{{ route('wizard.step3') }}" class="btn end">{{ __('lang.skip') }}</a>
                            @else
                                <button onclick="event.preventDefault();location.href = '{{ route('wizard.step3') }}'" class="btn btn-primary end">{{ __('lang.next') }}</button>
                            @endif
                        </div>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection