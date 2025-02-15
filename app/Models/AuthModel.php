<?php 

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['full_name', 'gender', 'college', 'email', 'password', 'role', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    public function verifyLogin($email, $password)
    {
        $user = $this->where('email', $email)->first();

        if (!$user || !isset($user['password']) || !password_verify($password, $user['password'])) {
            return [
				'status' => 401, 
				'message' => 'Invalid Credentials'
			];
        }

        return [
            'status' => 200,
            'message' => 'Login successfully',
            'user' => [
                'uid' => $user['uid'],
                'full_name' => $user['full_name'],
                'role' => $user['role']
            ]
        ];
    }

    public function signUp($data)
    {
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $userData = [
            'uid' => uniqid(),
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => $hashedPassword,
        ];

        if ($this->insert($userData)) {
            return ['status' => 200, 'message' => 'Registration successful, Please login.'];
        } else {
            return ['status' => 401, 'message' => 'Registration failed'];
        }
    }
}