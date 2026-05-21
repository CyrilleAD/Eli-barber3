@extends('layouts.app')

@section('content')
<div class="max-w-[800px] mx-auto px-6 py-10">
    <div class="flex justify-between items-center mb-10 border-b border-border-sable pb-6">
        <div>
            <h2 class="font-display-lg-mobile text-3xl">Espace Créateur</h2>
            <p class="text-muted-taupe text-sm">Gestion des réservations et des horaires.</p>
        </div>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="border border-red-300 text-red-600 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-50">
                Déconnexion
            </button>
        </form>
    </div>

    <!-- Notifications de succès -->
    @if(session('success'))
        <div class="mb-8 p-4 bg-green-100 text-green-700 rounded text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <!-- A. CONFIGURER UNE DISPONIBILITÉ -->
        <div>
            <h3 class="font-bold text-lg mb-6 border-b border-primary pb-2 text-primary">Ajouter une ouverture</h3>
            <form action="{{ route('admin.availabilities.store') }}" method="POST" class="space-y-6 bg-silk-beige p-6 rounded-xl border border-border-sable">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-muted-taupe mb-2">Date</label>
                    <input type="date" name="date" required class="w-full border-border-sable rounded-lg bg-white">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-muted-taupe mb-2">Début</label>
                        <input type="time" name="start_time" required class="w-full border-border-sable rounded-lg bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-muted-taupe mb-2">Fin</label>
                        <input type="time" name="end_time" required class="w-full border-border-sable rounded-lg bg-white">
                    </div>
                </div>
                <button type="submit" class="w-full bg-primary text-white py-3 rounded-lg font-bold uppercase text-xs tracking-wider hover:bg-opacity-95">
                    Ajouter cette plage
                </button>
            </form>

            <h3 class="font-bold text-md mt-10 mb-4">Vos plages d'ouverture actives</h3>
            <div class="space-y-3">
                @forelse($availabilities as $avail)
                    <div class="flex justify-between items-center bg-white p-4 border border-border-sable rounded-lg text-sm">
                        <span>
                            <strong>{{ \Carbon\Carbon::parse($avail->date)->translatedFormat('d M') }}</strong> : 
                            {{ substr($avail->start_time, 0, 5) }} - {{ substr($avail->end_time, 0, 5) }}
                        </span>
                        <form action="{{ route('admin.availabilities.destroy', $avail->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 font-bold">X</button>
                        </form>
                    </div>
                @empty
                    <p class="text-xs text-muted-taupe">Aucune plage définie.</p>
                @endforelse
            </div>
        </div>

        <!-- B. LISTE DES RENDEZ-VOUS A VENIR -->
        <div>
            <h3 class="font-bold text-lg mb-6 border-b border-primary pb-2 text-primary">Rendez-vous prévus</h3>
            <div class="space-y-4">
                @forelse($appointments as $appt)
                    <div class="bg-white p-6 border border-border-sable rounded-xl space-y-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="block font-bold text-md">{{ $appt->client_name }}</span>
                                <span class="text-xs text-muted-taupe">{{ $appt->client_email }} • {{ $appt->client_phone }}</span>
                            </div>
                            <span class="bg-silk-beige px-3 py-1 text-xs rounded-full font-bold text-primary">
                                {{ substr($appt->start_time, 0, 5) }} (45 min)
                            </span>
                        </div>
                        <div class="text-sm">
                            <strong>Le :</strong> {{ \Carbon\Carbon::parse($appt->date)->translatedFormat('d F Y') }}
                        </div>
                        <div class="pt-2 flex gap-2">
                            <form action="{{ route('admin.appointments.cancel', $appt->id) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit" class="w-full border border-red-200 text-red-500 py-2 rounded-lg text-xs font-bold uppercase hover:bg-red-50">
                                    Annuler
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-muted-taupe text-center py-10">Aucun rendez-vous planifié.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection