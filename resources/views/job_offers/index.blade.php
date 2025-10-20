@extends('layouts.app')

@section('title', 'Offres d\'emploi')

@section('content')
    <div class="container py-4 pt-5">
        <h1 class="fw-bold mb-4 mt-5 gradient-text">Offres d'emploi</h1>
        <!-- Barre de recherche + filtres -->
        <div class="mb-4">
            <div class="card-body">
                {{-- Formulaire de filtres --}}
                <form id="filter-form" method="GET" class="filter-form">
                    <div class="filter-container">
                        <div class="filter-group">
                            <label for="search" class="filter-label">
                                <span class="material-symbols-outlined">search</span>
                                Recherche
                            </label>
                            <input type="text" name="q" id="search" class="filter-input"
                                   placeholder="Titre ou description">
                        </div>

                        <div class="filter-group">
                            <label for="location" class="filter-label">
                                <span class="material-symbols-outlined">location_on</span>
                                Localisation
                            </label>
                            <select name="location" id="location" class="filter-select">
                                <option value="">Toutes localisations</option>
                                <option value="Paris">Paris</option>
                                <option value="Lyon">Lyon</option>
                                <option value="Marseille">Marseille</option>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label for="sector" class="filter-label">
                                <span class="material-symbols-outlined">business_center</span>
                                Secteur
                            </label>
                            <select name="sector" id="sector" class="filter-select">
                                <option value="">Tous secteurs</option>
                                <option value="IT">Informatique</option>
                                <option value="Finance">Finance</option>
                                <option value="RH">Ressources humaines</option>
                            </select>
                        </div>

                        <button type="submit" class="filter-btn">
                            <span class="material-symbols-outlined">tune</span>
                            Filtrer
                        </button>
                    </div>
                </form>

                <style>
                    .filter-form {
                        margin-bottom: 2rem;
                    }

                    .filter-container {
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                        gap: 1.5rem;
                        align-items: flex-end;
                        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
                        padding: 2rem;
                        border-radius: 16px;
                        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
                    }

                    .filter-group {
                        display: flex;
                        flex-direction: column;
                        gap: 0.75rem;
                    }

                    .filter-label {
                        font-size: 0.95rem;
                        font-weight: 600;
                        color: #1a202c;
                        display: flex;
                        align-items: center;
                        gap: 0.5rem;
                        cursor: pointer;
                        margin: 0;
                    }

                    .filter-label .material-symbols-outlined {
                        font-size: 20px;
                        color: var(--indigo);
                    }

                    .filter-input,
                    .filter-select {
                        padding: 0.75rem 1rem;
                        border: 2px solid #e2e8f0;
                        border-radius: 10px;
                        font-size: 0.95rem;
                        color: #1a202c;
                        background: #ffffff;
                        transition: all 0.3s ease;
                        font-family: inherit;
                    }

                    .filter-input::placeholder {
                        color: #a0aec0;
                    }

                    .filter-input:focus,
                    .filter-select:focus {
                        outline: none;
                        border-color: var(--indigo);
                        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
                    }

                    .filter-input:hover,
                    .filter-select:hover {
                        border-color: var(--indigo);
                    }

                    .filter-select {
                        cursor: pointer;
                        appearance: none;
                        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23083838' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
                        background-repeat: no-repeat;
                        background-position: right 1rem center;
                        padding-right: 2.5rem;
                    }

                    .filter-btn {
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        gap: 0.5rem;
                        padding: 0.75rem 1.5rem;
                        background: linear-gradient(135deg, var(--indigo), var(--aquamarine));
                        color: var(--sand);
                        border: none;
                        border-radius: 10px;
                        font-size: 0.95rem;
                        font-weight: 600;
                        cursor: pointer;
                        transition: all 0.3s ease;
                        width: 100%;
                    }

                    .filter-btn:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 10px 15px -3px rgba(8, 56, 61, 0.3);
                        color: var(--sand);
                    }

                    .filter-btn .material-symbols-outlined {
                        font-size: 20px;
                    }

                    @media (max-width: 768px) {
                        .filter-container {
                            grid-template-columns: 1fr;
                            padding: 1.5rem;
                            gap: 1rem;
                        }

                        .filter-btn {
                            width: 100%;
                        }
                    }

                    /* Styles des cartes offres */
                    .offer-card {
                        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
                        border-radius: 16px;
                        overflow: hidden;
                        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
                        position: relative;
                        height: 100%;
                        display: flex !important;
                        flex-direction: column;
                        text-decoration: none !important;
                        color: inherit !important;
                        border: 1px solid rgba(255, 255, 255, 0.5);
                    }

                    .offer-card:hover {
                        transform: translateY(-8px);
                        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
                    }

                    .offer-header {
                        padding: 24px 20px;
                        background: linear-gradient(135deg, rgba(5, 56, 61, 0.05), rgba(56, 118, 124, 0.05));
                        border-bottom: 1px solid rgba(5, 56, 61, 0.1);
                    }

                    .offer-company {
                        display: flex;
                        align-items: center;
                        gap: 12px;
                        margin-bottom: 12px;
                    }

                    .offer-company-logo {
                        width: 40px;
                        height: 40px;
                        border-radius: 8px;
                        background: linear-gradient(135deg, var(--indigo), var(--aquamarine));
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        color: var(--white);
                        font-weight: 600;
                        font-size: 14px;
                        flex-shrink: 0;
                        box-shadow: 0 4px 12px rgba(5, 56, 61, 0.2);
                    }

                    .offer-company-name {
                        font-size: 13px;
                        color: var(--indigo);
                        font-weight: 600;
                        text-transform: uppercase;
                        letter-spacing: 0.5px;
                    }

                    .offer-card .card-title {
                        font-size: 18px;
                        font-weight: 700 !important;
                        color: #1a202c;
                        margin-bottom: 8px !important;
                        line-height: 1.3;
                        letter-spacing: -0.5px;
                    }

                    .offer-meta {
                        display: flex;
                        gap: 12px;
                        flex-wrap: wrap;
                        font-size: 13px;
                        color: #718096;
                        margin: 0 !important;
                    }

                    .meta-item {
                        display: flex;
                        align-items: center;
                        gap: 4px;
                    }

                    .offer-body {
                        padding: 20px;
                        flex-grow: 1;
                        display: flex;
                        flex-direction: column;
                    }

                    .offer-card .card-text {
                        color: #4a5568;
                        font-size: 14px;
                        line-height: 1.6;
                        margin-bottom: 16px !important;
                        display: -webkit-box;
                        -webkit-line-clamp: 2;
                        -webkit-box-orient: vertical;
                        overflow: hidden;
                        flex-grow: 1;
                    }

                    .offer-footer {
                        padding: 20px;
                        border-top: 1px solid rgba(5, 56, 61, 0.08);
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        gap: 12px;
                    }

                    .offer-salary {
                        flex-grow: 1;
                    }

                    .salary-label {
                        font-size: 12px;
                        color: #718096;
                        text-transform: uppercase;
                        letter-spacing: 0.5px;
                        margin-bottom: 4px;
                    }

                    .salary-amount {
                        font-size: 16px;
                        font-weight: 700;
                        background: linear-gradient(135deg, #E17333, #FF8C50);
                        -webkit-background-clip: text;
                        -webkit-text-fill-color: transparent;
                        background-clip: text;
                    }

                    .offer-btn {
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        gap: 6px;
                        padding: 10px 16px;
                        background: linear-gradient(135deg, var(--indigo), var(--aquamarine));
                        color: var(--sand) !important;
                        border: none;
                        border-radius: 10px;
                        font-size: 13px;
                        font-weight: 600;
                        cursor: pointer;
                        transition: all 0.3s ease;
                        text-decoration: none !important;
                        white-space: nowrap;
                    }

                    .offer-btn:hover {
                        transform: translateY(-2px);
                        box-shadow: 0 8px 16px rgba(5, 56, 61, 0.3);
                        color: var(--sand) !important;
                    }

                    @media (max-width: 768px) {
                        .offer-footer {
                            flex-direction: column;
                            align-items: stretch;
                        }

                        .offer-btn {
                            width: 100%;
                        }
                    }
                </style>
            </div>
        </div>

        <!-- Loader -->
        <div id="loader" class="text-center my-4 d-none">
            <div class="spinner-border text-success" role="status"></div>
            <p class="mt-2">Chargement des offres...</p>
        </div>

        <!-- Liste des offres -->
        <div id="offers-list" class="row g-3 min-vh-100"></div>

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
                                const companyName = offer.recruiter?.companyName || 'Entreprise';
                                const companyInitials = companyName.substring(0, 2).toUpperCase();
                                const salaryDisplay = offer.salaryMin && offer.salaryMax
                                    ? `${offer.salaryMin}€ - ${offer.salaryMax}€`
                                    : offer.salaryMin
                                        ? `À partir de ${offer.salaryMin}€`
                                        : 'Non communiqué';

                                offersList.innerHTML += `
                            <div class="col-md-4">
                                <a href="/job_offers/${offer.id}" class="card offer-card text-decoration-none">
                                    <div class="offer-header">
                                        <div class="offer-company">
                                            <div class="offer-company-logo">${companyInitials}</div>
                                            <div class="offer-company-name">${companyName}</div>
                                        </div>
                                        <h5 class="card-title">${offer.title}</h5>
                                        <div class="offer-meta">
                                            <div class="meta-item">
                                                <span class="material-symbols-outlined">location_on</span>
                                                <span>${offer.location}</span>
                                            </div>
                                            <div class="meta-item">
                                                <span class="material-symbols-outlined">schedule</span>
                                                <span>${offer.employmentType}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body offer-body">
                                        <p class="card-text">${offer.description.substring(0, 150)}...</p>
                                    </div>
                                    <div class="offer-footer">
                                        <div class="offer-salary">
                                            <div class="salary-label">Salaire</div>
                                            <div class="salary-amount">${salaryDisplay}</div>
                                        </div>
                                        <button class="offer-btn" onclick="event.preventDefault(); window.location.href='/job_offers/${offer.id}'">
                                            <span class="material-symbols-outlined">arrow_forward</span>
                                            Voir
                                        </button>
                                    </div>
                                </a>
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
