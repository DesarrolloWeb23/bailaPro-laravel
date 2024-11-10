<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ClaseUser;
use App\Models\Clases;
use App\Models\User;

class Lessons extends Component
{
    public $id;
    public $name;
    public $description;
    public $duration;
    public $schedule;
    public $capacity;
    public $start_date;
    public $end_date;
    public $state_id;
    public $user_id;
    public $lessons;
    public $lessonId;
    public $teachers;
    public $teacherId;

    public function mount()
    {
        $sessionUser = auth()->user()->id;

        if (User::find($sessionUser)->hasRole('Estudiante')) {
            //traer las clases del estudiante
            //$this->lessons = ClaseUser::with('user')->with('Estudiante')->get();
            $this->lessons = Clases::inscriptionsByStudent($sessionUser);
        }
        if (User::find($sessionUser)->hasRole('Profesor')) {
            $this->lessons = ClaseUser::where('user_id', $sessionUser )->with('teacher')->get();
        }
        else if (User::find($sessionUser)->hasRole('Administrador|SuperAdmin')){
            //$this->lessons = Clases::inscriptionsByStudent($sessionUser);
            //$this->lessons = Clases::with('inscriptions')->get();

        } 
        
        $this->teachers = User::whereHas('roles', function($q){
            $q->where('name', 'Profesor');
        })->get();
    }

    public function delete($id)
    {
        try {
            ClaseUser::where('id',$id)->delete();
            return $this->redirect('/lsn/r',navigate:true); 
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function edit($id)
    {
        $lesson = ClaseUser::findOrFail($id);

        $this->lessonId = $lesson->id;
        $this->name = $lesson->name;
        $this->duration = $lesson->duration;
        $this->schedule = $lesson->schedule;
        $this->capacity = $lesson->capacity;
        $this->user_id = $lesson->user_id;
    }

    public function update()
    {
        try {
            $lesson = ClaseUser::findOrFail($this->lessonId);
            $lesson->update([
                'name' => $this->name,
                'description'=> $this->description,
                'duration' => $this->duration,
                'schedule' => $this->schedule,
                'capacity'=> $this->capacity,
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
                'name'=> $this->name,
                'description'=> $this->description,
                'duration'=> $this->duration,
                'capacity'=> $this->capacity,
                'schedule'=> $this->schedule,
                'start_date'=> $this->start_date,
                'end_date'=> $this->end_date,
                'state_id'=> 1
            ]);
            return $this->redirect('/lsn/r',navigate:true); 
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function render()
    {
        return view('livewire.lessons');
    }
}
