<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoModel extends Model
{
    protected $table = 'pedido';
    protected $primaryKey = 'pedido_id';
    protected $allowedFields = [
        'empresa_id', 'persona_id', 'users_id', 'metodo_pago_emp_id', 'metodo_envio_emp_id',
        'direciones_id', 'fecha_pedido', 'fecha_entrega', 'extras', 'comentarios',
        'total_pagar', 'igv', 'precio_envio', 'fecha_entregado', 'hora_entregado', 'estado'
    ];


    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    public function getPedidos()
    {
        $this->select('pedido.*, empresa.nombre as empresa, persona.nombre as cliente, metodo_pago.nombre as metodo_pago, metodo_envio.nombre as metodo_envio, direccion.direccion as direccion, direccion.referencia as referencia, direccion.distrito as distrito, direccion.provincia as provincia, direccion.departamento as departamento, direccion.pais as pais');
        $this->join('empresa', 'empresa.empresa_id = pedido.empresa_id');
        $this->join('persona', 'persona.persona_id = pedido.persona_id');
        $this->join('metodo_pago', 'metodo_pago.metodo_pago_id = pedido.metodo_pago_emp_id');
        $this->join('metodo_envio', 'metodo_envio.metodo_envio_id = pedido.metodo_envio_emp_id');
        $this->join('direccion', 'direccion.direcciones_id = pedido.direciones_id');
        $this->where('pedido.estado', 'A');
        $this->orderBy('pedido.pedido_id', 'DESC');
        return $this->findAll();
    }
    
}
