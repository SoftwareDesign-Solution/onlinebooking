@extends('layouts.app')

@section('content')
    <div id="bookings">
        <div class="search-parameter-container">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="search-parameters">
                            Ergebnisse für {{ join(", ", array_map(function($room) { return $room->name; }, $requestedRooms)) }}
                            <div class="date-range">
                                {{ $dateFrom->translatedFormat('D d M') }} – {{ $dateTo->translatedFormat('D d M') }}
                            </div>
                            <div class="hour-range">
                                {{ str_pad($hourFrom, 2, '0', STR_PAD_LEFT) }} : 00
                                - {{ str_pad($hourTo, 2, '0', STR_PAD_LEFT) }} : 00
                            </div>

                            <a class="edit-search" href="/">
                                @svg('assets/icons/edit.svg')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="results">
                        @foreach($availableSlots as $date => $slotsPerRoom)
                            @if(sizeof($slotsPerRoom) == 0)
                                <div class="result-date no-results">{{ \Carbon\Carbon::make($date)->translatedFormat('D d M') }}</div>
                                <div class="result no-result">
                                    kein Termin gefunden
                                </div>
                            @else
                                <div class="result-date">{{ \Carbon\Carbon::make($date)->translatedFormat('D d M') }}</div>
                                @foreach($slotsPerRoom as $slot => $roomsForSlot)
                                    @if(sizeof($roomsForSlot) == 0)
                                        @continue
                                    @endif

                                    <div class="result">
                                        <div class="hour-range">{{ str_pad($slot, 2, '0', STR_PAD_LEFT) }} : 00 - {{ str_pad($slot + 1, 2, '0', STR_PAD_LEFT) }} : 00</div>
                                        <div class="rooms">
                                            @foreach($roomsForSlot as $room)
                                                <a class="room" href="/rooms/{{ $room->id }}/book?dateFrom={{ $date }}&dateTo={{ $date }}&hourFrom={{ $slot }}&hourTo={{ $slot + 1 }}&rooms={{ join(",", array_map(function($room) { return $room->id; }, $requestedRooms)) }}">
                                                    <div class="header">
                                                        <div class="name">{{ $room->name }}</div>
                                                        <div class="rate">{{ $room->rate }}€/h</div>
                                                        <div class="icons">
                                                            @if($room->smoking)
                                                                @svg('assets/icons/smoking.svg')
                                                            @else
                                                                @svg('assets/icons/smoking-ban.svg', 'warning')
                                                            @endif

                                                            @if($room->air_conditioned)
                                                                @svg('assets/icons/snowflake.svg')
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="genre">
                                                        {{ $room->genre }}
                                                    </div>
                                                    <div class="conditions">
                                                        @if($room->smoking)
                                                            Raucherraum
                                                        @else
                                                            Nichtraucherraum
                                                        @endif

                                                        @if($room->air_conditioned)
                                                            , klimatisiert
                                                        @endif
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(request()->query('bookingSuccessful'))
        <toast ref="successToast" :show-on-mount="true" class="toast-successful-booking">
            <p class="content">Termin erfolgreich gebucht</p>
            <div class="icon">
                @svg('assets/icons/check.svg', 'success')
            </div>
            <a class="button" href="/">Weiteren Termin suchen</a>
            <button class="hide-toast" type="button" v-on:click="$refs.successToast.hide()">Meldung schließen</button>
        </toast>
    @endif
@endsection
