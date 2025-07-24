@if ($isLogin)
    <div class="form-group">
        <label for="{{ $id ?? $name }}">
            {{ $label }}
            @if ($isRequired)
                <span class="text-danger">*</span>
            @endif
        </label>
        <div class="input-group mb-3">
            <input 
                type="{{ $type }}" 
                class="form-control @error($name) is-invalid @enderror"
                name="{{ $name }}" 
                id="{{ $id ?? $name }}" 
                value="{{ old($name, $value) }}"
                placeholder="{{ $placeholder }}"
            >
            @if ($icon)
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas {{ $icon }}"></span>
                    </div>
                </div>
            @endif
            @error($name)
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
@elseif ($isSearch)
    <div class="form-group mb-2 mr-2">
        <label for="{{ $id ?? $name }}" class="mr-2">{{ $label }}</label>
        <input 
            type="{{ $type }}" 
            class="form-control"
            name="{{ $name }}" 
            id="{{ $id ?? $name }}" 
            value="{{ old($name, $value) }}"
            placeholder="{{ $placeholder }}"
            @disabled($isDisabled)
        >
    </div>
@else
    <div class="form-group">
        <div class="row align-items-center mb-2">
            <label class="col-sm-3 col-form-label">
                {{ $label }}
                @if ($isRequired)
                    <span class="text-danger">*</span>
                @endif
            </label>
            <div class="col-sm-9">
                <input 
                    type="{{ $type }}" 
                    class="form-control @error($name) is-invalid @enderror"
                    name="{{ $name }}" 
                    id="{{ $id ?? $name }}" 
                    value="{{ old($name, $value) }}"
                    @disabled($isDisabled)
                >
                @error($name)
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
@endif