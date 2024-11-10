<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Roles;
use App\Models\State;
use App\Actions\Fortify\CreateNewUser;

class Usuarios extends Component
{
    public $users;
    public $roles;
    public $name;
    public $email;
    public $date_of_birth;
    public $phone;
    public $state_id;
    public $especialidad_id;
    public $password;
    public $password_confirmation;
    public $rol_id;
    public $usuarioId;
    public $states;

    public function mount()
    {
        //traer la informacion del modelo y guardarla en la variable usuarios
        $this->users = User::with('state','roles')->get();
        $this->roles = Roles::all();
        $this->states = State::all();
    }

    public function register()
    {
        return view('auth.register', ['roles' => Roles::all(),]);
    }

    public function delete($id)
    {
        try {
            User::where('id',$id)->delete();
            return $this->redirect('/usr/r',navigate:true); 
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);

        $this->usuarioId = $usuario->id;
        $this->name = $usuario->name;
        $this->email = $usuario->email;
        $this->rol_id = $usuario->rol_id;
        $this->phone = $usuario->phone;
        $this->date_of_birth = $usuario->date_of_birth;
        $this->state_id = $usuario->state_id;
    }

    public function update()
    {
        try {
            $usuario = User::findOrFail($this->usuarioId);
            $usuario->update([
                'name' => $this->name,
                'email' => $this->email,
                'rol_id' => $this->rol_id,
                'password' => bcrypt($this->password),
                'phone' => $this->phone,
                'date_of_birth' => $this->date_of_birth,
                'state_id' => $this->state_id
            ]);

            return $this->redirect('/usr/r', navigate: true);
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
                'date_of_birth' => $this->date_of_birth,
                'phone' => $this->phone,
                'state_id' => $this->state_id,
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
        return view('livewire.usuarios');
    }
}
