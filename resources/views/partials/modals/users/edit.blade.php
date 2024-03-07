<form action="{{ route('users.update', $user) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="modal fade"
        id="editUserModal-{{ $user->id }}"
        tabindex="-1"
        aria-labelledby="editUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">
                        {{ __('Modifier Utilisateur') }}
                    </h5>

                    <button type="button"
                        class="btn-close"
                        data-mdb-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="segment" class="form-label">
                            {{ __('Plateau') }}
                        </label>

                        <select name="segment"
                            id="segment"
                            class="form-select @error('segment') is-invalid @enderror">
                            <option value="">{{ __('Plateau') }}</option>

                            @foreach ($segments as $segment)
                                <option value="{{ $segment->id }}"
                                    {{ old('segment', $segment->id) == $segment->id ? 'selected' : '' }}>
                                    {{ $segment->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('segment')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">
                            {{ __('Prénom et nom') }}
                        </label>

                        <input type="text"
                            name="name"
                            id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $user->name) }}">

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            {{ __('Email') }}
                        </label>

                        <input type="email"
                            name="email"
                            id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $user->email) }}">

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">
                            {{ __('Login') }}
                        </label>

                        <input type="text"
                            name="username"
                            id="username"
                            class="form-control @error('username') is-invalid @enderror"
                            value="{{ old('username', $user->username) }}">

                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-outline mb-3">
                        <label for="role" class="form-label">
                            {{ __('Rôle') }}
                        </label>

                        <select name="role"
                            id="role"
                            class="form-select">
                            <option value="">{{ __('Rôle') }}</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}"
                                    {{ old('role', $user->roles[0]->name) === $role->name ? 'selected' : '' }}>
                                    {{ $role->display_name }}
                                </option>
                            @endforeach
                        </select>

                        @error('role')
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
