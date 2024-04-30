<?php 
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'empresa_id',
        'persona_id',
        'name',
        'email',
        'telefono',
        'password',
        'role_id',
        'estado' 
    ];
    
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField = 'deleted_at';


    // Validación
    protected $validationRules = [
        'name'     => 'required|is_unique[users.name,id,{id}]',
        'email'    => 'required|valid_email|is_unique[users.email,id,{id}]',
        'telefono' => 'required|numeric|max_length[9]|min_length[9]|is_unique[users.telefono,id,{id}]',
        'password' => 'required',
        'role_id'  => 'required|in_list[1,2,3,4]',
        'estado'   => 'required|in_list[A,I]'
    ];
    
    protected $validationMessages  = [
        'name'     => [
            'is_unique' => 'El nombre de usuario ya existe.',
            'required'  => 'El nombre de usuario es obligatorio.'
        ],
        'email'    => [
            'is_unique'    => 'El correo electrónico ya existe.',
            'valid_email'  => 'El correo electrónico no es válido.',
            'required'     => 'El correo electrónico es obligatorio.'
        ],
        'telefono' => [
            'required'    => 'El teléfono es obligatorio.',
            'numeric'     => 'El teléfono debe ser numérico.',
            'max_length'  => 'El teléfono no puede tener más de 9 dígitos.',
            'is_unique'   => 'El teléfono ya existe.',
        ],
        'password' => [
            'required' => 'La contraseña es obligatoria.'
        ],
        'role_id'  => [
            'required' => 'El rol es obligatorio.',
            'in_list'  => 'El rol seleccionado no es válido.'
        ],
        'estado'   => [
            'required' => 'El estado es obligatorio.',
            'in_list'  => 'El estado seleccionado no es válido.'
        ]
    ];
    
   
    public function isDuplicate(array $data)
    {
        return $this->where($data)->countAllResults() > 0;
    }
    
    

    

}
