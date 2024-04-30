<?php

namespace App\Controllers;

use App\Models\DetallePedidoModel;
use App\Models\PedidoModel;
use CodeIgniter\Database\Database;

class Pedido extends BaseController
{



    public function index()
    {
        try {
            $pedidoModel = new PedidoModel();
            $data = $pedidoModel->findAll();
            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error interno' . $e->getMessage()]);
        }
    }


 public function store()
{

    try {
        // Obtener el cuerpo de la solicitud
        $requestBody = $this->request->getBody();

        // Decodificar el cuerpo de la solicitud como JSON
        $requestData = json_decode($requestBody, true);

        // Verificar si se recibieron datos
        if (empty($requestData)) {
            return $this->response->setJSON(['error' => 'No se recibieron datos']);
        }

        // Verificar si se recibieron datos del pedido
        if (empty($requestData['datos_pedido'])) {
            return $this->response->setJSON(['error' => 'No se recibieron datos del pedido']);
        }

        // Verificar si se recibieron datos de los detalles del pedido
        if (empty($requestData['detalles_pedido'])) {
            return $this->response->setJSON(['error' => 'No se recibieron datos de los detalles del pedido']);
        }

        $detallesPedido = $requestData['detalles_pedido'];

        // Obtener datos del pedido
        $datosPedido = $requestData['datos_pedido'];

        // Verificar si se recibieron datos de los detalles del pedido
        if (empty($detallesPedido)) {
            return $this->response->setJSON(['error' => 'No se recibieron datos de los detalles del pedido']);
        }

        // Agregar campos por defecto a los datos del pedido
        $datosPedido['empresa_id'] = 1;
        $datosPedido['igv'] = 0;
        $datosPedido['estado'] = 1;

        // Verificar campos obligatorios en el pedido
        $camposObligatorios = ['persona_id', 'users_id', 'metodo_pago_emp_id', 'metodo_envio_emp_id', 'direciones_id', 'fecha_pedido', 'fecha_entrega', 'total_pagar', 'precio_envio'];

        foreach ($camposObligatorios as $campo) {
            if (!isset($datosPedido[$campo]) || empty($datosPedido[$campo])) {
                return $this->response->setJSON(['error' => "El campo $campo es obligatorio en los datos del pedido"]);
            }
        }

        // Aquí puedes agregar más validaciones específicas según tus requisitos

        // Insertar datos del pedido en la base de datos
        $pedidoModel = new PedidoModel();
        $pedidoModel->insert($datosPedido);

        // Obtener el ID del pedido recién insertado
        $pedido_id = $pedidoModel->getInsertID();

        // Insertar detalles del pedido en la base de datos
        $detallePedidoModel = new DetallePedidoModel();
        foreach ($detallesPedido as $detalle) {
            $detalle['pedido_id'] = $pedido_id;
            $detalle['igv'] = 0;
            $detalle['estado'] = 'A';
            $detallePedidoModel->insert($detalle);
        }

        // Aquí puedes agregar más lógica según tus requisitos

        return $this->response->setJSON(['exito' => 'Datos del pedido y detalles insertados correctamente']);
    } catch (\Exception $e) {
        return $this->response->setJSON(['error' => 'Error interno: ' . $e->getMessage()]);
    }
}
  
}
