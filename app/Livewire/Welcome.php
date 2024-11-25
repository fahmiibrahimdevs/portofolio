<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

class Welcome extends Component
{
    #[Title('Fahmi Ibrahim')]
    
    public function render()
    {
        return view('livewire.welcome')->extends('components.layouts.welcome');
    }
}
