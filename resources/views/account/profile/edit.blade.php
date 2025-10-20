@extends('layouts.app')
@section('title', 'Modifier mon profil | Discorev')

@section('content')
    <div class="container my-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h2>Modifier mon profil</h2>
                <small class="disabled">{{ $type }}</small>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-3">
                        <ul class="nav nav-tabs flex-md-column flex-row me-3" id="profileTabs">
                            @foreach ($tabs as $key => $tab)
                                <li class="nav-item">
                                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" href="#"
                                        data-tab="{{ $key }}">
                                        <span class="material-symbols-outlined me-1">{{ $tab['icon'] }}</span>
                                        {{ $tab['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-12 col-md-9" id="tab-content">
                        @foreach ($tabs as $key => $tab)
                            <div class="tab-pane {{ $loop->first ? 'd-block' : 'd-none' }}" id="{{ $key }}">
                                @switch($key)
                                    @case('company')
                                        @include('partials.recruiter-fields-company', [
                                            'recruiter' => $recruiter,
                                            'sectors' => $sectors,
                                        ])
                                    @break

                                    @case('account-recruiter')
                                        @include('partials.account-fields', ['user' => $user])
                                    @break

                                    @case('page')
                                        @include('partials.recruiter-fields-page', [
                                            'recruiter' => $recruiter,
                                        ])
                                    @break

                                    @case('profile')
                                        @include('partials.candidate-fields-profile', ['user' => $user])
                                    @break

                                    @case('account-candidate')
                                        @include('partials.account.fields', ['user' => $user])
                                    @break

                                    @case('cv')
                                        @include('partials.candidate-fields-cv', ['user' => $user])
                                    @break

                                    @case('help')
                                        <div class="alert alert-info">Page d'aide à venir 🚧</div>
                                    @break
                                @endswitch
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('#profileTabs .nav-link');
            const panes = document.querySelectorAll('#tab-content .tab-pane');

            // Fonction pour activer un onglet donné
            function activateTab(selected) {
                tabs.forEach(tab => {
                    tab.classList.toggle('active', tab.getAttribute('data-tab') === selected);
                });
                panes.forEach(pane => {
                    pane.classList.toggle('d-block', pane.id === selected);
                    pane.classList.toggle('d-none', pane.id !== selected);
                });
            }

            // Récupère le paramètre tab dans l'URL
            function getTabFromURL() {
                const params = new URLSearchParams(window.location.search);
                return params.get('tab');
            }

            // Met à jour le paramètre tab dans l'URL sans recharger la page
            function updateURL(tab) {
                const params = new URLSearchParams(window.location.search);
                params.set('tab', tab);
                const newUrl = window.location.pathname + '?' + params.toString();
                history.replaceState(null, '', newUrl);
            }

            // Écouteur de clic sur chaque tab
            tabs.forEach(tab => {
                tab.addEventListener('click', function(e) {
                    e.preventDefault();
                    const selected = tab.getAttribute('data-tab');
                    activateTab(selected);
                    updateURL(selected);
                });
            });

            // Au chargement, active l'onglet depuis l'URL ou le premier par défaut
            let initialTab = getTabFromURL();

            // Vérifie que l'onglet existe dans les tabs
            if (!initialTab || ![...tabs].some(t => t.getAttribute('data-tab') === initialTab)) {
                initialTab = tabs[0].getAttribute('data-tab'); // premier onglet par défaut
            }

            activateTab(initialTab);
        });
    </script>

    <style>
        #profileTabs .nav-link {
            color: var(--indigo);
        }

        #profileTabs .nav-link.active {
            color: var(--indigo);
            font-weight: 500;
        }

        #profileTabs .nav-link:hover {
            color: var(--indigo);
            text-decoration: underline;
        }
    </style>
@endsection
