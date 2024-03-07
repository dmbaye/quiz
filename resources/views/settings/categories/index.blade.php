@extends('layouts.dashboard')

@section('content')
<section>
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span>{{ __('Catégories') }}</span>

                <div class="mb-0">
                    <a href="#"
                        class="btn btn-sm btn-success"
                        data-mdb-toggle="modal"
                        data-mdb-target="#addCategoryModal">
                        {{ __('Ajouter Catégorie') }}
                    </a>
                </div>
            </div>

            <div class="card-body">
                @if ($categories->count())
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Nom Categorie') }}</th>
                                <th>{{ __('Quizzes') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $index => $category)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <a href="{{ route('categories.show', $category) }}">
                                            {{ $category->name }}
                                        </a>
                                    </td>
                                    <td>{{ $category->quizzes->count() }}</td>
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
                                                        data-mdb-target="#editCategoryModal-{{ $category->id }}">
                                                        {{ __('Modifier') }}
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="#"
                                                        class="dropdown-item"
                                                        onclick="event.preventDefault();
                                                        document.getElementById('delete-form-{{ $category->id }}').submit();">
                                                        {{ __('Supprimer') }}
                                                    </a>
                                                </li>
                                            </ul>

                                            <form id="delete-form-{{ $category->id }}"
                                                action="{{ route('categories.delete', $category) }}"
                                                method="POST"
                                                class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Edit Category Modal -->
                                <form action="{{ route('categories.update', $category) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal fade"
                                        id="editCategoryModal-{{ $category->id }}"
                                        tabindex="-1"
                                        aria-labelledby="editCategoryModalLabel"
                                        aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editCategoryModalLabel">
                                                        {{ __('Modifier Catégorie') }}
                                                    </h5>

                                                    <button type="button"
                                                        class="btn-close"
                                                        data-mdb-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="form-outline">
                                                        <input type="text"
                                                            name="name"
                                                            id="name"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            value="{{ old('name', $category->name) }}"
                                                            autofocus>

                                                        <label for="name" class="form-label">
                                                            {{ __('Nom Catégorie') }}
                                                        </label>

                                                        @error('name')
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

                    {{ $categories->links() }}
                @else
                    <p>{{ __('Vous n\'avez pas encore ajoute de catégories.') }}</p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

<!-- Add Category Modal -->
<form action="{{ route('categories.store') }}" method="POST">
    @csrf

    <div class="modal fade"
        id="addCategoryModal"
        tabindex="-1"
        aria-labelledby="addCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">
                        {{ __('Nouvelle Catégorie') }}
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
                            value="{{ old('name') }}"
                            autofocus>

                        <label for="name" class="form-label">
                            {{ __('Nom Catégorie') }}
                        </label>

                        @error('name')
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
