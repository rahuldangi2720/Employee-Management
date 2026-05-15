<?php



namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class messageBanner extends Component
{
    public $msg;
    public $pre;

    public function __construct($msg  , $pre)
    {
        $this->msg=$msg;
        $this->pre=$pre;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.message-banner');
    }
}
