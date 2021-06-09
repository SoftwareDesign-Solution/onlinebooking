@extends('layouts.app')

@section('content')
    <div id="home">
        <div class="container">
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <h1>Jetzt Proberaum am Naschmarkt buchen</h1>
                    <p class="subheader">Top-Ausstattung und bis 72h vor dem Termin stornierbar!</p>

                    @if (Auth::user()->active == 0)
                    <p class="subheader">Dein Account wird innerhalb von 24h nach deiner Registrierung manuell von uns aktiviert. Du bekommst eine E-Mail sobald du einen Slot buchen kannst. Wir bitten dich um Gelduld. Vielen Dank.</p>
                    @endif

                    <room-finder-form>
                        @csrf
                    </room-finder-form>
                </div>
                <div class="col-lg-2"></div>
            </div>
        </div>
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-10">
                        <h2 id="anchor-rooms">Die Proberäume im Überblick</h2>
                        <horizontal-slider>
                            @foreach($rooms as $room)
                                @if($room->active)
                                    <div class="col-lg-4">
                                        <room-card :room-id="{{ $room->id }}"></room-card>
                                    </div>
                                @endif
                            @endforeach
                        </horizontal-slider>
                    </div>
                    <div class="col-lg-1"></div>
                </div>
            </div>
        </div>
        <half-width-image-section image-position="right" image="/assets/images/image-01.jpg">
            <h3 id="anchor-additional-services">Leihinstrumente und Leistungen</h3>
            <p><strong>Kostenlos:</strong> Doublekick Keyboards Voc Mics Percussion Stimmgeräte Headphones Stative Kabel</p>
            <p><strong>4€/h:</strong> E-Gitarre E-Bass China zusätzliches Crash 14″ oder 18″ Akustische Gitarre mit Tonabnehmer Kurzweil K-2000</p>
            <p><strong>5€/h:</strong> Yamaha E-Piano P-80 mit 88 gerichteten Tasten Akustische Gitarre (Takamine) mit Tonabnehme</p>
            <p><strong>0,5€/Stk:</strong> Gehörschutz</p>
            <p><strong>10€/Stk:</strong> Drumsticks</p>
        </half-width-image-section>
        <half-width-image-section image-position="left"  image="/assets/images/image-02.jpg">
            <h5>Montag bis Sonntag – 10€/h</h5>
            <h3>Proberaum für Unterricht</h3>
            <p>Einen Proberaum für Unterrichtsstunden kannst du täglich buchen. Eine Unterrichtsstunde bedeutet: ein Schüler und ein Lehrer befinden sich im Raum und spielen das gleiche Instrument. Eine Stunde kostet 10€.</p>
        </half-width-image-section>
        <half-width-image-section image-position="right" image="/assets/images/image-03.jpg">
            <h5>Montag bis Sonntag bis 17 Uhr – 5€/h</h5>
            <h3>Proberaum für Einzelmusiker</h3>
            <p>Als einzelner Musiker kannst du unser Last Minute Angebot werktags von Montag bis Freitag bis 17 Uhr telefonisch oder an der Rezeption buchen und kostet 5€ die Stunde. Außerhalb dieser Zeiten und an Feiertagen gibt es dieses Angebot um 10€ die Stunde. Ein Raum kann nur am selben Tag und nach Verfügbarkeit gebucht werden. Die Buchung dieses Angebots erfolgt ausschließlich telefonisch oder an der Rezeption.</p>
            <p>Dieses Angebot ist besonders bei Drummern und anderen Musikern, die laute Instrumente spielen, beliebt.</p>
        </half-width-image-section>
        <half-width-image-section image-position="left"  image="/assets/images/image-04.jpg">
            <h5 class="inverted">Der beste Proberaum Wiens hat</h5>
            <h3 class="inverted">Persönliche Beratung</h3>
            <p>Du brauchst Hilfe mit der Technik oder weißt einfach nur nicht, wie du dein Handy als Playback verwenden kannst? Im t-on steht die persönliche Betreuung an erster Stelle. Wir helfen dir, damit du schnell zu spielen beginnen kannst.</p>
        </half-width-image-section>
        <half-width-image-section image-position="right" image="/assets/images/image-05.jpg">
            <h5 class="inverted">Proberaum für</h5>
            <h3 class="inverted">Tourneevorbereitung</h3>
            <p>Willst du für eine Tournee oder ein wichtiges Konzert proben und brauchst ein größeres Stundenkontingent?</p>
            <p>Dann kannst du auch außerhalb der Öffnungszeiten individuelle Zeiten vereinbaren. Ruf einfach an oder schreib uns eine E-Mail.</p>
        </half-width-image-section>
    </div>
@endsection
