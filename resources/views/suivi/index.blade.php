@extends('layout.app')

@section('content')
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">

            <div class="flex justify-between">
                <h2 class="card-title">Liste des Encours</h2>
                <button class="btn btn-ghost" onclick="my_modal_1.showModal()"><i
                        class="fa-solid fa-bars text-lg"></i></button>
            </div>

            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Article</th>
                            <th>Type</th>
                            <th>Opération</th>
                            <th>État</th>
                            <th>Opérateur</th>
                            <th>Début</th>
                            <th>Fin</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($suivis as $s)
                            <tr>
                                <td class="font-bold">
                                    N° {{ $s->numero_produit }}
                                </td>

                                <td>
                                    {{ $s->article->reference }}
                                    ({{ $s->article->typeSousEnsemble->designation ?? '' }})
                                </td>

                                <td>Stator</td>

                                <td>
                                    {{ $s->operation }}
                                </td>

                                <td>
                                    @if ($s->etat === 'attente')
                                        <span class="badge badge-warning">Attente</span>
                                    @elseif($s->etat === 'en_cours')
                                        <span class="badge badge-info">En cours</span>
                                    @else
                                        <span class="badge badge-success">Terminé</span>
                                    @endif
                                </td>

                                <td>
                                    {{ $s->operator->name ?? '-' }}
                                </td>

                                <td>
                                    {{ $s->started_at ? $s->started_at->format('d/m H:i') : '-' }}
                                </td>

                                <td>
                                    {{ $s->ended_at ? $s->ended_at->format('d/m H:i') : '-' }}
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    Aucun suivi pour le moment.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

        </div>
    </div>


    <dialog id="my_modal_1" class="modal">
        <div class="modal-box">

            {{-- Bouton X pour fermer --}}
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>

            <h2 class="card-title">Créer une nouvelle entrée</h2>

            <p class="text-sm opacity-70">
                Ajoute un produit à suivre en bobinage stator.
            </p>

            <form method="post" action="{{ route('suivi.store') }}" class="mt-4 space-y-4">
                @csrf

                {{-- Sélection du modèle --}}
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold">Modèle (article)</span>
                    </label>
                    <select name="article_id" class="select select-bordered w-full">
                        <option value="">-- choisir un article --</option>
                        @foreach ($articles as $article)
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
                    <input type="text" name="numero_produit" class="input input-bordered w-full" placeholder="ex : 6589"
                        required />
                </div>

                {{-- Actions --}}
                <div class="modal-action">
                    <button type="submit" class="btn btn-primary">
                        Ajouter à la file d’attente
                    </button>
                </div>
            </form>
        </div>
    </dialog>
@endsection
