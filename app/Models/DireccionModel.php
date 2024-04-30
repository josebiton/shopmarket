<?php

namespace App\Models;

use CodeIgniter\Model;

class DireccionModel extends Model {
    protected $table      = 'direciones';
    protected $primaryKey = 'direciones_id';
    protected $allowedFields = [
        'persona_id',
        'direccion',
        'lat',
        'lgn',
        'referencia',
        'estado'
    ];

    public function getDirecciones($persona_id){
        $this->select('direciones_id, direccion, lat, lgn, referencia, estado');
        $this->where('persona_id', $persona_id);
        $this->where('estado', 'A');
        $this->orderBy('direciones_id', 'DESC');
        $query = $this->get();
        return $query->getResultArray();
    }
   
}