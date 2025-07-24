<div class="form-group">
    <div class="row align-items-center mb-2">
        <label class="col-sm-3 col-form-label">{{ $label }}</label>
        <div class="col-sm-9 input-group">
            <div class="custom-file">
                <input type="file"
                       class="custom-file-input @error($name) is-invalid @enderror"
                       id="{{ $name }}"
                       name="{{ $name }}"
                >
                <label class="custom-file-label" for="{{ $name }}"> Chọn tệp đính kèm</label>
            </div>
            @error($name)
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    @if ($preview && $previewUrl)
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-9">
                <img src="{{ $previewUrl }}" style="max-width: 150px;" class="mt-2" />
            </div>
        </div>
    @endif
</div>