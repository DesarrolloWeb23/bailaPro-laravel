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
    public $fecha_nacimiento;
    public $telefono;
    public $estado_id;
    public $especialidad_id;
    public $password;
    public $password_confirmation;
    public $rol_id;
    public $usuarioId;

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

        // Emitir el evento para notificar que la edición ha sido completada
        //$this->dispatch('editCompleted'); //se deshabilita ya que no se esta utilizando quitar el modal
    }

    public function update()
    {
        try {
            $usuario = User::findOrFail($this->usuarioId);
            $usuario->update([
                'name' => $this->name,
                'email' => $this->email,
                'rol_id' => $this->rol_id,
                'password' => bcrypt($this->password) // Opcional: solo si se desea actualizar la contraseña
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
                'estado_id' => 1,
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
