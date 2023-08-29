<?php

namespace App\Http\Livewire;

use App\Models\Propuesta;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

use Livewire\Component;

class FormPropuestasEnviadas extends Component
{
    use WithPagination;

    public $perPage = '1';

    public $message = "";



    public function render()
    {
        $user = Auth::user();

        $propuestas = Propuesta::with('user') // Cargar la relación con el usuario creador

            ->where('user_id', $user->id)

            ->where('estado', 'enviada')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.form-propuestas-enviadas', [
            'propuestas' => $propuestas,
        ]);
    }


    public function eliminarPropuesta($id)
    {
        $propuesta = Propuesta::find($id);

        if ($propuesta) {
            $propuesta->delete();
            $this->message = "¡La propuesta ha sido eliminada!";
        }

        // Actualizar la lista de propuestas
        $this->render();
    }




}
