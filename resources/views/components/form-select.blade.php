@if ($isSearch)
    <div class="form-group mb-2 mr-2">
        <label for="{{ $name }}" class="mr-2">{{ $label }}</label>
        <select 
            class="form-control"
            name="{{ $name }}" 
            id="{{ $id }}"
            @disabled($isDisabled)
        >
            <option value="" @selected($isSelect && !old($name, $value))>{{ $placeholder ?? 'Tất cả' }}</option>
            @foreach($options as $option)
                <option value="{{ $option->value }}" @selected(old($name, $value) === $option->value)>
                    {{ $option->label() }}
                </option>
            @endforeach
        </select>
    </div>
@else
    <div class="form-group">
        <div class="row align-items-center mb-2">
            <label class="col-sm-3 col-form-label">{{ $label }}</label>
            <div class="col-sm-9">
                <select 
                    class="form-control @error($name) is-invalid @enderror" 
                    name="{{ $name }}" @disabled($isDisabled)
                >
                    <option value="" @disabled(true) @selected($isSelect && !old($name))>{{ $placeholder ?? 'Chọn trạng thái' }}</option>
                    @foreach($options as $option)
                        <option value="{{ $option->value }}" @selected(old($name, $value) === $option->value)>
                            {{ $option->label() }}
                        </option>
                    @endforeach
                </select>
                @error($name)
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
@endif