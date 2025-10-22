<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<footer class="footer">
    <div class="footer-container">
        <div class="footer-col">
            <h3>Liens utiles</h3>
            <ul>
                <li><a href="{{ route('home')}}">Accueil</a></li>
                <li><a href="{{ route('job_offers.index') }}">Offres d'emploi</a></li>
                <li><a href="{{ route('companies.index')}}">Trouver une entreprise</a></li>
                <li><a href="{{ route('recruiters.tarifs')}}">Tarifs recruteurs</a></li>
                <li><a href="{{ route('auth', ['tab' => 'login']) }}">Candidats</a></li>
                <li><a href="{{ route('auth', ['tab' => 'login']) }}">Recruteurs</a></li>
                <li><a href="#blog">Blog</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h3>À propos</h3>
            <ul>
                <li><a href="#">Notre mission</a></li>
                <li><a href="#">Équipe</a></li>
                <li><a href="#">Carrières</a></li>
                <li><a href="#">Presse</a></li>
            </ul>
        </div>

        <div class="footer-col logo-section">
            <img style="height: 50px; width: 50px" src="/img/logos/logo-white.svg" alt="Logo Discorev">
            <div>
                <h3 style="text-align: center; margin-bottom: 15px;">Suivez-nous</h3>
                <div class="social-icons">
                    <a href="https://www.linkedin.com/company/discorev/" class="social-icon" target="_blank" aria-label="LinkedIn" title="LinkedIn">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="https://www.instagram.com/discorev.fr/" class="social-icon" target="_blank" aria-label="Instagram" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-legal-links">
        <a href="{{ route('mentions-legales') }}">Mentions légales</a>
        <a href="{{ route('cgu') }}">CGU</a>
        <a href="{{ route('cgv') }}">CGV</a>
        <a href="{{ route('politique-confidentialite') }}">Politique de confidentialité</a>
    </div>

    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} Discorev. Tous droits réservés.</p>
    </div>
</footer>
</body>
</html>

<style>
    .footer {
        background-color: var(--indigo);
        color: var(--white);
        padding: 60px 20px 0;
        margin-top: 100px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 40px;
        padding: 0 20px 60px;
    }

    .footer-col h3 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 20px;
        color: var(--white);
        text-transform: uppercase;
        letter-spacing: 1px;
        position: relative;
        padding-bottom: 10px;
    }

    .footer-col h3::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 40px;
        height: 3px;
        background: var(--gradient-secondary);
        border-radius: 2px;
    }

    .footer-col ul {
        list-style: none;
    }

    .footer-col ul li {
        margin-bottom: 12px;
        transition: all 0.3s ease;
    }

    .footer-col ul li a {
        color: var(--wondrous-blue);
        text-decoration: none;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .footer-col ul li a:hover {
        color: var(--larch-bolete);
        transform: translateX(4px);
    }

    .footer-col ul li a::before {
        content: '→';
        margin-right: 8px;
        opacity: 0;
        transform: translateX(-8px);
        transition: all 0.3s ease;
    }

    .footer-col ul li a:hover::before {
        opacity: 1;
        transform: translateX(0);
    }

    .logo-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 30px;
    }

    .logo-section img {
        max-width: 150px;
        height: auto;
        transition: transform 0.3s ease;
        filter: brightness(1.1);
    }

    .logo-section img:hover {
        transform: scale(1.05);
    }

    .social-icons {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .social-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        background: rgba(249, 137, 72, 0.15);
        border: 1px solid var(--larch-bolete);
        border-radius: 50%;
        color: var(--orangish);
        transition: all 0.3s ease;
        text-decoration: none;
        font-size: 18px;
    }

    .social-icon:hover {
        background: var(--gradient-secondary);
        color: var(--white);
        transform: translateY(-4px);
        box-shadow: var(--shadow-hover);
        border-color: var(--orangish);
    }

    .footer-legal-links {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }

    .footer-legal-links a {
        color: var(--wondrous-blue);
        text-decoration: none;
        font-size: 13px;
        transition: all 0.3s ease;
        position: relative;
    }

    .footer-legal-links a:hover {
        color: var(--larch-bolete);
    }

    .footer-legal-links a::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--larch-bolete);
        transition: width 0.3s ease;
    }

    .footer-legal-links a:hover::after {
        width: 100%;
    }

    .footer-bottom {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        text-align: center;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        color: var(--aquamarine);
        font-size: 14px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .footer {
            padding: 40px 15px 0;
        }

        .footer-container {
            grid-template-columns: 1fr;
            gap: 30px;
            padding: 0 15px 40px;
        }

        .footer-col h3 {
            font-size: 15px;
            margin-bottom: 15px;
        }

        .footer-legal-links {
            flex-direction: column;
            gap: 10px;
            padding: 30px 15px;
            text-align: center;
        }

        .logo-section {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 30px;
        }

        .social-icons {
            gap: 12px;
        }

        .social-icon {
            width: 38px;
            height: 38px;
            font-size: 16px;
        }
    }

    @media (max-width: 480px) {
        .footer {
            padding: 30px 10px 0;
            margin-top: 50px;
        }

        .footer-container {
            gap: 20px;
            padding: 0 10px 30px;
        }

        .footer-col h3 {
            font-size: 14px;
            margin-bottom: 12px;
        }

        .footer-col ul li {
            margin-bottom: 10px;
        }

        .footer-col ul li a {
            font-size: 13px;
        }

        .footer-legal-links {
            padding: 20px 10px;
            gap: 8px;
        }

        .footer-legal-links a {
            font-size: 12px;
        }

        .footer-bottom {
            padding: 15px 10px;
            font-size: 12px;
        }

        .logo-section img {
            max-width: 120px;
        }
    }
</style>
