<nav id="burger-menu">
    <div v-hide-burger-menu class="background"></div>
    <div class="navigation">
        <ul>
            <li class="{{ request()->path() == '/' ?  'active' : '' }}">
                <a href="/">Home</a>
            </li>
            <li><a href="/#anchor-rooms">Proberäume</a></li>
            <li><a href="/#anchor-additional-services">Zusatzleistungen</a></li>
            @auth
            <li class="{{ request()->path() == 'profile/bookings' ?  'active' : '' }}">
                <a href="/profile/bookings">Meine Termine</a>
            </li>
            @endauth
        </ul>
        @auth
            <form method="post" action="/logout">
                @csrf
                <button type="submit">Abmelden</button>
            </form>

            <form method="get" action="/profile">
                <button class="secondary" type="submit">Mein Profil</button>
            </form>
        @else
            <button v-hide-burger-menu v-show-popup="'login'" type="button">Anmelden</button>

            <form method="get" action="/register">
                <button class="secondary">Registrieren</button>
            </form>
        @endauth
    </div>
</nav>
