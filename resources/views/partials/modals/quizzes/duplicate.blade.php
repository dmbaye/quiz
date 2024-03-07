<form action="{{ route('quizzes.duplicate', $quiz) }}" method="POST">
    @csrf

    <div class="modal fade"
        id="duplicateQuizModal-{{ $quiz->id }}"
        tabindex="-1"
        aria-labelledby="duplicateQuizModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="duplicateQuizModalLabel">
                        {{ __('Dupliquer Quiz') }}
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
                                    {{ old('category', $category->id) == $category->id ? 'selected' : '' }}>
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
                        <label for="name">
                            {{ __('Nom Quiz') }}
                        </label>

                        <input type="text"
                            name="name"
                            id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $quiz->name) }}">

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="date">
                            {{ __('Date Quiz') }}
                        </label>

                        <input type="date"
                            name="date"
                            id="date"
                            class="form-control @error('date') is-invalid @enderror"
                            value="{{ old('date', $quiz->start_date->format('Y-m-d')) }}">

                        @error('date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="objective">
                            {{ __('Objectif Quiz') }}
                        </label>

                        <input type="number"
                            name="objective"
                            id="objective"
                            class="form-control @error('objective') is-invalid @enderror"
                            value="{{ old('objective', $quiz->objective) }}">

                        @error('objective')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="duration">
                            {{ __('Durée Quiz') }}
                        </label>

                        <input type="number"
                            name="duration"
                            id="duration"
                            class="form-control @error('duration') is-invalid @enderror"
                            value="{{ old('duration', $quiz->duration) }}">

                        @error('duration')
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
