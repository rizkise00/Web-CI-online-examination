<?php 

namespace App\Models;

use CodeIgniter\Model;

class QuestionOptionModel extends Model
{
    protected $table = 'question_options';
    protected $primaryKey = 'id';
    protected $allowedFields = ['quiz_id', 'question_id', 'option_name', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}