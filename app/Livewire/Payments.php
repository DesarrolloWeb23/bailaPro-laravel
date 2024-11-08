<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pay;
use App\Models\User;

class Payments extends Component
{
    public $id;
    public $name;
    public $description;
    public $date;
    public $amount;
    public $student_id;
    public $payments;
    public $paymentId;
    public $students;


    public function mount()
    {
        $this->payments = Pay::with('user')->get();
        $this->students = User::role('Estudiante')->get();
    }

    public function delete($id)
    {
        try {
            Pay::where('id',$id)->delete();
            return $this->redirect('/pym/r',navigate:true); 
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function edit($id)
    {
        $payment = Pay::findOrFail($id);

        $this->paymentId = $payment->id;
        $this->name = $payment->name;
        $this->fecha_pago = $payment->fecha_pago;
        $this->amount = $payment->amount;
        $this->student_id = $payment->user_id;
    }

    public function update()
    {
        try {
            $payment = Pay::findOrFail($this->paymentId);
            $payment->update([
                'name' => $this->name,
                'description' => $this->description,
                'fecha_pago' => $this->fecha_pago,
                'amount' => $this->amount,
                'user_id' => $this->student_id,
                'state_id' => 1
            ]);

            return $this->redirect('/pym/r', navigate: true);
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function save()
    {
        try {
            Pay::create([
                'name' => $this->name,
                'description' => $this->description,
                'date' => $this->date,
                'amount' => $this->amount,
                'user_id' => $this->student_id,
                'state_id' => 1
            ]);
            return $this->redirect('/pym/r',navigate:true); 
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function render()
    {
        return view('livewire.payments',[
            'payments' => $this->payments,
            'students' => $this->students
        ]);
    }
}
