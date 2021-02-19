@extends('layouts.app')

@section('content')
    <div id="room">
        <div class="section image-slider-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <image-slider>
                            @foreach($room->images as $image)
                                <img class="hidden" src="/api/rooms/{{$room->id}}/photos/{{ $image->filename }}">
                            @endforeach
                        </image-slider>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="icons mobile">
                                @if($room->air_conditioned)
                                    @svg('assets/icons/snowflake.svg', 'icon')
                                @endif

                                @if($room->smoking)
                                    @svg('assets/icons/smoking.svg', 'icon')
                                @else
                                    @svg('assets/icons/smoking-ban.svg', 'icon warning')
                                @endif
                            </div>

                            <h5>{{ $room->name }}</h5>
                            <p>
                                {{ $room->genre }}<br>
                                @if( $room->smoking )
                                    Raucherraum
                                @else
                                    Nichtraucherraum
                                @endif
                                @if( $room->air_conditioned )
                                    , klimatisiert
                                @endif
                            </p>
                            <h5>Beschreibung</h5>
                            <p>{{ $room->description }}</p>
                            <h5>Ausstattung</h5>
                            <p>{{ $room->equipment }}</p>
                            <a href="/" class="button">Termin suchen</a>
                        </div>
                        <div class="col-lg-6">
                            <div class="icons desktop">
                                @if($room->air_conditioned)
                                    @svg('assets/icons/snowflake.svg', 'icon')
                                @endif

                                @if($room->smoking)
                                    @svg('assets/icons/smoking.svg', 'icon')
                                @else
                                    @svg('assets/icons/smoking-ban.svg', 'icon warning')
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
