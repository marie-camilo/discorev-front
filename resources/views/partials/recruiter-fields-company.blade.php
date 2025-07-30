<div class="row justify-content-between">
    <div class="col-12 col-md-6">
        <form action="{{ route('recruiter.update', $recruiter['id']) }}" method="POST" enctype="multipart/form-data">
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
                <label for="contactPerson" class="form-label">Personne à contacter</label>
                <textarea class="form-control" id="contactPerson" name="contactPerson" rows="2">{{ old('contactPerson', $recruiter['contactPerson'] ?? '') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                Mettre à jour
            </button>
        </form>
    </div>
    <div class="col-12 col-md-6">
        <x-media-uploader :label="'logo de l\'entreprise'" :medias="$recruiter['medias']" type="company_logo" context="company_page"
            target-type="recruiter" :title="'Logo ' . $recruiter['companyName']" :target-id="$recruiter['id']" />
    </div>
</div>
