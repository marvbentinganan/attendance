@extends('layouts.app') @push('header_scripts')
@endpush
@section('left')
    @include('partials.left-menu')
@endsection

@section('content')
<div class="ui top attached large breadcrumb segment">
    <a href="{{ url('/home') }}" class="section"><i class="home icon"></i>Home</a>
    <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
    <a href="{{ route('reports') }}" class="section">Reports</a>
</div>
<div class="ui top attached header">List of Events</div>
<div class="ui attached segment">
    <table class="ui unstackable compact celled table">
        <thead>
            <th class="center aligned">#</th>
            <th class="center aligned">Name</th>
            <th class="center aligned">Duration</th>
            <th class="center aligned">Action</th>
        </thead>
        <tbody>
            @foreach($events as $key => $event)
            <tr>
                <th class="center aligned">{{ ++$key }}</th>
                <td>{{ $event->name }}</td>
                <td>{{ $event->from->toFormattedDateString() }} to {{ $event->to->toFormattedDateString() }}</td>
                <td>
                    <a href="{{ route('event.attendance', $event->slug) }}" class="ui primary mini circular icon button"><i class="ion-eye icon"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('right')
@endsection
 @push('footer_scripts')
@endpush
