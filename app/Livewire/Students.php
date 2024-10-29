<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Estudiantes;

class Students extends Component
{
    public $id;
    public $email;
    public $fecha_nacimiento;
    public $fecha_registro;
    public $nombre;
    public $telefono;
    public $students;
    public $studentId;

    public function mount()
    {
        $this->students = Estudiantes::all();
    }

    public function delete($id)
    {
        try {
            Estudiantes::where('id',$id)->delete();
            return $this->redirect('/std/r',navigate:true); 
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function edit($id)
    {
        $student = Estudiantes::findOrFail($id);

        $this->studentId = $student->id;
        $this->email = $student->email;
        $this->fecha_nacimiento = $student->fecha_nacimiento;
        $this->nombre = $student->nombre;
        $this->telefono = $student->telefono;
    }

    public function update()
    {
        try {
            $student = Estudiantes::findOrFail($this->studentId);
            $student->update([
                'email' => $this->email,
                'fecha_nacimiento' => $this->fecha_nacimiento,
                'nombre' => $this->nombre,
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
            Estudiantes::create([
                'email' => $this->email,
                'fecha_nacimiento' => $this->fecha_nacimiento,
                'fecha_registro' => now(),
                'nombre' => $this->nombre,
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
