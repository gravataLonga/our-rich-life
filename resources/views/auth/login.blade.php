<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
    <form action="{{ route('login.store') }}" method="post">
        @csrf

        <div class="p-6 flex flex-col bg-white rounded-md space-y-6 border border-slate-100">
            <div class="flex flex-col space-y-2">
                <label for="email">
                    e-mail
                </label>
                <x-form.input name="email" type="email"/>
            </div>
            <div class="flex flex-col space-y-2">
                <label for="password">password</label>
                <x-form.input name="password" type="password"/>
            </div>
            <x-button.primary type="submit">submit</x-button.primary>
        </div>

    </form>
</div>

</body>
</html>
