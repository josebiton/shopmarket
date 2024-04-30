<?php

namespace App\Controllers;

use App\Models\DetallePedidoModel;

class DetallePedido extends BaseController
{
    public function index()
    {
       try {
            $detallePedidoModel = new DetallePedidoModel();
            $data = $detallePedidoModel->findAll();
            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error interno' . $e->getMessage()]);
       }

    }



    public function store()
    {

    }

}
