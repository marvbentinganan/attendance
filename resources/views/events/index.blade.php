@extends('layouts.app')
@section('left')
@include('partials.left-menu')
@endsection

@section('content')
<div class="ui top attached large breadcrumb segment">
    <a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
    <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
    <a href="{{ route('events') }}" class="section">Events</a>
    <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
</div>
<div class="ui attached segment">
    <form method="POST" id="event-form" class="ui form">
        @csrf
        <div class="field">
            <label for="name">Name of Event</label>
            <div class="ui left icon input">
                <input type="text" name="name" id="name" value="{{ old('name') }}">
                <i class="ion-calendar icon"></i>
            </div>
        </div>
        <div class="field">
            <label for="description">Description of Event</label>
            <textarea name="description" id="description" cols="30" rows="5">{{ old('description') }}</textarea>
        </div>
        <div class="two fields">
            <div class="field">
                <label>From</label>
                <div class="ui calendar" id="rangestart">
                    <div class="ui input left icon">
                        <i class="calendar icon"></i>
                        <input type="text" name="from" placeholder="Start">
                    </div>
                </div>
            </div>
            <div class="field">
                <label>To</label>
                <div class="ui calendar" id="rangeend">
                    <div class="ui input left icon">
                        <i class="calendar icon"></i>
                        <input type="text" name="to" placeholder="End">
                    </div>
                </div>
            </div>
        </div>
        <div class="ui sub header">Event Controls</div>
        <div class="two fields">
            <div class="field">
                <div class="field">
                    <label>From (Morning)</label>
                    <div class="ui calendar" id="from_morning">
                        <div class="ui input left icon">
                            <i class="ion-clock icon"></i>
                            <input type="text" name="from_morning" placeholder="From">
                        </div>
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="field">
                    <label>To (Morning)</label>
                    <div class="ui calendar" id="to_morning">
                        <div class="ui input left icon">
                            <i class="ion-clock icon"></i>
                            <input type="text" name="to_morning" placeholder="To">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="two fields">
            <div class="field">
                <div class="field">
                    <label>From (Afternoon)</label>
                    <div class="ui calendar" id="from_afternoon">
                        <div class="ui input left icon">
                            <i class="ion-clock icon"></i>
                            <input type="text" name="from_afternoon" placeholder="From">
                        </div>
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="field">
                    <label>To (Afternoon)</label>
                    <div class="ui calendar" id="to_afternoon">
                        <div class="ui input left icon">
                            <i class="ion-clock icon"></i>
                            <input type="text" name="to_afternoon" placeholder="To">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="field">
            <button type="submit" class="ui primary submit icon button"><i class="ion-calendar icon"></i> Add Event</button>
        </div>
    </form>
</div>
@endsection

@section('right')
    <div id="event-container">

    </div>
@endsection
@push('footer_scripts')
<script src="{{ asset('js/semantic-ui/calendar.min.js') }}"></script>
<script src="{{ asset('plugins/axios/axios.min.js') }}"></script>
<script>
    getEvents();

    $('#rangestart').calendar({
        type: 'date',
        endCalendar: $('#rangeend'),
    });

    $('#rangeend').calendar({
        type: 'date',
        startCalendar: $('#rangestart')
    });

    $('#from_morning').calendar({
        type: 'time',
        ampm: false,
        endCalendar: $('#to_morning')
    });

    $('#to_morning').calendar({
        type: 'time',
        ampm: false,
        startCalendar: $('#from_morning')
    });

    $('#from_afternoon').calendar({
        type: 'time',
        ampm: false,
        endCalendar: $('#to_afternoon')
    });

    $('#to_afternoon').calendar({
        type: 'time',
        ampm: false,
        startCalendar: $('#from_afternoon')
    });

    $('#event-form').submit(function(event){
        event.preventDefault();
        var route = '{{  route('event.add') }}';
        var data = $('#event-form').serialize();
        axios.post(route, data)
        .then(response => {
            $('.form')[0].reset('form');
            getEvents(),
            toastr.success(response.data);
        })
        .catch(error => {
            console.log(error.response.data);
        })
    });

    function getEvents(){
        axios.get('{{ route('events.list') }}')
        .then(response => {
            $('#event-container').html(response.data);
        })
        .catch(error => {
            console.log(error.response.data);
        })
    }
</script>
@endpush
