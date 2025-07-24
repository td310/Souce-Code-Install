<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class FormSelect extends Component
{
    /**
     * Create the component instance.
     */
    public function __construct(
        public string $label,
        public string $name,
        public mixed $value = null,
        public array $options = [],
        public bool $isSelect = false,
        public bool $isDisabled = false,
        public bool $isSearch = false,
        public ?string $placeholder = null,
        public ?string $id = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.form-select');
    }
}