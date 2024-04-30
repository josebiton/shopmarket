<?php

namespace App\Controllers;

use App\Models\CategoriaModel;


class Categoria extends BaseController
{


    public function index()
    {
        try {
            $categoriaModel = new CategoriaModel();
            $categorias = $categoriaModel->getCategorias();
           //return $this->response->setJSON(['Data' => $categorias]);
          return $this->response->setJSON($categorias);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error interno' . $e->getMessage()]);
        }
    }

    public function store()
{
    try {
        // Obtén los datos enviados por la solicitud POST
        $requestData = $this->request->getPost();

        // Valida los datos utilizando las reglas de validación definidas en el modelo
        $categoriaModel = new CategoriaModel();

        if (!$categoriaModel->validate($requestData)) {
            // Hubo errores de validación
            return $this->response->setJSON(['error' => $categoriaModel->errors()]);
        } 

        // Capturar la imagen de la categoría y guardarla en el directorio de imágenes
        $file = $this->request->getFile('imagen');

        if ($file->isValid() && !$file->hasMoved()) {
            $extension = 'png';  // Cambiar la extensión de la imagen si es necesario
            $newName = date('Ymd') . '-CT' . mt_rand(1000, 9999) . '.' . $extension;
            $file->move(ROOTPATH . 'public/imagenes/categorias', $newName);

            // Inserta los datos en la base de datos
            $categoriaData = [
                'nombre' => $requestData['nombre'],
                'imagen' => 'categorias/'.$newName,
                'estado' => 1, // Categoría activa por defecto
            ];

            if ($categoriaModel->insert($categoriaData)) {
                // Verifica si la inserción fue exitosa
                return $this->response->setJSON(['status' => 'success', 'message' => 'Categoría registrada con éxito']);
            } else {
                return $this->response->setJSON(['error' => 'No se pudo registrar la categoría.']);
            }
        } else {
            return $this->response->setJSON(['error' => 'La imagen no es válida o no se pudo guardar.']);
        }
    } catch (\Exception $e) {
        // Maneja errores internos
        return $this->response->setJSON(['status' => 'error', 'message' => 'Error interno: ' . $e->getMessage()]);
    }
}

}
