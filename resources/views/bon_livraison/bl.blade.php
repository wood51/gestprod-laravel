@extends('layout.app')

@section('content')
    <div class="card w-full h-full bg-base-100 shadow-xl">
        <div class="card-body overflow-y-auto">
            <h2 class="card-title m-2">
                <a href="/bl"><i class="fa-solid fa-share fa-flip-horizontal"></i></a>

                Bon de livraison n°{{ $bl->id }}
                @if ($bl->state === 'validated')
                    <div class="badge badge-outline badge-success text-sm">validé </div>
                @elseif($bl->state === 'draft')
                    <div class="badge badge-outline badge-warning text-sm">en cours</div>
                @elseif($bl->state === 'canceled')
                    <div class="badge badge-outline badge-error text-sm">annulé</div>
                @endif

            </h2>
            {{-- <td>{{ strtoupper($bl->createdBy?->username) }}
                <span class="font-normal">{{ $bl->created_at?->translatedFormat(' - d/m/Y à H:i') }}</span>
            </td> --}}
            <div class="overflow-y-auto max-h-full">
                <table class="table table-sm">
                    <thead>
                        <tr class="bg-blue-200">

                            <td>Reference</td>
                            <td>PA</td>
                            <td>Poste</td>
                            <td>Qte</td>
                            {{-- <td>Numero</td> --}}
                            @if ($lignes->isNotEmpty())
                                @foreach ($lignes->first()?->planning?->numero_meta as $key => $value)
                                    <td>{{ $key }}</td>
                                @endforeach
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lignes as $ligne)
                            <tr>

                                <td>{{ $ligne->planning->article->reference }}</td>
                                <td>{{ $ligne->planning->no_commande }}</td>
                                <td>{{ $ligne->planning->no_poste }}</td>
                                <td>1</td>
                                @foreach ($ligne->planning->numero_meta as $num)
                                    <td>{{ $num }}</td>
                                @endforeach


                            </tr>
                        @endforeach
                    </tbody>
            </div>
        </div>
    </div>
@endsection
