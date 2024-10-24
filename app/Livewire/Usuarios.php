<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Roles;

class Usuarios extends Component
{
    public $usuarios;
    public $roles;

    public function mount()
    {
        //traer la informacion del modelo y guardarla en la variable usuarios
        $this->usuarios = User::all();
        $this->roles = Roles::all();
    }

    public function delete($id)
    {
        try {
            User::where('id',$id)->delete();
            return $this->redirect('usr',navigate:true); 
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function render()
    {
        //retornar la vista con los usuarios y roles
        return view('livewire.usuarios',[
            'usuarios' => $this->usuarios,
            'roles' => $this->roles
        ]);
    }
}
