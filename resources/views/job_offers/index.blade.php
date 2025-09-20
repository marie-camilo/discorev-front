@extends('layouts.app')

@section('title', 'Offres d\'emploi')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Offres d'emploi</h1>

        <!-- Barre de recherche + filtres -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form id="filter-form" class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text">
                                <span class="material-symbols-outlined">search</span>
                            </span>
                            <input type="text" name="q" id="search" class="form-control"
                                placeholder="Titre ou description">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="location" id="location">
                            <option value="">Toutes localisations</option>
                            <option value="Paris">Paris</option>
                            <option value="Lyon">Lyon</option>
                            <option value="Marseille">Marseille</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="sector" id="sector">
                            <option value="">Tous secteurs</option>
                            <option value="IT">Informatique</option>
                            <option value="Finance">Finance</option>
                            <option value="RH">Ressources humaines</option>
                        </select>
                    </div>
                    <div class="col-md-2 text-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <span class="material-symbols-outlined">filter_alt</span> Filtrer
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Loader -->
        <div id="loader" class="text-center my-4 d-none">
            <div class="spinner-border text-success" role="status"></div>
            <p class="mt-2">Chargement des offres...</p>
        </div>

        <!-- Liste des offres -->
        <div id="offers-list" class="row g-3">
            <!-- Offres insérées ici par JS -->
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            <nav>
                <ul id="pagination" class="pagination"></ul>
            </nav>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const offersList = document.getElementById('offers-list');
            const loader = document.getElementById('loader');
            const pagination = document.getElementById('pagination');

            let currentPage = 1;
            const limit = 6;

            function fetchOffers(page = 1) {
                loader.classList.remove('d-none');
                offersList.innerHTML = '';
                pagination.innerHTML = '';
                currentPage = page;

                const params = new URLSearchParams({
                    page: page,
                    limit: limit,
                    includeRecruiter: 1,
                    q: document.getElementById('search').value,
                    location: document.getElementById('location').value,
                    sector: document.getElementById('sector').value
                });
                console.log('Envoi requête à :', `/job_offers?${params.toString()}`);

                axios.get(`/api/job_offers?${params.toString()}`)
                    .then(response => {
                        const offers = response.data.data
                        console.log(response);

                        if (offers.length === 0) {
                            offersList.innerHTML =
                                `<div class="col-12 text-center"><p>Aucune offre trouvée.</p></div>`;
                        } else {
                            offers.forEach(offer => {
                                offersList.innerHTML += `
                            <div class="col-md-4">
                                <div class="card shadow-sm h-100">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">${offer.title}</h5>
                                        <p class="text-muted mb-2">${offer.location} • ${offer.employmentType}</p>
                                        <p class="mb-3">${offer.description.substring(0, 100)}...</p>
                                        <div class="mt-auto">
                                            <p class="fw-bold text-success">${offer.salaryMin ? offer.salaryMin + '€' : ''} - ${offer.salaryMax ? offer.salaryMax + '€' : ''}</p>
                                            <a href="/job_offers/${offer.id}" class="btn btn-outline-primary w-100">
                                                Voir l'offre
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                            });
                        }

                        // Pagination (simple)
                        const totalPages = offers.length < limit ? page : page + 1;
                        if (totalPages > 1) {
                            for (let i = 1; i <= totalPages; i++) {
                                pagination.innerHTML += `
                            <li class="page-item ${i === currentPage ? 'active' : ''}">
                                <a class="page-link" href="#" data-page="${i}">${i}</a>
                            </li>`;
                            }
                        }
                    })
                    .catch((e) => {
                        offersList.innerHTML =
                            `<div class="col-12 text-center"><p class="text-danger">Erreur lors du chargement des offres.</p></div>`;
                        console.error('Erreur Axios :', e);

                    })
                    .finally(() => {
                        loader.classList.add('d-none');
                    });
            }

            // Listener filtres
            document.getElementById('filter-form').addEventListener('submit', function(e) {
                e.preventDefault();
                fetchOffers(1);
            });

            // Pagination click
            pagination.addEventListener('click', function(e) {
                if (e.target.tagName === 'A') {
                    e.preventDefault();
                    const page = parseInt(e.target.dataset.page);
                    fetchOffers(page);
                }
            });

            fetchOffers();
        });
    </script>
@endpush
