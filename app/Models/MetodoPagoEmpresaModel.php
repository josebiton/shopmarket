<?php

namespace App\Models;

use CodeIgniter\Model;

class MetodoPagoEmpresaModel extends Model
{
    protected $table = 'metodo_pago_emp';
    protected $primaryKey = 'metodo_pago_emp_id';
    protected $allowedFields = ['empresa_id', 'metodo_pago_id', 'estado'];

    
    public function getMetodos()
    {
        $this->select('metodo_pago_emp_id, empresa_id, metodo_pago_id, estado');
        $this->where('estado', "A");
        $this->orderBy('metodo_pago_emp_id', 'DESC');
        $query = $this->get();
        return $query->getResultArray();
    }


    public function getMetodosNombresPorEntidad()
    {
        $this->select('metodo_pago_emp.metodo_pago_emp_id, metodo_pago_emp.empresa_id, metodo_pago.nombre as metodo_pago_nombre, metodo_pago.logo as metodo_pago_logo, metodo_pago_emp.estado');
        $this->join('metodo_pago', 'metodo_pago.metodo_pago_id = metodo_pago_emp.metodo_pago_id');
        $this->where('metodo_pago_emp.estado', 'A');
        $this->orderBy('metodo_pago_emp.metodo_pago_emp_id', 'DESC');
        $query = $this->get();
        return $query->getResultArray();
    }
    
   

    public function getMetodo($id)
    {
        $this->select('metodo_pago_emp_id, empresa_id, metodo_pago_id, estado');
        $this->where('metodo_pago_emp_id', $id);
        $this->where('estado', "A");
        $query = $this->get();
        return $query->getRowArray();
    }


}
