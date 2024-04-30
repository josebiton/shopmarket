<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonaModel extends Model
{
    protected $table = 'persona';
    protected $primaryKey = 'persona_id';
    protected $allowedFields = ['ruc_dni', 'nombres', 'apellidos', 'razon_social', 'representante_legal', 'nombre_comercial', 'telefono', 'estado'];

    

    
    public function getPersonas() {
        $this->select('persona.*');
        $this->where('persona.estado', 'A');
        $this->orderBy('persona.persona_id', 'DESC');
        return $this->findAll();
    }

    // Lista a todas las personas  y oculta razon_social, representante_legal,nombre_comercial
    public function getPersonasClientes()
    {
    $this->select('persona_id, ruc_dni, nombres, apellidos, telefono, estado');
    $this->where('estado', 'A');
    $this->orderBy('persona_id', 'DESC');
    return $this->findAll();
    }

   

}
