<form method="POST" action="{{ route('register.submit') }}" enctype="multipart/form-data">
    @csrf

    {{-- Prénom --}}
    <div class="mb-3">
        <label for="firstName" class="form-label">Prénom <span class="text-danger">*</span></label>
        <input id="firstName" type="text" class="form-control @error('firstName') is-invalid @enderror" name="firstName"
            value="{{ old('firstName') }}" required autofocus>
        @error('firstName')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    {{-- Nom  --}}
    <div class="mb-3">
        <label for="lastName" class="form-label">Nom de famille <span class="text-danger">*</span></label>
        <input id="lastName" type="text" class="form-control @error('lastName') is-invalid @enderror"
            name="lastName" value="{{ old('lastName') }}" required autofocus>
        @error('lastName')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    {{-- Email --}}
    <div class="mb-3">
        <label for="registerEmail" class="form-label">Email <span class="text-danger">*</span></label>
        <input id="registerEmail" type="email" class="form-control @error('registerEmail') is-invalid @enderror"
            name="registerEmail" value="{{ old('email') }}" required>
        @error('registerEmail')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    {{-- Mot de passe --}}
    <div class="mb-3">
        <label for="registerPassword" class="form-label">Mot de passe <span class="text-danger">*</span></label>
        <input id="registerPassword" type="password"
            class="form-control @error('registerPassword') is-invalid @enderror" name="registerPassword" required>
        @error('registerPassword')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    {{-- Confirmation mot de passe --}}
    <div class="mb-3">
        <label for="registerPassword_confirmation" class="form-label">Confirmer le mot de passe <span
                class="text-danger">*</span></label>
        <input id="registerPassword_confirmation" type="password" class="form-control"
            name="registerPassword_confirmation" required>
    </div>

    {{-- Téléphone --}}
    <div class="mb-3">
        <label for="phoneNumber" class="form-label">Téléphone <span class="text-danger">*</span></label>
        <input id="phoneNumber" type="text" class="form-control @error('phoneNumber') is-invalid @enderror"
            name="phoneNumber" value="{{ old('phoneNumber') }}" required>
        @error('phoneNumber')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    {{-- Type de compte (switch) --}}
    <div class="mb-4">
        <label class="form-label d-block">Vous êtes : <span class="text-danger">*</span></label>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="accountType" id="recruiter" value="recruiter"
                {{ old('accountType') === 'recruiter' ? 'checked' : '' }} required>
            <label class="form-check-label" for="recruiter">Recruteur</label>
        </div>

        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="accountType" id="candidate" value="candidate"
                {{ old('accountType') === 'candidate' ? 'checked' : '' }} required>
            <label class="form-check-label" for="candidate">Candidat</label>
        </div>

        @error('accountType')
            <span class="invalid-feedback d-block">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-check my-3">
        <input class="form-check-input @error('accept-cgu') is-invalid @enderror" type="checkbox" id="accept-cgu"
            name="accept-cgu" {{ old('accept-cgu') ? 'checked' : '' }} required>
        <label class="form-check-label" for="accept-cgu">
            J'accepte les <a href="#" data-bs-toggle="modal" data-bs-target="#modalCGU">Conditions Générales
                d'Utilisation</a> <span class="text-danger">*</span>
        </label>
        @error('accept-cgu')
            <span class="invalid-feedback d-block">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-check mb-3">
        <input class="form-check-input @error('accept-confidentiality') is-invalid @enderror" type="checkbox"
            id="accept-confidentiality" name="accept-confidentiality"
            {{ old('accept-confidentiality') ? 'checked' : '' }} required>
        <label class="form-check-label" for="accept-confidentiality">
            J'accepte la <a href="#" data-bs-toggle="modal" data-bs-target="#modalConfidentiality">Politique de
                confidentialité</a> <span class="text-danger">*</span>
        </label>
        @error('accept-confidentiality')
            <span class="invalid-feedback d-block">{{ $message }}</span>
        @enderror
    </div>


    <div class="form-check mb-3">
        <input class="form-check-input @error('newsletter') is-invalid @enderror" type="checkbox" id="newsletter"
            name="newsletter" {{ old('newsletter') ? 'checked' : '' }}>
        <label class="form-check-label" for="newsletter">
            Je souhaite m'inscrire à la newsletter
        </label>
    </div>

    {{-- Bouton d'inscription --}}
    <button type="submit" class="btn btn-highlight w-100">S'inscrire</button>
</form>

{{-- Modal CGU --}}
<div class="modal fade" id="modalCGU" tabindex="-1" aria-labelledby="modalCGULabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCGULabel">Conditions Générales d'Utilisation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <p>Voici les conditions générales d'utilisation...</p>
            </div>
        </div>
    </div>
</div>

{{-- Modal Politique de confidentialité --}}
<div class="modal fade" id="modalConfidentiality" tabindex="-1" aria-labelledby="modalConfidentialityLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalConfidentialityLabel">Politique de confidentialité</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <p>Voici la politique de confidentialité...</p>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-highlight {
        background: linear-gradient(135deg, var(--orangish),
        var(--larch-bolete));
        color: var(--sand) !important;
        border: none;
    }

    .btn-highlight:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(249, 137, 72, 0.3);
        color: var(--sand); }
</style>
