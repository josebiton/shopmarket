<?php 
namespace App\Models;

use CodeIgniter\Model;

class RolModel extends Model{
    protected $table      = 'roles';
    // Uncomment below if you want add primary key
    protected $primaryKey = 'id';
    protected $allowedFields = ['name','description'];
    protected $returnType     = 'array';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $useTimestamps = true;


    
}