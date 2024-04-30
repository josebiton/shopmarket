<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\RolModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

use Config\Services;
use Firebase\JWT\JWT;

class Auth extends BaseController
{

    use ResponseTrait;


    public function __construct()
    {
        helper('password_helper');
    }

    public function logueo()
    {
        try {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $usuarioModel = new UserModel();
            $validateUsuario = $usuarioModel->where('email', $email)->first();

            if ($validateUsuario == null) {
                return $this->response->setJSON(['error' => 'Usuario o contraseña incorrectos.']);
            }

            // Caputar los datos del ususario un la variable data
            $data = [
                'id' => $validateUsuario['id'],
                'name' => $validateUsuario['name'],
                'email' => $validateUsuario['email'],
                'persona_id' => $validateUsuario['persona_id'],
                'telefono' => $validateUsuario['telefono'],
                'role_id' => $validateUsuario['role_id'],
            ];

            if (verifyPassword($password, $validateUsuario['password'])) {
                $jwt = $this->generateJWT($validateUsuario);
                return $this->response->setJSON(['status' => 'success', 'message' => 'Exito', 'Token' => $jwt , 'data'=>$data]);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Contraseña incorrecta']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => $e->getMessage()]);
        }
    }


    protected function generateJWT($usuario)
    {
        $key = Services::getSecretKey();
        $time = time();

        $roleName = $this->getRoleName($usuario['role_id']);
        $payload = [
            'aud' => base_url(),
            'iat' => $time,
            'exp' => $time + 3600, //como entero
            'data' => [
                'nombre' => $usuario['name'],
                'email' => $usuario['email'],
                'rol' => $roleName,
            ]
        ];

        $jwt = JWT::encode($payload, $key, 'HS256');
        return $jwt;
    }


    protected function getRoleName($roleId)
    {
        $roleModel = new RolModel();
        $role = $roleModel->find($roleId);

        if ($role) {
            return $role['name'];
        } else {
            return 'Rol Desconocido';
        }
    }

    public function register()
    {
        try {
            $inputData = $this->request->getPost();
            $usuarioModel = new UserModel();

            // Validar si ya existe un usuario con el mismo nombre, correo o teléfono
            if ($usuarioModel->isDuplicate($inputData)) {
                return $this->response->setJSON(['error' => 'Ya existe un usuario con el mismo nombre, correo o teléfono.']);
            }

            // Iniciar transacción
            $usuarioModel->transStart();

            // Validación de los campos
            if (!$usuarioModel->validate($inputData)) {
                $usuarioModel->transRollback(); // Revertir transacción en caso de fallo en la validación
                return $this->response->setJSON(['error' => $usuarioModel->errors()]);
            }

            $email = $inputData['email'];
            // Verificar si es una dirección de correo electrónico válida
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return $this->response->setJSON(['error' => 'La dirección de correo electrónico no es válida.']);
            }

            // Verificar si es un dominio permitido (puedes ajustar la lista según tus necesidades)
            $allowedDomains = ['gmail.com', 'hotmail.com', 'upeu.edu.pe', 'outlook.com'];
            $domain = strtolower(substr(strrchr($email, "@"), 1));

            if (!in_array($domain, $allowedDomains)) {
                return $this->response->setJSON(['error' => 'No se permiten direcciones de correo electrónico de este dominio.']);
            }


            // Crear un nuevo registro de usuario
            $usuarioData = [
                'empresa_id' => 1,
                'persona_id' => null,
                'name' => strtoupper($inputData['name']),
                'email' => $email,
                'telefono' => $inputData['telefono'],
                'password' => hashPassword($inputData['password']),
                'role_id' => 2,
                'estado' => 'A',
            ];

            $usuarioModel->insert($usuarioData);

            // Comprobar si la inserción fue exitosa
            if ($usuarioModel->affectedRows() > 0) {
                $usuarioModel->transComplete(); // Confirmar transacción
                return $this->response->setJSON(['status' => 'success', 'message' => 'Usuario registrado con éxito']);
            } else {
                $usuarioModel->transRollback(); // Revertir transacción en caso de fallo
                return $this->response->setJSON(['error' => 'No se pudo registrar el usuario.']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => 'Error interno: ' . $e->getMessage()]);
        }
    }
}
