<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Profesores;

class Teacher extends Component
{
    public $id;
    public $email;
    public $especialidad;
    public $fecha_contratacion;
    public $nombre;
    public $telefono;
    public $teachers;
    public $teacherId;

    public function mount()
    {
        //traer la informacion del modelo y guardarla en la variable usuarios
        $this->teachers = Profesores::all();
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
        $teacher = Profesores::findOrFail($id);

        $this->teacherId = $teacher->id;
        $this->email = $teacher->email;
        $this->especialidad = $teacher->especialidad;
        $this->fecha_contratacion = $teacher->fecha_contratacion;
        $this->nombre = $teacher->nombre;
        $this->telefono = $teacher->telefono;
    }

    public function update()
    {
        try {
            $teacher = Profesores::findOrFail($this->teacherId);
            $teacher->update([
                'email' => $this->email,
                'especialidad' => $this->especialidad,
                'fecha_contratacion' => $this->fecha_contratacion,
                'nombre' => $this->nombre,
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
                'nombre' => $this->nombre,
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
        return view('livewire.profesores',[
            'teachers' => $this->teachers
        ]);
    }
}
