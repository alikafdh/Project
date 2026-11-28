@php
    $profil = $profil ?? \App\Models\ProfilPuskesmas::first();
    $klasters = $klasters ?? \App\Models\KlasterILP::orderBy('id')->get();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' - ' : '' }}UPTD Puskesmas Cilimus — Dinas Kesehatan Kabupaten Kuningan</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Google Material Symbols Outlined -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-[#F8F9FA] text-slate-900 antialiased selection:bg-[#E8F5E9] selection:text-[#0D3813]" style="font-family: 'Inter', system-ui, -apple-system, sans-serif;">
    <x-public.topbar :profil="$profil" />

    <x-public.navbar :profil="$profil" />

    <main class="min-h-screen">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <x-public.footer :profil="$profil" :klasters="$klasters" />

    <x-public.whatsapp-fab :profil="$profil" />

    @stack('scripts')
</body>
</html>
