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
                        <li class="nav-item"><a class="nav-link text-white fw-medium"
                                href="{{ route('job_offers.index') }}">Offres</a></li>
                        <li class="nav-item"><a class="nav-link text-white fw-medium"
                                href="{{ route('companies.index') }}">Entreprises</a></li>
                        <li class="nav-item"><a class="nav-link text-white fw-medium"
                                href="{{ route('recruiters.tarifs') }}">Recruteurs</a></li>
                    </ul>
                    <div>
                        @if ($isAuthenticated && isset($user))
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
                    <li class="nav-item"><a class="nav-link text-white fw-regular"
                            href="{{ route('job_offers.index') }}">Offres</a></li>
                    <li class="nav-item"><a class="nav-link text-white fw-regular"
                            href="{{ route('companies.index') }}">Entreprises</a></li>
                    <li class="nav-item"><a class="text-white fw-regular btn btn-warning"
                            href="{{ route('recruiters.tarifs') }}">Premium</a></li>

                    @if ($isAuthenticated && isset($user))
                        @php
                            $isCandidate = $user['accountType'] === 'candidate';
                            $isRecruiter = $user['accountType'] === 'recruiter';
                            $isAdmin = $user['accountType'] === 'admin';
                        @endphp

                        @if ($isCandidate)
                            <!-- Dropdown Candidat -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white fw-medium" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Candidat
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('applications.candidate') }}">Mes
                                            candidatures</a></li>
                                </ul>
                            </li>
                        @endif

                        @if ($isRecruiter)
                            <!-- Dropdown Recruteur -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white fw-medium" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Recruteur
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('recruiter.jobs.create') }}">Publier
                                            une
                                            offre</a></li>
                                    <li><a class="dropdown-item" href="{{ route('recruiter.jobs.index') }}">Mes
                                            offres</a></li>
                                    <li><a class="dropdown-item" href="{{ route('cvtheque.index') }}">Cvthèque</a></li>
                                </ul>
                            </li>
                        @endif

                        @if ($isAdmin)
                            <!-- Dropdown Administrateur -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white fw-medium" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Administrateur
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('recruiter.jobs.create') }}">Gestion
                                            des utilisateurs</a></li>
                                    <li><a class="dropdown-item" href="{{ route('recruiter.jobs.index') }}">Gestion des
                                            offres</a></li>
                                    <li><a class="dropdown-item" href="{{ route('cvtheque.index') }}">Cvthèque</a></li>
                                </ul>
                            </li>
                        @endif
                    @endif
                </ul>

                @if ($isAuthenticated && isset($user))
                    @php
                        $profilePicture = collect(session('user.medias') ?? [])->firstWhere('type', 'profile_picture');
                        $profilePictureUrl = $profilePicture
                            ? env('DISCOREV_API_URL') . '/' . $profilePicture['filePath']
                            : asset('img/default-avatar.png');
                    @endphp
                    <!-- Dropdown Compte -->
                    <div class="dropdown">
                        <a class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                            href="#" data-bs-toggle="dropdown">
                            <img src="{{ $profilePictureUrl }}" alt="Profil"
                                class="rounded-circle me-2 object-fit-cover" width="36" height="36"
                                style="max-width:36px; max-height:36px;">
                            Mon compte
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">Profil</a></li>
                            <li><a class="dropdown-item" href="{{ route('settings') }}">Paramètres</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
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
