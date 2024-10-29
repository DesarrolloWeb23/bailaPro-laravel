<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class Teacher extends Component
{
    public $id;
    public $email;
    public $especialidad;
    public $fecha_contratacion;
    public $name;
    public $telefono;
    public $teachers;
    public $teacherId;

    public function mount()
    {
        //traer la informacion del modelo y guardarla en la variable usuarios
        $this->teachers = User::where('rol_id', 2)->get();
    }

    public function delete($id)
    {
        try {
            Profesores::where('id',$id)->delete();
            return $this->redirect('/tch/r',navigate:true); 
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function edit($id)
    {
        $teacher = User::findOrFail($id);

        $this->teacherId = $teacher->id;
        $this->email = $teacher->email;
        $this->especialidad = $teacher->especialidad;
        $this->fecha_contratacion = $teacher->fecha_contratacion;
        $this->name = $teacher->name;
        $this->telefono = $teacher->telefono;
    }

    public function update()
    {
        try {
            $teacher = User::findOrFail($this->teacherId);
            $teacher->update([
                'email' => $this->email,
                'especialidad' => $this->especialidad,
                'fecha_contratacion' => $this->fecha_contratacion,
                'name' => $this->name,
                'telefono' => $this->telefono
            ]);

            return $this->redirect('/tch/r', navigate: true);
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function save()
    {
        try {
            Profesores::create([
                'email' => $this->email,
                'especialidad' => $this->especialidad,
                'fecha_contratacion' => $this->fecha_contratacion,
                'name' => $this->name,
                'telefono' => $this->telefono,
                'created_at' => now(),
                'updated_at' => null
            ]);
            return $this->redirect('/tch/r',navigate:true); 
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function render()
    {
        return view('livewire.teacher',[
            'teachers' => $this->teachers
        ]);
    }
}
