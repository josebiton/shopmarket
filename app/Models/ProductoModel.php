<?php 
namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model{
    protected $table      = 'producto';
    
    protected $primaryKey = 'producto_id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'nombre',
        'descripcion',
        'marca_id',
        'estado'
    ];

    public function getProductos(){
        $this->select('producto.*, marca.nombre as marca_nombre');
        $this->join('marca', 'marca.marca_id = producto.marca_id', 'left');
        $this->where('producto.estado', 'A');
        $this->orderBy('producto.producto_id', 'DESC');
        $query = $this->get();
        return $query->getResultArray();
    }

    // public function getProductosConDetalle(){
    //     $this->select('producto.nombre as producto_nombre, producto.descripcion, marca.nombre as marca_nombre, producto_detalle.slug, empresa.nombre_comercial as empresa_nombre, categoria.nombre as categoria_nombre, unidad.nombre as unidad_nombre, producto_detalle.precio, producto_detalle.stock');
    //     $this->join('producto', 'producto.producto_id = producto_detalle.producto_id');
    //     $this->join('marca', 'marca.marca_id = producto.marca_id');
    //     $this->join('empresa', 'empresa.empresa_id = producto_detalle.empresa_id');
    //     $this->join('categoria', 'categoria.categoria_id = producto_detalle.categoria_id');
    //     $this->join('unidad', 'unidad.unidad_id = producto_detalle.unidad_id');
    //     $this->where('producto.estado', 'A');
    //     $this->orderBy('producto.producto_id', 'DESC');
    //     $query = $this->get();
    //     return $query->getResultArray();
    // }

    public function getProducto($producto_id){
        $this->select('producto.*, marca.nombre as marca_nombre');
        $this->join('marca', 'marca.marca_id = producto.marca_id', 'left');
        $this->where('producto.estado', 'A');
        $this->where('producto.producto_id', $producto_id);
        $query = $this->get();
        return $query->getRowArray();
    }
    
    
}