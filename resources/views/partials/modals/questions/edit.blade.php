<form action="{{ route('questions.update', $question) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="modal fade"
        id="editQuestionModal-{{ $question->id }}"
        tabindex="-1"
        aria-labelledby="editQuestionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editQuestionModalLabel">
                        {{ __('Modifier Question') }}
                    </h5>

                    <button type="button"
                        class="btn-close"
                        data-mdb-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="question">
                            {{ __('Question') }}
                        </label>

                        <textarea name="question"
                            id="question"
                            rows="4"
                            cold="10"
                            class="form-control @error('question') is-invalid @enderror">{{ old('question', $question->text) }}</textarea>

                        @error('question')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="points">
                            {{ __('Points') }}
                        </label>

                        <input type="number"
                            name="points"
                            id="points"
                            class="form-control @error('points') is-invalid @enderror"
                            value="{{ old('points', $question->points) }}">

                        @error('points')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <select name="type"
                            id="type"
                            class="form-select @error('type') is-invalid @enderror">
                            <option value="">{{ __('Type Question') }}</option>
                            <option value="single" {{ $question->type == 'single' ? 'selected' : '' }}>
                                {{ __('Réponse Unique') }}
                            </option>
                            <option value="multiple" {{ $question->type == 'multiple' ? 'selected' : '' }}>
                                {{ __('Réponse Multiple') }}
                            </option>
                        </select>

                        @error('type')
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
