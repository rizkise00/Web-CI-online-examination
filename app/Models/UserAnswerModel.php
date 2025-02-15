<?php 

namespace App\Models;

use CodeIgniter\Model;

class UserAnswerModel extends Model
{
    protected $table = 'user_answers';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'quiz_id', 'question_id', 'answer', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}