<div class="row justify-content-between">
    <div class="col-12 col-md-6">
        <form method="POST" action="{{ route('profile.update', session('user.id')) }}" class="mb-4">
            @csrf
            @method('PUT')
            <h5>Informations générales</h5>

            <div class="mb-3">
                <label>Prénom</label>
                <input type="text" name="firstName" class="form-control"
                    value="{{ old('firstName', session('user.firstName')) }}">
            </div>
            <div class="mb-3">
                <label>Nom</label>
                <input type="text" name="lastName" class="form-control"
                    value="{{ old('lastName', session('user.lastName')) }}">
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                    value="{{ old('email', session('user.email')) }}">
            </div>
            <div class="mb-3">
                <label>N° de téléphone</label>
                <input type="text" name="contactPhone" class="form-control"
                       value="{{ old('contactPhone', session('user.phoneNumber')) }}">
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>
    {{-- Section Avatar --}}
    <div class="col-12 col-md-6">
        <x-media-uploader :label="'photo de profil'" :medias="session('user.medias')" type="profile_picture" context="user_profile"
            target-type="user" :title="'Photo de ' . session('user.lastName') . ' ' . session('user.firstName')" :target-id="session('user.id')" :isMultiple="false" />
    </div>
</div>
