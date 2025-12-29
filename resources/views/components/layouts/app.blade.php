<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Page Title' }}</title>
        @vite(['resources/js/app.js', 'resources/css/app.css'])
    </head>

    <body class="bg-slate-100">

    <header class="h-20 bg-slate-800 flex items-center">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="font-bold font-sans text-2xl text-white"><a href="/">Our Richer Life</a></h1>
            <nav class="">
                <div class="flex justify-around text-white font-semibold space-x-4 items-center">
                    <x-nav-item>Vision</x-nav-item>
                    <x-nav-item>Financial Selfie</x-nav-item>
                    <x-nav-item wire:navigate href="{{ route('bucket.overview') }}">Bucket</x-nav-item>
                </div>
            </nav>
        </div>
    </header>

    <div class="container mx-auto mt-10">
        {{ $slot }}
    </div>
    </body>
</html>
