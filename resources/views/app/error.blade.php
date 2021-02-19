@extends('layouts.app')

@section('content')
    <div id="error">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h1>Ein Fehler ist aufgetreten</h1>
                    <p>{{ $message }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
