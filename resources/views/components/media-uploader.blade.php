@php
    $uniqueId = 'mediaUploader_' . $type;
@endphp

<form action="{{ route('media.upload') }}" method="POST" enctype="multipart/form-data" id="{{ $uniqueId }}_form">
    @csrf

    <div class="mb-3">
        <label for="{{ $uniqueId }}_file" class="form-label text-capitalize">{{ $label ?? 'Fichier' }}</label>
        <div class="d-flex align-items-center justify-content-between mb-3 text-center">
            {{-- Preview du fichier existant --}}
            <div>
                @php
                    $existingMedia = collect($medias)->firstWhere('type', $type);
                @endphp
                @if ($existingMedia)
                    <div id="{{ $uniqueId }}_existingPreview" class="mt-2">
                        <img src="{{ env('DISCOREV_API_URL') . '/' . $existingMedia['filePath'] }}" alt="Media actuel"
                            class="w-25 rounded-circle">
                    </div>
                @endif
            </div>

            {{-- Preview pour nouveau fichier --}}
            <div id="{{ $uniqueId }}_newPreview"></div>
        </div>

        <input type="file" class="form-control" id="{{ $uniqueId }}_file" name="file" accept="image/*"
            required>
    </div>

    <input type="hidden" name="uploadType" value="media">
    <input type="hidden" name="type" value="{{ $type }}">
    <input type="hidden" name="context" value="{{ $context }}">
    <input type="hidden" name="targetType" value="{{ $targetType }}">
    <input type="hidden" name="title" value="{{ $title }}">
    <input type="hidden" name="targetId" value="{{ $targetId }}">

    <button type="submit" class="btn btn-success">Modifier {{ $label ?? 'fichier' }}</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('{{ $uniqueId }}_file');
        const previewContainer = document.getElementById('{{ $uniqueId }}_newPreview');

        fileInput?.addEventListener('change', function(event) {
            const file = event.target.files[0];
            previewContainer.innerHTML = '';
            if (file && file.type.startsWith('image/')) {
                const preview = document.createElement('img');
                preview.src = URL.createObjectURL(file);
                preview.className = 'mt-2 w-25 rounded-circle';
                previewContainer.appendChild(preview);
            }
        });
    });
</script>
