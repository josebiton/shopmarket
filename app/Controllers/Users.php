<?php 
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
class Users extends Controller{

    public function index() {
        try {
            $userModel = new UserModel();
            $users = $userModel->findAll();
            return $this->response->setJSON($users);
        } catch (\Exception $e) {
            return $this->response->setJSON(['error' => $e->getMessage()]);
        }
    }

}


