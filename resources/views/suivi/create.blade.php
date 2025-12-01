@extends('layout.app')

@section('content')
    <div class="max-w-lg mx-auto mt-8">

        @if(session('success'))
            <div class="alert alert-success shadow-lg mb-4">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">Créer une nouvelle entrée</h2>
                <p class="text-sm opacity-70">Ajoute un produit à suivre en bobinage stator.</p>

                <form method="POST" action="{{ route('suivi.store') }}" class="space-y-4">
                    @csrf

                    {{-- Sélection du modèle --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Modèle (article)</span>
                        </label>
                        <select name="article_id" class="select select-bordered w-full" required>
                            <option value="">-- choisir un article --</option>
                            @foreach($articles as $article)
                                <option value="{{ $article->id }}">
                                    {{ $article->reference }}
                                    ({{ $article->typeSousEnsemble->designation ?? '' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Numéro produit --}}
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold">Numéro produit</span>
                        </label>
                        <input
                            type="text"
                            name="numero_produit"
                            class="input input-bordered w-full"
                            placeholder="ex : 6589"
                            required
                        />
                    </div>

                    {{-- Bouton --}}
                    <div class="card-actions justify-end">
                        <button type="submit" class="btn btn-primary">
                            Ajouter à la file d’attente
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

@endsection
