<?php 

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['uid', 'full_name', 'gender', 'college', 'email', 'password', 'role', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    public function getList($perPage, $page)
    {
        return $this->orderBy('id', 'DESC')->paginate($perPage, 'default', $page);
    }

    public function store($data)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $userData = [
            'uid' => substr(bin2hex(random_bytes(5)), 0, 10),
            'full_name' => $data['full_name'],
            'gender' => $data['gender'],
            'college' => $data['college'],
            'email' => $data['email'],
            'password' => $hashedPassword,
            'role' => $data['role']
        ];

        $this->insert($userData);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return ['status' => 401, 'message' => 'Failed to create user'];
        }

        return ['status' => 200, 'message' => 'Successfully created user'];
    }

    public function get($quizId)
    {
        $data = $this->where('id', $quizId)->first();

        if (!$data) {
            return ['status' => 401, 'message' => 'Failed to get user', 'data' => $data];
        }

        return ['status' => 200, 'message' => 'Successfully get user', 'data' => $data];
    }

    public function put($userId, $data)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $user = [
            'full_name' => $data['full_name'],
            'gender' => $data['gender'],
            'college' => $data['college'],
            'role' => $data['role'],
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->update($userId, $user);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return ['status' => 401, 'message' => 'Failed to update user'];
        }

        return ['status' => 200, 'message' => 'Successfully updated user'];
    }

    public function destroy($userId)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $this->where('id', $userId)->delete();

        $db->transComplete();

        if ($db->transStatus() === false) {
            return ['status' => 401, 'message' => 'Failed to delete user'];
        }

        return ['status' => 200, 'message' => 'Successfully deleted user'];
    }
}