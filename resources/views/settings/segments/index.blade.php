@extends('layouts.dashboard')

@section('content')
<section class="mt-4">
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span>{{ __('Plateaux') }}</span>

                <div class="mb-0">
                    <a href="#"
                        class="btn btn-sm btn-success"
                        data-mdb-toggle="modal"
                        data-mdb-target="#addSegmentModal">
                        {{ __('Ajouter Plateau') }}
                    </a>
                </div>
            </div>

            <div class="card-body">
                @if ($segments->count())
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Nom Plateau') }}</th>
                                <th>{{ __('Nb Utilisateurs') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($segments as $index => $segment)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $segment->name }}</td>
                                    <td>{{ $segment->users->count() }}</td>
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
                                                        data-mdb-target="#editSegmentModal-{{ $segment->id }}">
                                                        {{ __('Modifier') }}
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="#"
                                                        class="dropdown-item"
                                                        onclick="event.preventDefault();
                                                        document.getElementById('delete-form-{{ $segment->id }}').submit();">
                                                        {{ __('Supprimer') }}
                                                    </a>
                                                </li>
                                            </ul>

                                            <form id="delete-form-{{ $segment->id }}"
                                                action="{{ route('segments.delete', $segment) }}"
                                                method="POST"
                                                class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                    </td>
                                </tr>

                                <!-- Edit Segment Modal -->
                                <form action="{{ route('segments.update', $segment) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal fade"
                                        id="editSegmentModal-{{ $segment->id }}"
                                        tabindex="-1"
                                        aria-labelledby="editSegmentModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editSegmentModalLabel">
                                                        {{ __('Modifier Plateau') }}
                                                    </h5>

                                                    <button type="button"
                                                        class="btn-close"
                                                        data-mdb-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="form-outline mb-3">
                                                        <input type="text"
                                                            name="name"
                                                            id="name"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            value="{{ old('name', $segment->name) }}">

                                                        <label for="name" class="form-label">
                                                            {{ __('Nom Plateau') }}
                                                        </label>

                                                        @error('name')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>

                                                    <div class="form-outline mb-3">
                                                        <textarea name="description"
                                                            id="description"
                                                            cols="30"
                                                            rows="3" class="form-control">{{ old('description', $segment->description) }}</textarea>

                                                        <label for="date" class="form-label">
                                                            {{ __('Description') }}
                                                        </label>

                                                        @error('date')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button"
                                                        class="btn btn-secondary"
                                                        data-mdb-dismiss="modal">
                                                        {{ __('Annuler') }}
                                                    </button>

                                                    <button type="submit"
                                                        class="btn btn-primary">
                                                        {{ __('Sauvegarder') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- End Modal -->
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Aucun données pour le moment.</p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

<!-- Add Segment Modal -->
<form action="{{ route('segments.store') }}" method="POST">
    @csrf

    <div class="modal fade"
        id="addSegmentModal"
        tabindex="-1"
        aria-labelledby="addSegmentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSegmentModalLabel">
                        {{ __('Nouveau Plateau') }}
                    </h5>

                    <button type="button"
                        class="btn-close"
                        data-mdb-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="form-outline mb-3">
                        <input type="text"
                            name="name"
                            id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}">

                        <label for="name" class="form-label">
                            {{ __('Nom Plateau') }}
                        </label>

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-outline mb-3">
                        <textarea name="description"
                            id="description"
                            cols="30"
                            rows="3" class="form-control">{{ old('description') }}</textarea>

                        <label for="date" class="form-label">
                            {{ __('Description') }}
                        </label>

                        @error('date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button"
                        class="btn btn-secondary"
                        data-mdb-dismiss="modal">
                        {{ __('Annuler') }}
                    </button>

                    <button type="submit"
                        class="btn btn-primary">
                        {{ __('Sauvegarder') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
