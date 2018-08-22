@extends('layouts.auth')
@section('title') Register
@endsection

@section('content')
<div class="six wide computer only six wide tablet only fourteen wide mobile only column">
    <div class="ui center aligned segment">
        <div class="ui huge blue header">{{ config('app.name') }}
            <div class="ui sub header">Register</div>
        </div>
        <form action="{{ route('register') }}" method="POST" class="ui form">
            @csrf
            <div class="field">
                <div class="ui right icon input">
                    <input type="text" id="firstname" name="firstname" placeholder="Firstname" value="{{ old('firstname') }}" autofocus>
                    <i class="ion-ios-contact icon"></i>
                </div>
            </div>
            <div class="field">
                <div class="ui right icon input">
                    <input type="text" id="lastname" name="lastname" placeholder="Lastname" value="{{ old('lastname') }}">
                    <i class="ion-ios-contact icon"></i>
                </div>
            </div>
            <div class="field">
                <div class="ui right icon input">
                    <input type="text" id="username" name="username" placeholder="Username" value="{{ old('username') }}">
                    <i class="ion-ios-contact icon"></i>
                </div>
            </div>
            <div class="field">
                <div class="ui right icon input">
                    <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}">
                    <i class="ion-email icon"></i>
                </div>
            </div>
            <div class="field">
                <div class="ui right icon input">
                    <input type="password" id="password" name="password" placeholder="Password">
                    <i class="ion-locked icon"></i>
                </div>
            </div>
            <div class="field">
                <div class="ui right icon input">
                    <input type="password" id="password-confirm" name="password_confirmation" placeholder="Confirm Password" required>
                    <i class="ion-locked icon"></i>
                </div>
            </div>
            <div class="field">
                <button type="submit" class="ui fluid primary submit icon button">
					<i class="ion-person-add icon"></i> Register
				</button>
            </div>
            <div class="ui error message"></div>
        </form>
    </div>
</div>
@endsection
 @push('footer_scripts')
<script>
    $('.ui.form').form({
        fields:{
            firstname: {
                identifier: 'firstname',
                rules: [{
                    type : 'empty',
                    prompt : 'Please enter your Firstname'
                }]
            },
            lastname: {
                identifier : 'lastname',
                rules: [{
                    type : 'empty',
                    prompt : 'Please enter your Lastname'
                }]
            },
            username: {
                identifier: 'username',
                rules: [{
                    type : 'empty',
                    prompt : 'Please enter your Username'
                }]
            },
            email: {
                identifier: 'email',
                rules: [{
                    type : 'email',
                    prompt : 'Please enter a valid email address'
                }]
            },
            password: {
                identifier: 'password',
                rules: [{
                    type : 'empty',
                    prompt : 'Please provide a password'
                }]
            },
            password_confirmation: {
                identifier: 'password-confirm',
                rules: [{
                    type : 'match[password]',
                    prompt : 'Passwords do not match'
                }]
            }
        },
        on: 'blur',
        inline: true
    });
</script>

@endpush
