@extends('layouts.app') @push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>

@endpush
@section('left') {{--
    @include('partials.left-menu') --}}
<div class="ui top attached header"><i class="ion-calendar icon"></i>Event Details</div>
<div class="ui attached segment">
    <div class="ui centered sub header">
        {{ $event->name }}
    </div>
    <p>
        {{ $event->description }}
    </p>
    <div class="ui hidden divider"></div>
    <div class="ui item list">
        <div class="item"><i class="calendar icon"></i> From: {{ $event->from->toFormattedDateString() }}</div>
        <div class="item"><i class="calendar icon"></i> To: {{ $event->to->toFormattedDateString() }}</div>
    </div>
</div>
@endsection

@section('content') {{--
<div class="ui top attached large breadcrumb segment">
    <a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
    <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
    <a href="{{ route('events') }}" class="section">Events</a>
    <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
    <a href="{{ route('events') }}" class="section">{{ $event->name }}</a>
    <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
</div> --}}
<div class="ui hidden divider"></div>
<div class="ui huge centered header">{{ $event->name }}</div>
<div class="ui hidden divider"></div>
<form action="" method="POST" id="attendance-form" class="ui form" @submit.prevent="recordAttendance()">
    @csrf
    <div class="field">
        <div class="ui large left labeled icon input">
            <div class="ui blue label"><i class="address book icon"></i>Scan Your ID:</div>
            <input type="text" name="id_number" v-model="query.id_now" id="" autofocus>
        </div>
    </div>
</form>
<div class="ui hidden divider"></div>
<div class="ui top attached header">Attendance Record</div>
<div class="ui attached segment">
    <div class="ui items">
        <div class="item">
            <div class="image">
                <img src="{{ asset('images/avatar.jpg') }}" alt="" class="ui small image">
            </div>
            <div class="content">
                <div class="header">@{{ recent.student.firstname }} @{{ recent.student.lastname }}</div>
                <div class="right floated meta">
                    <span class="date"><i class="blue address card icon"></i> @{{ recent.student.id_now }}</span>
                </div>
                <div class="description">
                    <table class="ui celled structured compact blue table">
                        <thead>
                            <th class="center aligned"><i class="ion-calendar icon"></i></th>
                            <th class="center aligned">AM</th>
                            <th class="center aligned">PM</th>
                        </thead>
                        <tbody v-for="attendance in recent.results">
                            <tr>
                                <th class="center aligned">@{{ attendance.day }}</th>
                                <td class="center aligned" v-if="attendance.morning == true">
                                    <i class="large green ion-ios-checkmark icon"></i>
                                </td>
                                <td class="center aligned" v-else>
                                    <i class="large red ion-ios-close icon"></i>
                                </td>
                                <td class="center aligned" v-if="attendance.afternoon == true">
                                    <i class="large green ion-ios-checkmark icon"></i>
                                </td>
                                <td class="center aligned" v-else>
                                    <i class="large red ion-ios-close icon"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('right')
<div class="ui top attached header"><i class="ion-person icon"></i>Recent Attendees</div>
<div class="ui attached segment">
    <div class="ui small feed">
        <div v-for="attendee in attendees" class="event">
            <div class="label">
                <img src="{{ asset('images/avatar.jpg') }}" alt="">
            </div>
            <div class="content">
                <div class="summary">
                    <a href="" class="user">@{{ attendee.student.firstname }} @{{ attendee.student.lastname }}</a>
                    <div class="date">@{{ attendee.recorded_at }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
 @push('footer_scripts')
<script src="{{ asset('plugins/axios/axios.min.js') }}"></script>
<script>
    new Vue({
		el: '#app',
		data: {
			query : {
                id_now : '',
            },
            attendees : {},
            recent : {
                student : {},
                results : {},
                message : undefined
            }
		},
		methods: {
			init() {
               // Initialize Console Log
               console.log('Initializing ...');
               this.getRecent();
               this.getAttendees();
            },

            getAttendees(){
                var route = '{{ route('attendance.attendees', $event->slug) }}';
                axios.get(route)
                .then(response => {
                    this.attendees = response.data;
                })
                .catch(error => {
                    console.log(error.response.data);
                });
            },

            getRecent(){
                var route = '{{ route('attendance.recent', $event->slug) }}';
                axios.get(route)
                .then(response => {
                    this.recent = response.data,
                    console.log(this.recent);
                })
                .catch(error => {
                    console.log(error.response.data);
                });
            },

            recordAttendance(){
                var route = '{{ route('attendance.record', $event->slug) }}';
                axios.post(route, this.$data.query)
                .then(response => {
                    this.recent = response.data,
                    toastr.success(this.recent.message),
                    this.getAttendees(),
                    this.query.id_now = null,
                    $('form .input').focus();
                })
                .catch(error => {
                    console.log(error.response.data),
                    toastr.error("No Record Found");
                });
            }
         },
         created() {
         	this.init();
            // setInterval(function (){
            //    this.getAttendees();
            // }.bind(this), 30000);
         }
      });
</script>

@endpush
