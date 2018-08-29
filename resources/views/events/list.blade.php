<div class="ui top attached header">
    <i class="ion-calendar icon"></i> Recent Events
</div>
<div class="ui attached segment">
    @if($events != null)
    <div class="ui relaxed divided items">
        @foreach($events as $event)
        <div class="item">
            <div class="content">
                <div class="header">{{ $event->name }}</div>
                <div class="meta">
                    <span class="date"><i class="ion-calendar icon"></i>From : {{ $event->from->toFormattedDateString() }}</span>
                    <span class="date"><i class="ion-calendar icon"></i>To : {{ $event->to->toFormattedDateString() }}</span>
                    <span class="date">{{ $event->duration }} days</span>
                </div>
                <div class="description">
                    {{ $event->description }}
                </div>
                <div class="extra">
                    <div class="ui three mini buttons">
                        <a href="{{ route('event.show', $event->slug) }}" class="ui mini blue icon button"><i class="ion-share icon"></i> Open</a>
                        <button class="ui mini teal icon button"><i class="ion-edit icon"></i> Update</button>
                        <button class="ui mini red icon button"><i class="ion-trash-a icon"></i> Delete</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="ui info message">
        <i class="ion-info icon"></i>
        <div class="content">
            <div class="header">No Results Founds</div>
            <p>No Events Available</p>
        </div>
    </div>
    @endif
</div>
