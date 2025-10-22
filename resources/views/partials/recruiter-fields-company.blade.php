<form action="{{ route('recruiter.update', $recruiter['id']) }}" method="POST" enctype="multipart/form-data" id="recruiter-profile-form">
    @csrf
    @method('PUT')

    <h5 class="fw-bold mb-3">Général</h5>

    <div class="mb-3">
        <label for="companyName" class="form-label">Nom de l’entreprise</label>
        <input type="text" class="form-control" id="companyName" name="companyName"
               value="{{ old('companyName', $recruiter['companyName'] ?? '') }}" required>
    </div>

    <div class="mb-3">
        <label for="siret" class="form-label">Siret de l’entreprise</label>
        <input type="text" class="form-control" id="siret" name="siret"
               value="{{ old('siret', $recruiter['siret'] ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="companyDescription" class="form-label">Description de l’entreprise</label>
        <textarea class="form-control" id="companyDescription" name="companyDescription" rows="3">{{ old('companyDescription', $recruiter['companyDescription'] ?? '') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="location" class="form-label">Lieu de l’entreprise</label>
        <input type="text" class="form-control" id="location" name="location"
               value="{{ old('location', $recruiter['location'] ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="website" class="form-label">Site web de l’entreprise</label>
        <input type="text" class="form-control" id="website" name="website"
               value="{{ old('website', $recruiter['website'] ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="sector" class="form-label">Secteur d’activité</label>
        <select class="form-select" id="sector" name="sector">
            <option value="" disabled {{ old('sector', $recruiter['sector'] ?? '') == '' ? 'selected' : '' }}>Sélectionnez un secteur</option>
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
        <label for="teamSize" class="form-label">Taille de l’entreprise</label>
        <input type="text" class="form-control" id="teamSize" name="teamSize"
               value="{{ old('teamSize', $recruiter['teamSize'] ?? '') }}">
    </div>

    <div class="mb-3">
        <label for="contactPhone" class="form-label">Contact (téléphone)</label>
        <input type="text" class="form-control" id="contactPhone" name="contactPhone"
               value="{{ old('contactPhone', $recruiter['contactPhone'] ?? '') }}" minlength="10" maxlength="20">
    </div>

    <div class="mb-3">
        <label for="contactEmail" class="form-label">Contact (e-mail)</label>
        <input type="email" class="form-control" id="contactEmail" name="contactEmail"
               value="{{ old('contactEmail', $recruiter['contactEmail'] ?? '') }}">
    </div>

    <h5 class="fw-bold mb-3 mt-4">Logo et équipe</h5>

    <div class="mb-3">
        <x-media-uploader :label="'Logo de l\'entreprise'" :medias="$recruiter['medias']" type="company_logo" context="company_page"
                          target-type="recruiter" :title="'Logo ' . $recruiter['companyName']" :target-id="$recruiter['id']" :isMultiple="false" />
    </div>

    <div class="mb-3">
        <x-recruiter-team-member-form :recruiter="$recruiter" />
    </div>

    <div class="mb-3">
        <x-media-uploader :label="'Photos de l\'entreprise'" :medias="$recruiter['medias']" type="company_image" context="company_page"
                          target-type="recruiter" :title="'Galerie ' . $recruiter['companyName']" :target-id="$recruiter['id']" :isMultiple="true" />
    </div>

    <div class="mt-3">
        <button type="submit" class="btn btn-primary w-100">Mettre à jour</button>
    </div>
</form>
