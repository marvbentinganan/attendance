@extends('layouts.app') @push('header_scripts')
<script src="{{ asset('plugins/vuejs/vue.js') }}"></script>


@endpush
@section('left')
    @include('partials.left-menu')
@endsection

@section('content')
<div class="ui top attached large breadcrumb segment">
    <a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
    <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
    <a href="{{ route('reports') }}" class="section">Reports</a>
    <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
    <a href="{{ route('event.attendance', $event->slug) }}" class="section">{{ $event->name }}</a>
</div>
<div class="ui hidden divider"></div>
<div class="ui centered header">List of Attendees for {{ $event->name }}</div>
<div class="ui top attached segment">
    <div class="ui fluid icon input">
        <input type="text" name="keyword" v-model="keyword" id="" placeholder="Search for Student...">
        <i class="inverted circular search icon"></i>
    </div>
</div>
<table class="ui attached unstackable compact celled table">
    <thead>
        <th class="three wide center aligned">ID Number</th>
        <th class="ten wide center aligned">Name</th>
        <th class="three wide center aligned">Action</th>
    </thead>
    <tbody>
        <tr v-for="attendee in filteredAttendees">
            <td class="center aligned">@{{ attendee.id_now }}</td>
            <td>@{{ attendee.firstname }} @{{ attendee.lastname }}</td>
            <td class="center aligned">
                <button class="ui mini fluid teal icon button" @click="getRecord(attendee.id)"><i class="ion-ios-albums icon"></i> Load Record</button>
            </td>
        </tr>
    </tbody>
</table>
@endsection

@section('right')
<div class="ui raised card" v-if="records != null">
    <div class="image">
        <img src="{{ asset('images/avatar.jpg') }}" alt="">
    </div>
    <div class="content">
        <div class="header">@{{ records.student.firstname }} @{{ records.student.lastname }}</div>
        <div class="description">
            <table class="ui small compact unstackable celled table">
                <thead>
                    <th class="center aligned">Date</th>
                    <th class="center aligned">AM</th>
                    <th class="center aligned">PM</th>
                </thead>
                <tbody>
                    <tr v-for="record in records.attendances">
                        <td class="center aligned">@{{ record.day }}</td>
                        <td class="center aligned" v-if="record.morning == true">
                            <i class="large green ion-ios-checkmark icon"></i>
                        </td>
                        <td class="center aligned" v-else>
                            <i class="large red ion-ios-close icon"></i>
                        </td>
                        <td class="center aligned" v-if="record.afternoon == true">
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
@endsection
 @push('footer_scripts')
<script src="{{ asset('plugins/axios/axios.min.js') }}"></script>
<script>
    new Vue({
		el: '#app',
		data: {
            keyword : '',
            attendees : {
                firstname : '',
                lastname : '',
                id_now : '',
                id_number : ''
            },
            records : {
                student : '',
                attendances : {}
            },
        },
        computed : {
            filteredAttendees(){
                let attendees = this.attendees
                if (this.keyword && this.keyword != null) {
                    attendees = attendees.filter((attendee) => {
                        return attendee.id_now.indexOf(this.keyword) !== -1
                    })
                }
                return attendees
            }
        },
		methods: {
			init() {
               // Initialize Console Log
               console.log('Initializing ...');
               this.getAttendees();
            },

            getAttendees(){
                var route = '{{ route('event.attendees', $event->slug) }}';
                axios.get(route)
                .then(response => {
                    this.attendees = response.data;
                })
                .catch(error => {
                    console.log(error.response.data);
                });
            },

            getRecord(id){
                var route = '{{ url('reports') }}' + '/' + '{{ $event->slug }}' + '/' + id
                axios.get(route)
                .then(response => {
                    this.records = response.data;
                })
                .catch(error => {
                    console.log(error.response.data);
                })
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
