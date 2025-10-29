@extends('layouts.app')

@section('title', 'Connexion | Discorev')

@section('content')
    @php
        $isLogin = $tab === 'login';
    @endphp

    <div class="auth-container">
        <div class="auth-wrapper">
            {{-- Partie gauche : Formulaire --}}
            <div class="auth-form-section">
                {{-- Logo --}}
                <div class="auth-logo">
                    <img src="{{ asset('img/logos/logo-blue.svg') }}" alt="Logo">
                </div>

                {{-- Message de bienvenue --}}
                <div class="auth-header">
                    <h1 id="headerTitle">Bienvenue !</h1>
                    <p id="headerSubtitle">Connectez-vous pour accéder à votre tableau de bord</p>
                </div>

                {{-- Tabs Connexion / Inscription --}}
                <div class="auth-tabs">
                    <button class="auth-tab {{ $isLogin ? 'active' : '' }}" data-tab="login" type="button">
                        <span class="material-symbols-outlined">login</span>
                        Connexion
                    </button>
                    <button class="auth-tab {{ !$isLogin ? 'active' : '' }}" data-tab="register" type="button">
                        <span class="material-symbols-outlined">person_add</span>
                        Inscription
                    </button>
                    <div class="auth-tab-indicator {{ $isLogin ? 'left' : 'right' }}"></div>
                </div>

                {{-- Formulaires --}}
                <div class="auth-forms">
                    <div class="auth-form-wrapper {{ $isLogin ? 'active' : '' }}" id="loginFormWrapper">
                        @include('auth.login')
                    </div>
                    <div class="auth-form-wrapper {{ !$isLogin ? 'active' : '' }}" id="registerFormWrapper">
                        @include('auth.register')
                    </div>
                </div>
            </div>

            {{-- Partie droite : Image --}}
            <div class="auth-image-section" style="background: url('{{ asset('img/lpj/portrait-lucette-gris.jpg') }}') center/cover no-repeat;">
                <div class="auth-image-overlay"></div>
                <div class="auth-image-content">
                    <h2>Rejoignez la communauté</h2>
                    <p>Découvrez des opportunités uniques adaptées à vos compétences</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            padding: 1rem;
        }

        .auth-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            width: 100%;
            max-width: 1200px;
            height: 700px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
            background: white;
        }

        .auth-form-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem 3rem;
            height: 100%;
        }

        .auth-form-section.with-scroll {
            justify-content: flex-start;
            overflow-y: auto;
            padding-top: 2rem;
        }

        .auth-logo {
            margin-bottom: 2rem;
        }

        .auth-logo img {
            width: 60px;
            height: auto;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }

        .auth-header p {
            font-size: 1rem;
            color: #718096;
            margin: 0;
            transition: all 0.3s ease;
        }

        .auth-tabs {
            position: relative;
            display: flex;
            gap: 0.5rem;
            margin-bottom: 2.5rem;
            background: transparent;
            border-radius: 0;
            padding: 0;
            width: auto;
            max-width: none;
        }

        .auth-tab {
            flex: auto;
            padding: 0.5rem 1rem;
            border: none;
            background: transparent;
            color: #a0aec0;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            position: relative;
            z-index: 2;
            border-bottom: 2px solid transparent;
        }

        .auth-tab .material-symbols-outlined {
            font-size: 18px;
        }

        .auth-tab:hover {
            color: var(--indigo);
        }

        .auth-tab.active {
            color: var(--indigo);
            border-bottom-color: var(--indigo);
        }

        .auth-tab-indicator {
            display: none;
        }

        .auth-forms {
            position: relative;
            width: 100%;
            max-width: 400px;
        }

        .auth-form-wrapper {
            opacity: 0;
            transform: translateX(20px);
            transition: all 0.3s ease;
            pointer-events: none;
            position: absolute;
            width: 100%;
        }

        .auth-form-wrapper.active {
            opacity: 1;
            transform: translateX(0);
            pointer-events: auto;
            position: relative;
        }

        /* Scrollbar styling */
        .auth-form-section::-webkit-scrollbar {
            width: 6px;
        }

        .auth-form-section::-webkit-scrollbar-track {
            background: transparent;
        }

        .auth-form-section::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
        }

        .auth-form-section::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        /* Image section */
        .auth-image-section {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            height: 100%;
            background-size: cover !important;
            background-position: center !important;
        }

        .auth-image-overlay {
            display: none;
        }

        .auth-image-content {
            display: none;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .auth-wrapper {
                grid-template-columns: 1fr;
            }

            .auth-image-section {
                display: none;
            }

            .auth-form-section {
                padding: 2rem 1.5rem;
                min-height: auto;
            }

            .auth-header h1 {
                font-size: 1.75rem;
            }
        }

        @media (max-width: 640px) {
            .auth-container {
                padding: 0;
            }

            .auth-wrapper {
                border-radius: 0;
                box-shadow: none;
            }

            .auth-form-section {
                padding: 1.5rem;
                min-height: 100vh;
            }

            .auth-header h1 {
                font-size: 1.5rem;
            }

            .auth-logo img {
                width: 50px;
            }
        }
    </style>

    <script>
        const headerTitle = document.getElementById('headerTitle');
        const headerSubtitle = document.getElementById('headerSubtitle');

        const headers = {
            login: {
                title: 'Bienvenue !',
                subtitle: 'Connectez-vous pour accéder à votre tableau de bord'
            },
            register: {
                title: 'Pas encore inscrit ?',
                subtitle: 'Créez votre compte et rejoignez la communauté'
            }
        };

        document.querySelectorAll('.auth-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                const tabName = this.dataset.tab;
                const formSection = document.querySelector('.auth-form-section');

                // Update tabs
                document.querySelectorAll('.auth-tab').forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                // Update forms and scroll behavior
                document.querySelectorAll('.auth-form-wrapper').forEach(form => form.classList.remove('active'));
                document.getElementById(tabName + 'FormWrapper').classList.add('active');

                // Update header
                headerTitle.textContent = headers[tabName].title;
                headerSubtitle.textContent = headers[tabName].subtitle;

                // Add scroll class for registration form
                if (tabName === 'register') {
                    formSection.classList.add('with-scroll');
                } else {
                    formSection.classList.remove('with-scroll');
                }
            });
        });
    </script>
@endsection
