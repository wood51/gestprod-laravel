@extends('layout.app')

@section('content')
    <div class="card w-full h-full bg-base-100 shadow-xl">
        <div class="card-body overflow-y-auto">
            <h2 class="card-title m-2">BL</h2>
            <div class="overflow-y-auto max-h-full">
                <table class="table">
                    <thead>
                        <tr>
                        
                            <td>Reference</td>
                            <td>PA</td>
                            <td>Poste</td>
                            <td>Qte</td>
                            {{-- <td>Numero</td> --}}
                            @foreach ($lignes->first()?->planning?->numero_meta as $key => $value)
                                <td>{{ $key }}</td>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lignes as $ligne)
                            <tr>
                                
                                <td>{{ $ligne->planning->article->reference }}</td>
                                <td>{{ $ligne->planning->no_commande }}</td>
                                <td>{{ $ligne->planning->no_poste }}</td>
                                <td>1</td>
                                @foreach($ligne->planning->numero_meta as $num)
                                <td>{{ $num }}</td>
                                @endforeach

                                
                            </tr>
                        @endforeach
                    </tbody>
            </div>
        </div>
    </div>
@endsection
