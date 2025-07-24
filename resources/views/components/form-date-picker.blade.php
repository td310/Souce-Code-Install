<div class="form-group">
    <div class="row align-items-center mb-2">
        <label class="col-sm-3 col-form-label">
            {{ $label }}
            @if ($isRequired)
                <span class="text-danger">*</span>
            @endif
        </label>
        <div class="col-sm-9">
            <div class="input-group date" id="{{ $name }}" data-target-input="nearest">
                <input 
                    type="text" 
                    class="form-control datetimepicker-input @error($name) is-invalid @enderror"
                    data-target="#{{ $name }}" 
                    name="{{ $name }}" 
                    value="{{ old($name, $value) }}"
                >
                <div class="input-group-append" data-target="#{{ $name }}" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                </div>
                @error($name)
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>