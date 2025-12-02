@extends('layout.app')

@section('content')
<div class="card w-full h-full bg-base-100 shadow-xl">
    <div class="card-body overflow-y-auto flex flex-col">
        <h2 class="card-title m-2">Produits Réalisés</h2>
        <div class="flex-1 overflow-y-auto max-h-full">

            <form hx-get="{{ route('realisation.index') }}" hx-trigger="submit" hx-target="#realisation-zone"
                hx-swap="outerHTML" hx-push-url="true">
                @include('realisation.partials.table')
            </form>
        </div>
        <div class="card card-dash w-full bg-base-100 border-primary text-neutral-content ">
            <div class="card-body items-start text-center">
                <button class="btn btn-primary" id="btnAddBl">Ajouter au BL</button>
            </div>
        </div>
    </div>
</div>

<script>
    const boxes = () => document.querySelectorAll('tbody input[type="checkbox"]:not(:disabled)');
    const btnBL = document.querySelector('#btnAddBl');

    const syncAll = () => {
        const check_all = document.querySelector('#check_all');
        if (!check_all) return;
        check_all.checked = [...boxes()].every(cb => cb.checked);
        syncBtn();
    };

    const toggleAll = (checked) => {
        boxes().forEach(cb => cb.checked = checked);
        syncBtn();
    };

    const syncBtn = () => {
        const anyChecked =
            document.querySelector('#check_all')?.checked ||
            [...boxes()].some(cb => cb.checked);

        btnBL.disabled = !anyChecked;
    };

    document.addEventListener('change', (e) => {
        if (e.target.matches('#check_all')) {
            toggleAll(e.target.checked);
        } else if (e.target.matches('tbody input[type="checkbox"]')) {
            syncAll();
        }
    });

    document.addEventListener('htmx:afterSwap', () => {
        const check_all = document.querySelector('#check_all');
        if (check_all) check_all.checked = false;
        syncBtn();
    });

    document.addEventListener('DOMContentLoaded', syncAll);
</script>

@endsection