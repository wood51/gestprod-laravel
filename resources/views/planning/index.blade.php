<div class="card w-full h-full bg-base-100 shadow-xl">
    <div class="card-body overflow-y-auto">
        <h2 class="card-title m-2">Planning</h2>
        <div class="overflow-y-auto max-h-full">
            <div class="flex gap-2 mb-2">
                <button class="btn btn-xs" hx-get="{{ route('planning.index') }}?_dd=1" hx-target="#tbody-planning">
                    Test HTMX (dd)
                </button>

                <button class="btn btn-xs" hx-get="{{ route('planning.index') }}" hx-target="#tbody-planning">
                    Recharger tbody
                </button>
            </div>
            <table class="table table-sm">
                <!-- head -->
                <thead>
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
                </thead>
                <tbody id="tbody-planning">
                    @include('planning.partials.tbody')
                </tbody>
            </table>
        </div>
    </div>
</div>
