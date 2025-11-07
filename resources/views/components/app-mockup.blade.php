<section class="app-section">
    <div class="container">
        <div class="row align-items-center">
            <!-- Mockup -->
            <div class="col-12 col-lg-6 mb-5 mb-lg-0">
                <div class="app-mockup-container text-center">
                    <img src="{{ asset('img/mockup-app.png') }}" alt="Aperçu de l'app Discorev" class="app-mockup img-fluid rounded">
                </div>
            </div>

            <div class="col-12 col-lg-6 text-center text-lg-start">
                <div class="section-badge badge-teal mb-3">
                    <span class="material-symbols-outlined" style="font-size: 16px;">smartphone</span>
                    Application mobile - En cours de développement !
                </div>
                <h2 class="display-4 fw-bold mb-4">Votre carrière, toujours à portée de main</h2>
                <p class="fs-5 mb-5" style="line-height: 1.6; color: var(--text-secondary);">
                    Accédez aux meilleures offres d'emploi où que vous soyez
                    et postulez en un clic.
                </p>
            </div>
        </div>
    </div>
</section>

<style>
    .app-section {
        background: linear-gradient(135deg, #F9FAFB 0%, #FFFFFF 50%, #E0F2FE 100%) !important;
        color: var(--text-primary);
        position: relative;
        overflow: hidden;
        margin-bottom: 0;
        margin-top: 0;
    }

    .app-mockup-container {
        position: relative;
        max-width: 520px;
        margin: 0 auto;
    }

    .app-mockup {
        position: relative;
        width: 100%;
        z-index: 2;
    }

    @media (max-width: 768px) {
        .app-section {
            padding: 4rem 0;
        }

        .app-mockup-container {
            max-width: 280px;
        }
    }

    @media (max-width: 576px) {
        .app-section {
            flex-direction: column;
            align-items: center;
        }
    }
</style>
