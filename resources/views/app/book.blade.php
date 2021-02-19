@extends('layouts.app')

@section('content')
    <div id="room">
        <div class="section image-slider-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <image-slider>
                            @foreach($room->images as $image)
                                <img class="hidden" src="/api/rooms/{{$room->id}}/photos/{{ $image->filename }}">
                            @endforeach
                        </image-slider>
                    </div>
                    <div class="col-lg-3"></div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <simple-toggle default="booking" :options="[
                        { value: 'booking',   label: 'Buchung' },
                        { link: '/rooms/{{ $room->id }}', value: 'details',  label: 'Raumdetails' }
                        ]">
                    </simple-toggle>
                    <div class="content">
                        Buchung bis 72 Stunden vor Termin stornierbar!<br>
                        <strong class="name">{{ $room->name }}</strong> {{ $room->rate }}€/h<br>
                        {{ (new \Carbon\Carbon(request()->query('dateFrom')))->isoFormat('ddd D MMM') }}<br>
                        <book-room-form
                            v-on:change="$refs.hourFrom.value = $event.from; $refs.hourTo.value = $event.to"
                            :min-hour="{{ $minHour }}"
                            :max-hour="{{ $maxHour }}"
                            :hour-from="{{ request()->query('hourFrom', $minHour) }}"
                            :hour-to="{{ request()->query('hourTo', $maxHour) }}"
                        ></book-room-form>
                    </div>
                    <form method="post" action="book">
                        @csrf
                        <input type="hidden" name="dateFrom" value="{{ request()->query('dateFrom', \Carbon\Carbon::now()) }}">
                        <input type="hidden" name="dateTo" value="{{ request()->query('dateTo', \Carbon\Carbon::now()) }}">
                        <input ref="hourFrom" type="hidden" name="hourFrom" value="{{ request()->query('hourFrom', $minHour) }}">
                        <input ref="hourTo" type="hidden" name="hourTo" value="{{ request()->query('hourTo', $maxHour) }}">
                        <input type="hidden" name="rooms" value="{{ request()->query('rooms', $room->id) }}">
                        <div class="textarea-container">
                            <label>Buchungsnotiz:</label>
                            <textarea name="notes" cols="4"></textarea>
                        </div>
                        <button type="submit">Termin buchen</button>
                    </form>
                </div>
                <div class="col-lg-3"></div>
            </div>
        </div>
    </div>
@endsection
