<table class="table table-sm">
    <thead>
        <tr class="bg-blue-200">

            <td>Reference</td>
            <td>Désignation</td>
            <td>PA</td>
            <td>Poste</td>
            <td>Qte</td>

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
                <td>{{ $ligne->no_poste }}</td>
                <td>1</td>

                @foreach ($ligne->numero_meta as $num)
                    <td>{{ $num }}</td>
                @endforeach

            </tr>
        @endforeach
    </tbody>
</table>
