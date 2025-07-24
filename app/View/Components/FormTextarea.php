<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class FormTextarea extends Component
{
    /**
     * Create the component instance.
     */
    public function __construct(
        public string $label,
        public string $name,
        public mixed $value = null,
        public bool $isRequired = false
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.form-textarea');
    }
}