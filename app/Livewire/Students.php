<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\AcademyUser;
use App\Models\State;
use App\Models\Role;

class Students extends Component
{
    public $id;
    public $email;
    public $date_of_birth;
    public $fecha_registro;
    public $name;
    public $phone;
    public $students;
    public $studentId;
    public $state_id;
    public $rol_id;
    public $states;
    public $roles;
    public $sessionUser;

    public function mount()
    {
        $this->sessionUser = auth()->user()->id;
        $academyId = AcademyUser::where('user_id', $this->sessionUser)->first()->academy_id;

        //realiza la consulta de los estudiantes de la academia del usuario que inicio sesion
        $this->students = User::role('Estudiante')->whereHas('state', function ($query) {
            $query->where('id', '1'); // Filtra para el estado activo
        })
        ->whereHas('academyUsers.academy', function ($query) use ($academyId) {
            $query->where('id', $academyId); // Filtra por el ID de la academia específica
        })
        ->with('academyUsers.academy','state')
        ->get();

        $this->states = State::all();
        $this->roles = Role::where('name', 'Estudiante')->get();
    }

    public function delete($id)
    {
        try {
            User::where('id',$id)->delete();
            return $this->redirect('/std/r',navigate:true); 
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function edit($id)
    {
        $student = User::findOrFail($id);

        $this->studentId = $student->id;
        $this->email = $student->email;
        $this->date_of_birth = $student->date_of_birth;
        $this->name = $student->name;
        $this->phone = $student->phone;
        $this->state_id = $student->state_id;
    }

    public function update()
    {
        try {
            $student = User::findOrFail($this->studentId);
            $student->update([
                'email' => $this->email,
                'date_of_birth' => $this->date_of_birth,
                'name' => $this->name,
                'phone' => $this->phone
            ]);

            return $this->redirect('/std/r', navigate: true);
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function save()
    {
        try {
            $user = User::create([
                'email' => $this->email,
                'date_of_birth' => $this->date_of_birth,
                'created_at' => now(),
                'password' => bcrypt('password'),
                'password_confirmation' => bcrypt('password'),
                'state_id' => $this->state_id,
                'role_id' => $this->rol_id,
                'name' => $this->name,
                'phone' => $this->phone
            ]);

            $user->assignRole($this->rol_id);

            AcademyUser::create([
                'academy_id'=> AcademyUser::where('user_id', $this->sessionUser)->first()->academy_id,
                'user_id'=> User::latest()->first()->id,
            ]);

            return $this->redirect('/std/r',navigate:true); 
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function render()
    {
        return view('livewire.students',[
            'teachers' => $this->students
        ]);
    }
}
