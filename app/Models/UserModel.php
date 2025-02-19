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

        $user = $this->where('id', $userId)->first();

        $userAnswerModel = new \App\Models\UserAnswerModel();
        $userHistoryModel = new \App\Models\UserHistoryModel();
        $userRankingModel = new \App\Models\UserRankingModel();
        $userFeedbackModel = new \App\Models\UserFeedbackModel();

        $userAnswers = $userAnswerModel->where('user_id', $user['uid'])->findAll();

        foreach ($userAnswers as $answer) {
            $userAnswerModel->where('id', $answer['id'])->delete();
        }

        $userHistories = $userHistoryModel->where('user_id', $user['uid'])->findAll();

        foreach ($userHistories as $history) {
            $userHistoryModel->where('id', $history['id'])->delete();
        }

        $userFeedbacks = $userFeedbackModel->where('user_id', $user['uid'])->findAll();

        foreach ($userFeedbacks as $feedback) {
            $userFeedbackModel->where('id', $feedback['id'])->delete();
        }

        $userRankingModel->where('user_id', $user['uid'])->delete();
        $this->where('id', $userId)->delete();

        $db->transComplete();

        if ($db->transStatus() === false) {
            return ['status' => 401, 'message' => 'Failed to delete user'];
        }

        return ['status' => 200, 'message' => 'Successfully deleted user'];
    }

    public function getListRanking($perPage, $page)
    {
        $userRankingModel = new \App\Models\UserRankingModel();

        $data = [
            'user_list' => $userRankingModel
                            ->select('user_rankings.total_score, users.full_name, users.email, users.gender, users.college')
                            ->join('users', 'users.uid = user_rankings.user_id')
                            ->orderBy('user_rankings.total_score', 'DESC')
                            ->paginate($perPage, 'default', $page),
            'pager' => $userRankingModel->pager
        ];

        return $data;
    }

    public function getListFeedback($perPage, $page)
    {
        $userFeedbackModel = new \App\Models\UserFeedbackModel();

        $data = [
            'user_list' => $userFeedbackModel
                            ->select('user_feedbacks.message, users.full_name, users.email')
                            ->join('users', 'users.uid = user_feedbacks.user_id')
                            ->orderBy('user_feedbacks.created_at', 'DESC')
                            ->paginate($perPage, 'default', $page),
            'pager' => $userFeedbackModel->pager
        ];

        return $data;
    }

    public function storeFeedback($data)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $userFeedbackModel = new \App\Models\UserFeedbackModel();
        $userFeedbackModel->insert($data);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return ['status' => 401, 'message' => 'Failed to create feedback'];
        }

        return ['status' => 200, 'message' => 'Successfully created feedback'];
    }

    public function getListQuizHistory($perPage, $page)
    {
        $userHistoryModel = new \App\Models\UserHistoryModel();

        $data = [
            'history_list' => $userHistoryModel
                            ->select('user_histories.*, quizzes.title, quizzes.total_question')
                            ->join('quizzes', 'quizzes.id = user_histories.quiz_id')
                            ->orderBy('user_histories.created_at', 'DESC')
                            ->paginate($perPage, 'default', $page),
            'pager' => $userHistoryModel->pager
        ];

        return $data;
    }
}