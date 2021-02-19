@extends('layouts.app')

@section('content')
    <div id="password-reset">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <h3>
                            Passwort vergessen?<br>
                            Deine E-Mail-Adresse bitte
                        </h3>

                        <label for="email">E-Mail Addresse</label>
                        <input id="email" type="email"
                               class="@error('email') invalid @enderror" name="email"
                               value="{{ old('email') ?? request()->query('email') }}" required autocomplete="email">
                        @error('email')
                        <div class="validation-error">
                            Ungültige E-Mail
                        </div>
                        @enderror

                        <button type="submit" class="secondary">E-Mail senden</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
