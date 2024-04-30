<?php

use App\Models\RolModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


function validateAccess($roles, $authHeader)
{
    if (!is_array($roles)) {
        return false;
    }

    try {
        $secretKey = Services::getSecretKey();
        $arr = explode(' ', $authHeader);
        $jwt = $arr[1];
        $algorithm = 'HS256';
        $key = new Key($secretKey, $algorithm);
        $decodedToken = JWT::decode($jwt, $key);

        $rolModel = new RolModel();
        $rol = $rolModel->find($decodedToken->data->rol);

        if ($rol == null) {
            return false;
        }

        // foreach ($roles as $role) {
        //     if ($role == $rol['nombre']) {
        //         return true;
        //     }
        // }
            if(!in_array($rol['name'], $roles)){
                return false;
            }




        return true;

    } catch (\Exception $e) {
        return false; // Error al decodificar el token
    }
}

