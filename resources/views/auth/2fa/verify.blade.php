@extends(backpack_view('layouts.auth'))


@section('content')

<form method="POST" action="{{ route('2fa.check') }}">
    @csrf
    <div class="row justify-content-md-center mt-5">
        <div class="col-lg-4 ">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Weryfikacja 2-etapowa</h3>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Wprowadź kod z aplikacji.</label>
                                <input type="text" required id="otp" name="one_time_password" class="form-control" data-mask="0 0 0 - 0 0 0" data-mask-visible="true" autocomplete="off" inputmode="numeric" autofocus>
                                @if($errors->any())
                                    <h4>{{$errors->first()}}</h4>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Weryfikuj</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

{{--     <h2>Verify Two-Factor Authentication</h2>
    <form method="POST" action="{{ route('2fa.check') }}">
        @csrf
        <label for="otp">Enter your 2FA code:</label>
        <input type="text" id="otp" name="one_time_password" required>
        @if($errors->any())
            <h4>{{$errors->first()}}</h4>
        @endif
        <button type="submit">Verify</button>
    </form> --}}
@endsection
