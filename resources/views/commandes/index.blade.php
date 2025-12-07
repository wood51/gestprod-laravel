@extends('layout.app')

@section('content')
<div class="card bg-base-100 shadow-xl">
    <div class="card-body">
        <h2 class="card-title mb-4">
            Commandes (PA)
        </h2>

        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead>
                    <tr>
                        <th>PA</th>
                        <th>Date commande</th>
                        <th>Lignes</th>
                        <th>Qté cmd</th>
                        <th>Qté livrée</th>
                        <th>Reste</th>
                        <th>Statut</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($commandes as $commande)
                        @php
                            $qteCmd = (int) ($commande->qte_commandee_sum ?? 0);
                            $qteLiv = (int) ($commande->qte_livree_sum ?? 0);
                            $reste  = max($qteCmd - $qteLiv, 0);
                        @endphp
                        <tr>
                            <td class="font-mono">{{ $commande->pa }}</td>
                            <td>
                                @if ($commande->date_commande)
                                    {{ $commande->date_commande->format('d/m/Y') }}
                                @else
                                    <span class="opacity-40 text-xs">-</span>
                                @endif
                            </td>
                            <td>{{ $commande->lignes_count }}</td>
                            <td>{{ $qteCmd }}</td>
                            <td>{{ $qteLiv }}</td>
                            <td class="{{ $reste > 0 ? 'font-semibold' : 'opacity-60' }}">
                                {{ $reste }}
                            </td>
                            <td>
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
                                <span class="badge {{ $statusClass }} badge-sm">
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="text-right">
                                <a href="{{ route('commandes.show', $commande) }}"
                                   class="btn btn-xs btn-outline">
                                    Détail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center opacity-60">
                                Aucune commande pour l’instant.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
