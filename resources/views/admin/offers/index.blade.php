@extends('layouts.app')

@section('title', 'Administrateur | Liste des offres')

@section('content')
    <script src="//unpkg.com/alpinejs" defer></script>

    <div class="container py-4 pt-5">
        <h1 class="fw-bold mb-4 mt-5">Administrateur | Offres d'emplois</h1>

        <div class="list-group">

            @foreach ($offers as $offer)
                <div class="list-group-item py-3 px-4 shadow-sm border-0 mb-3 rounded-3" x-data="{ edit: false }">

                    {{-- VIEW MODE --}}
                    <template x-if="!edit">
                        <div class="d-flex flex-wrap justify-content-between align-items-center">

                            <div class="me-3" style="min-width: 220px;">
                                <div class="fw-bold fs-5">{{ $offer->title }}</div>
                                <div class="text-muted small">
                                    {{ $offer->recruiter->companyName ?? 'Entreprise inconnue' }}
                                </div>
                            </div>

                            <div class="text-muted small me-3" style="min-width: 280px;">
                                <strong>Desc :</strong> {{ Str::limit($offer->description, 60) }} <br>
                                <strong>Req :</strong> {{ Str::limit($offer->requirements, 60) }}
                            </div>

                            <div class="text-muted small me-3" style="min-width: 160px;">
                                <strong>Salaire :</strong><br>
                                @if ($offer->salaryMin || $offer->salaryMax)
                                    {{ number_format($offer->salaryMin ?? 0, 0, ',', ' ') }} –
                                    {{ number_format($offer->salaryMax ?? 0, 0, ',', ' ') }} €
                                @else
                                    -
                                @endif
                            </div>

                            <div class="text-muted small me-3" style="min-width: 100px;">
                                <strong>Type :</strong><br>
                                {{ strtoupper($offer->employmentType) }}
                            </div>

                            <div class="text-muted small me-3" style="min-width: 140px;">
                                <strong>Lieu :</strong><br>
                                {{ $offer->location }}
                                @if ($offer->remote)
                                    <span class="badge bg-info ms-1">Remote</span>
                                @endif
                            </div>

                            <div class="text-muted small me-3" style="min-width: 220px;">
                                <strong>Dates :</strong><br>
                                Publ.: {{ optional($offer->publicationDate)->format('d/m/Y') ?? '-' }} |
                                Début: {{ optional($offer->startDate)->format('d/m/Y') ?? '-' }} |
                                Fin: {{ optional($offer->endDate)->format('d/m/Y') ?? '-' }} |
                                Exp.: {{ optional($offer->expirationDate)->format('d/m/Y') ?? '-' }}
                            </div>

                            <div class="me-3" style="min-width: 90px;">
                                <span
                                    class="badge 
                                @if ($offer->status === 'active') bg-success
                                @elseif($offer->status === 'inactive') bg-warning
                                @elseif($offer->status === 'draft') bg-secondary
                                @else bg-danger @endif">
                                    {{ ucfirst($offer->status) }}
                                </span>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="button"
                                    class="btn btn-warning p-2 rounded-circle d-flex align-items-center justify-content-center"
                                    style="width:38px;height:38px;" @click="edit = true">
                                    <i class="material-symbols-outlined">edit</i>
                                </button>

                                <form action="{{ route('admin.offers.delete', $offer->id) }}" method="POST"
                                    onsubmit="return confirm('Supprimer cette offre ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="btn btn-danger p-2 rounded-circle d-flex align-items-center justify-content-center"
                                        style="width:38px;height:38px;">
                                        <i class="material-symbols-outlined">delete</i>
                                    </button>
                                </form>
                            </div>

                        </div>
                    </template>

                    {{-- EDIT MODE --}}
                    <template x-if="edit">
                        <form action="{{ route('admin.offers.update', $offer->id) }}" method="POST"
                            class="row gx-2 gy-2 align-items-end">
                            @csrf
                            @method('PUT')

                            <div class="col-md-3">
                                <label class="form-label small mb-1">Titre</label>
                                <input name="title" type="text" class="form-control form-control-sm"
                                    value="{{ $offer->title }}" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small mb-1">Lieu</label>
                                <input name="location" type="text" class="form-control form-control-sm"
                                    value="{{ $offer->location }}" required>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label small mb-1">Contrat</label>
                                <select name="employmentType" class="form-select form-select-sm" required>
                                    @foreach (['cdi', 'cdd', 'freelance', 'alternance', 'stage'] as $t)
                                        <option value="{{ $t }}"
                                            @if ($offer->employmentType == $t) selected @endif>{{ strtoupper($t) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-1">
                                <label class="form-label small mb-1">Salaire min</label>
                                <input name="salaryMin" type="number" class="form-control form-control-sm"
                                    value="{{ $offer->salaryMin }}">
                            </div>

                            <div class="col-md-1">
                                <label class="form-label small mb-1">Salaire max</label>
                                <input name="salaryMax" type="number" class="form-control form-control-sm"
                                    value="{{ $offer->salaryMax }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small mb-1">Remote</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="remote" type="checkbox" value="1"
                                        id="remote{{ $offer->id }}" @if ($offer->remote) checked @endif>
                                    <label class="form-check-label small" for="remote{{ $offer->id }}">Remote</label>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small mb-1">Publication</label>
                                <input name="publicationDate" type="datetime-local" class="form-control form-control-sm"
                                    value="{{ optional($offer->publicationDate)->format('Y-m-d\TH:i') ?? '' }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small mb-1">Début</label>
                                <input name="startDate" type="datetime-local" class="form-control form-control-sm"
                                    value="{{ optional($offer->startDate)->format('Y-m-d\TH:i') ?? '' }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small mb-1">Fin</label>
                                <input name="endDate" type="datetime-local" class="form-control form-control-sm"
                                    value="{{ optional($offer->endDate)->format('Y-m-d\TH:i') ?? '' }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small mb-1">Expiration</label>
                                <input name="expirationDate" type="datetime-local" class="form-control form-control-sm"
                                    value="{{ optional($offer->expirationDate)->format('Y-m-d\TH:i') ?? '' }}">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label small mb-1">Description</label>
                                <textarea name="description" class="form-control form-control-sm" rows="2" required>{{ $offer->description }}</textarea>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label small mb-1">Requirements</label>
                                <textarea name="requirements" class="form-control form-control-sm" rows="2">{{ $offer->requirements }}</textarea>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small mb-1">Status</label>
                                <select name="status" class="form-select form-select-sm" required>
                                    @foreach (['active', 'inactive', 'draft', 'archived'] as $s)
                                        <option value="{{ $s }}"
                                            @if ($offer->status == $s) selected @endif>{{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 d-flex justify-content-end gap-2 mt-1">
                                <button type="button" class="btn btn-sm btn-secondary"
                                    @click="edit = false">Cancel</button>
                                <button type="submit" class="btn btn-sm btn-success">Save</button>
                            </div>

                        </form>
                    </template>

                </div>
            @endforeach

        </div>
    </div>
@endsection
