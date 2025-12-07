@extends('layout.app')

@section('content')
<div class="card bg-base-100 shadow">
    <div class="card-body">
        <h2 class="card-title mb-4">
            Planning / Charge brute
        </h2>

        <div class="overflow-x-auto">
            <table class="table table-zebra w-full text-sm">
                <thead>
                    <tr>
                        <th>PA</th>
                        <th>Poste</th>
                        <th>Référence</th>
                        <th>Qté cmd</th>
                        <th>Qté livrée</th>
                        <th>Reste</th>
                        <th>Date client</th>
                        <th>Date ajustée</th>
                        <th>Retard</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($lignes as $ligne)
                        @php
                            $reste  = $ligne->qte_reste;
                            $retard = $ligne->retard_jours;
                            $isLate = $retard !== null && $retard > 0;
                        @endphp
                        <tr class="{{ $isLate ? 'bg-base-200' : '' }}">
                            <td class="font-mono">
                                {{ $ligne->commande?->pa }}
                            </td>
                            <td class="font-mono">
                                {{ $ligne->poste_client }}
                            </td>
                            <td>
                                {{ $ligne->article->reference ?? '—' }}
                            </td>
                            <td>{{ $ligne->qte_commandee }}</td>
                            <td>{{ $ligne->qte_livree }}</td>
                            <td class="{{ $reste > 0 ? 'font-semibold' : 'opacity-60' }}">
                                {{ $reste }}
                            </td>
                            <td>
                                @if ($ligne->date_client)
                                    {{ $ligne->date_client->format('d/m/Y') }}
                                @else
                                    <span class="opacity-40 text-xs">—</span>
                                @endif
                            </td>
                            <td>
                                @if ($ligne->date_ajustee)
                                    {{ $ligne->date_ajustee->format('d/m/Y') }}
                                @else
                                    <span class="opacity-40 text-xs">—</span>
                                @endif
                            </td>
                            <td class="{{ $isLate ? 'text-error font-semibold' : 'opacity-60' }}">
                                @if ($retard)
                                    {{ $retard }} j
                                @else
                                    —
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-sm">
                                    {{ $ligne->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center opacity-60">
                                Aucune ligne à planifier.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
