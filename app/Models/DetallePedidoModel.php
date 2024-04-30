<?php

namespace App\Models;

use CodeIgniter\Model;

class DetallePedidoModel extends Model
{
    protected $table = 'detalle_pedido';
    protected $primaryKey = 'detalle_id';
    protected $allowedFields = [
        'pedido_id', 'producto_detalle_id', 'nombre_producto',
        'cantidad', 'precio', 'igv', 'total', 'estado'
    ];


    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
