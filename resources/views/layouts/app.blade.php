<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Uskudar Uni - Address Book</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

@livewireStyles
@stack('styles')

<!-- Scripts -->
    <script src="{{ asset('js/alpine.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}"></script>
</head>
<body class="font-sans antialiased bg-gray-100">
<div class="min-h-screen bg-gray-100">
@include('layouts.navigation')

<!-- Page Heading -->
    <header class="bg-white shadow">
        <div class="flex justify-center max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            @if(! isset($buttons))
                <div>
                    {{ $header }}
                </div>
            @else
                <div class="mr-auto">
                    {{ $header }}
                </div>
                <div class="buttons">
                    {{ $buttons }}
                </div>
            @endif
        </div>
    </header>

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
</div>

@livewireScripts
@stack('scripts')

@if(session()->has('toast'))
    <script type="text/javascript">
        Toast.fire({
            icon: "{{ session('toast')['icon'] }}",
            title: "{{ session('toast')['message'] }}"
        })
    </script>
@endif

<script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js"
        data-turbolinks-eval="false" data-turbo-eval="false"></script>
</body>
</html>
