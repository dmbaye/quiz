<form action="{{ route('answers.update', [$question, $answer]) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="modal fade"
        id="editAnswerModal-{{ $answer->id }}"
        tabindex="-1"
        aria-labelledby="editAnswerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAnswerModalLabel">
                        {{ __('Modifier Réponse') }}
                    </h5>

                    <button type="button"
                        class="btn-close"
                        data-mdb-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="answer" class="form-label">
                            {{ __('Réponse') }}
                        </label>

                        <input type="text"
                            name="answer"
                            id="answer"
                            class="form-control @error('answer') is-invalid @enderror"
                            value="{{ old('answer', $answer->text) }}">

                        @error('answer')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-outline mb-3">
                        <label for="validity" class="form-label">
                            {{ __('Validité') }}
                        </label>

                        <select name="validity"
                            id="validity"
                            class="form-select @error('validity') is-invalid @enderror">
                            <option value="">{{ __('Validité') }}</option>
                            <option value="1" {{ old('validity', $answer->valid) == 1 ? 'selected' : '' }}>
                                {{ __('Vrai') }}
                            </option>
                            <option value="0" {{ old('validity', $answer->valid) == 0 ? 'selected' : '' }}>
                                {{ __('Faux') }}
                            </option>
                        </select>

                        @error('validity')
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
