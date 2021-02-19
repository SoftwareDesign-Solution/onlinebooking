<nav class="top-navigation">
    <div class="container">
        <div v-show-burger-menu class="burger-menu-icon"></div>
        <div class="spacer mobile"></div>
        <a href="/" class="logo">
            @svg('/assets/icons/logo-text.svg')
        </a>
        <div class="spacer"></div>
        <div class="navigation-items">
            <ul>
                <li class="{{ request()->path() == '/' ?  'active' : '' }}">
                    <a href="/">Home</a>
                </li>
                @auth
                <li class="{{ request()->path() == 'profile/bookings' ?  'active' : '' }}">
                    <a href="/profile/bookings">Meine Termine</a>
                </li>
                @endauth
                <li class="dropdown-navigation">
                    <div class="label">Proberäume</div>
                    @svg('/assets/icons/angle-down.svg', 'caret')
                    <ul class="items">
                        @foreach($rooms as $room)
                            @if($room->active)
                                <li class="{{ request()->path() == "rooms/$room->id" ? 'active' : 'inactive' }}">
                                    <a href="/rooms/{{ $room->id }}">{{ $room->name }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
        @auth
            <div class="auth">
                <a href="/profile" class="user">
                    <div class="user-name">
                        {{ Auth::user()->name }}
                    </div>

                    @svg('/assets/icons/user-filled.svg', 'user-icon')
                </a>
                <form action="/logout" method="post">
                    @csrf
                    <button class="secondary" type="submit">Abmelden</button>
                </form>
            </div>
            <div class="auth-mobile">
                <nav-popup-close-button>
                    <a href="/profile" class="user-icon">
                        @svg('/assets/icons/user-filled.svg')
                    </a>
                </nav-popup-close-button>
            </div>
        @else
            <div class="auth">
                <button v-show-popup="'login'" type="button">Anmelden</button>
            </div>
            <div class="auth-mobile">
                <nav-popup-close-button>@svg('/assets/icons/user.svg', 'user-icon')</nav-popup-close-button>
            </div>
        @endauth
    </div>
</nav>
