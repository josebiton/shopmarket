<?php

namespace App\Controllers;

use App\Models\MetodoEnvioEmpresaModel;

class MetodoEnvioEmpresa extends BaseController
{
    public function index()
    {
        try {
            $metodoModel = new MetodoEnvioEmpresaModel();
            $metodos = $metodoModel->getMetodosEnvios();
            return $this->response->setJSON($metodos);
    } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error interno' . $e->getMessage()]);
        }
    }

    public function store()
    {
        try {
            
            $requestData = $this->request->getPost();
            $metodoEnvioModel = new MetodoEnvioEmpresaModel();

            if (!$metodoEnvioModel->validate($requestData)) {
                return $this->response->setJSON(['error' => $metodoEnvioModel->errors()]);
            }

            $metodoEnvioEmpData = [
                'empresa_id' => 1,
                'metodo_envio_id' => $requestData['metodo_envio_id'],
                'precio' => $requestData['precio'],
                'estado' => 'A',
                
            ];
            
            $metodoEnvioModel->insert($metodoEnvioEmpData);

            if ($metodoEnvioModel ->affectedRows() > 0) {
                return $this->response->setJSON(['exito' => 'Metodo de envio agregado correctamente']);
            } else {
                return $this->response->setJSON(['error' => 'No se pudo agregar el metodo de envio']);
            }

        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error interno' . $e->getMessage()]);
        }
    }

    // fucion para actualizar el metodo de envio
    public function update()
    {
        try {
            $requestData = $this->request->getRawInput();
            $metodoEnvioModel = new MetodoEnvioEmpresaModel();

            if (!$metodoEnvioModel->validate($requestData)) {
                return $this->response->setJSON(['error' => $metodoEnvioModel->errors()]);
            }

            $metodoEnvioEmpData = [
                'empresa_id' => 1,
                'metodo_envio_id' => $requestData['metodo_envio_id'],
                'precio' => $requestData['precio'],
                'estado' => 'A',
                
            ];
            
            $metodoEnvioModel->update($requestData['id'], $metodoEnvioEmpData);

            if ($metodoEnvioModel ->affectedRows() > 0) {
                return $this->response->setJSON(['exito' => 'Metodo de envio actualizado correctamente']);
            } else {
                return $this->response->setJSON(['error' => 'No se pudo actualizar el metodo de envio']);
            }

        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error interno' . $e->getMessage()]);
        }
    }

    // funcion para eliminar el metodo de envio
    public function delete()
    {
        try {
            $requestData = $this->request->getRawInput();
            $metodoEnvioModel = new MetodoEnvioEmpresaModel();

            $metodoEnvioModel->delete($requestData['id']);

            if ($metodoEnvioModel ->affectedRows() > 0) {
                return $this->response->setJSON(['exito' => 'Metodo de envio eliminado correctamente']);
            } else {
                return $this->response->setJSON(['error' => 'No se pudo eliminar el metodo de envio']);
            }

        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error interno' . $e->getMessage()]);
        }
    }
}
