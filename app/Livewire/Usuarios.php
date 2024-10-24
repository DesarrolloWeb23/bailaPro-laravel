<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class Usuarios extends Component
{
    public $usuarios;

    public function mount()
    {
        //traer la informacion del modelo y guardarla en la variable usuarios
        $this->usuarios = User::all();
    }

    public function render()
    {
        $usuarios = $this->usuarios;
        return view('livewire.usuarios', compact('usuarios'));
    }
}
