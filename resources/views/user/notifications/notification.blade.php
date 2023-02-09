<div class="btn" data-tippy-content="الإشعارات">
    @if(Helper::notifications_count() > 0)
        <span class="badge">{{ Helper::notifications_count() }}</span>
    @endif
    <i data-feather="globe"></i>
</div>
<div class="dropdown-menu notifications">
    @forelse(Helper::notifications() as $notification)
        <div class="item @if(!$notification->read) not-read @endif">
            <div class="pic">
                <img src="{{ @asset('images/bilal.png') }}" alt="">
            </div>
            <div class="info">
                <a href="{{ $notification->url }}" notid="{{ $notification->id }}">
                    @if($notification->type == 'answer')
                        قام {{ $notification->nuser->name }} بالإجابة على سؤالك '{{ $notification->title }}'
                    @elseif($notification->type == 'best')
                        قام {{ $notification->nuser->name }} بتعليم إجابتك كأفضل إجابة على سؤاله '{{ $notification->title }}'
                    @endif
                </a>
            </div>
            @if(!$notification->read)
                <div class="status" notid="{{ $notification->id }}" data-tippy-content="تحديد كمقروء"></div>
            @endif
        </div>
    @empty
        لا يوجد إشعارات
    @endforelse
</div>

