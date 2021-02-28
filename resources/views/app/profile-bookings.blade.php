@extends('layouts.app')

@section('content')
    <div id="profile">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h1>Mein Profil</h1>

                    <simple-toggle :options="[
                        { value: 'bookings', label: 'Meine Termine'},
                        { link: '/profile', label: 'Meine Daten'}
                    ]"></simple-toggle>

                    @if(sizeof($bookings) == 0)
                        <p>Du hast keine gebuchten Termine</p>
                    @endif

                    <div class="bookings">
                        @foreach($bookings as $date => $bookingsForDate)
                            <div class="date">{{ \Carbon\Carbon::createFromFormat(config('roombooking.date_format'), $date)->translatedFormat('D d M') }}</div>
                            @foreach($bookingsForDate as $booking)
                                <div class="booking">
                                    <div class="time">{{ \Carbon\Carbon::make($booking->from)->format('H : 00') }} – {{ \Carbon\Carbon::make($booking->to)->format('H : 00') }}</div>

                                    <a href="/bookings/{{ $booking->id }}" class="room">
                                        <div class="header">
                                            <div class="name">{{ $booking->room->name }}</div>
                                            <div class="rate">{{ $booking->room->rate }}€/h</div>
                                            <div class="icons">
                                                @if($booking->room->smoking)
                                                    @svg('assets/icons/smoking.svg')
                                                @else
                                                    @svg('assets/icons/smoking-ban.svg', 'warning')
                                                @endif
                                                @if($booking->room->air_conditioned)
                                                        @svg('assets/icons/snowflake.svg', 'warning')
                                                @endif
                                            </div>
                                        </div>
                                        <div class="genre">{{ $booking->room->genre }}</div>
                                        <div class="info">
                                            @if($booking->room->smoking)
                                                Raucherraum
                                            @else
                                                Nichtraucherraum
                                            @endif
                                            @if($booking->room->air_conditioned)
                                                , klimatisiert
                                            @endif
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
