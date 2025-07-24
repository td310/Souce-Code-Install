<div class="form-group">
    <div class="row align-items-center mb-2">
        <label class="col-sm-3 col-form-label">
            {{ $label }}
            @if ($isRequired)
                <span class="text-danger">*</span>
            @endif
        </label>
        <div class="col-sm-9">
            <textarea 
                class="form-control @error($name) is-invalid @enderror" 
                name="{{ $name }}" 
                id="{{ $name }}"
            >
                {{ old($name, $value) }}
            </textarea>
            @error($name)
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>