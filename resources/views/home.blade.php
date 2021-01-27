
@extends('layouts.app')

@section('content')
<!-- ADMIN VIEW -->
    @if(Auth()->user()->is_admin)
    <div class="container mt-5">
        <div class="grix xs1 sm3 mt-5">
            <a href="{{route('users.index')}}" class="btn press airforce dark-4 rounded-1 shadow-1 w100 mb-2">Gestion utilisateurs</a>
            <a href="" class="btn press airforce dark-4 rounded-1 shadow-1 w100 mb-2">Interventions</a>
            <a href="{{route('vehicules.index')}}" class="btn press airforce dark-4 rounded-1 shadow-1 w100 mb-2">Véhicules</a>
        </div>
    </div>
    
<!-- USER VIEW -->
    @else
    <div class="container mt-5">
        <div class="grix xs1 sm3 mt-5">
            <form class="form-material" method="POST" action="{{ route('interventions.store') }}">
                @csrf
                <input hidden type="text" name="user_id" value="{{ Auth()->user()->id }}"></input>
                <button type="submit" class="btn press airforce dark-4 rounded-1 shadow-1 w100 mb-2">Nouvelle</button>
            </form>
            <a href="" class="btn press airforce dark-4 rounded-1 shadow-1 w100 mb-2">Rejoindre</a>
            <a href="" class="btn press airforce dark-4 rounded-1 shadow-1 w100">Reprendre</a>
        </div>
    </div>
    @endif

    <div class="container">
        <div id="container">
            <h1>QR Code Scanner</h1>

            <a id="btn-scan-qr">
                <img src="https://dab1nmslvvntp.cloudfront.net/wp-content/uploads/2017/07/1499401426qr_icon.svg">
            </a>

            <canvas hidden="" id="qr-canvas"></canvas>

            <div id="qr-result" hidden="">
                <b>Data:</b> <span id="outputData"></span>
            </div>
            <input type="text" id="test" placeholder="test"></input>

        </div>
    </div>
    <style>
    #qr-canvas {
  margin: auto;
  width: calc(100% - 20px);
  max-width: 400px;
}

#btn-scan-qr {
  cursor: pointer;
}

#btn-scan-qr img {
  height: 10em;
  padding: 15px;
  margin: 15px;
  background: white;
}

#qr-result {
  font-size: 1.2em;
  margin: 20px auto;
  padding: 20px;
  max-width: 700px;
  background-color: white;
}</style>
@endsection



@section('extra-js')
<script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script>
<script type="text/javascript" src="{{ mix('js/qrCodeScanner.js') }}"></script>

@endsection
