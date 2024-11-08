<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Dashboard extends Component
{
    public $roles;
    public $permissions;
    public $users;
    public $view = '';

    public $totalUsers;
    public $totalRoles;

    public function mount()
    {
        $this->users = User::with('state','roles')->get();
        $this->roles = Role::all();
        $this->permissions = Permission::all();
        
        $this->totalUsers = User::count();
        $this->totalRoles = Role::count();
    }

    public function placeholder()
    {
        return view('livewire.placeholders.skeleton');
    }

    public function changeView($view)
    {
        $this->view = $view;
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
