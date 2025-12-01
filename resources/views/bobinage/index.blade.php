@extends("layout.app")
@section("content")
    <div class="max-w-3xl mx-auto mt-8 space-y-6">

        @if(session('error'))
            <div class="alert alert-error shadow-lg">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- SUIVI EN COURS --}}
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title">Ton travail en cours</h2>

                @if($enCours)
                    <p class="text-lg font-semibold">{{ $enCours->libelle }}</p>
                    <p class="opacity-70">
                        Démarré : {{ $enCours->started_at->format('d/m H:i') }}
                    </p>

                    <form method="POST" action="{{ route('bobinage.stop', $enCours) }}">
                        @csrf
                        <button class="btn btn-error btn-lg mt-4 w-full">
                            STOP – J’ai terminé
                        </button>
                    </form>
                @else
                    <p>Aucun stator en cours.</p>
                @endif
            </div>
        </div>

        {{-- LISTE DES PRODUITS EN ATTENTE --}}
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">

                <h2 class="card-title">Stators en attente</h2>

                @if($enAttente->isEmpty())
                    <p>Aucun stator à traiter.</p>
                @else
                    <div class="space-y-4">
                        @foreach($enAttente as $suivi)
                            <div class="p-4 border rounded flex justify-between items-center">
                                <div>
                                    <p class="font-bold">{{ $suivi->libelle }}</p>
                                </div>

                                <form method="POST" action="{{ route('bobinage.start', $suivi) }}">
                                    @csrf
                                    <button class="btn btn-success">
                                        Démarrer
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>

    </div>

@endsection
