<?php

namespace App\Filters;

use App\Models\RolModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

use Config\Services;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthFilter implements FilterInterface
{
    use ResponseTrait;

    public function before(RequestInterface $request, $arguments = null)
    {
        // Se ejecutará antes de cualquier acción en el controlador
        
        try {
            $secretKey = Services::getSecretKey();
            $authHeader = $request->getServer('HTTP_AUTHORIZATION');

            if ($authHeader == null) {
                return Services::response()->setJSON(['error' => 'No autorizado'])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            }

            $arr = explode(' ', $authHeader);
            $jwt = $arr[1];

            
            $algorithm = 'HS256';
            $key = new Key($secretKey, $algorithm);

            try {
                $jwt = JWT::decode($jwt, $key);

               $rolModel = new RolModel();
                $rol = $rolModel->find($jwt->data->rol);

                if($rol == null){
                    return Services::response()->setJSON(['error' => 'El rol del JWT es invalido'])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
                } else {
                    return true;
                }

            } catch (ExpiredException $ee) {
                return Services::response()->setJSON(['error' => 'Su Token ha expirado'])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            }

             catch (\Exception $e) {
                return Services::response()->setJSON(['error' => 'Ocurrió un error al validar el token'])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            }

            if ($jwt === null) {
                return Services::response()->setJSON(['error' => 'Ocurrió un error al decodificar el token'])->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            }

        } catch (\Exception $e) {
            return Services::response()->setJSON(['error' => 'Ocurrió un error interno'])->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
