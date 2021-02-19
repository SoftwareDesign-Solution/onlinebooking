<?php /** @var App\Models\User[] $users */ ?>

@extends('layouts.cms')

@section('content')
    <div class="container">
        <div id="dashboard">
            <h1>Dashboard</h1>

            <total-occupancy ref="totalOccupancy" v-on:ratechanged="$refs.singleOccupancy.setRange($event)"></total-occupancy>

            <div class="row">
                <div class="col-6">
                    <opening-hours></opening-hours>
                </div>
                <div class="col-6">
                    <single-occupancy ref="singleOccupancy"></single-occupancy>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('sidebar')
    <sidebar>
        <appointments-sidebar v-on:datechange="$refs.totalOccupancy.setDate($event); $refs.singleOccupancy.setDate($event)"></appointments-sidebar>
    </sidebar>
@endsection
