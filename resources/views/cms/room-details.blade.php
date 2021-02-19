<?php /** @var App\Models\Room $room */ ?>

@extends('layouts.cms')

@section('content')
    <div id="room-details" class="container">
        <h1>Proberäume</h1>
        <h2>{{ $room->name }}</h2>

        <form method="post">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-8">
                            <label>Proberaumname</label>
                            <input type="text" name="name" value="{{ $room->name }}">
                        </div>
                        <div class="col-4">
                            <label>Preis pro Stunde</label>
                            <div class="rate">
                                <input type="number" step="0.01" name="rate" value="{{ $room->rate }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label>Genre</label>
                            <input type="text" name="genre" value="{{ $room->genre }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <label class="checkbox-label">Raucherraum</label>
                            <input type="checkbox" name="smoking" @if($room->smoking) checked="checked" @endif>
                        </div>
                        <div class="col-4">
                            <label class="checkbox-label">Klimatisiert</label>
                            <input type="checkbox" name="air_conditioned"
                                   @if($room->air_conditioned) checked="checked" @endif>
                        </div>
                        <div class="col-4">
                            <label class="checkbox-label success">Aktiv</label>
                            <input type="checkbox" name="active" class="success"
                                   @if($room->active) checked="checked" @endif>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="textarea-container">
                                <label class="textarea-label">Austattung:</label>
                                <textarea rows="5" name="equipment">{{ $room->equipment }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="row">
                        <div class="col-12">
                            <room-photo-upload :room-id="{{ $room->id }}"></room-photo-upload>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="textarea-container">
                                <label class="textarea-label">Beschreibung:</label>
                                <textarea rows="5" name="description">{{ $room->description }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <button type="submit">Änderungen speichern</button>
                </div>
            </div>
        </form>
    </div>
@endsection
