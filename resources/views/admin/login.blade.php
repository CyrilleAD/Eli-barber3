@extends('layouts.app')

@section('content')
<div class="max-w-[400px] mx-auto px-6 py-20 text-center">
    <h2 class="font-display-lg-mobile text-3xl mb-4">Espace Créateur</h2>
    <p class="text-muted-taupe text-sm mb-8">Veuillez saisir votre code d'accès.</p>

    @if($errors->has('pin'))
        <div class="mb-6 p-4 bg-red-100 text-red-700 text-sm rounded">
            {{ $errors->first('pin') }}
        </div>
    @endif

    <form action="{{ route('admin.login.post') }}" method="POST" id="pin-form">
        @csrf
        <!-- Affichage des cercles/points pour le PIN -->
        <div class="flex justify-center gap-4 mb-10">
            <span class="pin-dot w-4 h-4 rounded-full border-2 border-primary"></span>
            <span class="pin-dot w-4 h-4 rounded-full border-2 border-primary"></span>
            <span class="pin-dot w-4 h-4 rounded-full border-2 border-primary"></span>
            <span class="pin-dot w-4 h-4 rounded-full border-2 border-primary"></span>
        </div>

        <input type="hidden" name="pin" id="pin-input">

        <!-- Clavier numérique tactile -->
        <div class="grid grid-cols-3 gap-6 max-w-[280px] mx-auto mb-10">
            @for($i = 1; $i <= 9; $i++)
                <button type="button" onclick="pressKey('{{ $i }}')" class="w-16 h-16 rounded-full border border-border-sable flex items-center justify-center text-xl font-bold hover:bg-silk-beige active:bg-border-sable">
                    {{ $i }}
                </button>
            @endfor
            <button type="button" onclick="clearPIN()" class="w-16 h-16 rounded-full flex items-center justify-center text-sm font-semibold hover:text-red-600">
                Effacer
            </button>
            <button type="button" onclick="pressKey('0')" class="w-16 h-16 rounded-full border border-border-sable flex items-center justify-center text-xl font-bold hover:bg-silk-beige">
                0
            </button>
            <button type="submit" class="w-16 h-16 rounded-full bg-primary text-white flex items-center justify-center font-bold hover:bg-opacity-95">
                OK
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    let currentPIN = "";
    const maxDigits = 4;
    const pinInput = document.getElementById('pin-input');
    const dots = document.querySelectorAll('.pin-dot');

    function pressKey(num) {
        if (currentPIN.length < maxDigits) {
            currentPIN += num;
            updateDots();
        }
    }

    function clearPIN() {
        currentPIN = "";
        updateDots();
    }

    function updateDots() {
        pinInput.value = currentPIN;
        dots.forEach((dot, index) => {
            if (index < currentPIN.length) {
                dot.classList.add('bg-primary');
            } else {
                dot.classList.remove('bg-primary');
            }
        });
    }
</script>
@endsection