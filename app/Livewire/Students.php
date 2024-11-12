<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

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

    public function mount()
    {
        $this->students = User::role('Estudiante')->get();
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
            User::create([
                'email' => $this->email,
                'date_of_birth' => $this->date_of_birth,
                'created_at' => now(),
                'password' => bcrypt('password'),
                'password_confirmation' => bcrypt('password'),
                'state_id' => 1,
                'role_id' => 4,
                'name' => $this->name,
                'phone' => $this->phone
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
