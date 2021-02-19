@extends('layouts.app')

@section('content')
    <div id="profile">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h1>Mein Profil</h1>

                    <simple-toggle default="data" :options="[
                        { link: '/profile/bookings', value: 'bookings', label: 'Meine Termine'},
                        { value: 'data', label: 'Meine Daten'}
                    ]"></simple-toggle>

                    <profile-form></profile-form>
                </div>
            </div>
        </div>
    </div>
@endsection
