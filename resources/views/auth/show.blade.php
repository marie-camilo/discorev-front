@extends('layouts.app')

@section('title', 'Connexion | Discorev')

@section('content')
    @php
        $isLogin = $tab === 'login';
    @endphp

    <div class="container d-flex justify-content-center align-items-start min-vh-100 py-5">
        <div class="card shadow rounded-4 p-4" style="max-width: 600px; width: 100%;">
            {{-- Logo --}}
            <div class="text-center mb-4">
                <img src="{{ asset('img/logos/logo-blue.svg') }}" alt="Logo" class="img-fluid" style="width: 60px;">
            </div>

            {{-- Titre --}}
            <h2 class="text-center fw-bold mb-4">Bienvenue</h2>

            {{-- Tabs Connexion / Inscription --}}
            <ul class="nav nav-tabs justify-content-center mb-4 border-0">
                <li class="nav-item">
                    <a id="loginTab" href="{{ route('login') }}" class="nav-link {{ $isLogin ? 'active' : '' }}">
                        Connexion
                    </a>
                </li>
                <li class="nav-item">
                    <a id="registerTab" href="{{ route('register') }}" class="nav-link {{ !$isLogin ? 'active' : '' }}">
                        Inscription
                    </a>
                </li>
            </ul>

            {{-- Formulaires --}}
            <div class="form-container">
                <div id="loginForm" class="{{ $isLogin ? '' : 'd-none' }}">
                    @include('auth.login')
                </div>
                <div id="registerForm" class="{{ !$isLogin ? '' : 'd-none' }}">
                    @include('auth.register')
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const loginTab = document.getElementById('loginTab');
            const registerTab = document.getElementById('registerTab');
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');

            loginTab.addEventListener('click', function(e) {
                e.preventDefault();
                loginTab.classList.add('active');
                registerTab.classList.remove('active');
                loginForm.classList.remove('d-none');
                registerForm.classList.add('d-none');
            });

            registerTab.addEventListener('click', function(e) {
                e.preventDefault();
                registerTab.classList.add('active');
                loginTab.classList.remove('active');
                registerForm.classList.remove('d-none');
                loginForm.classList.add('d-none');
            });
        });
    </script>
@endsection
