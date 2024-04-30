<?php 
namespace App\Models;

use CodeIgniter\Model;

class MarcaModel extends Model {
    protected $table      = 'marca';
    protected $primaryKey = 'marca_id';
    protected $allowedFields = [
        'nombre',
        'estado'
    ];

    

}