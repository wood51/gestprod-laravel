<style>

</style>

    <table border="1"  style="width: 190mm; margin: 0 auto;">
        <thead>
            <tr>
                <!-- <td style="width:35mm;height:30px;line-height: 30px;text-align:center">Reference</td>
                <td style="width:60mm;height:30px;line-height: 30px;text-align:center">Désignation</td> -->
                <td style="width:15.83mm;height:30px;line-height: 30px;text-align:center">N° Cmde</td>
                <td style="width:15.83mm;height:30px;line-height: 30px;text-align:center">Poste</td>
                <td style="width:15.83mm;height:30px;line-height: 30px;text-align:center">Qte</td>

                @if ($lignes->isNotEmpty())
                @foreach ($lignes->first()->numero_meta as $key => $value)
                <td style="width:15.83mm;height:30px;line-height: 30px;text-align:center">{{ $key }}</td>
                @endforeach
                @endif

            </tr>
        </thead>
        <tbody>
            @foreach ($lignes as $ligne)
            <tr>
                <!-- <td style="width:35mm;text-align:center">{{ $ligne->article_ref }}</td>
                <td style="width:60mm;text-align:center">{{ $ligne->article_designation }}</td> -->
                <td style="width:15.83mm;text-align:center">{{ $ligne->no_commande }}</td>
                <td style="width:15.83mm;text-align:center">{{ $ligne->no_poste }}</td>
                <td style="width:15.83mm;text-align:center">1</td>

                @foreach ($ligne->numero_meta as $num)
                <td style="width:15.83mm;text-align:center">{{ $num }}</td>
                @endforeach

            </tr>
            @endforeach
        </tbody>
    </table>
