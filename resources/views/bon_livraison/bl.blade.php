@extends('layout.app')

@section('content')
    <div class="card w-full h-full bg-base-100 shadow-xl">
        <div class="card-body overflow-y-auto">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="card-title m-2">
                        <a href="/bl"><i class="fa-solid fa-share fa-flip-horizontal"></i></a>

                        Bon de livraison N° {{ $bl->id }}
                        @if ($bl->state === 'validated')
                            <div class="badge badge-outline badge-success text-sm">validé </div>
                        @elseif($bl->state === 'draft')
                            <div class="badge badge-outline badge-warning text-sm">en cours</div>
                        @elseif($bl->state === 'canceled')
                            <div class="badge badge-outline badge-error text-sm">annulé</div>
                        @endif

                    </h2>
                </div>
                <div>
                    <form action="{{ route('bl.validate', $bl->id) }}" method="post">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-success"
                            {{ $bl->state === 'draft' ? '' : 'disabled' }}>Valider
                            le Bl</button>
                    </form>
                </div>
            </div>
            <div class="overflow-y-auto max-h-full">
                <table class="table table-sm">
                    <thead>
                        <tr class="bg-blue-200">

                            <td>Reference</td>
                            <td>Désignation</td>
                            <td>PA</td>
                            <td>Poste</td>
                            <td>Qte</td>
                            {{-- TEMP debug --}}

                            {{-- <td>Numero</td> --}}
                            @if ($lignes->isNotEmpty())
                                @foreach ($lignes->first()->numero_meta as $key => $value)
                                    <td>{{ $key }}</td>
                                @endforeach
                            @endif

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lignes as $ligne)
                            <tr>
                                <td>{{ $ligne->article_ref }}</td>
                                <td>{{ $ligne->article_designation }}</td>
                                <td>{{ $ligne->no_commande }}</td>
                                <td>{{ $ligne->poste }}</td>
                                <td>1</td>

                                @foreach ($ligne->numero_meta as $num)
                                    <td>{{ $num }}</td>
                                @endforeach

                            </tr>
                        @endforeach
                    </tbody>
            </div>
        </div>
    </div>
@endsection
