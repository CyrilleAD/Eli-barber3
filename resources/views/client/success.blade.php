@extends('layouts.app')

@section('content')
<div class="max-w-[500px] mx-auto px-6 py-20 text-center">
    <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-8 border border-green-200">
        <span class="material-symbols-outlined text-green-600 text-4xl">check</span>
    </div>
    
    <h2 class="font-display-lg-mobile text-3xl mb-4">Rendez-vous confirmé</h2>
    <p class="text-muted-taupe mb-8">Merci {{ $appointment->client_name }}, votre moment de détente est réservé.</p>
    
    <div class="bg-silk-beige p-6 rounded-xl border border-border-sable mb-10 text-left space-y-4">
        <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($appointment->date)->translatedFormat('d F Y') }}</p>
        <p><strong>Horaire :</strong> {{ substr($appointment->start_time, 0, 5) }} - {{ substr($appointment->end_time, 0, 5) }} (45 min)</p>
        <p><strong>Salon :</strong> L'Atelier Prestige</p>
    </div>
    
    <div class="space-y-4">
        <!-- Bouton de retour -->
        <a href="{{ route('client.landing') }}" class="block w-full bg-on-secondary-fixed text-white py-4 rounded-lg font-bold uppercase tracking-widest hover:bg-opacity-90">
            Retour à l'accueil
        </a>
    </div>
</div>
@endsection