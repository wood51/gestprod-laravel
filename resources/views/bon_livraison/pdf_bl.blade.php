<style></style>

    <table border="1" style="width=100%">
        <thead>
            <tr>
                <td style="height:30px;line-height: 30px;text-align:center">Reference</td>
                <td style="height:30px;line-height: 30px;text-align:center">Désignation</td>
                <td style="height:30px;line-height: 30px;text-align:center">N° Cmde</td>
                <td style="height:30px;line-height: 30px;text-align:center">Poste</td>
                <td style="height:30px;line-height: 30px;text-align:center">Qte</td>
                <!-- <td style="height:30px;width:100px;line-height: 30px;text-align:center">Reference</td>
                <td style="height:30px;width:160px;line-height: 30px;text-align:center">Désignation</td>
                <td style="height:30px;width:60px;line-height: 30px;text-align:center">N° Cmde</td>
                <td style="height:30px;width:30px;line-height: 30px;text-align:center">Poste</td>
                <td style="height:30px;width:30px;line-height: 30px;text-align:center">Qte</td> -->

                @if ($lignes->isNotEmpty())
                @foreach ($lignes->first()->numero_meta as $key => $value)
                <td style="height:30px;line-height: 30px;text-align:center">{{ $key }}</td>
                <!-- <td style="height:30px;width:60px;line-height: 30px;text-align:center">{{ $key }}</td> -->
                @endforeach
                @endif

            </tr>
        </thead>
        <tbody>
            @foreach ($lignes as $ligne)
            <tr>
                <td style="text-align:center">{{ $ligne->article_ref }}</td>
                <td style="height:30px;line-height: 30px;text-align:center">{{ $ligne->article_designation }}</td>
                <td style="text-align:center">{{ $ligne->no_commande }}</td>
                <td style="text-align:center">{{ $ligne->no_poste }}</td>
                <td style="text-align:center">1</td>

                @foreach ($ligne->numero_meta as $num)
                <td style="text-align:center">{{ $num }}</td>
                @endforeach
                <!-- <td style="width:100px;text-align:center">{{ $ligne->article_ref }}</td>
                <td style="height:30px;width:160px;line-height: 30px;text-align:center">{{ $ligne->article_designation }}</td>
                <td style="width:60px;text-align:center">{{ $ligne->no_commande }}</td>
                <td style="width:30px;text-align:center">{{ $ligne->no_poste }}</td>
                <td style="width:30px;text-align:center">1</td>

                @foreach ($ligne->numero_meta as $num)
                <td style="width:60px;text-align:center">{{ $num }}</td>
                @endforeach -->

            </tr>
            @endforeach
        </tbody>
    </table>
