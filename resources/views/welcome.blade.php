@extends('layouts.app')

@section('title', 'Discorev')

@section('content')

    <section class="hero-modern text-center">
        <div class="container">
            <x-hero
                badge="Révélez l'ADN de votre entreprise"
                title="La découverte<br><span class='gradient-text'>d'entreprises réinventée</span>"
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
        'title' => 'Valorisez votre image de marque',
        'description' => 'Valorisez votre structure auprès de votre public cible grâce à une page dédiée et optimisée.',
        'image' => 'img/following.jpg',
        'reverse' => false
    ],
    [
        'badge' => 'Storytelling & Multimédia',
        'badgeColor' => 'orange',
        'icon' => 'video_library',
        'title' => 'Racontez votre histoire de manière impactante',
        'description' => 'Accédez à des outils éditoriaux pensés pour captiver votre audience et transmettre vos valeurs.',
        'image' => 'img/multimedia.jpg',
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

    @include('companies.company-card-featured', ['entrepriseCardData' => $entrepriseCardData])
@endsection
