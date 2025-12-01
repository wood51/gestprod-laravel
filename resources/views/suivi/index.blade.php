@extends("layout.app")
@section("content")
    <div class="max-w-5xl mx-auto mt-8">

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">

                <h2 class="card-title">Liste des suivis</h2>

                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Article</th>
                                <th>Étape</th>
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

                                    <td>
                                        {{ $s->operation }}
                                    </td>

                                    <td>
                                        @if($s->etat === 'attente')
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

    </div>

@endsection
