<div class="card w-full h-full bg-base-100 shadow-xl">
    <div class="card-body overflow-y-auto">
        <h2 class="card-title m-2">Planning</h2>
        <div class="overflow-y-auto max-h-full">
            <table class="table table-sm">
                <!-- head -->
                <thead>
                    <tr>
                        <th></th>
                        <th>Référence</th>
                        <th>Type</th>
                        <th>Numero</th>
                        <th>Semaine</th>
                        <th>Engagement</th>
                        <th>Status</th>
                        <th>Réalisée</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rows as $index => $row)
                        <tr class="hover:bg-base-300" data-planning="{{ $row->id }}">
                            <th>{{ $index + 1 }}</th>
                            <td>
                                <div class="flex items-center justify-start gap-2 h-full">
                                    <span style="background-color:  {{ $row->reference_couleur }} "
                                        class="w-4 h-6 rounded-sm"></span>
                                    <span>{{ $row->reference }}</span>
                                </div>
                            </td>
                            <td> {{ $row->type }} </td>
                            <td> {{ $row->numero }} </td>
                            <td> {{ $row->semaine }} </td>
                            <td> {{ $row->semaine_engagement }} </td>
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
                </tbody>
            </table>
        </div>
    </div>
</div>
