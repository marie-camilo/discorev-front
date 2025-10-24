@props([
    'medias' => [],
    'type' => 'media',
    'label' => null,
    'isMultiple' => false,
    'context' => 'recruiter',
    'targetId' => null,
    'targetType' => null,
    'title' => ''
])

@php
    $uniqueId = 'mediaUploader_' . $type;
    $inputName = $isMultiple ? 'file[]' : 'file';
    $existingMedias = $isMultiple
        ? collect($medias)->where('type', $type)
        : [collect($medias)->firstWhere('type', $type)];
@endphp

<div class="mb-3" id="{{ $uniqueId }}_container">
    <label for="{{ $uniqueId }}_file" class="fw-bold form-label text-capitalize">
        <h5>{{ $label ?? 'Fichier' }}</h5>
        <small class="fw-light text-muted">
            Taille maximale autorisée :
            {{ $type === 'company_logo' || $type === 'company_image' ? '5Mo' : '20Mo' }}
        </small><br>
        @if($isMultiple)
            <small class="fw-light text-muted">5 fichiers max</small>
        @endif
    </label>

    {{-- Preview des fichiers existants --}}
    <div class="d-flex flex-wrap gap-2 mb-3">
        @foreach($existingMedias as $media)
            @if ($media)
                <div class="position-relative d-inline-block me-2 mb-2 media-container" style="width: 150px;">
                    <img src="{{ config('app.api') . '/' . $media['filePath'] }}" alt="Media"
                         class="img-fluid rounded media-preview w-100" />

                    <div class="media-overlay d-flex justify-content-center align-items-center"
                         onclick="this.closest('.media-container').remove();">
                        <span class="delete-icon">&times;</span>
                    </div>

                    <input type="hidden" name="existing_{{ $type }}[]" value="{{ $media['id'] }}">
                </div>
            @endif
        @endforeach
    </div>

    {{-- Nouveau preview --}}
    <div id="{{ $uniqueId }}_newPreview" class="d-flex flex-wrap gap-2 mb-3"></div>

    {{-- Input file --}}
    <input type="file" class="form-control" id="{{ $uniqueId }}_file" name="{{ $inputName }}"
           accept="{{ $isMultiple ? 'image/*,video/*' : 'image/*' }}" @if($isMultiple) multiple @endif>

    {{-- Champs cachés --}}
    <input type="hidden" name="type" value="{{ $type }}">
    <input type="hidden" name="context" value="{{ $context }}">
    <input type="hidden" name="targetType" value="{{ $targetType }}">
    <input type="hidden" name="title" value="{{ $title }}">
    <input type="hidden" name="targetId" value="{{ $targetId }}">
</div>

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

            if (isMultiple && files.length > maxFiles) {
                alert(`Vous ne pouvez pas ajouter plus de ${maxFiles} fichiers à la fois.`);
                fileInput.value = '';
                return;
            }

            for (let file of files) {
                if (file.type.startsWith('image/') && file.size > maxImageSize) {
                    alert(`L'image "${file.name}" dépasse 5 Mo.`);
                    fileInput.value = '';
                    previewContainer.innerHTML = '';
                    return;
                }
                if (file.type.startsWith('video/') && file.size > maxVideoSize) {
                    alert(`La vidéo "${file.name}" dépasse 20 Mo.`);
                    fileInput.value = '';
                    previewContainer.innerHTML = '';
                    return;
                }

                if (file.type.startsWith('image/')) {
                    const preview = document.createElement('img');
                    preview.src = URL.createObjectURL(file);
                    preview.className = 'mt-2 w-25 rounded me-2';
                    previewContainer.appendChild(preview);
                } else {
                    const div = document.createElement('div');
                    div.textContent = file.name;
                    div.style.padding = '5px';
                    div.style.border = '1px solid #ccc';
                    div.style.borderRadius = '5px';
                    previewContainer.appendChild(div);
                }
            }
        });
    });
</script>
