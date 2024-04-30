<?php 
namespace App\Models;

use CodeIgniter\Model;

class CategoriaModel extends Model {
    protected $table      = 'categoria';
    protected $primaryKey = 'categoria_id';
    protected $allowedFields = [
        'nombre',
        'imagen',
        'estado'
    ];

    protected $validationRules    = [
        'nombre'     => 'required|min_length[3]|max_length[100]',
        'imagen'     => 'required|',
        'estado'     => 'required|numeric',
    ];

    public function getCategorias(){
        $this->select('*');
        $this->where('estado', 1);
        $this->orderBy('categoria_id', 'DESC');
        $query = $this->get();
        return $query->getResultArray();
    }




}