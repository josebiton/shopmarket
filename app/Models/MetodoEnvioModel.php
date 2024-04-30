<?php

namespace App\Models;

use CodeIgniter\Model;

class MetodoEnvioModel extends Model
{
    protected $table = 'metodo_envio';
    protected $primaryKey = 'metodo_envio_id';
    protected $allowedFields = ['nombre', 'descripcion', 'estado'];

    // Puedes agregar más métodos según sea necesario
}
