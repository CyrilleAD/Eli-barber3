@extends('layouts.app')

@section('content')
<div class="max-w-[600px] mx-auto px-6 pt-10 pb-32">
    <!-- Titre -->
    <section class="mb-10 text-center">
        <h2 class="font-display-lg-mobile text-3xl text-on-surface mb-2">Choix du créneau</h2>
        <p class="text-muted-taupe text-sm">Réservez votre séance de 45 minutes.</p>
    </section>

    <!-- Affichage des erreurs éventuelles -->
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('client.book.store') }}" method="POST" id="booking-form">
        @csrf
        <input type="hidden" name="date" id="selected-date" value="{{ $selectedDate }}">
        <input type="hidden" name="start_time" id="selected-time" value="{{ old('start_time') }}">

        <!-- 1. SÉLECTEUR DE DATE HORIZONTAL (7 PROCHAINS JOURS) -->
        <section class="mb-12">
            <h3 class="font-label-md uppercase tracking-widest text-primary text-xs mb-6">Sélectionnez la Date</h3>
            <div class="flex gap-4 overflow-x-auto no-scrollbar pb-4">
                @for($i = 0; $i < 7; $i++)
                    @php
                        $day = \Carbon\Carbon::today()->addDays($i);
                        $isTodaySelected = ($day->toDateString() === $selectedDate);
                    @endphp
                    <a href="?date={{ $day->toDateString() }}" 
                       class="flex flex-col items-center justify-center min-w-[72px] h-[92px] rounded-xl transition-all {{ $isTodaySelected ? 'border border-primary bg-silk-beige' : '' }}">
                        <span class="text-xs text-muted-taupe uppercase mb-2">{{ $day->translatedFormat('D') }}</span>
                        <div class="w-12 h-12 flex items-center justify-center rounded-full font-bold {{ $isTodaySelected ? 'text-primary' : 'text-on-surface' }}">
                            {{ $day->format('d') }}
                        </div>
                    </a>
                @endfor
            </div>
        </section>

        <!-- 2. GRILLE DE CRÉNEAUX DE 45 MIN -->
        <section class="mb-12">
            <h3 class="font-label-md uppercase tracking-widest text-primary text-xs mb-6">Créneaux Disponibles (45 min)</h3>
            @if(count($availableSlots) > 0)
                <div class="grid grid-cols-2 gap-4">
                    @foreach($availableSlots as $slot)
                        @php
                            $slotEnd = \Carbon\Carbon::createFromFormat('H:i', $slot)->addMinutes(45)->format('H:i');
                        @endphp
                        <button type="button" 
                                onclick="selectSlot('{{ $slot }}')"
                                id="slot-{{ $slot }}"
                                class="slot-btn h-16 flex items-center justify-center bg-silk-beige border border-border-sable rounded-lg font-medium transition-all hover:bg-secondary-container">
                            {{ $slot }} - {{ $slotEnd }}
                        </button>
                    @endforeach
                </div>
            @else
                <p class="text-muted-taupe text-center py-6">Aucun créneau disponible pour cette date.</p>
            @endif
        </section>

        <!-- 3. FORMULAIRE CLIENT -->
        <section class="mb-16">
            <h3 class="font-label-md uppercase tracking-widest text-primary text-xs mb-10">Vos Coordonnées</h3>
            <div class="space-y-12">
                <div class="relative border-b border-border-sable py-2">
                    <input class="w-full bg-transparent border-none focus:ring-0 p-0 font-semibold" 
                           id="client_name" name="client_name" value="{{ old('client_name') }}" placeholder=" " type="text" required/>
                    <label class="floating-label absolute left-0 top-2 text-muted-taupe pointer-events-none" for="client_name">Nom complet</label>
                </div>
                <div class="relative border-b border-border-sable py-2">
                    <input class="w-full bg-transparent border-none focus:ring-0 p-0 font-semibold" 
                           id="client_email" name="client_email" value="{{ old('client_email') }}" placeholder=" " type="email" required/>
                    <label class="floating-label absolute left-0 top-2 text-muted-taupe pointer-events-none" for="client_email">Adresse email</label>
                </div>
                <div class="relative border-b border-border-sable py-2">
                    <input class="w-full bg-transparent border-none focus:ring-0 p-0 font-semibold" 
                           id="client_phone" name="client_phone" value="{{ old('client_phone') }}" placeholder=" " type="tel" required/>
                    <label class="floating-label absolute left-0 top-2 text-muted-taupe pointer-events-none" for="client_phone">Numéro de téléphone</label>
                </div>
            </div>
        </section>

        <!-- 4. BOUTON DE CONFIRMATION FIXE EN BAS -->
        <div class="fixed bottom-0 left-0 w-full p-6 bg-glass-fill backdrop-blur-xl border-t border-border-sable z-50">
            <div class="max-w-[600px] mx-auto">
                <button type="submit" class="w-full bg-on-secondary-fixed text-white h-16 rounded-lg font-bold uppercase tracking-widest hover:bg-opacity-90 transition-all">
                    Confirmer mon rendez-vous
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function selectSlot(time) {
        // Mettre à jour l'input caché
        document.getElementById('selected-time').value = time;
        
        // Mettre à jour les classes visuelles des boutons
        document.querySelectorAll('.slot-btn').forEach(btn => {
            btn.classList.remove('bg-on-secondary-fixed', 'text-white', 'scale-105', 'shadow-lg');
            btn.classList.add('bg-silk-beige', 'text-on-secondary-fixed');
        });
        
        const selectedBtn = document.getElementById('slot-' + time);
        if (selectedBtn) {
            selectedBtn.classList.remove('bg-silk-beige', 'text-on-secondary-fixed');
            selectedBtn.classList.add('bg-on-secondary-fixed', 'text-white', 'scale-105', 'shadow-lg');
        }
    }
</script>
@endsection