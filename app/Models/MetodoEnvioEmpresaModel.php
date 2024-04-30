<?php

namespace App\Models;

use CodeIgniter\Model;

class MetodoEnvioEmpresaModel extends Model
{
    protected $table = 'metodo_envio_emp';
    protected $primaryKey = 'metodo_envio_emp_id';
    protected $allowedFields = ['metodo_envio_id', 'empresa_id', 'precio', 'estado'];

    
    public function getMetodos()
    {
        $this->select('metodo_envio_emp_id, metodo_envio_id, empresa_id, precio, estado');
        $this->where('estado', "A");
        $this->orderBy('metodo_envio_emp_id', 'DESC');
        $query = $this->get();
        return $query->getResultArray();
    }

   

     public function getMetodosEnvios()
{
    $this->select('metodo_envio_emp.metodo_envio_emp_id, metodo_envio_emp.metodo_envio_id, metodo_envio.nombre as metodo_envio_nombre, metodo_envio.descripcion as metodo_envio_descripcion, metodo_envio_emp.precio, metodo_envio_emp.estado');
    $this->join('metodo_envio', 'metodo_envio.metodo_envio_id = metodo_envio_emp.metodo_envio_id');
    $this->where('metodo_envio_emp.estado', 'A');
    $this->orderBy('metodo_envio_emp.metodo_envio_emp_id', 'DESC');
    $query = $this->get();
    return $query->getResultArray();
}


//     public function getMetodosEnvios()
// {
//     $this->select('metodo_envio_emp.metodo_envio_emp_id, metodo_envio_emp.metodo_envio_id, metodo_envio.nombre as metodo_envio_nombre, metodo_envio_emp.precio, metodo_envio_emp.estado');
//     $this->join('metodo_envio', 'metodo_envio.metodo_envio_id = metodo_envio_emp.metodo_envio_id');
//     $this->where('metodo_envio_emp.estado', 'A');
//     $this->orderBy('metodo_envio_emp.metodo_envio_emp_id', 'DESC');
//     $query = $this->get();
//     return $query->getResultArray();
// }

}
