@extends('layouts.cms')

@section('content')
    <div id="bookings" class="container">
        <h1>Kalender</h1>

        <bookings-day-toggle
            ref="bookingsDayToggle"
            v-on:change="$refs.bookingsTable.setDate($event)"
            start-date="{{ request()->query('date') }}">
        </bookings-day-toggle>
        <bookings-table
            ref="bookingsTable"
            v-on:slotselected="$refs.bookingsSidebar.onSlotSelected($event)"
            initialDate="{{ $date->toISOString() }}">
        </bookings-table>
    </div>
@endsection

@section('sidebar')
<sidebar>
    <bookings-sidebar
        ref="bookingsSidebar"
        v-on:datechange="$refs.bookingsDayToggle.setDate($event);"
        v-on:booked="$refs.bookingsTable.reload()">
    </bookings-sidebar>
</sidebar>
@endsection
