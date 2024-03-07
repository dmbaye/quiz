<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a href="{{ url('/') }}" class="navbar-brand" title="Quiz">
            <img src="/logo.png" alt="" width="40">
        </a>

        <button type="button"
            class="navbar-toggler"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div id="navbarSupportedContent" class="navbar-collapse collapse">
            <ul class="navbar-nav me-auto">
                @auth
                    @role(['trainee', 'user', 'supervisor', 'backoffice'])
                        <li class="nav-item">
                            <a href="{{ route('quizzes.list') }}" class="nav-link">
                                {{ __('Mes Quiz') }}
                            </a>
                        </li>
                    @endrole
                @endauth
            </ul>

            <ul class="navbar-nav ms-auto">
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a href="{{ route('login') }}"class="nav-link">
                                {{ __('Connexion') }}
                            </a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="nav-link">
                                {{ __('Register') }}
                            </a>
                        </li>
                    @endif
                @else
                    @role(['superadmin', 'admin', 'trainer'])
                        <li class="nav-item">
                            <a href="{{ route('quizzes.index') }}" class="nav-link">
                                {{ __('Quiz') }}
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link">
                                {{ __('Utilisateurs') }}
                            </a>
                        </li>
                    @endrole

                    <li class="nav-item dropdown">
                        <a href="#"
                            id="navbarDropdown"
                            class="nav-link dropdown-toggle"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                            v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end"
                            aria-labelledby="navbarDropdown">
                            @role(['superadmin', 'admin', 'trainer'])
                                <a href="{{ route('settings.index') }}"
                                    class="dropdown-item">
                                    {{ __('Paramètres') }}
                                </a>
                            @endrole

                            <a href="{{ route('profile.edit') }}"
                                class="dropdown-item">
                                {{ __('Profil') }}
                            </a>

                            <a href="{{ route('logout') }}"
                                class="dropdown-item"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Déconnexion') }}
                            </a>

                            <form id="logout-form"
                                action="{{ route('logout') }}"
                                method="POST"
                                class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
