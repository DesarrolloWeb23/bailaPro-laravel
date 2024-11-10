<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ClaseUser;
use App\Models\User;
use App\Models\Clases;

class Inscriptions extends Component
{
    public $id;
    public $fecha_inscripcion;
    public $clase_id;
    public $user_id;
    public $inscriptions;
    public $inscriptionId;
    public $students;
    public $lessons;

    public function mount()
    {
        $this->students = User::role('Estudiante')->get();
        $this->lessons = Clases::with('teacher')->get();
        $this->inscriptions = ClaseUser::with('clase','user')->get();
    }

    public function delete($id)
    {
        try {
            ClaseUser::where('id',$id)->delete();
            return $this->redirect('/ncp/r',navigate:true); 
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function edit($id)
    {
        $inscription = ClaseUser::findOrFail($id);

        $this->inscriptionId = $inscription->id;
        $this->fecha_inscripcion = $inscription->fecha_inscripcion;
        $this->clase_id = $inscription->clase_id;
        $this->user_id = $inscription->user_id;
    }

    public function update()
    {
        try {
            $inscription = ClaseUser::findOrFail($this->inscriptionId);
            $inscription->update([
                'fecha_inscripcion' => $this->fecha_inscripcion,
                'clase_id' => $this->clase_id,
                'user_id' => $this->user_id
            ]);

            return $this->redirect('/ncp/r', navigate: true);
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function save()
    {
        // if (auth()->user()->rol_id == '1') {
        //     $this->user_id = auth()->user()->id;
        // } else if(auth()->user()->rol_id == '3') {
        //     $this->user_id = $this->user_id;
        // }
        
        try {
            ClaseUser::create([
                'clase_id' => $this->clase_id,
                'user_id' => $this->user_id,
                'inscription_date' => now()
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
