@extends('layout.app')

@section('content')
    <div class="card w-full h-full bg-base-100 shadow-xl">
        <div class="card-body overflow-y-auto">

            <div class="flex items-center justify-between">
                <h2 class="card-title m-2">BON DE LIVRAISON</h2>
                <form action="{{ route('bl.create') }}" method="post">
                    @csrf
                    <button class="btn btn-sm btn-primary">Ajouter un BL</button>
                </form>
            </div>

            <div class="overflow-y-auto max-h-full">
                <table class="table table-sm font-semibold">
                    <thead>
                        <tr class="bg-blue-200">
                            <th>N°</th>
                            <th>Status</th>
                            <th>Création</th>
                            <th>Validation</th>
                            <th>Annulation</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rows as $r)
                            <tr class="hover:bg-gray-100">
                                <td>{{ $r->id }}</td>
                                <td>
                                    @if ($r->state === 'validated')
                                        <div class="badge badge-outline badge-success text-sm">validé</div>
                                    @elseif($r->state === 'draft')
                                        <div class="badge badge-outline badge-warning text-sm">en cours</div>
                                    @elseif($r->state === 'canceled')
                                        <div class="badge badge-outline badge-error text-sm">annulé</div>
                                    @endif
                                </td>
                                <td>{{ strtoupper($r->createdBy?->username) }}
                                    <span
                                        class="font-normal">{{ $r->created_at?->translatedFormat(' - d/m/Y à H:i') }}</span>
                                </td>
                                <td>{{ strtoupper($r->validatedBy?->username) }}
                                    <span
                                        class="font-normal">{{ $r->validated_at?->translatedFormat(' - d/m/Y à H:i') }}</span>
                                </td>
                                <td>{{ strtoupper($r->canceledBy?->username) }}
                                    <span
                                        class="font-normal">{{ $r->canceled_at?->translatedFormat(' - d/m/Y à H:i') }}</span>
                                </td>
                                <td>
                                    <div class="flex justify-center items-center gap-4">

                                        {{-- Visualisation --}}
                                        <a href="{{ route('bl.show', $r->id) }}"
                                            class="text-sm {{ $r->nb_lines ? 'text-primary' : 'text-neutral-content pointer-events-none' }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        {{-- Edition --}}
                                        <a href="{{ route('bl.show', $r->id) }}"
                                            class="text-sm {{ $r->state === 'draft' ? 'text-warning' : 'text-neutral-content pointer-events-none' }}">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                        {{-- Suppression --}}
                                        {{-- <a href="{{ route('bl.delete', $r->id) }}"
                                            class="text-sm {{ $r->state != 'canceled' ? 'text-error' : 'text-neutral-content pointer-events-none' }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </a> --}}
                                        <form action="{{ route('bl.delete', $r->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-link text-sm {{ $r->state != 'canceled' ? 'text-error' : 'text-neutral-content pointer-events-none' }}"><i
                                                    class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
