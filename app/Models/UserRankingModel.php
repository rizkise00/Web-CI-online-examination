<?php 

namespace App\Models;

use CodeIgniter\Model;

class UserRankingModel extends Model
{
    protected $table = 'user_rankings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'total_score', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}