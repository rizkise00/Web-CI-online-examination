<?php 

namespace App\Models;

use CodeIgniter\Model;

class UserFeedbackModel extends Model
{
    protected $table = 'user_feedbacks';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'message', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}