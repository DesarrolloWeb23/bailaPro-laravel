<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class Students extends Component
{
    public $id;
    public $email;
    public $fecha_nacimiento;
    public $fecha_registro;
    public $name;
    public $telefono;
    public $students;
    public $studentId;

    public function mount()
    {
        $this->students = User::where('rol_id', 1)->get();
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
        $this->fecha_nacimiento = $student->fecha_nacimiento;
        $this->name = $student->name;
        $this->telefono = $student->telefono;
    }

    public function update()
    {
        try {
            $student = User::findOrFail($this->studentId);
            $student->update([
                'email' => $this->email,
                'fecha_nacimiento' => $this->fecha_nacimiento,
                'name' => $this->name,
                'telefono' => $this->telefono
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
                'fecha_nacimiento' => $this->fecha_nacimiento,
                'fecha_registro' => now(),
                'name' => $this->name,
                'telefono' => $this->telefono
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
