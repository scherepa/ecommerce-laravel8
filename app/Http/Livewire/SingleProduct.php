<?php

namespace App\Http\Livewire;

use App\Models\MultiImg;
use Livewire\Component;

class SingleProduct extends Component
{
    public $prod;
    public $multi;
    public $color_en;
    public $color_heb;
    public $size_en;

    public function render()
    {
        return view('livewire.single-product');
    }
}
