<form action="{{ route('recruiter.update', $recruiter['id']) }}" method="POST" enctype="multipart/form-data"
    id="recruiter-profile-form">
    @csrf
    @method('PUT')

    <h3 class="fw-bold mb-3">Général</h3>

    <div class="mb-3">
        <label for="companyName" class="form-label fw-bold">Nom de l'entreprise</label>
        <input type="text" class="form-control" id="companyName" name="companyName"
            value="{{ old('companyName', $recruiter['companyName'] ?? '') }}" required>
    </div>

    <div class="mb-3">
        <label for="siret" class="form-label fw-bold">Siret de l'entreprise</label>
        <input type="text" class="form-control" id="siret" name="siret"
            value="{{ old('siret', $recruiter['siret'] ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="companyDescription" class="form-label fw-bold">Description de l'entreprise</label>
        <textarea class="form-control auto-resize" id="companyDescription" name="companyDescription" rows="1">{{ old('companyDescription', $recruiter['companyDescription'] ?? '') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="location" class="form-label fw-bold">Lieu de l'entreprise</label>
        <input type="text" class="form-control" id="location" name="location"
            value="{{ old('location', $recruiter['location'] ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="website" class="form-label fw-bold">Site web de l'entreprise</label>
        <input type="text" class="form-control" id="website" name="website"
            value="{{ old('website', $recruiter['website'] ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="sector" class="form-label fw-bold">Secteur d'activité</label>
        <select class="form-select" id="sector" name="sector">
            <option value="" disabled {{ old('sector', $recruiter['sector'] ?? '') == '' ? 'selected' : '' }}>
                Sélectionnez un secteur
            </option>

            @foreach ($sectors as $section => $subsectors)
                <optgroup label="{{ $section }}">
                    @foreach ($subsectors as $code => $label)
                        <option value="{{ $code }}"
                            {{ old('sector', $recruiter['sector'] ?? '') == $code ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </optgroup>
            @endforeach

            {{-- Cas où le secteur actuel n'existe plus dans la liste --}}
            @if (!isset($sectors[$recruiter['sector'] ?? '']) && !empty($recruiter['sector']))
                <option value="{{ $recruiter['sector'] }}" selected>{{ $recruiter['sector'] }}</option>
            @endif
        </select>
    </div>

    <div class="mb-3">
        <label for="teamSize" class="form-label fw-bold">Taille de l'entreprise</label>
        <input type="text" class="form-control" id="teamSize" name="teamSize"
            value="{{ old('teamSize', $recruiter['teamSize'] ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="contactPhone" class="form-label fw-bold">Contact (téléphone)</label>
        <input type="text" class="form-control" id="contactPhone" name="contactPhone"
            value="{{ old('contactPhone', $recruiter['contactPhone'] ?? '') }}" minlength="10" maxlength="20">
    </div>

    <div class="mb-3">
        <label for="contactEmail" class="form-label fw-bold">Contact (e-mail)</label>
        <input type="email" class="form-control" id="contactEmail" name="contactEmail"
            value="{{ old('contactEmail', $recruiter['contactEmail'] ?? '') }}">
    </div>

    <h3 class="fw-bold mb-3 mt-4">Logo et médias</h3>

    <!-- Logo de l'entreprise -->
    <div class="mb-4">
        <label class="form-label fw-bold">Logo de l'entreprise</label>

        @php
            $logo = collect($recruiter['medias'] ?? [])->firstWhere('type', 'company_logo');
        @endphp

        @if ($logo)
            <div class="mb-3">
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ config('app.api') . '/' . $logo['filePath'] }}" alt="company logo">

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="delete_logo" id="deleteLogo"
                            value="1" {{ old('new_logo') ? 'disabled' : '' }}>
                        <label class="form-check-label text-danger fw-bold" for="deleteLogo">
                            Supprimer le logo
                        </label>
                    </div>
                </div>
                <small class="text-muted">Cocher pour supprimer (désactivé si vous uploadez un nouveau logo)</small>
            </div>
        @endif

        <div>
            <label for="new_logo" class="form-label">
                {{ $logo ? 'Remplacer le logo' : 'Ajouter un logo' }}
                <small class="text-muted">(Max 5Mo, formats: jpg, png, svg)</small>
            </label>
            <input type="file" class="form-control" id="new_logo" name="new_logo"
                accept="image/jpeg,image/png,image/svg+xml">
            <div id="logo_preview" class="mt-2 w-24 h-24"></div>
        </div>
    </div>

    <h3 class="fw-bold mb-3 mt-4">Membres de l’équipe</h3>

    <div id="team-members-section">
        {{-- Champ pour IDs supprimés --}}
        <input type="hidden" name="deletedIds" id="deletedIds">

        <div id="team-members-list" class="row">
            {{-- Membres existants --}}
            @foreach ($recruiter['teamMembers'] ?? [] as $index => $member)
                <div
                    class="card col-12 col-md-6 rounded p-3 mb-2 d-flex justify-content-between align-items-center bg-light member-card">
                    <div>
                        <input type="hidden" name="teamMembers[{{ $index }}][id]"
                            value="{{ $member['id'] }}">
                        <input type="text" name="teamMembers[{{ $index }}][name]"
                            class="form-control mb-1" value="{{ $member['name'] }}" placeholder="Nom" required>
                        <input type="email" name="teamMembers[{{ $index }}][email]"
                            class="form-control mb-1" value="{{ $member['email'] }}" placeholder="Email">
                        <input type="text" name="teamMembers[{{ $index }}][role]" class="form-control"
                            value="{{ $member['role'] }}" placeholder="Rôle">
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger delete-member ms-3">
                        <i class="material-symbols-outlined">delete</i>
                    </button>
                </div>
            @endforeach
        </div>

        {{-- Bouton d’ajout --}}
        <div class="d-flex justify-content-center mt-2">
            <button type="button" id="add-member-btn"
                class="btn rounded-circle p-0 d-flex align-items-center justify-content-center"
                style="width: 40px; height: 40px; background-color: #ced4da;">
                <i class="material-symbols-outlined">add</i>
            </button>
        </div>
    </div>

    <script>
        let memberIndex = {{ count($recruiter['teamMembers'] ?? []) }};
        const deletedInput = document.getElementById('deletedIds');

        // Ajouter un membre
        document.getElementById('add-member-btn').addEventListener('click', () => {
            const container = document.getElementById('team-members-list');
            const html = `
            <div class="card col-12 col-md-6 rounded p-3 mb-2 bg-light member-card">
                <div>
                    <input type="text" name="teamMembers[${memberIndex}][name]" class="form-control mb-1" placeholder="Nom" required>
                    <input type="email" name="teamMembers[${memberIndex}][email]" class="form-control mb-1" placeholder="Email">
                    <input type="text" name="teamMembers[${memberIndex}][role]" class="form-control" placeholder="Rôle">
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger delete-member ms-3">
                    <i class="material-symbols-outlined">delete</i>
                </button>
            </div>
        `;
            container.insertAdjacentHTML('beforeend', html);
            memberIndex++;
        });

        // Supprimer un membre
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('.delete-member');
            if (!btn) return;

            e.preventDefault();
            const card = btn.closest('.member-card');
            const hiddenId = card.querySelector('input[name*="[id]"]');

            if (hiddenId && hiddenId.value) {
                const deletedIds = deletedInput.value ? deletedInput.value.split(',') : [];
                deletedIds.push(hiddenId.value);
                deletedInput.value = deletedIds.join(',');
            }

            card.remove();
        });
    </script>

    <!-- Galerie photos -->
    <div class="mb-4">
        <label class="form-label fw-bold">Photos de l'entreprise</label>

        @php
            $images = collect($recruiter['medias'] ?? [])->where('type', 'company_image');
        @endphp

        @if ($images->isNotEmpty())
            <div class="mb-3">
                <p class="text-muted small">Cochez les images à supprimer :</p>
                <div class="d-flex flex-wrap gap-2">
                    @foreach ($images as $image)
                        <div class="position-relative" style="width: 150px;">
                            <img src="{{ config('app.api') . '/' . $image['filePath'] }}" class="img-thumbnail w-100"
                                style="height: 150px; object-fit: cover;">
                            <div class="position-absolute top-0 end-0 m-1">
                                <div class="form-check bg-white rounded p-1">
                                    <input class="form-check-input" type="checkbox" name="delete_images[]"
                                        value="{{ $image['id'] }}" id="img{{ $image['id'] }}">
                                    <label class="form-check-label text-danger fw-bold" for="img{{ $image['id'] }}">
                                        ✕
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div>
            <label for="new_images" class="form-label">
                Ajouter de nouvelles photos
                <small class="text-muted">(Max 5 fichiers, 5Mo chacun)</small>
            </label>
            <input type="file" class="form-control" id="new_images" name="new_images[]"
                accept="image/jpeg,image/png,image/jpg" multiple>
            <div id="images_preview" class="d-flex flex-wrap gap-2 mt-2"></div>
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary w-100 py-2">
            <i class="bi bi-check-circle me-2"></i>Mettre à jour le profil
        </button>
    </div>
</form>

<!-- Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-resize des textareas
        const textareas = document.querySelectorAll('.auto-resize');
        textareas.forEach(textarea => {
            const resize = () => {
                textarea.style.height = 'auto';
                textarea.style.height = textarea.scrollHeight + 'px';
            };
            textarea.addEventListener('input', resize);
            resize();
        });

        // Preview du logo
        const logoInput = document.getElementById('new_logo');
        const logoPreview = document.getElementById('logo_preview');
        const maxLogoSize = 5 * 1024 * 1024; // 5 Mo

        logoInput?.addEventListener('change', function(e) {
            logoPreview.innerHTML = '';
            const file = e.target.files[0];

            if (!file) return;

            // Vérification de la taille
            if (file.size > maxLogoSize) {
                alert('Le logo ne doit pas dépasser 5 Mo.');
                logoInput.value = '';
                return;
            }

            // Vérification du type
            if (!file.type.match('image.*')) {
                alert('Veuillez sélectionner une image valide.');
                logoInput.value = '';
                return;
            }

            // Afficher la preview
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-full h-full object-contain rounded';
                logoPreview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });

        // Preview des images
        const imagesInput = document.getElementById('new_images');
        const imagesPreview = document.getElementById('images_preview');
        const maxImageSize = 5 * 1024 * 1024; // 5 Mo
        const maxFiles = 5;

        imagesInput?.addEventListener('change', function(e) {
            imagesPreview.innerHTML = '';
            const files = Array.from(e.target.files);

            if (files.length > maxFiles) {
                alert(`Vous ne pouvez pas ajouter plus de ${maxFiles} images à la fois.`);
                imagesInput.value = '';
                return;
            }

            let validFiles = true;

            files.forEach(file => {
                // Vérification de la taille
                if (file.size > maxImageSize) {
                    alert(`L'image "${file.name}" dépasse la taille maximale de 5 Mo.`);
                    validFiles = false;
                    return;
                }

                // Vérification du type
                if (!file.type.match('image.*')) {
                    alert(`Le fichier "${file.name}" n'est pas une image valide.`);
                    validFiles = false;
                    return;
                }

                // Afficher la preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'position-relative';
                    div.style.width = '150px';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-thumbnail w-100';
                    img.style.height = '150px';
                    img.style.objectFit = 'cover';

                    div.appendChild(img);
                    imagesPreview.appendChild(div);
                };
                reader.readAsDataURL(file);
            });

            if (!validFiles) {
                imagesInput.value = '';
                imagesPreview.innerHTML = '';
            }
        });

        // Validation avant soumission
        const form = document.getElementById('recruiter-profile-form');
        form?.addEventListener('submit', function(e) {
            // Vérifier le logo
            if (logoInput.files.length > 0) {
                const file = logoInput.files[0];
                if (file.size > maxLogoSize) {
                    e.preventDefault();
                    alert('Le logo ne doit pas dépasser 5 Mo.');
                    return false;
                }
            }

            // Vérifier les images
            if (imagesInput.files.length > 0) {
                const files = Array.from(imagesInput.files);

                if (files.length > maxFiles) {
                    e.preventDefault();
                    alert(`Vous ne pouvez pas ajouter plus de ${maxFiles} images.`);
                    return false;
                }

                for (let file of files) {
                    if (file.size > maxImageSize) {
                        e.preventDefault();
                        alert(`L'image "${file.name}" dépasse la taille maximale de 5 Mo.`);
                        return false;
                    }
                }
            }
        });
    });
</script>

<style>
    .img-thumbnail {
        border: 2px solid #dee2e6;
        transition: all 0.3s ease;
    }

    .img-thumbnail:hover {
        border-color: #0d6efd;
        box-shadow: 0 0 10px rgba(13, 110, 253, 0.3);
    }

    .form-check-input:checked~.form-check-label {
        font-weight: bold;
    }
</style>
