@extends('layouts.dashboard')

@section('content')
<section>
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span>{{ __('Rôles') }}</span>

                <div class="mb-0">
                    <a href="#"
                        class="btn btn-sm btn-success"
                        data-mdb-toggle="modal"
                        data-mdb-target="#addRoleModal">
                        {{ __('Ajouter Rôle') }}
                    </a>
                </div>
            </div>

            <div class="card-body">
                @if ($roles->count())
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $index => $role)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $role->display_name }}</td>
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
                                                        data-mdb-target="#editRoleModal-{{ $role->id }}">
                                                        {{ __('Modifier') }}
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="#"
                                                        class="dropdown-item"
                                                        onclick="event.preventDefault();
                                                        document.getElementById('delete-form-{{ $role->id }}').submit();">
                                                        {{ __('Supprimer') }}
                                                    </a>
                                                </li>
                                            </ul>

                                            <form id="publish-form-{{ $role->id }}"
                                                action="{{ route('quizzes.publish', $role) }}"
                                                method="POST"
                                                class="d-none">
                                                @csrf
                                                @method('PUT')
                                            </form>

                                            <form id="archive-form-{{ $role->id }}"
                                                action="{{ route('quizzes.archive', $role) }}"
                                                method="POST"
                                                class="d-none">
                                                @csrf
                                                @method('PUT')
                                            </form>

                                            <form id="delete-form-{{ $role->id }}"
                                                action="{{ route('quizzes.delete', $role) }}"
                                                method="POST"
                                                class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Aucune données pour le moment</p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@include('partials.modals.roles.create')
