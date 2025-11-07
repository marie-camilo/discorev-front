@extends('layouts.app')

@section('title', 'Discorev')

@section('content')

    <section class="hero-modern text-center">
        <div class="container">
            <x-hero
                badge="Votre carrière commence ici"
                title="La découverte<br><span class='gradient-text'>d'entreprises réinventées</span>"
                description="Découvrez les entreprises autrement à travers leur histoire, leurs valeurs et leurs équipes, et accédez à leurs dernières propositions d'embauches."
                text-align="center"
            />
        </div>
    </section>

    <section class="feature-section">
        <div class="container">
            <x-feature-section :features="[
    [
        'badge' => 'Marketing RH',
        'badgeColor' => 'blue',
        'icon' => 'campaign',
        'title' => 'Valorisez votre marque employeur',
        'description' => 'Attirez les meilleurs talents grâce à des stratégies de communication RH ciblées et efficaces.',
        'image' => 'img/following.jpg',
        'reverse' => false
    ],
    [
        'badge' => 'Storytelling & Multimédia',
        'badgeColor' => 'orange',
        'icon' => 'video_library',
        'title' => 'Racontez votre histoire de manière impactante',
        'description' => 'Créez des contenus narratifs et multimédias pour captiver votre audience et transmettre vos valeurs.',
        'image' => 'img/paperwork.jpg',
        'reverse' => true
    ],
    [
        'badge' => 'Communication & Jobboard',
        'badgeColor' => 'teal',
        'icon' => 'work_outline',
        'title' => 'Diffusez vos opportunités efficacement',
        'description' => 'Optimisez votre communication et vos offres d’emploi grâce à nos outils et notre expertise.',
        'image' => 'img/team.jpg',
        'reverse' => false
    ]
]" />
        </div>
    </section>

    <section id="partners" class="py-5">
        <div class="container">
            <x-companies.section-partners
                :companies="$companies"
                badge="Entreprises partenaires"
                title="Ils nous font déjà confiance"
                button-text="Voir plus d’entreprises"
                button-link="{{ route('companies.index') }}"
            />
        </div>
    </section>
@endsection
