<div class="row justify-content-between">
    <div class="col-12 col-md-6">
        <form method="POST" action="{{ route('profile.update', $user['id']) }}" class="mb-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="section" value="general">
            <h5>Informations générales</h5>

            @if (session('success_general'))
                <div class="alert alert-success">{{ session('success_general') }}</div>
            @endif

            <div class="mb-3">
                <label>Prénom</label>
                <input type="text" name="firstName" class="form-control"
                    value="{{ old('firstName', auth()->user()->firstName) }}">
            </div>
            <div class="mb-3">
                <label>Nom</label>
                <input type="text" name="lastName" class="form-control"
                    value="{{ old('lastName', auth()->user()->lastName) }}">
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                    value="{{ old('email', auth()->user()->email) }}">
            </div>
            <div class="mb-3">
                <label>N° de téléphone</label>
                <input type="text" name="phoneNumber" class="form-control"
                    value="{{ old('phoneNumber', auth()->user()->phoneNumber) }}">
            </div>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>
    {{-- Section Avatar --}}
    <div class="col-12 col-md-6">
        <x-media-uploader :label="'photo de profil'" :medias="$user['medias']" type="profile_picture" context="user_profile"
            target-type="user" :title="'Photo de ' . $user['lastName'] . ' ' . $user['firstName']" :target-id="$user['id']" :isMultiple="false" />
    </div>
</div>
