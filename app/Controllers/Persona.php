<?php

namespace App\Controllers;

use App\Models\DireccionModel;
use App\Models\PersonaModel;
use App\Models\UserModel;

class Persona extends BaseController
{
    public function index()
    {
        try {
            $personaModel = new PersonaModel();
            $data = $personaModel->getPersonas();
            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error interno: ' . $e->getMessage()]);
        }
    }

    public function clientesPersona()
    {
        try {
            $personaModel = new PersonaModel();
            $data = $personaModel->getPersonasClientes();
            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error interno: ' . $e->getMessage()]);
        }
    }


    public function getPersona($id)
    {
        try {
            $personaModel = new PersonaModel();
            $direccionModel = new DireccionModel(); // Asumo que tienes un modelo para las direcciones

            // Obtén la información de la persona
            $persona = $personaModel->select('persona_id, ruc_dni, nombres, apellidos, telefono, estado')
                ->where('persona.persona_id', $id)
                ->where('persona.estado', 'A')
                ->first();

            // Obtén las direcciones asociadas a la persona
            $direcciones = $direccionModel->select('direciones_id, direccion, referencia')
                ->where('persona_id', $id)
                ->where('estado', 'A')
                ->findAll();

            // Agrega las direcciones a los datos de la persona
            $persona['direcciones'] = $direcciones;

            return $persona;
        } catch (\Exception $e) {
            return ['error' => 'Error interno: ' . $e->getMessage()];
        }
    }

    public function show($id)
    {
        try {
            $persona = $this->getPersona($id);
            return $this->response->setJSON($persona);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error interno: ' . $e->getMessage()]);
        }
    }


    // En tu controlador de CodeIgniter
    public function store()
    {
        try {
            $requestBody = $this->request->getBody();
            // Obtener datos del cuerpo de la solicitud
            $requestData = json_decode($requestBody, true);

            if (json_last_error() != JSON_ERROR_NONE) {
                return $this->response->setJSON(['error' => 'Error al decodificar JSON: ' . json_last_error_msg()]);
            }
            
      

            // Validar datos (puedes agregar más validaciones según tus necesidades)
            if (empty($requestData['dni']) || empty($requestData['nombres']) || empty($requestData['apellidos']) || empty($requestData['telefono']) || empty($requestData['direccion'])) {
                return $this->response->setJSON(['error' => 'Faltan datos obligatorios']);
            }

            // Verificar si la persona ya existe
            $personaModel = new PersonaModel();
            $persona = $personaModel->where('ruc_dni', $requestData['dni'])->first();
            if ($persona) {
                return $this->response->setJSON(['error' => 'La persona ya existe']);
            }

            // Crear una nueva persona
            $personaModel = new PersonaModel();
            $personaData = [
                'ruc_dni' => $requestData['dni'],
                'nombres' => $requestData['nombres'],
                'apellidos' => $requestData['apellidos'],
                'razon_social' => null,
                'representante_legal' => null,
                'nombre_comercial' => null,
                'telefono' => $requestData['telefono'],
                'estado' => 'A',
            ];
            $personaModel->insert($personaData);


            // Obtener el ID de la persona recién creada
            $persona_id = $personaModel->getInsertID();

            // Crear una nueva dirección asociada a la persona
            $direccionModel = new DireccionModel();
            $direccionData = [
                'persona_id' => $persona_id,
                'direccion' => $requestData['direccion'],
                'lat' => null,
                'lgn' =>  null,
                'referencia' => $requestData['referencia'],
                'estado' => 'A',
            ];

            $direccionModel->insert($direccionData);

            // Verificar si el teléfono de la persona coincide con algún usuario existente
            $usuarioModel = new UserModel();
            $usuario = $usuarioModel->where('telefono', $requestData['telefono'])->first();

            if ($usuario) {
                // Si se encuentra un usuario con el mismo número de teléfono, asociar la persona con ese usuario
                $usuario_id = $usuario['id'];

                // Actualizar el registro de persona con el usuario_id
                $usuarioModel->update($usuario_id, ['persona_id' => $persona_id]);
            }

            return $this->response->setJSON(['exito' => 'Persona y dirección agregadas correctamente','persona_id' => $persona_id]);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error interno: ' . $e->getMessage()]);
        }
    }





    public function update($id)
    {
        // Puedes implementar la lógica para actualizar una persona aquí
    }

    public function delete($id)
    {
        // Puedes implementar la lógica para eliminar una persona aquí
    }
}
