<header class="sticky-top">
    <nav class="navbar navbar-expand-lg bg-indigo shadow py-3 px-lg-5">
        <div class="container-fluid">
            <!-- Logo -->
            <a class="navbar-brand text-white" href="{{ route('home')}}">
                <img src="{{ asset('img/logos/logo-white.svg') }}" alt="logo Discorev" class="me-3">
                Discorev
            </a>

            <!-- Hamburger menu mobile -->
            <button class="navbar-toggler text-white" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Offcanvas menu mobile -->
            <div class="offcanvas offcanvas-end d-lg-none" tabindex="-1" id="offcanvasNavbar">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title text-white fw-bold">Discorev</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav w-100 mb-3">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('job_offers.index') }}">
                                Offres
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('companies.index') }}">
                                Entreprises
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('recruiters.tarifs') }}">
                                Prenium
                            </a>
                        </li>
                    </ul>

                    @if ($isAuthenticated && isset($user))
                        @php
                            $accountType = $user['accountType'] ?? null;
                            $isCandidate = $accountType === 'candidate';
                            $isRecruiter = $accountType === 'recruiter';
                        @endphp

                        @if ($isCandidate)
                            <a class="nav-link text-white" href="{{ route('applications.candidate') }}">
                                <span class="material-symbols-outlined">bookmark</span>
                                Mes candidatures
                            </a>
                        @endif

                        @if ($isRecruiter)
                            <a class="nav-link text-white" href="{{ route('recruiter.jobs.create') }}">
                                <span class="material-symbols-outlined">add</span>
                                Publier une offre
                            </a>
                            <a class="nav-link text-white" href="{{ route('recruiter.jobs.index') }}">
                                <span class="material-symbols-outlined">list</span>
                                Mes offres
                            </a>
                        @endif

                        <hr class="my-3 border-white border-opacity-25">
                        <a class="btn btn-login w-100 mb-2" href="{{ route('profile') }}">
                            <span class="material-symbols-outlined">person</span>
                            Mon compte
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="w-100">
                            @csrf
                            <button type="submit" class="btn btn-outline-light w-100">
                                <span class="material-symbols-outlined">logout</span>
                                Déconnexion
                            </button>
                        </form>
                    @else
                        <a class="btn btn-login w-100" href="{{ route('auth', ['tab' => 'login']) }}">
                            <span class="material-symbols-outlined">login</span>
                            Connexion
                        </a>
                    @endif
                </div>
            </div>

            <!-- Liens desktop -->
            <div class="d-none d-lg-flex align-items-center ms-auto gap-2">
                <ul class="navbar-nav d-flex flex-row mb-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('job_offers.index') }}">
                            Offres
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('companies.index') }}">
                            Entreprises
                        </a>
                    </li>

                    @if ($isAuthenticated && isset($user))
                        @php
                            $accountType = $user['accountType'] ?? null;
                            $isCandidate = $accountType === 'candidate';
                            $isRecruiter = $accountType === 'recruiter';
                            $isAdmin = $accountType === 'admin';
                        @endphp

                        @if ($isCandidate)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-outlined">bookmark</span>
                                    Candidat
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('applications.candidate') }}">
                                            <span class="material-symbols-outlined" style="font-size: 16px;">bookmark</span>
                                            Mes candidatures
                                        </a></li>
                                </ul>
                            </li>
                        @endif

                        @if ($isRecruiter)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-outlined">badge</span>
                                    Recruteur
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('recruiter.jobs.create') }}">
                                            <span class="material-symbols-outlined" style="font-size: 16px;">add</span>
                                            Publier une offre
                                        </a></li>
                                    <li><a class="dropdown-item" href="{{ route('recruiter.jobs.index') }}">
                                            <span class="material-symbols-outlined" style="font-size: 16px;">list</span>
                                            Mes offres
                                        </a></li>
                                    <li><a class="dropdown-item" href="{{ route('cvtheque.index') }}">
                                            <span class="material-symbols-outlined" style="font-size: 16px;">folder</span>
                                            Cvthèque
                                        </a></li>
                                </ul>
                            </li>
                        @endif

                        @if ($isAdmin)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-outlined">admin_panel_settings</span>
                                    Admin
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ route('recruiter.jobs.create') }}">
                                            <span class="material-symbols-outlined" style="font-size: 16px;">people</span>
                                            Utilisateurs
                                        </a></li>
                                    <li><a class="dropdown-item" href="{{ route('recruiter.jobs.index') }}">
                                            <span class="material-symbols-outlined" style="font-size: 16px;">work</span>
                                            Offres
                                        </a></li>
                                    <li><a class="dropdown-item" href="{{ route('cvtheque.index') }}">
                                            <span class="material-symbols-outlined" style="font-size: 16px;">folder</span>
                                            Cvthèque
                                        </a></li>
                                </ul>
                            </li>
                        @endif
                    @endif
                </ul>

                <a class="btn btn-warning" href="{{ route('recruiters.tarifs') }}">
                    <span class="material-symbols-outlined">star</span>
                    Premium
                </a>

                @if ($isAuthenticated && isset($user))
                    @php
                        $profilePicture = collect(session('user.medias') ?? [])->firstWhere('type', 'profile_picture');
                        $profilePictureUrl = $profilePicture
                            ? config('app.api') . '/' . $profilePicture['filePath']
                            : asset('img/default-avatar.png');
                    @endphp
                    <div class="dropdown">
                        <a class="profile-dropdown" href="#" data-bs-toggle="dropdown">
                            <img src="{{ $profilePictureUrl }}" alt="Profil" class="profile-avatar">
                            <span>Mon compte</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">
                                    <span class="material-symbols-outlined" style="font-size: 16px;">person</span>
                                    Profil
                                </a></li>
                            <li><a class="dropdown-item" href="{{ route('settings') }}">
                                    <span class="material-symbols-outlined" style="font-size: 16px;">settings</span>
                                    Paramètres
                                </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <span class="material-symbols-outlined" style="font-size: 16px;">logout</span>
                                        Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('auth', ['tab' => 'login']) }}" class="btn btn-login">
                        <span class="material-symbols-outlined">login</span>
                        Connexion
                    </a>
                @endif
            </div>
        </div>
    </nav>
</header>

<style>
    .navbar-brand img {
        width: auto;
        height: 30px;
        max-height: 35px;
    }

    .bg-indigo {
        background-color: var(--aquamarine) !important;
    }

    .navbar {
        box-shadow: 0 4px 12px rgba(5, 56, 61, 0.15);
        transition: all 0.3s ease;
    }

    .navbar-brand {
        font-size: 20px !important;
        font-weight: 700;
        letter-spacing: -0.5px;
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .navbar-brand:hover {
        opacity: 0.9;
    }

    .navbar-brand img {
        transition: transform 0.3s ease;
    }

    .navbar-brand:hover img {
        transform: scale(1.05);
    }

    .nav-link {
        position: relative;
        font-weight: 500;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        color: var(--white) !important;
        padding: 8px 12px !important;
        border-radius: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .nav-link:hover {
        color: var(--larch-bolete) !important;
    }

    .nav-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background: var(--gradient-secondary);
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }

    .nav-link:hover::after {
        width: 80%;
    }

    .dropdown-toggle::after {
        transition: transform 0.3s ease;
        margin-left: 4px;
    }

    .nav-link.show::after {
        width: 80%;
    }

    .dropdown-menu {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border: 1px solid rgba(5, 56, 61, 0.1);
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(5, 56, 61, 0.15);
        animation: slideDown 0.3s ease;
        margin-top: 12px !important;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .dropdown-item {
        color: #1a202c;
        font-weight: 500;
        font-size: 0.9rem;
        padding: 10px 16px;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }

    .dropdown-item:hover {
        color: var(--indigo);
        border-left-color: var(--orangish);
        padding-left: 20px;
    }

    .dropdown-divider {
        margin: 8px 0;
        background-color: rgba(5, 56, 61, 0.1);
    }

    .btn-login {
        background: var(--sand) !important;
        color: var(--indigo);
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 8px 20px;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-login:hover {
        box-shadow: 0 8px 16px rgba(5, 56, 61, 0.2);
        color: var(--sand) !important;
        background: var(--indigo) !important;
    }

    .btn-warning {
        background: var(--gradient-secondary);
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.9rem;
        padding: 8px 20px;
        transition: all 0.3s ease;
        color: var(--sand) !important;
        text-decoration: none;
    }

    .btn-warning:hover {
        color: var(--sand) !important;
    }

    .btn-warning,
    .btn-login {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        line-height: 1;
        vertical-align: middle;
    }

    .btn-warning .material-symbols-outlined,
    .btn-login .material-symbols-outlined {
        font-size: 20px;
        vertical-align: middle;
        line-height: 1;
    }

    .navbar-toggler {
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 6px;
        padding: 6px 10px;
        transition: all 0.3s ease;
    }

    .navbar-toggler:focus {
        box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.2);
    }

    .navbar-toggler:hover {
        border-color: rgba(255, 255, 255, 0.6);
    }

    .offcanvas {
        background: linear-gradient(135deg, var(--indigo) 0%, #0d4a52 100%);
    }

    .offcanvas-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .btn-close-white {
        filter: brightness(1.2);
        transition: all 0.3s ease;
    }

    .btn-close-white:hover {
        filter: brightness(0.8);
    }

    .offcanvas-body .nav-link {
        padding: 12px 8px !important;
        margin-bottom: 8px;
        border-radius: 8px;
        font-weight: 500;
    }

    .offcanvas-body .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.15);
        padding-left: 16px !important;
    }

    .offcanvas-body .btn {
        border-radius: 8px;
        font-weight: 600;
    }

    .profile-dropdown {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 8px 12px;
        background-color: rgba(255, 255, 255, 0.08);
        border-radius: 8px;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none !important;
        color: var(--white) !important;
    }

    .profile-dropdown:hover {
        background-color: rgba(255, 255, 255, 0.15);
    }

    .profile-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease;
    }

    .profile-dropdown:hover .profile-avatar {
        border-color: var(--larch-bolete);
        transform: scale(1.05);
    }

    .navbar-nav {
        gap: 8px;
    }

    @media (max-width: 991px) {
        .navbar-nav {
            gap: 0;
        }

        .nav-link::after {
            display: none;
        }

        .offcanvas-body {
            padding: 20px 0;
        }

        .offcanvas-body .btn {
            margin-top: 12px;
        }
    }

    @media (max-width: 576px) {
        .navbar {
            padding-left: 12px !important;
            padding-right: 12px !important;
        }

        .navbar-brand {
            font-size: 18px !important;
        }

        .navbar-brand img {
            height: 24px;
        }
    }
</style>
