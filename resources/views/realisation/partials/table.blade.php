<div id="realisation-zone">
    <table class="table table-sm select-none">
        <thead class="sticky top-0 z-10">
            {{-- Titres --}}
            <tr class="bg-primary/80 text-primary-content">
                <th class="w-10">
                    <label for="check_all">
                        <input type="checkbox" id="check_all" />
                    </label>
                </th>
                <th>Référence</th>
                <th>Type</th>
                <th>Numero</th>
                {{-- <th>Semaine</th> --}}
                <th>Engagement</th>
                <th>PA</th>
                <th>Poste</th>
                <th>Status</th>
                {{-- <th>Réalisée</th> --}}
                <th></th>
            </tr>

            {{-- Filtres --}}
            <tr class="bg-primary/10 backdrop-blur">
                <th></th>
                <th>
                    <select name="refs" class="select select-xs select-bordered w-full">
                        <option value="">Tous</option>
                        @foreach ($refs as $r)
                            <option value="{{ $r->reference }}" @selected(request('refs') === $r->reference)>
                                {{ $r->reference }}
                            </option>
                        @endforeach
                    </select>
                </th>
                <th>
                    <select name="type" class="select select-xs select-bordered w-full">
                        <option value="">Tous</option>
                        @foreach ($types as $t)
                            <option value="{{ $t->designation }}" @selected(request('type') === $t->designation)>
                                {{ $t->designation }}
                            </option>
                        @endforeach
                    </select>
                </th>
                <th></th>
                {{-- <th></th> --}}
                <th>
                    <input name="eng" value="{{ request('eng') }}" placeholder="YYYY-WW"
                        class="input input-xs input-bordered w-full" />
                </th>
                <th></th>
                <th></th>

                <th>
                    <select name="status" class="select select-xs select-bordered w-full">
                        <option value="">Tous</option>
                        @foreach ($statuses as $s)
                            <option value="{{ $s }}" @selected(request('status') === $s)>
                                {{ $s }}
                            </option>
                        @endforeach
                    </select>
                </th>

                {{-- <th></th> --}}

                <th class="flex gap-1">
                    <button type="submit" class="btn btn-xs btn-primary" title="Appliquer"><i class="fas fa-check"></i></button> {{-- Appliquer --}}

                    <button
                        class="btn btn-xs"
                        hx-get="{{ route('realisation.index') }}"
                        hx-target="#realisation-zone"
                        hx-swap="outerHTML"
                        hx-push-url="true"
                        title="Reset"
                    >
                        <i class="fa-solid fa-xmark"></i> {{-- Reset --}}
                    </button>
                </th>
            </tr>
        </thead>

        <tbody id="tbody-realisation">
            @include('realisation.partials.tbody', ['rows' => $rows])
        </tbody>
    </table>

    <div class="mt-4">
        {{ $rows->links() }}
    </div>
</div>
