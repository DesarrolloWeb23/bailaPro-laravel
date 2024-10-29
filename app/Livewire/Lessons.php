<?php

namespace App\Livewire;

use Livewire\Component;

class Lessons extends Component
{
    public $id;
    public $capacidad;
    public $duracion;
    public $nombre;
    public $profesor_id;
    public $lessons;

    public function mount()
    {
        $this->lessons = Clases::all();
    }

    public function delete($id)
    {
        try {
            Clases::where('id',$id)->delete();
            return $this->redirect('/lsn/r',navigate:true); 
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function edit($id)
    {
        $lesson = Clases::findOrFail($id);

        $this->lessonId = $lesson->id;
        $this->email = $lesson->email;
        $this->especialidad = $lesson->especialidad;
        $this->fecha_contratacion = $lesson->fecha_contratacion;
        $this->nombre = $lesson->nombre;
        $this->telefono = $lesson->telefono;
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
            Clases::create([
                'concepto' => $this->concepto,
                'fecha_pago' => $this->fecha_pago,
                'monto' => $this->monto,
                'estudiante_id' => $this->estudiante_id
            ]);
            return $this->redirect('/lsn/r',navigate:true); 
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function render()
    {
        return view('livewire.lessons',[
            'lessons' => $this->lessons
        ]);
    }
}
