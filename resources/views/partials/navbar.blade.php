<header class="sticky-top">
    <nav class="navbar navbar-expand-lg bg-aquamarine shadow py-2 px-lg-5">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center text-white fw-bold fs-4" href="{{ route('home') }}">
                <img src="{{ asset('img/logos/logo-white.svg') }}" alt="logo Discorev" height="30" class="me-2">
                Discorev
            </a>

            <!-- Hamburger menu mobile -->
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Offcanvas menu mobile -->
            <div class="offcanvas offcanvas-end text-bg-aquamarine d-lg-none" tabindex="-1" id="offcanvasNavbar">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title text-white">Discorev</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav mb-3">
                        <li class="nav-item"><a class="nav-link text-white fw-medium" href="{{ route('home') }}">Accueil</a></li>
                        <li class="nav-item"><a class="nav-link text-white fw-medium" href="{{ route('job_offers.index') }}">Offres</a></li>
                        <li class="nav-item"><a class="nav-link text-white fw-medium" href="{{ route('companies.index') }}">Entreprises</a></li>
                        <li class="nav-item"><a class="nav-link text-white fw-medium" href="{{ route('recruiters.tarifs') }}">Recruteurs</a></li>
                    </ul>
                    <div>
                        @if($isAuthenticated && isset($user))
                            <a class="btn btn-login w-100 mb-2" href="{{ route('profile') }}">Mon compte</a>
                        @else
                            <a class="btn btn-login w-100" href="{{ route('auth', ['tab' => 'login']) }}">Connexion</a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Liens desktop -->
            <div class="d-none d-lg-flex align-items-center ms-auto gap-3">
                <ul class="navbar-nav d-flex flex-row gap-3 mb-0">
                    <li class="nav-item"><a class="nav-link text-white fw-medium" href="{{ route('home') }}">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link text-white fw-medium" href="{{ route('job_offers.index') }}">Offres</a></li>
                    <li class="nav-item"><a class="nav-link text-white fw-medium" href="{{ route('companies.index') }}">Entreprises</a></li>
                    <li class="nav-item"><a class="nav-link text-white fw-medium" href="{{ route('recruiters.tarifs') }}">Recruteurs</a></li>
                </ul>

                @if($isAuthenticated && isset($user))
                    <div class="dropdown">
                        <a class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                           href="#" data-bs-toggle="dropdown">
                            <img src="{{ $profilePictureUrl }}" alt="Profil" class="rounded-circle me-2" width="36" height="36">
                            Mon compte
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">Profil</a></li>
                            <li><a class="dropdown-item" href="{{ route('settings') }}">Paramètres</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Déconnexion</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('auth', ['tab' => 'login']) }}" class="btn btn-login">Connexion</a>
                @endif
            </div>

        </div>
    </nav>
</header>
