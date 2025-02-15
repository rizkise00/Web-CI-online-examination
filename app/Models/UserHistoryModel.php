<?php 

namespace App\Models;

use CodeIgniter\Model;

class UserHistoryModel extends Model
{
    protected $table = 'user_histories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'quiz_id', 'right', 'wrong', 'score', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}