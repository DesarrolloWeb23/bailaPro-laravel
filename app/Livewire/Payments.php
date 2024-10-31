<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pagos;
use App\Models\Estudiantes;

class Payments extends Component
{
    public $id;
    public $concepto;
    public $fecha_pago;
    public $monto;
    public $estudiante_id;
    public $payments;
    public $paymentId;
    public $students;


    public function mount()
    {
        $this->payments = Pagos::with('student')->get();
        $this->students = Estudiantes::all();
    }

    public function delete($id)
    {
        try {
            Pagos::where('id',$id)->delete();
            return $this->redirect('/pym/r',navigate:true); 
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function edit($id)
    {
        $payment = Pagos::findOrFail($id);

        $this->paymentId = $payment->id;
        $this->concepto = $payment->concepto;
        $this->fecha_pago = $payment->fecha_pago;
        $this->monto = $payment->monto;
        $this->estudiante_id = $payment->estudiante_id;
    }

    public function update()
    {
        try {
            $payment = Pagos::findOrFail($this->paymentId);
            $payment->update([
                'concepto' => $this->concepto,
                'fecha_pago' => $this->fecha_pago,
                'monto' => $this->monto,
                'estudiante_id' => $this->estudiante_id
            ]);

            return $this->redirect('/pym/r', navigate: true);
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function save()
    {
        try {
            Pagos::create([
                'concepto' => $this->concepto,
                'fecha_pago' => $this->fecha_pago,
                'monto' => $this->monto,
                'estudiante_id' => $this->estudiante_id
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
