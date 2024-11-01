<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Roles;
use App\Models\Estados;
use App\Actions\Fortify\CreateNewUser;

#[lazy]
class Usuarios extends Component
{
    public $usuarios;
    public $roles;
    public $name;
    public $email;
    public $fecha_nacimiento;
    public $telefono;
    public $estado_id;
    public $especialidad_id;
    public $password;
    public $password_confirmation;
    public $rol_id;
    public $usuarioId;
    public $states;

    public function mount()
    {
        //traer la informacion del modelo y guardarla en la variable usuarios
        $this->usuarios = User::with('state','rol')->get();
        $this->roles = Roles::all();
        $this->states = Estados::all();
    }

    public function placeholder()
    {
        return view('livewire.placeholders.skeleton');
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
        $this->telefono = $usuario->telefono;
        $this->fecha_nacimiento = $usuario->fecha_nacimiento;
        $this->estado_id = $usuario->estado_id;
    }

    public function update()
    {
        try {
            $usuario = User::findOrFail($this->usuarioId);
            $usuario->update([
                'name' => $this->name,
                'email' => $this->email,
                'rol_id' => $this->rol_id,
                //'password' => bcrypt($this->password) // Opcional: solo si se desea actualizar la contraseña
                'telefono' => $this->telefono,
                'fecha_nacimiento' => $this->fecha_nacimiento,
                'estado_id' => $this->estado_id
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
                'fecha_nacimiento' => $this->fecha_nacimiento,
                'telefono' => $this->telefono,
                'estado_id' => $this->estado_id,
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
