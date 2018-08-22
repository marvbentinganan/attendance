@extends('layouts.auth')
@section('title') Sign In
@endsection

@section('content')
<div class="six wide computer only six wide tablet only fourteen wide mobile only column">
    <div class="ui segment">
        <div class="ui huge centered blue header">{{ config('app.name') }}
            <div class="ui sub header">Login</div>
        </div>
        <form action="{{ route('login') }}" method="POST" class="ui form">
            @csrf
            <div class="field">
                <label for="username">Username</label>
                <div class="ui right icon input">
                    <input type="text" id="username" name="username" placeholder="Username" value="{{ old('username') }}" autofocus>
                    <i class="ion-ios-contact icon"></i>
                </div>
            </div>
            <div class="field">
                <label for="password">Password</label>
                <div class="ui right icon input">
                    <input type="password" id="password" name="password" placeholder="Password">
                    <i class="ion-locked icon"></i>
                </div>
            </div>
            <div class="field">
                <div class="ui checkbox">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Keep Me Logged In</label>
                </div>
            </div>
            <div class="field">
                <button type="submit" class="ui fluid primary submit icon button">
					<i class="ion-log-in icon"></i> Sign In
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
			username: {
				identifier: 'username',
				rules: [{
					type : 'empty',
					prompt : 'Please enter your Username'
				}]
			},
			password: {
				identifier: 'password',
				rules: {[
					type : 'empty',
					prompt : 'Please enter your correct Password'
				]}
			}
        },
        on: 'blur',
        inline: true
	});

</script>

@endpush
