@extends('layouts.app')

@section('content')
<section class="relative h-[85vh] w-full flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img alt="Studio" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDK2IkiEJwNBTkkcO_tbXx0lOe8lQH9tSrUgBJQ0EeGUFGdn3w8uRMghHRkOoMQyX6yLjuhADsI0rGP7jEQ4jXnC-6B-bzLhRuRCGrIVXH-8xzKKksPwtfzA0gj7Uy5HYxQ0OPmDfbxGoWKNRGbD6S0iQbLkiLzZ_nk1yAIuSgAbfrt-V0Xqu7CSYTrzJcKprJIFQvnxWVdyaBtwXF3h7iPn_9Wl26Mf1nGZI945Jo83d9Dg3aOEc8Hh8AZf1TOQbVhqdIqSE25M-U"/>
        <div class="absolute inset-0 bg-black/40"></div>
    </div>
    <div class="relative z-10 px-6 text-center max-w-xl">
        <h2 class="font-display-lg-mobile text-4xl text-white mb-8 italic">
            L'Atelier Prestige.<br/>
            <span class="not-italic font-light opacity-90 text-2xl">Sculpter votre allure sur rendez-vous.</span>
        </h2>
        <a href="{{ route('client.book') }}" class="inline-block bg-[#1E1B16] text-[#F4EFE6] px-12 py-5 rounded-lg text-sm uppercase tracking-widest font-semibold hover:bg-opacity-90 transition-all">
            Réserver un créneau
        </a>
    </div>
</section>

<!-- Description & Services -->
<section class="bg-silk-beige py-24 px-6">
    <div class="max-w-screen-xl mx-auto flex flex-col md:flex-row gap-12">
        <div class="w-full md:w-1/2">
            <span class="text-primary font-bold uppercase tracking-widest mb-4 block">L'Excellence du Geste</span>
            <h3 class="font-headline-md text-3xl text-secondary leading-tight mb-8">Une approche singulière de la coiffure.</h3>
        </div>
        <div class="w-full md:w-1/2 space-y-12">
            <div class="border-t border-[#A48B60] pt-6">
                <h4 class="font-bold text-secondary text-lg">01. Prestation artisanale</h4>
                <p class="mt-4 text-muted-taupe">Chaque coupe est réalisée avec soin, selon des techniques artisanales précises et personnalisées.</p>
            </div>
            <div class="border-t border-[#A48B60] pt-6">
                <h4 class="font-bold text-secondary text-lg">02. Séance individuelle de 45 minutes</h4>
                <p class="mt-4 text-muted-taupe">Un créneau réservé et calme pour un diagnostic capillaire et une coupe soignée dans un cadre privé.</p>
            </div>
        </div>
    </div>
</section>
@endsection