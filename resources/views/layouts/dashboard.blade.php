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
    <link href="https://fonts.bunny.net/css?family=Exo+2" rel="stylesheet">

    <link rel="stylesheet" href="/css/mdb.min.css">
    <link rel="stylesheet" type="text/css" href="/css/admin.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw=="
    crossorigin="anonymous"></script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <!--Main Navigation-->
        <header>
            <!-- Sidebar -->
            <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
                <div class="position-sticky">
                    <div class="list-group list-group-flush mx-3 mt-4">
                        <a href="#"
                            class="list-group-item list-group-item-action py-2"
                            data-mdb-ripple-init aria-current="true">
                            <i class="fa fa-tachometer-alt fa-fw me-3"></i><span>{{ __('Tableau de bord') }}</span>
                        </a>

                        <a href="{{ route('quizzes.index') }}"
                            class="list-group-item list-group-item-action py-2
                              {{ request()->is('admin/quizzes*') ? 'active' : '' }}"
                            data-mdb-ripple-init aria-current="true">
                            <i class="fa fa-file-lines fa-fw me-3"></i><span>{{ __('Quiz') }}</span>
                        </a>

                        <a href="{{ route('users.index') }}"
                            class="list-group-item list-group-item-action py-2
                            {{ request()->is('admin/users*') ? 'active' : '' }}"
                            data-mdb-ripple-init aria-current="true">
                            <i class="fa fa-users fa-fw me-3"></i><span>{{ __('Utilisateurs') }}</span>
                        </a>

                        <a href="{{ route('segments.index') }}"
                            class="list-group-item list-group-item-action py-2
                            {{ request()->is('admin/segments*') ? 'active' : '' }}"
                            data-mdb-ripple-init aria-current="true">
                            <i class="fas fa-building-user fa-fw me-3"></i><span>{{ __('Plateaux') }}</span>
                        </a>

                        <a href="{{ route('categories.index') }}"
                            class="list-group-item list-group-item-action py-2
                            {{ request()->is('admin/categories*') ? 'active' : '' }}"
                            data-mdb-ripple-init aria-current="true">
                            <i class="fas fa-table-cells-large fa-fw me-3"></i><span>{{ __('Catégories') }}</span>
                        </a>

                        <a href="{{ route('roles.index') }}"
                            class="list-group-item list-group-item-action py-2
                            {{ request()->is('admin/roles*') ? 'active' : '' }}"
                            data-mdb-ripple-init aria-current="true">
                            <i class="fas fa-users-gear fa-fw me-3"></i><span>{{ __('Roles') }}</span>
                        </a>
                    </div>
                </div>
            </nav>
            <!-- Sidebar -->

            <!-- Navbar -->
            <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
                <!-- Container wrapper -->
                <div class="container-fluid">
                    <!-- Toggle button -->
                    <button type="button"
                        class="navbar-toggler"
                        data-mdb-collapse-init
                        data-mdb-target="#sidebarMenu"
                        aria-controls="sidebarMenu"
                        aria-expanded="false"
                        aria-label="Toggle navigation">
                        <i class="fas fa-bars"></i>
                    </button>

                    <!-- Brand -->
                    <a href="{{ url('/') }}" class="navbar-brand">
                        <img src="/logo.png" alt="" width="40">
                    </a>

                    <!-- Right links -->
                    <ul class="navbar-nav ms-auto d-flex flex-row">
                        <!-- Avatar -->
                        <li class="nav-item dropdown">
                            <a href="#"
                                class="nav-link dropdown-toggle hidden-arrow d-flex align-items-center"
                                id="navbarDropdownMenuLink"
                                role="button"
                                data-mdb-dropdown-init aria-expanded="false">
                                <img src="/images/avatar.jpg"
                                    class="rounded-circle"
                                    height="22"
                                    alt=""
                                    loading="lazy">
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end"
                                aria-labelledby="navbarDropdownMenuLink">
                                <li>
                                    <a href="{{ route('profile.edit') }}"
                                        class="dropdown-item">{{ __('Mon profil') }}</a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                        class="dropdown-item"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        {{ __('Déconnexion') }}
                                    </a>
                                </li>

                                <form id="logout-form"
                                    action="{{ route('logout') }}"
                                    method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- Container wrapper -->
            </nav>
            <!-- Navbar -->
        </header>
        <!--Main Navigation-->

        <!--Main layout-->
        <main class="py-4" style="margin-top: 58px">
            @include('partials.flash')
            @yield('content')
        </main>
    </div>

    <script type="text/javascript" src="/js/mdb.umd.min.js"></script>
    <!-- Custom scripts -->
    <script type="text/javascript" src="/js/admin.js"></script>

    @yield('scripts')
</body>
</html>
