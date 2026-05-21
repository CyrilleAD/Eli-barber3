<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0, viewport-fit=cover" name="viewport"/>
    <title>@yield('title', "L'Atelier Prestige | Haute Coiffure")</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Bodoni+Moda:ital,opsz,wght@0,6..96,400..900;1,6..96,400..900&family=Manrope:wght@200..800&display=swap" rel="stylesheet"/>
    <!-- Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
              "surface-bright": "#fbf9f6",
              "glass-fill": "rgba(244, 239, 230, 0.75)",
              "border-sable": "#E3DCD0",
              "silk-beige": "#F4EFE6",
              "background": "#fbf9f6",
              "primary": "#6e5932",
              "secondary": "#625e57",
              "muted-taupe": "#6E665A",
              "on-secondary-fixed": "#1e1b16",
              "surface": "#fbf9f6",
              "on-surface": "#1b1c1a"
            },
            "fontFamily": {
              "display-lg-mobile": ["Bodoni Moda"],
              "label-md": ["Manrope"],
              "headline-md": ["Bodoni Moda"],
              "body-md": ["Manrope"]
            }
          }
        }
      }
    </script>
    <style>
        body {
            background-color: #FAF8F5;
            color: #1E1B16;
            overflow-x: hidden;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }
        .diagonal-strike {
            background: linear-gradient(to top left, transparent calc(50% - 0.5px), #E3DCD0, transparent calc(50% + 0.5px));
        }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .floating-label {
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            transform-origin: left top;
        }
        input:focus + .floating-label,
        input:not(:placeholder-shown) + .floating-label {
            transform: translateY(-20px) scale(0.85);
            color: #6e5932;
        }
    </style>
    @yield('styles')
</head>
<body class="font-body-md antialiased bg-surface text-on-surface">

    <!-- Top Navigation Bar -->
    <header class="fixed top-0 w-full z-50 bg-glass-fill backdrop-blur-xl border-b border-border-sable h-16 flex justify-between items-center px-6">
        <button class="text-primary p-2">
            <span class="material-symbols-outlined">menu</span>
        </button>
        <a href="{{ route('client.landing') }}">
            <h1 class="font-display-lg-mobile text-xl tracking-[0.2em] text-secondary">L'ATELIER PRESTIGE</h1>
        </a>
        <button class="text-primary p-2">
            <span class="material-symbols-outlined">shopping_bag</span>
        </button>
    </header>

    <!-- Main Content -->
    <main class="pt-16 min-h-screen">
        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>