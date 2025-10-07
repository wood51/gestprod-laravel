<div class="card w-full h-full bg-base-100 shadow-xl">
    <div class="card-body">
        <h2 class="card-title">Planning</h2>
        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th></th>
                    <th>Sous ensemble</th>
                    <th>Job</th>
                    <th>Favorite Color</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 10; $i++)
                    <tr class="hover:bg-base-300">
                        <th><input type="checkbox" id="row-{{ $i }}" />{{ $i }}</th>
                        <td>Brice Swyre</td>
                        <td>Tax Accountant</td>
                        <td>Red</td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>
