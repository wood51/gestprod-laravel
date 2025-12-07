@extends('layout.app')

@section('content')
<div class="space-y-4">

    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="card-title">
                        Commande {{ $commande->pa }}
                    </h2>
                    <p class="text-sm opacity-70">
                        Client : {{ $commande->client ?? '—' }}
                    </p>
                    <p class="text-sm opacity-70">
                        Date commande :
                        @if ($commande->date_commande)
                            {{ $commande->date_commande->format('d/m/Y') }}
                        @else
                            —
                        @endif
                    </p>
                </div>

                @php
                    $status = $commande->status;
                    $statusClass = match ($status) {
                        'open'    => 'badge-info',
                        'partial' => 'badge-warning',
                        'closed'  => 'badge-success',
                        'cancelled' => 'badge-neutral',
                        default   => 'badge-ghost',
                    };
                @endphp

                <div class="text-right">
                    <span class="badge {{ $statusClass }} badge-lg">
                        {{ $status }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <h3 class="card-title mb-4">
                Lignes de commande
            </h3>

            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th>Poste</th>
                            <th>Référence</th>
                            <th>Qté cmd</th>
                            <th>Qté livrée</th>
                            <th>Reste</th>
                            <th>Date client</th>
                            <th>Date ajustée</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($commande->lignes as $ligne)
                            @php
                                $qCmd  = (int) $ligne->qte_commandee;
                                $qLiv  = (int) $ligne->qte_livree;
                                $reste = max($qCmd - $qLiv, 0);

                                $status = $ligne->status;
                                $statusClass = match ($status) {
                                    'open'    => 'badge-info',
                                    'partial' => 'badge-warning',
                                    'closed'  => 'badge-success',
                                    'cancelled' => 'badge-neutral',
                                    default   => 'badge-ghost',
                                };
                            @endphp
                            <tr>
                                <td class="font-mono">
                                    {{ $ligne->poste_client }}
                                </td>
                                <td>
                                    @if ($ligne->article)
                                        <span class="font-semibold">
                                            {{ $ligne->article->reference}}
                                        </span>
                                    @else
                                        <span class="opacity-40 text-xs">—</span>
                                    @endif
                                </td>
                                <td>{{ $qCmd }}</td>
                                <td>{{ $qLiv }}</td>
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
                                <td>
                                    <span class="badge {{ $statusClass }} badge-sm">
                                        {{ $status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center opacity-60">
                                    Aucune ligne pour cette commande.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <a href="{{ route('commandes.index') }}" class="btn btn-sm btn-ghost">
                    ← Retour aux commandes
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
