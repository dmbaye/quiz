@extends('layouts.dashboard')

@section('content')
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <span class="align-self-center">{{ __('Utilisateurs') }}</span>

                        <div class="d-flex">
                            <form action="" method="GET" class="me-2">
                                <input type="text"
                                    name="search"
                                    id="search"
                                    value="{{ request()->search ?? '' }}"
                                    placeholder="Rechercher utilisateur..."
                                    class="form-control form-control-sm">
                            </form>

                            <span>
                                <a href="#"
                                    class="btn btn-sm btn-success"
                                    data-mdb-toggle="modal"
                                    data-mdb-target="#addUserModal">
                                    {{ __('Ajouter Utilisateur') }}
                                </a>
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        @if ($users->count())
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Nom') }}</th>
                                        <th>{{ __('Login') }}</th>
                                        <th>{{ __('Plateau') }}</th>
                                        <th>{{ __('Fonction') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $index => $user)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>
                                                <a href="{{ route('users.show', $user) }}">
                                                    {{ $user->username }}
                                                </a>
                                            </td>
                                            <td>{{ $user->segment->name ?? '' }}</td>
                                            <td>{{ $user->roles[0]->display_name }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button"
                                                        class="btn btn-sm btn-light dropdown-toggle"
                                                        id="dropdownMenuButton1"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fa fa-ellipsis"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                        <li>
                                                            <a href="#"
                                                                class="dropdown-item"
                                                                data-mdb-toggle="modal"
                                                                data-mdb-target="#editUserModal-{{ $user->id }}">
                                                                {{ __('Modifier') }}
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="#"
                                                                class="dropdown-item"
                                                                onclick="event.preventDefault();
                                                                document.getElementById('deactivate-form-{{ $user->id }}').submit();">
                                                                {{ __('Desactiver') }}
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="#"
                                                                class="dropdown-item"
                                                                onclick="event.preventDefault();
                                                                document.getElementById('delete-form-{{ $user->id }}').submit();">
                                                                {{ __('Supprimer') }}
                                                            </a>
                                                        </li>
                                                    </ul>

                                                    <form id="deactivate-form-{{ $user->id }}"
                                                        action="{{ route('users.deactivate', $user) }}"
                                                        method="POST"
                                                        class="d-none">
                                                        @csrf
                                                        @method('delete')
                                                    </form>

                                                    <form id="delete-form-{{ $user->id }}"
                                                        action="{{ route('users.delete', $user) }}"
                                                        method="POST"
                                                        class="d-none">
                                                        @csrf
                                                        @method('delete')
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Edit User Modal -->
                                        @include('partials.modals.users.edit')
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $users->links() }}
                        @else
                            <p>{{ __('Aucun utilisateur trouvez. Ajouter des utilisateurs.') }}</p>
                        @endif
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header d-flex justify-content-between">
                        <span class="align-self-center">{{ __('Utilisateurs Inactifs') }}</span>

                        <div class="d-flex">
                            <form action="" method="GET" class="me-2">
                                <input type="text"
                                    name="search"
                                    id="search"
                                    value="{{ request()->search ?? '' }}"
                                    placeholder="Rechercher utilisateur..."
                                    class="form-control form-control-sm">
                            </form>
                        </div>
                    </div>

                    <div class="card-body">
                        @if ($inactiveUsers->count())
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Nom') }}</th>
                                        <th>{{ __('Login') }}</th>
                                        <th>{{ __('Plateau') }}</th>
                                        <th>{{ __('Role') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inactiveUsers as $index => $user)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>
                                                <a href="{{ route('users.show', $user) }}">
                                                    {{ $user->username }}
                                                </a>
                                            </td>
                                            <td>{{ $user->segment->name ?? '' }}</td>
                                            <td>{{ $user->roles[0]->display_name }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button"
                                                        class="btn btn-sm btn-light dropdown-toggle"
                                                        id="dropdownMenuButton1"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fa fa-ellipsis"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                        <li>
                                                            <a href="#"
                                                                class="dropdown-item"
                                                                data-mdb-toggle="modal"
                                                                data-mdb-target="#editUserModal-{{ $user->id }}">
                                                                {{ __('Modifier') }}
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="#"
                                                                class="dropdown-item"
                                                                onclick="event.preventDefault();
                                                                document.getElementById('activation-form-{{ $user->id }}').submit();">
                                                                {{ __('Activer') }}
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="#"
                                                                class="dropdown-item"
                                                                onclick="event.preventDefault();
                                                                document.getElementById('delete-form-{{ $user->id }}').submit();">
                                                                {{ __('Supprimer') }}
                                                            </a>
                                                        </li>
                                                    </ul>

                                                    <form id="activation-form-{{ $user->id }}"
                                                        action="{{ route('users.activate', $user) }}"
                                                        method="POST"
                                                        class="d-none">
                                                        @csrf
                                                        @method('PUT')
                                                    </form>

                                                    <form id="delete-form-{{ $user->id }}"
                                                        action="{{ route('users.delete', $user) }}"
                                                        method="POST"
                                                        class="d-none">
                                                        @csrf
                                                        @method('delete')
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Edit User Modal -->
                                        @include('partials.modals.users.edit')
                                    @endforeach
                                </tbody>
                            </table>

                            {{ $inactiveUsers->links() }}
                        @else
                            <p>{{ __('Aucun utilisateur inactif trouvez.') }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                @role(['superadmin', 'admin'])
                    <div class="card">
                        <div class="card-header">{{ __('Importer des utilisateurs') }}</div>

                        <div class="card-body">
                            <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <input type="file" name="file" id="file" class="form-control">
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    {{ __('Importer') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endrole
            </div>
        </div>
    </div>
</section>
@endsection

<!-- Add User Modal -->
@include('partials.modals.users.create')

@section('scripts')
<script>
    function deleteUser(id) {
        window.location.href = `/admin/users/${id}/delete`;
    }
</script>
@endsection
