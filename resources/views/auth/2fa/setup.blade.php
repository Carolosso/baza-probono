@extends(backpack_view('layouts.auth'))


@section('content')

<form method="POST" action="{{ route('2fa.store') }}">
    @csrf
    <div class="row justify-content-center mt-5 mx-auto">
        <div class="col-lg-4">
            <div class="row row-cards">
                <div class="col-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Konfiguracja weryfikacji 2-etapowej</h3>
                        </div>
                        <div class="card-body">        
                            <div class="mb-3">
                                <label class="form-label">Zeskanuj poniższy kod QR w aplikacji Google Authenticator.</label>
                                <a href="https://support.google.com/accounts/answer/1066447?hl=pl&co=GENIE.Platform%3DAndroid&sjid=16241549177917833362-EU#:~:text=Pobieranie%20aplikacji%20Authenticator" target="_blank">Pomoc Google dotycząca weryfikacji dwuetapowej</a>
                                <hr>
                                <div class="text-center">
                                    <img src="{{ $dataUri }}" alt="QR Code" class="">
                                </div>
                                <label class="form-label">Lub wprowadź poniższy kod:</label>
                                <input type="text" class="form-control text-center" name="secret" value="{{ $secret }}" readonly>
                                <hr>
                                <label class="form-label">Po pomyślnym zeskanowaniu w aplikacji mobilnej zostanie wyświetlony kod o nazwie "Adopcja_Serca_Baza". <br>Jeżeli tak się stało - konfiguracja przebiegła pomyślnie i można przejść dalej. </label>
                                @if($errors->any())
                                    <h4>{{$errors->first()}}</h4>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer text-end">                         
                            <button type="submit" class="btn btn-primary">Skonfiguruj logowanie 2-etapowe</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- @section('content')
{{-- 
    <h2>Set up Two-Factor Authentication</h2>
    <p>Scan the QR code below with your Google Authenticator app:</p>
    <img src="{{ $dataUri }}" alt="QR Code">
    <form method="POST" action="{{ route('2fa.store') }}">
        @csrf
        <input type="hidden" name="secret" value="{{ $secret }}">
        <button type="submit">Enable 2FA</button>
    </form> 
@endsection --}}
