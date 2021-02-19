@extends('layouts.app')

@section('content')
    <div id="register">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h3>Termine für deine Musik, registriere dich jetzt!</h3>

                    <div class="row">
                        <form class="col-lg-6" method="POST" action="{{ route('register') }}">
                            @csrf

                            <label for="name">Name</label>
                            <input id="name" type="text" class="@error('name') invalid @enderror"
                                   name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                            <div class="validation-error">
                                {{ $message }}
                            </div>
                            @enderror

                            <label for="phone">Telefonnummer</label>
                            <input id="phone" type="tel"
                                   class="@error('phone') invalid @enderror" name="phone"
                                   value="{{ old('phone') }}" required autocomplete="tel">
                            @error('phone')
                            <div class="validation-error">
                                Die eingegebene Telefonnummer ist ungültig.
                            </div>
                            @enderror

                            <label for="email">E-Mail Addresse</label>
                            <input id="email" type="email"
                                   class="@error('email') invalid @enderror" name="email"
                                   value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                            <div class="validation-error">
                                @if($message == 'validation.unique')
                                    E-Mail bereits vergeben
                                @else
                                    Ungültige E-Mail
                                @endif
                            </div>
                            @enderror

                            <label for="password">Passwort</label>

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

                            <div class="check-box-container">
                                <label class="checkbox-label">Hiermit bestätige ich die Richtigkeit aller Angaben zu
                                    meiner Person.</label>
                                <input type="checkbox" required>
                            </div>

                            <div class="check-box-container">
                                <label class="checkbox-label">Ich stimme zu, dass meine persönlichen Daten, nämlich
                                    Vorname, Nachname, Telefon & E-Mail zum Zweck der Proberaumreservierung verarbeitet
                                    werden.</label>
                                <input type="checkbox" required>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Jetzt registrieren
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
