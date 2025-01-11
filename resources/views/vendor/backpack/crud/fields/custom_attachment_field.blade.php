<div>
    <div id="attachment-container">
        {{-- Display existing attachments if editing --}}
        @if(isset($entry) && $entry->attachments->count() > 0)
            @foreach($entry->attachments as $attachment)
                <div class="attachment-item col-md-4">
                   
                    
                    {{-- Link to view the file --}}
                    <label>Aktualny plik</label>
                    <div class="file-preview">
                        @php
                            $fileExtension = pathinfo($attachment->attachment_url, PATHINFO_EXTENSION);
                        @endphp

                        {{-- Show preview if the file is an image --}}
                        @if(in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']))
                            <img src="{{ asset('storage/' . $attachment->attachment_url) }}" alt="attachment-preview" class="img-fluid mb-2" style="max-height: 400px;">
                        {{-- Show preview if the file is a PDF --}}
                        @elseif(strtolower($fileExtension) == 'pdf')
                            <iframe src="{{ asset('storage/' . $attachment->attachment_url) }}" width="100%" height="400px"></iframe>
                        {{-- Show a default icon for other file types --}}
                        @else
                            <p>Plik: {{ $attachment->attachment_url }}</p>
                        @endif
                    </div>
                     <a href="{{ asset('storage/' . $attachment->attachment_url) }}" 
                       target="_blank" 
                       class="d-block mb-2">Otwórz w nowej karcie</a>   
                    {{-- Hidden field to keep track of the existing attachment ID --}}
                    <input type="hidden" name="attachments[{{ $loop->index }}][id]" value="{{ $attachment->id }}">

                    {{-- Option to replace the file --}}
{{--                     <label>Zamień plik</label>
                    <input type="file" name="attachments[{{ $loop->index }}][file]" class="form-control"> --}}
                     <label>Opis załącznika</label>
                    <input type="text" name="attachments[{{ $loop->index }}][attachment_description]" 
                           value="{{ $attachment->attachment_description }}" 
                           class="form-control">
                    <button type="button" class="btn btn-danger remove-attachment my-3">Usuń</button>
                    <hr>
                </div>
            @endforeach
        @else
            {{-- Empty fields for creating a new child --}}
            <div class="attachment-item col-md-4">
                <label>Opis załącznika</label>
                <input type="text" name="attachments[0][attachment_description]" class="form-control">

                <label>Dodaj plik</label>
                <input type="file" name="attachments[0][file]" class="form-control">

                <button type="button" class="btn btn-danger remove-attachment my-3">Usuń</button>
                <hr>
            </div>
        @endif
    </div>

    <button type="button" id="add-attachment" class="btn btn-info">Dodaj załącznik</button>
</div>

{{-- JavaScript to dynamically add/remove attachments --}}
<script>
    let attachmentIndex = {{ isset($entry) && $entry->attachments->count() > 0 ? $entry->attachments->count() : 1 }};

    document.getElementById('add-attachment').addEventListener('click', function () {
        let container = document.getElementById('attachment-container');
        let attachmentItem = `
            <div class="attachment-item col-md-4">
               
                <label>Dodaj plik</label>
                <input type="file" name="attachments[${attachmentIndex}][file]" class="form-control">

                 <label>Opis załącznika</label>
                <input type="text" name="attachments[${attachmentIndex}][attachment_description]" class="form-control">

                <button type="button" class="btn btn-danger remove-attachment my-3">Usuń</button>
                <hr>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', attachmentItem);
        attachmentIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-attachment')) {
            e.target.parentElement.remove();
        }
    });
</script>
