<?php

namespace App\View\Components\Buttons;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PrimaryButton extends Component
{
    /**
     * The button type.
     *
     * @var string
     */
    public $type;

    /**
     * Create a new component instance.
     *
     * @param  string  $type
     * @return void
     */
    public function __construct($type = 'button')
    {
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.primary-button');
    }
}
