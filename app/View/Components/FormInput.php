<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class FormInput extends Component
{
    /**
     * Create the component instance.
     */
    public function __construct(
        public string $label,
        public string $name,
        public string $type = 'text',
        public mixed $value = null,
        public bool $isRequired = false,
        public bool $isDisabled = false,
        public bool $isSearch = false,
        public bool $isLogin = false,
        public ?string $placeholder = null,
        public ?string $id = null,
        public ?string $icon = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.form-input');
    }
}