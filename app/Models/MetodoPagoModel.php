<?php

namespace App\Models;

use CodeIgniter\Model;

class MetodoPagoModel extends Model
{
    protected $table = 'metodo_pago';
    protected $primaryKey = 'metodo_pago_id';
    protected $allowedFields = ['nombre', 'logo', 'estado'];

    // Puedes agregar más métodos según sea necesario
}
