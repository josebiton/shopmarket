<?php 
namespace App\Models;

use CodeIgniter\Model;

class ProductoImagenModel extends Model {
    protected $table      = 'producto_imagen';
    protected $primaryKey = 'producto_imagen_id';
    protected $allowedFields = [
        'producto_detalle_id',
        'descripcion',
        'ruta',
        'estado'
    ];

    

}