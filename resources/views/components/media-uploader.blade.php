@php
    $uniqueId = 'mediaUploader_' . $type;
    $inputName = $isMultiple ? 'file[]' : 'file';
@endphp

<form action="{{ route('media.upload') }}" method="POST" enctype="multipart/form-data" id="{{ $uniqueId }}_form">
    @csrf

    <div class="mb-3">
        <label for="{{ $uniqueId }}_file" class="fw-bold form-label text-capitalize">
            <h5>{{ $label ?? 'Fichier' }}</h5>
            <small class="fw-light text-muted">Taille maximale autorisée (20Mo)</small><br>

            @if ($isMultiple)
                <small class="fw-light text-muted">5 fichiers max</small>
            @endif
        </label>

        {{-- Preview des fichiers existants --}}
        <div class="d-flex flex-wrap gap-2 mb-3">
            @php
                $existingMedias = $isMultiple
                    ? collect($medias)->where('type', $type)
                    : [collect($medias)->firstWhere('type', $type)];
            @endphp

            @foreach ($existingMedias as $media)
                @if ($media)
                    <div class="position-relative d-inline-block me-2 mb-2 media-container" style="width: 150px;">
                        <img src="{{ config('app.api') . '/' . $media['filePath'] }}" alt="Media"
                            class="img-fluid rounded media-preview w-100" />

                        <div class="media-overlay d-flex justify-content-center align-items-center"
                            onclick="deleteMedia({{ $media['id'] }}, this)">
                            <span class="delete-icon">&times;</span>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        {{-- Nouveau preview --}}
        <div id="{{ $uniqueId }}_newPreview" class="d-flex flex-wrap gap-2 mb-3"></div>

        {{-- Input file --}}
        <input type="file" class="form-control" id="{{ $uniqueId }}_file" name="{{ $inputName }}"
            accept="{{ $isMultiple ? 'image/*,video/*' : 'image/*' }}" @if ($isMultiple) multiple @endif
            required onchange="checkSize({{ $uniqueId }}'_file')">
    </div>

    {{-- Champs cachés --}}
    <input type="hidden" name="uploadType" value="media">
    <input type="hidden" name="type" value="{{ $type }}">
    <input type="hidden" name="context" value="{{ $context }}">
    <input type="hidden" name="targetType" value="{{ $targetType }}">
    <input type="hidden" name="title" value="{{ $title }}">
    <input type="hidden" name="targetId" value="{{ $targetId }}">

    <button type="submit" class="btn btn-success">
        {{ $isMultiple ? 'Ajouter les fichiers' : 'Modifier ' . ($label ?? 'fichier') }}
    </button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('{{ $uniqueId }}_file');
        const previewContainer = document.getElementById('{{ $uniqueId }}_newPreview');
        const isMultiple = {{ $isMultiple ? 'true' : 'false' }};
        const maxFiles = 5;
        const maxImageSize = 5 * 1024 * 1024; // 5 Mo
        const maxVideoSize = 20 * 1024 * 1024; // 20 Mo

        fileInput?.addEventListener('change', function(event) {
            const files = Array.from(event.target.files);
            previewContainer.innerHTML = '';

            // Limite de fichiers
            if (isMultiple && files.length > maxFiles) {
                alert(`Vous ne pouvez pas ajouter plus de ${maxFiles} fichiers à la fois.`);
                fileInput.value = '';
                return;
            }

            for (let file of files) {
                // Vérification de la taille selon type
                if (file.type.startsWith('image/') && file.size > maxImageSize) {
                    alert(`L'image "${file.name}" dépasse la taille maximale autorisée de 5 Mo.`);
                    fileInput.value = '';
                    previewContainer.innerHTML = '';
                    return;
                }

                if (file.type.startsWith('video/') && file.size > maxVideoSize) {
                    alert(`La vidéo "${file.name}" dépasse la taille maximale autorisée de 20 Mo.`);
                    fileInput.value = '';
                    previewContainer.innerHTML = '';
                    return;
                }

                // Aperçu pour les images uniquement
                if (file.type.startsWith('image/')) {
                    const preview = document.createElement('img');
                    preview.src = URL.createObjectURL(file);
                    preview.className = 'mt-2 w-25 rounded me-2';
                    previewContainer.appendChild(preview);
                }
            }
        });

        // Empêche l'envoi du formulaire si un fichier est trop lourd (sécurité double)
        const form = document.getElementById('{{ $uniqueId }}_form');
        form.addEventListener('submit', function(e) {
            const files = Array.from(fileInput.files);
            for (let file of files) {
                if ((file.type.startsWith('image/') && file.size > maxImageSize) ||
                    (file.type.startsWith('video/') && file.size > maxVideoSize)) {
                    e.preventDefault();
                    alert(`Le fichier "${file.name}" dépasse la taille maximale autorisée.`);
                    return false;
                }
            }
        });
    });
</script>


