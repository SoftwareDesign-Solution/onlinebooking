@extends('layouts.app')

@section('content')
    <div id="room">
        <div class="section image-slider-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <image-slider>
                            @foreach($booking->room->images as $image)
                                <img class="hidden" src="/api/rooms/{{$booking->room->id}}/photos/{{ $image->filename }}">
                            @endforeach
                        </image-slider>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <simple-toggle default="booking" :options="[
                        { value: 'booking',   label: 'Termin' },
                        { link: '/rooms/{{ $booking->room->id }}', value: 'details',  label: 'Raumdetails' }
                        ]"></simple-toggle>
                    <p>
                        Buchung bis 72 Stunden vor Termin stornierbar!<br>
                        <strong class="name">{{ $booking->room->name }}</strong> {{ $booking->room->rate }}€/h<br>
                        {{ \Carbon\Carbon::make($booking->from)->translatedFormat('D d M') }} - {{ \Carbon\Carbon::make($booking->to)->translatedFormat('D d M') }}<br>
                        {{ \Carbon\Carbon::make($booking->from)->format('H : 00') }} – {{ \Carbon\Carbon::make($booking->to)->format('H : 00')  }}
                    </p>
                    @if($canCancel)
                        <button v-on:click="$refs.confirmToast.show()" type="button">Termin stornieren</button>
                    @else
                        <button disabled="disabled" type="button">Termin stornieren</button>
                    @endif
                </div>
            </div>
        </div>
        <toast ref="confirmToast" class="confirm-toast">
            <p>Bist du sicher?</p>
            <form method="post">
                @csrf
                @method('DELETE')
                <button type="submit">Termin endgültig stornieren</button>
            </form>
            <button class="cancel" v-on:click="$refs.confirmToast.hide()" type="button">Abbrechen</button>
        </toast>
    </div>
@endsection
