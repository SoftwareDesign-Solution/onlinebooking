@extends('layouts.app')

@section('content')
    <div id="password-reset">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="email" value="{{ $email }}">

                        <h3>
                            Passwort ändern<br>
                        </h3>

                        <label for="password">Neues Passwort</label>

                        <input id="password" type="password"
                               class="@error('password') invalid @enderror"
                               name="password"
                               required autocomplete="new-password">

                        @error('password')
                        <div class="validation-error">
                            Passwort muss min. 9 Zeichen lang sein , ein Sonderzeichen (zum Beispiel !,?,$,%, etc.) und eine Zahl enthalten
                        </div>
                        @enderror

                        <label for="password-confirm">Passwort wiederholen</label>
                        <input id="password-confirm" type="password" class="form-control"
                               name="password_confirmation" required autocomplete="new-password">

                        <button type="submit" class="secondary">Passwort ändern</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
