<div class="ui blue inverted top fixed borderless menu">
    {{--
    <div class="link item" onclick="showMenu()">
        <a><i class="large bars icon"></i></a>
    </div> --}}
    <a href="{{ url('/home') }}" class="header item">
        <img src="{{ asset('images/logo.png')}}" alt="" class="ui avatar image">
          {{ config('app.name') }}
    </a>

    <div class="right menu">
        @auth
        <div class="item">{{ now()->toFormattedDateString() }}</div>
        <div class="ui dropdown link item">
            {{ auth()->user()->username }}
            <i class="dropdown icon"></i>
            <div class="menu">
                <a class="item" href=""><i class="ion-gear-b icon"></i> Account Settings</a>
                <div class="item" onclick="confirm()"><i class="ion-android-exit icon"></i>Logout</div>
            </div>
        </div>
        {{-- Logout Form --}}
        <form action="{{ route('logout') }}" method="POST" id="logout" style="display: hidden;">
            @csrf
        </form>
        @endauth @guest
        <a href="{{ url('login') }}" class="item">Login</a>
        <a href="{{ url('register') }}" class="item">Register</a> @endguest
    </div>
</div>
