<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Lesson;
use App\Models\User;
use App\Models\AcademyUser;
use App\Models\TeacherLesson;

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
        $this->updateLessons();
        
        $this->teachers = User::whereHas('roles', function($q){
            $q->where('name', 'Profesor');
        })->get();
    }

    public function delete($id)
    {
        try {
            Lesson::where('id',$id)->delete();
            return $this->redirect('/lsn/r',navigate:true); 
        } catch (\Exception $th) {
            dd($th);
        }
    }

    //Funcion para inactivar las lessons
    public function disable($id)
    {
        try {
            $lesson = Lesson::findOrFail($id);
            $lesson->update([
                'state_id'=> 2
            ]);
            $this->updateLessons();
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function edit($id)
    {
        $lesson = Lesson::findOrFail($id);

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
            $lesson = Lesson::findOrFail($this->lessonId);
            $lesson->update([
                'name' => $this->name,
                'description'=> $this->description,
                'duration'=> $this->duration,
                'schedule'=> $this->schedule,
                'capacity'=> $this->capacity
            ]);

            TeacherLesson::where('lesson_id', $this->lessonId)->update([
                'user_id'=> $this->teacherId
            ]);

            $this->updateLessons();
            $this->reset(['name','description','duration','schedule','capacity','start_date','end_date','state_id','user_id']);
            session()->flash('message', 'Clase actualizada correctamente.');
        } catch (\Exception $th) {
            dd($th);
        }
    }
    
    public function save()
    {
        try {
            $academyUser = AcademyUser::where('user_id', auth()->user()->id)->first();
            $lesson = Lesson::create([
                'name'=> $this->name,
                'description'=> $this->description,
                'duration'=> $this->duration,
                'capacity'=> $this->capacity,
                'schedule'=> $this->schedule,
                'start_date'=> $this->start_date,
                'end_date'=> $this->end_date,
                'state_id'=> 1,  
                'academy_id'=> $academyUser->academy_id,
            ]);

            TeacherLesson::create([
                'lesson_id'=> $lesson->id,
                'user_id'=> $this->user_id,
            ]);

            $this->updateLessons();
            $this->reset(['name','description','duration','schedule','capacity','start_date','end_date','state_id','user_id']);
            session()->flash('message', 'Clase creada correctamente.');
        } catch (\Exception $th) {
            dd($th);
        }
    }

    //funcion para actualizar la lista de clases
    public function updateLessons()
    {
        $sessionUser = auth()->user()->id;

        if (User::find($sessionUser)->hasRole('Estudiante')) {
            //traer las clases del estudiante
            //$this->lessons = ClaseUser::with('user')->with('Estudiante')->get();
            $this->lessons = Lesson::inscriptionsByStudent($sessionUser);
        }
        if (User::find($sessionUser)->hasRole('Profesor')) {
            $this->lessons = ClaseUser::where('user_id', $sessionUser )->with('teachers')->get();
        }
        if (User::find($sessionUser)->hasRole('SuperAdmin')) {
            $this->lessons = Lesson::with('teachers','academy')->get(); //trae todas las clases
        }
        else if (User::find($sessionUser)->hasRole('Administrador')){
            //me consulta todas las lessons creeadas por la academia del usuario que inicio sesion, que se encuentren activas
            $this->lessons = Lesson::where('academy_id', AcademyUser::where('user_id', $sessionUser)->first()->academy_id)->with('teachers')
            ->where('state_id', 1)->get();
        } 
    }

    public function render()
    {
        return view('livewire.lessons');
    }
}
