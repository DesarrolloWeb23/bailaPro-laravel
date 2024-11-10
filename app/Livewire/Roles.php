<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Role;

class Roles extends Component
{
    public $id;
    public $name;
    public $guard_name;
    public $created_at;
    public $updated_at;
    public $roles;
    public $rolId;

    public function mount()
    {
        $this->roles = Role::all();
    }

    public function delete($id)
    {
        try {
            Role::where('id',$id)->delete();
            return $this->roles = Role::all();
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function save()
    {
        try {
            // Crear una instancia de CreateNewUser
            $creator = new Role();

        
            $creator->create([
                'name' => $this->name,
                'guard_name' => $this->guard_name,
                'created_at' => now(),
                'updated_at' => null
            ]);

            $this->roles = Role::all();
            $this->reset(['name', 'guard_name']);
            session()->flash('message', 'Rol creado correctamente.');

        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function render()
    {
        return view('livewire.roles');
    }
}
