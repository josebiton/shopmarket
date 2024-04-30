<?php

namespace App\Controllers;

use App\Models\MetodoPagoEmpresaModel;

class MetodoPagoEmpresa extends BaseController
{
    public function index()
    {
        try {
            $metodoModel = new MetodoPagoEmpresaModel();
            $metodos = $metodoModel->getMetodosNombresPorEntidad();

            return $this->response->setJSON($metodos);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error interno' . $e->getMessage()]);
        }

    }

    public function store()
    {
        try {
            
            $requestData = $this->request->getPost();
            $metodoPagoModel = new MetodoPagoEmpresaModel();

            if (!$metodoPagoModel->validate($requestData)) {
                return $this->response->setJSON(['error' => $metodoPagoModel->errors()]);
            }

            $metodoPagoEmpData = [
                'empresa_id' => 1,
                'metodo_pago_id' => $requestData['metodo_pago_id'],
                'estado' => 'A',
                
            ];


            $metodoPagoModel->insert($metodoPagoEmpData);
            if ($metodoPagoModel ->affectedRows() > 0) {
                return $this->response->setJSON(['exito' => 'Metodo de pago agregado correctamente']);
            } else {
                return $this->response->setJSON(['error' => 'No se pudo agregar el metodo de pago']);
            }
            
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error interno' . $e->getMessage()]);
        }

    }
}
