    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3>Bevor du buchst, musst du dich noch anmelden!</h3>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="E-Mail Addresse">
                    <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Passwort">
                    <button type="submit">Anmelden</button>
                </form>
            </div>
        </div>
    </div>
    <hr>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <p>
                    Noch kein Mitglied? <a href="/register">Jetzt registrieren</a>
                </p>
                <p>
                    <a href="{{ route('password.request') }}">Passwort vergessen</a>
                </p>
            </div>
        </div>
    </div>
