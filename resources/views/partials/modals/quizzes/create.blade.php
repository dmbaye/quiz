<form action="{{ route('quizzes.store') }}" method="POST">
    @csrf

    <div class="modal modal-lg fade"
        id="addQuizModal"
        tabindex="-1"
        aria-labelledby="addQuizModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addQuizModalLabel">
                        {{ __('Nouveau Quiz') }}
                    </h5>

                    <button type="button"
                        class="btn-close"
                        data-mdb-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <select name="category"
                            id="category"
                            class="form-select">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('category')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="name" class="mb-1">
                            {{ __('Nom Quiz') }}
                        </label>

                        <input type="text"
                            name="name"
                            id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}">

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="date" class="mb-1">
                                    {{ __('Date Quiz') }}
                                </label>

                                <input type="date"
                                    name="date"
                                    id="date"
                                    class="form-control @error('date') is-invalid @enderror"
                                    value="{{ old('date') }}">

                                @error('date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class="mb-3">
                                <label for="objective" class="mb-1">
                                    {{ __('Objectif Quiz') }}
                                </label>

                                <input type="number"
                                    name="objective"
                                    id="objective"
                                    class="form-control @error('objective') is-invalid @enderror"
                                    value="{{ old('objective') }}">

                                @error('objective')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class="mb-3">
                                <label for="duration" class="mb-1">
                                    {{ __('Durée Quiz (minutes)') }}
                                </label>

                                <input type="number"
                                    name="duration"
                                    id="duration"
                                    class="form-control @error('duration') is-invalid @enderror"
                                    value="{{ old('duration') }}">

                                @error('duration')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="mb-1">
                            {{ __('Description (optionnel)') }}
                        </label>

                        <textarea name="description"
                            id="description"
                            cols="30"
                            rows="3"
                            class="form-control"></textarea>

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
