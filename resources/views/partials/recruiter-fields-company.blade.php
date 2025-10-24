<form action="{{ route('recruiter.update', $recruiter['id']) }}" method="POST" enctype="multipart/form-data" id="recruiter-profile-form">
    @csrf
    @method('PUT')

    <!-- === Général === -->
    <h3 class="fw-bold mb-3">Général</h3>

    <div class="mb-3">
        <label for="

companyName" class="form-label fw-bold">Nom de l'entreprise</label>
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
        <textarea class="form-control auto-resize" id="companyDescription" name="companyDescription" rows="1">
            {{ old('companyDescription', $recruiter['companyDescription'] ?? '') }}
        </textarea>
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
            @foreach ($sectors as $code => $label)
                <option value="{{ $code }}" {{ old('sector', $recruiter['sector'] ?? '') == $code ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
            @if(!isset($sectors[$recruiter['sector'] ?? '']) && !empty($recruiter['sector']))
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

    <!-- === Logo et médias === -->
    <h3 class="fw-bold mb-3 mt-4">Logo et médias</h3>

    <!-- Logo -->
    <div class="mb-4">
        <label class="form-label fw-bold">Logo de l'entreprise</label>

        @php
            $logo = collect($recruiter['medias'] ?? [])->firstWhere('type', 'company_logo');
        @endphp

        @if($logo)
            <div class="mb-3">
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ config('app.api') . '/' . $logo['filePath'] }}"
                         alt="Logo actuel"
                         class="img-thumbnail"
                         style="max-width: 150px; max-height: 150px; object-fit: contain;">

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="delete_logo" id="deleteLogo" value="1">
                        <label class="form-check-label text-danger fw-bold" for="deleteLogo">
                            Supprimer le logo
                        </label>
                    </div>
                </div>
                <small class="text-muted d-block">
                    Cocher pour supprimer. <br>
                    <em class="text-warning">Désactivé si vous uploadez un nouveau logo.</em>
                </small>
            </div>
        @endif

        <div>
            <label for="new_logo" class="form-label">
                {{ $logo ? 'Remplacer le logo' : 'Ajouter un logo' }}
                <small class="text-muted">(Max 5 Mo, formats: jpg, png, svg)</small>
            </label>
            <input type="file" class="form-control" id="new_logo" name="new_logo"
                   accept="image/jpeg,image/png,image/svg+xml">
            <div id="logo_preview" class="mt-2"></div>
        </div>
    </div>

    <!-- Membres équipe -->
    <h3 class="fw-bold mb-3 mt-4">Membres de l’équipe</h3>
    <div id="team-members-section">
        <input type="hidden" name="deleted_member_ids" id="deleted_member_ids">

        <div id="team-members-list" class="row">
            @foreach ($recruiter['teamMembers'] ?? [] as $index => $member)
                <div class="card col-12 col-md-6 rounded p-3 mb-2 d-flex justify-content-between align-items-center bg-light member-card">
                    <div class="flex-grow-1">
                        <input type="hidden" name="teamMembers[{{ $index }}][id]" value="{{ $member['id'] }}">
                        <input type="text" name="teamMembers[{{ $index }}][name]" class="form-control mb-1"
                               value="{{ $member['name'] }}" placeholder="Nom" required>
                        <input type="email" name="teamMembers[{{ $index }}][email]" class="form-control mb-1"
                               value="{{ $member['email'] }}" placeholder="Email">
                        <input type="text" name="teamMembers[{{ $index }}][role]" class="form-control"
                               value="{{ $member['role'] }}" placeholder="Rôle">
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger delete-member ms-3">
                        <i class="material-symbols-outlined">delete</i>
                    </button>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-3">
            <button type="button" id="add-member-btn"
                    class="btn btn-outline-secondary rounded-circle p-0 d-flex align-items-center justify-content-center"
                    style="width: 40px; height: 40px;">
                <i class="material-symbols-outlined">add</i>
            </button>
        </div>
    </div>

    <!-- Galerie photos -->
    <div class="mb-4">
        <label class="form-label fw-bold">Photos de l'entreprise</label>

        @php
            $images = collect($recruiter['medias'] ?? [])->where('type', 'company_image');
        @endphp

        @if($images->isNotEmpty())
            <div class="mb-3">
                <p class="text-muted small mb-2">Cochez les images à supprimer :</p>
                <div class="d-flex flex-wrap gap-2">
                    @foreach($images as $image)
                        <div class="position-relative image-item" style="width: 150px;" data-id="{{ $image['id'] }}">
                            <img src="{{ config('app.api') . '/' . $image['filePath'] }}"
                                 class="img-thumbnail w-100"
                                 style="height: 150px; object-fit: cover;">
                            <div class="position-absolute top-0 end-0 m-1">
                                <div class="form-check bg-white rounded p-1 shadow-sm">
                                    <input class="form-check-input delete-image-checkbox" type="checkbox"
                                           name="delete_images[]" value="{{ $image['id'] }}" id="img{{ $image['id'] }}">
                                    <label class="form-check-label text-danger fw-bold" for="img{{ $image['id'] }}">
                                        X
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
                <small class="text-muted">(Max 5 fichiers, 5 Mo chacun)</small>
            </label>
            <input type="file" class="form-control" id="new_images" name="new_images[]"
                   accept="image/jpeg,image/png,image/jpg" multiple>
            <div id="images_preview" class="d-flex flex-wrap gap-2 mt-2"></div>
        </div>
    </div>

    <!-- Submit -->
    <div class="mt-4">
        <button type="submit" class="btn btn-primary w-100 py-2">
            <i class="bi bi-check-circle me-2"></i>Mettre à jour le profil
        </button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const logoInput = document.getElementById('new_logo');
        const deleteLogoCheckbox = document.getElementById('deleteLogo');
        const logoPreview = document.getElementById('logo_preview');
        const imagesInput = document.getElementById('new_images');
        const imagesPreview = document.getElementById('images_preview');
        const maxSize = 5 * 1024 * 1024; // 5 Mo
        const maxFiles = 5;

        // === Désactiver suppression logo si nouveau upload ===
        logoInput?.addEventListener('change', function () {
            if (this.files.length > 0 && deleteLogoCheckbox) {
                deleteLogoCheckbox.checked = false;
                deleteLogoCheckbox.disabled = true;
            } else if (deleteLogoCheckbox) {
                deleteLogoCheckbox.disabled = false;
            }
        });

        // === Preview logo ===
        logoInput?.addEventListener('change', function (e) {
            logoPreview.innerHTML = '';
            const file = e.target.files[0];
            if (!file) return;

            if (file.size > maxSize) {
                alert('Le logo ne doit pas dépasser 5 Mo.');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail';
                img.style.maxWidth = '200px';
                img.style.maxHeight = '200px';
                img.style.objectFit = 'contain';
                logoPreview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });

        // === Preview images + validation ===
        imagesInput?.addEventListener('change', function (e) {
            imagesPreview.innerHTML = '';
            const files = Array.from(e.target.files);

            if (files.length > maxFiles) {
                alert(`Maximum ${maxFiles} images autorisées.`);
                this.value = '';
                return;
            }

            files.forEach(file => {
                if (file.size > maxSize) {
                    alert(`"${file.name}" dépasse 5 Mo.`);
                    imagesInput.value = '';
                    imagesPreview.innerHTML = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = e => {
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
        });

        // === Feedback visuel suppression image ===
        document.querySelectorAll('.delete-image-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const item = this.closest('.image-item');
                if (this.checked) {
                    item.style.opacity = '0.4';
                    item.style.pointerEvents = 'none';
                } else {
                    item.style.opacity = '1';
                    item.style.pointerEvents = 'auto';
                }
            });
        });

        // === Membres équipe ===
        let memberIndex = {{ count($recruiter['teamMembers'] ?? []) }};
        const deletedIdsInput = document.getElementById('deleted_member_ids');

        document.getElementById('add-member-btn').addEventListener('click', () => {
            const container = document.getElementById('team-members-list');
            const html = `
            <div class="card col-12 col-md-6 rounded p-3 mb-2 bg-light member-card">
                <div class="flex-grow-1">
                    <input type="text" name="teamMembers[${memberIndex}][name]" class="form-control mb-1" placeholder="Nom" required>
                    <input type="email" name="teamMembers[${memberIndex}][email]" class="form-control mb-1" placeholder="Email">
                    <input type="text" name="teamMembers[${memberIndex}][role]" class="form-control" placeholder="Rôle">
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger delete-member ms-3">
                    <i class="material-symbols-outlined">delete</i>
                </button>
            </div>`;
            container.insertAdjacentHTML('beforeend', html);
            memberIndex++;
        });

        document.addEventListener('click', e => {
            const btn = e.target.closest('.delete-member');
            if (!btn) return;

            const card = btn.closest('.member-card');
            const idInput = card.querySelector('input[name*="[id]"]');
            if (idInput?.value) {
                const ids = deletedIdsInput.value ? deletedIdsInput.value.split(',') : [];
                ids.push(idInput.value);
                deletedIdsInput.value = ids.filter(Boolean).join(',');
            }
            card.remove();
        });

        // === Auto-resize textarea ===
        document.querySelectorAll('.auto-resize').forEach(textarea => {
            const resize = () => {
                textarea.style.height = 'auto';
                textarea.style.height = textarea.scrollHeight + 'px';
            };
            textarea.addEventListener('input', resize);
            resize();
        });
    });
</script>
