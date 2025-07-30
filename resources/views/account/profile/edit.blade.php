@extends('layouts.app')
@section('title', 'Modifier mon profil | Discorev')

@section('content')
    <div class="container my-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h2>Modifier mon profil {{ $type === 'candidate' ? 'Candidat' : 'Recruteur' }}</h2>
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
                        @if ($type === 'recruiter')
                            <div class="tab-pane" id="company" style="display:block;">
                                @include('partials.recruiter-fields-company', ['recruiter' => $recruiter])
                            </div>
                            <div class="tab-pane" id="account" style="display:none;">
                                @include('partials.account-fields', ['user' => $user])
                            </div>
                            <div class="tab-pane" id="page" style="display:none;">
                                @include('partials.recruiter-fields-page', ['recruiter' => $recruiter])
                            </div>
                        @elseif ($type === 'candidate')
                            <div class="tab-pane" id="profile" style="display:block;">
                                @include('partials.candidate-fields-profile', ['user' => $user])
                            </div>
                            <div class="tab-pane" id="account" style="display:none;">
                                @include('partials.account.fields', ['user' => $user])
                            </div>
                            <div class="tab-pane" id="cv" style="display:none;">
                                @include('partials.candidate-fields-cv', ['user' => $user])
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('#profileTabs .nav-link').forEach(function(tab) {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('#profileTabs .nav-link').forEach(function(t) {
                    t.classList.remove('active');
                });
                tab.classList.add('active');
                let selected = tab.getAttribute('data-tab');
                document.querySelectorAll('#tab-content .tab-pane').forEach(function(pane) {
                    pane.style.display = pane.id === selected ? 'block' : 'none';
                });
            });
        });
    </script>
@endsection
