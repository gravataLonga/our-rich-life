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
    </div>
</header>

    <div class="container mx-auto mt-10">
        @csrf

        <x-card class="mx-auto">
            <form action="{{ route('login.store') }}" method="post">
                <div class="flex flex-col space-y-4">
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
                    <x-button.primary type="submit">sign in</x-button.primary>
                </div>
            </form>
            <x-login-link email="me@jonathan.pt" class="mt-10"/>
        </x-card>
    </div>

</body>
</html>
