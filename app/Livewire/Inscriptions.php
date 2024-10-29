<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Inscripciones;
use App\Models\Estudiantes;
use App\Models\Clases;

class Inscriptions extends Component
{
    public $id;
    public $fecha_inscripcion;
    public $clase_id;
    public $estudiante_id;
    public $inscriptions;
    public $inscriptionId;
    public $students;
    public $lessons;

    public function mount()
    {
        $this->students = Estudiantes::all();
        $this->lessons = Clases::all();
        $this->inscriptions = Inscripciones::with('student', 'lesson')->get();
    }

    public function delete($id)
    {
        try {
            Inscripciones::where('id',$id)->delete();
            return $this->redirect('/ncp/r',navigate:true); 
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function edit($id)
    {
        $inscription = Inscripciones::findOrFail($id);

        $this->inscriptionId = $inscription->id;
        $this->fecha_inscripcion = $inscription->fecha_inscripcion;
        $this->clase_id = $inscription->clase_id;
        $this->estudiante_id = $inscription->estudiante_id;
    }

    public function update()
    {
        try {
            $inscription = Inscripciones::findOrFail($this->inscriptionId);
            $inscription->update([
                'fecha_inscripcion' => $this->fecha_inscripcion,
                'clase_id' => $this->clase_id,
                'estudiante_id' => $this->estudiante_id
            ]);

            return $this->redirect('/ncp/r', navigate: true);
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function save()
    {
        try {
            Inscripciones::create([
                'fecha_inscripcion' => now(),
                'clase_id' => $this->clase_id,
                'estudiante_id' => $this->estudiante_id
            ]);
            return $this->redirect('/ncp/r', navigate: true);
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function render()
    {
        return view('livewire.inscriptions');
    }
}
