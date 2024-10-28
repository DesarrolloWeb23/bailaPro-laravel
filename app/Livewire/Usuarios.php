<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Roles;
use App\Actions\Fortify\CreateNewUser;

class Usuarios extends Component
{
    public $usuarios;
    public $roles;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $rol_id;

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

    public function save()
    {
        try {
            // Crear una instancia de CreateNewUser
            $creator = new CreateNewUser();

        
            $creator->create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
                'rol_id' => $this->rol_id
            ]);
            return $this->redirect('/usr/r',navigate:true); 
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
