@extends('layouts.app')

@section('title', 'Offres d\'emploi | Discorev')

@section('content')
    <div class="container my-5">
        <h1 class="fw-bold mb-4">Vous aussi, trouvez le <span class="text-primary">job idéal</span></h1>

        {{-- Barre de recherche + filtres --}}
        <div class="card p-4 shadow-sm mb-4">
            <form id="filters-form" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <span class="material-symbols-outlined text-muted">search</span>
                        </span>
                        <input type="text" name="query" class="form-control" placeholder="Job, mot-clé, entreprise">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <span class="material-symbols-outlined text-muted">location_on</span>
                        </span>
                        <input type="text" name="location" class="form-control" placeholder="France">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="job_type" class="form-select">
                        <option value="">Type de job</option>
                        <option value="cdi">CDI</option>
                        <option value="cdd">CDD</option>
                        <option value="stage">Stage</option>
                        <option value="alternance">Alternance</option>
                        <option value="freelance">Freelance</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <span class="material-symbols-outlined me-1">tune</span> Rechercher
                    </button>
                </div>
            </form>
        </div>

        {{-- Loader --}}
        <div id="loader" class="text-center my-5 d-none">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-2">Chargement des offres...</p>
        </div>

        {{-- Liste des offres --}}
        <div id="offers-container">
            <div id="offers-list">

            </div>
            {{-- contenu injecté dynamiquement ici --}}
        </div>
    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("filters-form");
        const offersList = document.getElementById("offers-list");
        const loader = document.getElementById("loader");
        const offersContainer = document.getElementById("offers-container");

        let currentPage = 1;

        const fetchOffers = async (page = 1, useFilters = false) => {
            const formData = new FormData(form);
            const params = new URLSearchParams(formData);
            params.append('page', page);

            loader.classList.remove('d-none');
            offersList.innerHTML = ''; // Nettoie
            clearPagination(); // Nettoie la pagination

            const endpoint = useFilters ? 'job_offers/filters' : 'job_offers';

            try {
                const response = await fetch(
                    `{{ env('DISCOREV_API_URL') }}/${endpoint}?${params.toString()}`);
                const data = await response.json();
                const offers = data.data || [];
                console.log("Réponse de l'API :", offers); // 🔍 Vérifie le format ici

                if (offers.length === 0) {
                    offersList.innerHTML =
                        '<div class="alert alert-warning text-center">Aucune offre trouvée.</div>';
                } else {
                    renderOffers(offers);
                    renderPagination(data.meta);
                }
            } catch (error) {
                offersList.innerHTML =
                    '<div class="alert alert-danger">Erreur lors du chargement des offres.</div>';
                console.error(error);
            } finally {
                loader.classList.add('d-none');
            }
        };

        const renderOffers = (offers) => {
            offersList.innerHTML = '';

            offers.forEach((offer, index) => {
                const card = document.createElement('div');
                card.className = 'card shadow-sm mb-3 animated fadeIn';
                card.style.animationDelay = `${index * 100}ms`;

                card.innerHTML = `
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title mb-0">${offer.title}</h5>
                        <small class="text-muted">📅 ${new Date(offer.publicationDate).toLocaleDateString()}</small>
                    </div>
                    <p class="card-text text-muted">${offer.description?.substring(0, 120) || ''}...</p>

                    <div class="mb-3">
                        <span class="badge bg-primary me-1"><i class="material-symbols-outlined align-middle">location_on</i> ${offer.location}</span>
                        <span class="badge bg-info me-1"><i class="material-symbols-outlined align-middle">work</i> ${offer.employmentType.toUpperCase()}</span>
                        ${offer.remote ? '<span class="badge bg-success me-1"><i class="material-symbols-outlined align-middle">home</i> Télétravail</span>' : ''}
                        ${offer.salaryRange ? `<span class="badge bg-warning text-dark me-1"><i class="material-symbols-outlined align-middle">euro</i> ${offer.salaryRange}</span>` : ''}
                    </div>

                    <a href="/job_offers/${offer.id}" class="btn btn-outline-primary">
                        <span class="material-symbols-outlined align-middle">visibility</span> Voir l'offre
                    </a>
                </div>
            `;

                offersList.appendChild(card);
            });
        };

        const renderPagination = (meta) => {
            if (!meta || meta.totalPages <= 1) return;

            let paginationHTML = '<nav class="mt-4"><ul class="pagination justify-content-center">';
            for (let i = 1; i <= meta.totalPages; i++) {
                paginationHTML += `
                <li class="page-item ${meta.currentPage === i ? 'active' : ''}">
                    <button class="page-link" data-page="${i}">${i}</button>
                </li>
            `;
            }
            paginationHTML += '</ul></nav>';

            offersContainer.insertAdjacentHTML('beforeend', paginationHTML);

            document.querySelectorAll('.page-link').forEach(btn => {
                btn.addEventListener('click', () => {
                    currentPage = parseInt(btn.dataset.page);
                    fetchOffers(currentPage, true);
                });
            });
        };

        const clearPagination = () => {
            const paginations = offersContainer.querySelectorAll('nav');
            paginations.forEach(nav => nav.remove());
        };

        // Empêche soumission classique du formulaire
        form.addEventListener('submit', e => {
            e.preventDefault();
            currentPage = 1;
            fetchOffers(currentPage, true);
        });

        // Filtres en temps réel
        form.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('input', () => {
                currentPage = 1;
                fetchOffers(currentPage, true);
            });
        });

        // Chargement initial
        fetchOffers(currentPage, false);
    });
</script>
