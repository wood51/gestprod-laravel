@foreach ($rows as $index => $row)
    <tr class="hover:bg-base-300" id="planning_{{ $row->id }}">
        <th>
            <label for="check_{{ $row->id }}">
                @if ($row->pa === null && $row->semaine_engagement !== 'Fait')
                    <input type="checkbox" id="check_{{ $row->id }}" disabled />
                @else
                    <input type="checkbox" id="check_{{ $row->id }}" />
                @endif
            </label>
        </th>
        <td>
            <div class="flex items-center justify-start gap-2 h-full">
                <span style="background-color:  {{ $row->reference_couleur }} " class="w-4 h-6 rounded-sm"></span>
                <span>{{ $row->reference }}</span>
            </div>
        </td>
        <td> {{ $row->type }} </td>
        <td> {{ $row->numero }} </td>
        <td> {{ $row->semaine }} </td>
        <td> {{ $row->semaine_engagement }} </td>
        <td> {{ $row->pa }}</td>
        <td> {{ $row->poste }}</td>
        <td>
            @switch($row->status)
                @case('Fait')
                    <div class="badge badge-outline text-success text-xs">{{ $row->status }}</div>
                @break

                @case('Reporté')
                    <div class="badge badge-outline text-error text-xs">{{ $row->status }}</div>
                @break

                @case('En cours')
                    <div class="badge badge-outline text-warning text-xs">{{ $row->status }}</div>
                @break

                @case('Engagé')
                    <div class="badge badge-outline text-info text-xs">{{ $row->status }}</div>
                @break

                @default
                    <div class="badge badge-outline text-xs">{{ $row->status }}</div>
            @endswitch
        </td>
        <td> <i class="fas fa-check text-success"></i> </td>
        <td><i class="fa-solid fa-ellipsis-vertical"></i></td>
    </tr>
@endforeach
