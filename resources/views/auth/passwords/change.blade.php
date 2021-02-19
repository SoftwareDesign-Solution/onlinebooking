@extends('layouts.app')

@section('content')
    <div id="password-reset">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form method="POST" action="{{ route('password.change') }}">
                        @csrf
                        <h3>
                            Passwort ändern<br>
                        </h3>

                        <label for="old-password">Altes Passwort</label>

                        <input id="old-password" type="password"
                               class="@error('old-password') invalid @enderror"
                               name="old-password"
                               required autocomplete="new-password">

                        @error('old-password')
                        <div class="validation-error">
                            Das Passwort ist falsch
                        </div>
                        @enderror

                        <label for="password">Neues Passwort</label>

                        <input id="password" type="password"
                               class="@error('password') invalid @enderror"
                               name="password"
                               required autocomplete="new-password">

                        @error('password')
                        <div class="validation-error">
                            Passwort muss min. 9 Zeichen lang sein , ein Sonderzeichen und eine Zahl enthalten
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
