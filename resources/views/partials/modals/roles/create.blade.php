<form action="{{ route('roles.store') }}" method="POST">
    @csrf

    <div class="modal modal-lg fade"
        id="addRoleModal"
        tabindex="-1"
        aria-labelledby="addRoleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoleModalLabel">
                        {{ __('Ajouter Rôle') }}
                    </h5>

                    <button type="button"
                        class="btn-close"
                        data-mdb-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="role">
                            {{ __('Nom') }}
                        </label>

                        <input type="text"
                            name="role"
                            id="role"
                            value="{{ old('role') }}"
                            class="form-control @error('role') is-invalid @enderror">

                        @error('role')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description">
                            {{ __('Description') }}
                        </label>

                        <textarea name="description"
                            id="description"
                            rows="2"
                            cold="10"
                            class="form-control @error('points') is-invalid @enderror">{{ old('points') }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="permissions">
                            <input type="checkbox"
                                name="permissions[]"
                                id="permissions"
                                class="form-check">
                            {{ __('Permissions') }}
                        </label>
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
