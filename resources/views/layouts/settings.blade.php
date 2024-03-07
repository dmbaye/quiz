<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Dɔnniya') }}</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        @include('partials.navbar')
        @include('partials.flash')

        <div class="container mt-4">
            <!-- Tabs navs -->
            <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="{{ route('settings.index') }}"
                        class="nav-link {{ url()->current() === route('settings.index') ? 'active' : '' }}"
                        role="tab"
                        aria-controls="ex1-tabs-2"
                        aria-selected="false">
                        {{ __('Parametres') }}
                    </a>
                </li>

                <li class="nav-item" role="presentation">
                    <a href="{{ route('categories.index') }}"
                        class="nav-link {{ url()->current() === route('categories.index') ? 'active' : '' }}"
                        role="tab"
                        aria-controls="ex1-tabs-2"
                        aria-selected="false">
                        {{ __('Catégories') }}
                    </a>
                </li>

                <li class="nav-item" role="presentation">
                    <a href="{{ route('segments.index') }}"
                        class="nav-link {{ url()->current() === route('segments.index') ? 'active' : '' }}"
                        role="tab"
                        aria-controls="ex1-tabs-2"
                        aria-selected="false">
                        {{ __('Plateaux') }}
                    </a>
                </li>

                @role(['superadmin', 'admin'])
                    <li class="nav-item" role="presentation">
                        <a href="{{ route('roles.index') }}"
                            class="nav-link {{ url()->current() === route('roles.index') ? 'active' : '' }}"
                            role="tab"
                            aria-controls="ex1-tabs-2"
                            aria-selected="false">
                            {{ __('Rôles') }}
                        </a>
                    </li>
                @endrole
            </ul>
            <!-- Tabs navs -->
        </div>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>
</html>
