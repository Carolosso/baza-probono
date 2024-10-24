{{-- custom_payment_field.blade.php --}}
<div>
    <div id="payment-container">
        {{-- Check if the $entry exists (editing case), otherwise show empty fields (creating case) --}}
        @if(isset($entry) && $entry->payments->count() > 0)
            @foreach($entry->payments as $payment)
                <div class="payment-item col-md-4">
                    <label>Kwota wpłaty</label>
                    <div class="input-group">
                     <input type="number" name="payments[{{ $loop->index }}][payment_amount]" step="any" value="{{ $payment->payment_amount }}" class="form-control">
                     <span class="input-group-text">zł</span>
                    </div>
                    
                    <label>Data wpłaty</label>
                    <input type="date" name="payments[{{ $loop->index }}][payment_date]" value="{{ $payment->payment_date }}" class="form-control">
                    
                    <label>Opis wpłaty</label>
                    <input type="text" name="payments[{{ $loop->index }}][payment_description]" value="{{ $payment->payment_description }}" class="form-control">

                    <button type="button" class="btn btn-danger remove-payment my-3">Usuń</button>
                    <hr>
                </div>

            @endforeach
        @else
            {{-- Empty fields for the create case --}}
            <div class="payment-item col-md-4">
                <label>Kwota wpłaty</label>
                <div class="input-group">
                    <input type="number" name="payments[0][payment_amount]" step="any" class="form-control">
                    <span class="input-group-text">zł</span>
                </div>
                <label>Data wpłaty</label>
                <input type="date" name="payments[0][payment_date]" class="form-control">
                
                <label>Opis wpłaty</label>
                <input type="text" name="payments[0][payment_description]" class="form-control">

                <button type="button" class="btn btn-danger remove-payment my-3">Usuń</button>
                <hr>
            </div>
        @endif
    </div>

    <button type="button" id="add-payment" class="btn btn-info">Dodaj nową wpłatę</button>
</div>

{{-- JavaScript to dynamically add/remove payments --}}
<script>
    let paymentIndex = {{ isset($entry) && $entry->payments->count() > 0 ? $entry->payments->count() : 1 }};

    document.getElementById('add-payment').addEventListener('click', function() {
        let container = document.getElementById('payment-container');
        let paymentItem = `
            <div class="payment-item col-md-4">
                <label>Kwota wpłaty</label>
                <div class="input-group">
                    <input type="number" name="payments[${paymentIndex}][payment_amount]" step="any" class="form-control">
                <span class="input-group-text">zł</span>
                </div>
                <label>Data wpłaty</label>
                <input type="date" name="payments[${paymentIndex}][payment_date]" class="form-control">

                <label>Opis wpłaty</label>
                <input type="text" name="payments[${paymentIndex}][payment_description]" class="form-control">
               
                <button type="button" class="btn btn-danger remove-payment my-3">Usuń</button>
                <hr>
                </div>

        `;
        container.insertAdjacentHTML('beforeend', paymentItem);
        paymentIndex++;
    });

    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-payment')) {
            e.target.parentElement.remove();
        }
    });
</script>
