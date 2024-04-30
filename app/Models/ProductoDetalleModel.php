<?php 
namespace App\Models;

use CodeIgniter\Model;

class ProductoDetalleModel extends Model {
    protected $table      = 'producto_detalle';
    protected $primaryKey = 'producto_detalle_id';
    protected $allowedFields = [
        'slug',
        'producto_id',
        'empresa_id',
        'categoria_id',
        'unidad_id',
        'precio',
        'stock',
        'estado'
    ];

    // Mostrar el producto con su detalle
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

    public function getProductosConDetalle(){
        $this->select('producto.producto_id, producto.nombre as producto_nombre, producto.descripcion, marca.nombre as marca_nombre, producto_detalle.slug, empresa.nombre_comercial as empresa_nombre, categoria.nombre as categoria_nombre, unidad.nombre as unidad_nombre, producto_detalle.precio, producto_detalle.stock');
        $this->join('producto', 'producto.producto_id = producto_detalle.producto_id');
        $this->join('marca', 'marca.marca_id = producto.marca_id');
        $this->join('empresa', 'empresa.empresa_id = producto_detalle.empresa_id');
        $this->join('categoria', 'categoria.categoria_id = producto_detalle.categoria_id');
        $this->join('unidad', 'unidad.unidad_id = producto_detalle.unidad_id');
        $this->join('producto_imagen', 'producto_imagen.producto_detalle_id = producto_detalle.producto_detalle_id', 'left');
        $this->where('producto.estado', 'A');
        $this->orderBy('producto.producto_id', 'DESC');
        $this->groupBy('producto.producto_id'); // Agrupa por ID de producto para evitar duplicados
        $this->select('GROUP_CONCAT(producto_imagen.ruta) as imagenes', false); // Agrupa las rutas de imágenes en una cadena
        $query = $this->get();
        return $query->getResultArray();
    }
    

    //Lista productos por categoria
    public function getProductosPorCategoria($categoria_id){
        $this->select('producto.producto_id, producto.nombre as producto_nombre, producto.descripcion, marca.nombre as marca_nombre, producto_detalle.slug, empresa.nombre_comercial as empresa_nombre, categoria.nombre as categoria_nombre, unidad.nombre as unidad_nombre, producto_detalle.precio, producto_detalle.stock');
        $this->join('producto', 'producto.producto_id = producto_detalle.producto_id');
        $this->join('marca', 'marca.marca_id = producto.marca_id');
        $this->join('empresa', 'empresa.empresa_id = producto_detalle.empresa_id');
        $this->join('categoria', 'categoria.categoria_id = producto_detalle.categoria_id');
        $this->join('unidad', 'unidad.unidad_id = producto_detalle.unidad_id');
        $this->join('producto_imagen', 'producto_imagen.producto_detalle_id = producto_detalle.producto_detalle_id', 'left');
        $this->where('producto.estado', 'A');
        $this->where('producto_detalle.categoria_id', $categoria_id);
        $this->orderBy('producto.producto_id', 'DESC');
        $this->groupBy('producto.producto_id'); // Agrupa por ID de producto para evitar duplicados
        $this->select('GROUP_CONCAT(producto_imagen.ruta) as imagenes', false); // Agrupa las rutas de imágenes en una cadena
        $query = $this->get();
        return $query->getResultArray();
    }
    
    
    //Lista productos por id de producto y sus detalles
    public function getProductosPorId($id){
        $this->select('producto.producto_id, producto.nombre as producto_nombre, producto.descripcion, marca.nombre as marca_nombre, producto_detalle.slug, empresa.nombre_comercial as empresa_nombre, categoria.nombre as categoria_nombre, unidad.nombre as unidad_nombre, producto_detalle.precio, producto_detalle.stock');
        $this->join('producto', 'producto.producto_id = producto_detalle.producto_id');
        $this->join('marca', 'marca.marca_id = producto.marca_id');
        $this->join('empresa', 'empresa.empresa_id = producto_detalle.empresa_id');
        $this->join('categoria', 'categoria.categoria_id = producto_detalle.categoria_id');
        $this->join('unidad', 'unidad.unidad_id = producto_detalle.unidad_id');
        $this->join('producto_imagen', 'producto_imagen.producto_detalle_id = producto_detalle.producto_detalle_id', 'left');
        $this->where('producto.estado', 'A');
        $this->where('producto.producto_id', $id);
        $this->orderBy('producto.producto_id', 'DESC');
        $this->groupBy('producto.producto_id'); // Agrupa por ID de producto para evitar duplicados
        $this->select('GROUP_CONCAT(producto_imagen.ruta) as imagenes', false); // Agrupa las rutas de imágenes en una cadena
        $query = $this->get();
        return $query->getResultArray();
    }
    
    
}