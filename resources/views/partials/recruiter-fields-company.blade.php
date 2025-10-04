<div class="row justify-content-between">
    <div class="col-12 col-md-6 mb-4">

        <h5 class="fw-bold">Général</h5>
        <form action="{{ route('recruiter.update', $recruiter['id']) }}" method="POST" enctype="multipart/form-data"
            id="recruiter-profile-form">
            @csrf
            @method('PUT')

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
                <input type="text" class="form-control" id="sector" name="sector"
                    value="{{ old('sector', $recruiter['sector'] ?? '') }}">
            </div>

            <div class="mb-3">
                <label for="teamSize" class="form-label">Taille de l’entreprise</label>
                <input type="text" class="form-control" id="teamSize" name="teamSize"
                    value="{{ old('teamSize', $recruiter['teamSize'] ?? '') }}">
            </div>

            <div class="mb-3">
                <label for="contactPhone" class="form-label">Contact (téléphone)</label>
                <input type="text" class="form-control" id="contactPhone" name="contactPhone"
                    value="{{ old('contactPhone', $recruiter['contactPhone'] ?? '') }}">
            </div>

            <div class="mb-3">
                <label for="contactEmail" class="form-label">Contact (e-mail)</label>
                <input type="email" class="form-control" id="contactEmail" name="contactEmail"
                    value="{{ old('contactEmail', $recruiter['contactEmail'] ?? '') }}">
            </div>

            <button type="submit" class="btn btn-primary">
                Mettre à jour
            </button>
        </form>
    </div>
    <div class="col-12 col-md-6">
        <div class="mb-3">
            <x-media-uploader :label="'logo de l\'entreprise'" :medias="$recruiter['medias']" type="company_logo" context="company_page"
                target-type="recruiter" :title="'Logo ' . $recruiter['companyName']" :target-id="$recruiter['id']" :isMultiple=false />
        </div>

        <div class="mb-3">
            <x-recruiter-team-member-form :recruiter="$recruiter" />
        </div>
    </div>
    <div class="col-12">
        <div class="mb-3">
            <x-media-uploader :label="'photos de l\'entreprise'" :medias="$recruiter['medias']" type="company_image" context="company_page"
                target-type="recruiter" :title="'Galerie ' . $recruiter['companyName']" :target-id="$recruiter['id']" :isMultiple=true />

        </div>
    </div>
</div>
