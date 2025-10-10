<div class="card w-full h-full bg-base-100 shadow-xl">
    <div class="card-body overflow-y-auto">
        <h2 class="card-title m-2">Planning</h2>
        <div class="overflow-y-auto max-h-full">
            <div class="flex gap-2 mb-2">
            </div>
            <form hx-get="{{ route('planning.rows') }}" hx-trigger="submit" hx-target="#tbody-planning" hx-push-url="true">
                <table class="table table-sm">
                    <!-- head -->
                    {{-- <thead>
                        <tr class="sticky top-0 z-10 bg-blue-200">
                            <th>
                                <label for="check_all">
                                    <input type="checkbox" id="check_all" />
                                </label>
                            </th>
                            <th>Référence</th>
                            <th>Type</th>
                            <th>Numero</th>
                            <th>Semaine</th>
                            <th>Engagement</th>
                            <th>PA</th>
                            <th>Poste</th>
                            <th>Status</th>
                            <th>Réalisée</th>
                            <th>Action</th>
                        </tr>
                    </thead> --}}
                    <thead class="sticky top-0 z-10">
                        {{-- Titres --}}
                        <tr class="bg-blue-200">
                            <th class="w-10">
                                <label for="check_all">
                                    <input type="checkbox" id="check_all" />
                                </label>
                            </th>
                            <th>Référence</th>
                            <th>Type</th>
                            <th>Numero</th>
                            <th>Semaine</th>
                            <th>Engagement</th>
                            <th>PA</th>
                            <th>Poste</th>
                            <th>Status</th>
                            <th>Réalisée</th>
                            <th>Action</th>
                        </tr>

                        {{-- Filtres (on ne met QUE Status pour l’instant) --}}
                        <tr class="bg-blue-100/80 backdrop-blur">
                            <th></th>
                            <th></th>
                            <th>
                                <select name="type" class="select select-xs select-bordered w-full">
                                    <option value="">Tous</option>
                                    @foreach ($types ?? ['Alternateur', 'Compresseur'] as $t)
                                        <option value="{{ $t }}" @selected(request('type') === $t)>
                                            {{ $t }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th></th>
                            <th></th>
                            <th>
                                <input name="eng" value="{{ request('eng') }}" placeholder="YYYY-WW"
                                    class="input input-xs input-bordered w-full" />
                            </th>
                            <th></th>
                            <th></th>
                       

                            {{-- Status --}}
                            <th>
                                <select name="status" class="select select-xs select-bordered w-full">
                                    <option value="">Tous</option>
                                    @foreach ($statuses ?? ['Fait', 'Reporté', 'En cours', 'Engagé'] as $s)
                                        <option value="{{ $s }}" @selected(request('status') === $s)>
                                            {{ $s }}</option>
                                    @endforeach
                                </select>
                            </th>

                            <th></th>

                            {{-- Actions filtres --}}
                            <th class="flex gap-1">
                                <button type="submit" class="btn btn-xs btn-primary">Appliquer</button>

                                {{-- Reset logique (ne re-render QUE le tbody) --}}
                                <a class="btn btn-xs" hx-get="{{ route('planning.rows') }}" hx-target="#tbody-planning"
                                    hx-push-url="true" hx-vals='{"status": ""}'>
                                    Reset
                                </a>
                            </th>
                        </tr>
                    </thead>

                    <tbody id="tbody-planning">
                        @include('planning.partials.tbody')
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
