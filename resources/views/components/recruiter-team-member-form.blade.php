<form action="{{ route('recruiter.members.sync', $recruiter['id']) }}" method="POST" id="team-members-form">
    @csrf

    <h5 class="fw-bold mt-4">Membres de l’équipe</h5>

    <div id="team-members-list" class="row">
        {{-- Membres à supprimer --}}
        <input type="hidden" name="deletedIds" id="deletedIds">

        {{-- Membres existants --}}
        @foreach ($recruiter['teamMembers'] ?? [] as $index => $member)
            <div class="card col-12 col-md-6 rounded p-3 mb-2 d-flex justify-content-between align-items-center bg-light member-card">
                <div>
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

    {{-- Bouton d’ajout --}}
    <div class="d-flex justify-content-center mt-2">
        <button type="button" id="add-member-btn"
                class="btn rounded-circle p-0 d-flex align-items-center justify-content-center"
                style="width: 40px; height: 40px; background-color: #ced4da;">
            <i class="material-symbols-outlined">add</i>
        </button>
    </div>

    <div class="text-end mt-3">
        <button type="submit" class="btn btn-success">Sauvegarder les membres</button>
    </div>
</form>

<script>
    let memberIndex = {{ count($recruiter['teamMembers'] ?? []) }};
    const deletedInput = document.getElementById('deletedIds');

    // 🧱 Ajouter un membre
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

    // 🗑️ Supprimer un membre (juste côté front)
    document.addEventListener('click', async (e) => {
        const btn = e.target.closest('.delete-member');
        if (!btn) return;

        e.preventDefault(); // ⚠️ empêche le navigateur de suivre le bouton comme un submit ou lien

        const card = btn.closest('.member-card');
        const hiddenId = card.querySelector('input[name*="[id]"]');

        if (hiddenId && hiddenId.value) {
            const memberId = hiddenId.value;

            console.log('clic', memberId)
            try {
                const response = await fetch(`/recruiter/{{ $recruiter['id'] }}/team/${memberId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                });

                const result = await response.json();

                if (response.ok) {
                    card.remove();
                } else {
                    alert(result.message || 'Erreur lors de la suppression.');
                }
            } catch (err) {
                console.error(err);
                alert('Erreur lors de la suppression.');
            }
        } else {
            card.remove();
        }
    });
</script>
