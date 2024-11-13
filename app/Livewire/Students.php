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
    public $password;
    public $password_confirmation;
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

    //funcion para cambiar el estado del usuario a inactivo
    public function disable($id)
    {
        try {
            $student = User::findOrFail($id);
            $student->update([
                'state_id' => 2
            ]);

            $this->updateStudents(); 
            $this->reset(['name','email','date_of_birth','phone','state_id','rol_id']);
            session()->flash('message', 'Usuario inactivado correctamente.');
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function edit($id)
    {
        $student = User::findOrFail($id);
        $student_rol = $student->roles->first();

        $this->studentId = $student->id;
        $this->email = $student->email;
        $this->date_of_birth = $student->date_of_birth;
        $this->name = $student->name;
        $this->phone = $student->phone;
        $this->state_id = $student->state_id;
        $this->rol_id = $student_rol->name;
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

            $this->updateStudents(); 
            $this->reset(['name','email','date_of_birth','phone','state_id','rol_id']);
            session()->flash('message', 'Usuario actualizado correctamente.');
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
                'password' => bcrypt($this->password),
                'password_confirmation' => bcrypt($this->password_confirmation),
                'state_id' => $this->state_id,
                'role_id' => $this->rol_id,
                'name' => $this->name,
                'phone' => $this->phone
            ]);

            $user->assignRole($this->rol_id);

            AcademyUser::create([
                'academy_id'=> AcademyUser::where('user_id', $this->sessionUser)->first()->academy_id,
                'user_id'=> $user->id,
            ]);

            $this->updateStudents(); 
            $this->reset(['name','email','date_of_birth','phone','state_id','rol_id']);
            session()->flash('message', 'Usuario creado correctamente.');
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

    //funcion para actualizar el arreglo de estudiantes
    public function updateStudents()
    {
        $academyId = AcademyUser::where('user_id', $this->sessionUser)->first()->academy_id;

        $this->students = User::role('Estudiante')->whereHas('state', function ($query) {
            $query->where('id', '1'); // Filtra para el estado activo
        })
        ->whereHas('academyUsers.academy', function ($query) use ($academyId) {
            $query->where('id', $academyId); // Filtra por el ID de la academia específica
        })
        ->with('academyUsers.academy','state')
        ->get();
    }
}
