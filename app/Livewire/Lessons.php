<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Clases;
use App\Models\Profesores;

class Lessons extends Component
{
    public $id;
    public $capacidad;
    public $duracion;
    public $horario;
    public $nombre;
    public $profesor_id;
    public $lessons;
    public $lessonId;
    public $teachers;
    public $teacherId;

    public function mount()
    {
        $this->lessons = Clases::with('teacher')->get();
        $this->teachers = Profesores::all();
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
        $this->capacidad = $lesson->capacidad;
        $this->duracion = $lesson->duracion;
        $this->horario = $lesson->horario;
        $this->nombre = $lesson->nombre;
        $this->profesor_id = $lesson->profesor_id;
    }

    public function update()
    {
        try {
            $lesson = Clases::findOrFail($this->lessonId);
            $lesson->update([
                'capacidad' => $this->capacidad,
                'duracion' => $this->duracion,
                'horario' => $this->horario,
                'nombre' => $this->nombre,
                'profesor_id' => $this->profesor_id
            ]);

            return $this->redirect('/lsn/r', navigate: true);
        } catch (\Exception $th) {
            dd($th);
        }
    }
    
    public function save()
    {
        try {
            Clases::create([
                'capacidad' => $this->capacidad,
                'duracion' => $this->duracion,
                'horario' => $this->horario,
                'nombre' => $this->nombre,
                'profesor_id' => $this->profesor_id
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
