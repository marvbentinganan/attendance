@extends('layouts.app')

@section('left')
    @include('partials.left-menu')
@endsection

@section('content')
<div class="ui top attached large breadcrumb segment">
    <a href="{{ url('/home') }}" class="section">Dashboard</a>
    <div class="divider"><i class="blue ion-chevron-right icon"></i></div>
</div>
<div class="ui attached segment">
    Content Here
</div>
@endsection

@section('right')

@endsection
