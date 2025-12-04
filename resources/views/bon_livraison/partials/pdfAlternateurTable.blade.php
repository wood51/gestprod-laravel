<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr style="font-weight: bold;background-color: lightskyblue;">
            <td style="width:63mm;height:26px;line-height: 26px;text-align:center">Reference - Désignation</td>
            <!-- <td style="width:60mm;height:26px;line-height: 26px;text-align:center">Désignation</td> -->
            <td style="width:20.83mm;height:26px;line-height: 26px;text-align:center">N° Cde</td>
            <td style="width:13.83mm;height:26px;line-height: 26px;text-align:center">Poste</td>
            <td style="width:13.83mm;height:26px;line-height: 26px;text-align:center">Qte</td>

            @if ($lignes->isNotEmpty())
                @foreach ($lignes->first()->numero_meta as $key => $value)
                    <td style="width:26.17mm;height:26px;line-height: 26px;text-align:center">{{ $key }}</td>
                @endforeach
            @endif

        </tr>
    </thead>
    <tbody>
        @foreach ($lignes as $i => $ligne)
            <tr @if ($i % 2 == 1) style="background-color:lightgray;" @endif>
                <td style="width:63mm;"><b>{{ $ligne->article_ref }}</b><br>{{ $ligne->article_designation }}</td>
                <td style="width:20.83mm;text-align:center;height:26px;line-height: 26px">{{ $ligne->no_commande }}</td>
                <td style="width:13.83mm;text-align:center;height:26px;line-height: 26px">{{ $ligne->no_poste }}</td>
                <td style="width:13.83mm;text-align:center;height:26px;line-height: 26px">1</td>

                @foreach ($ligne->numero_meta as $num)
                    <td style="width:26.17mm;height:26px;line-height: 26px;text-align:center">{{ $num }}</td>
                @endforeach

            </tr>
        @endforeach

        @php
            $totalLignes = 12; // nombre de lignes qu’on veut au total
            $nbCols = 4 + ($lignes->isNotEmpty() ? count($lignes->first()->numero_meta) : 0);
        @endphp

        @for ($j = $lignes->count(); $j < $totalLignes; $j++)
            <tr @if($j % 2 == 1) style="background-color:lightgray;" @endif>
                @for ($c = 0; $c < $nbCols; $c++)
                    <td style="height:26px;">&nbsp;</td>
                @endfor
            </tr>
        @endfor
    </tbody>
</table>
