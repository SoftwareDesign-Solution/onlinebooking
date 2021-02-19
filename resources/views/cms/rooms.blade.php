<?php /** @var App\Models\Room[] $rooms */ ?>

@extends('layouts.cms')

@section('content')
    <div id="rooms" class="container">
        <h1>Proberäume</h1>

        <table>
            <tr class="header">
                <th>Proberaumname</th>
                <th>Genre</th>
                <th>Preis Pro Stunde</th>
                <th>Raucherraum</th>
                <th>Klimatisiert</th>
                <th>Aktiv</th>
            </tr>

            @foreach ($rooms as $room)
                <tr>
                    <td><a href="{{ url("cms/rooms/$room->id") }}">{{ $room->name }}</a></td>
                    <td>{{ $room->genre }}</td>
                    <td>{{ $room->rate }}€</td>
                    <td data-value="{{ $room->smoking }}" class="smoking">{{ $room->smoking ? "Ja" : "Nein" }}</td>
                    <td data-value="{{ $room->air_conditioned }}"
                        class="air-conditioned">{{ $room->air_conditioned ? "Ja" : "Nein" }}</td>
                    <td data-value="{{ $room->active }}" class="active">{{ $room->active ? "aktiv" : "inaktiv" }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
