<?php 

namespace App\Models;

use CodeIgniter\Model;

class QuizModel extends Model
{
    protected $table = 'quizzes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'total_question', 'time', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    public function getList($perPage, $page, $userId = null)
    {
        $userHistoryModel = new \App\Models\UserHistoryModel();
        
        $quizList = $this->orderBy('id', 'DESC')->paginate($perPage, 'default', $page);

        if ($userId) {
            foreach($quizList as $index => $quiz) {
                $userHistory = $userHistoryModel->where(['user_id' => $userId, 'quiz_id' => $quiz['id']])->first();
    
                if ($userHistory) {
                    $quizList[$index]['quiz_completed'] = true;
                } else {
                    $quizList[$index]['quiz_completed'] = false;
                }
            }
        }

        return $quizList;
    }

    public function storeQuiz($quiz, $questions)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $this->insert($quiz);
        $quizId = $this->getInsertID();

        $questionModel = new \App\Models\QuestionModel();
        $questionOptionModel = new \App\Models\QuestionOptionModel();
        
        foreach ($questions as $question) {
            $question['quiz_id'] = $quizId;
            $questionModel->insert($question);

            $questionId = $questionModel->getInsertID();

            foreach ($question['options'] as $option) {
                $option = [
                    'quiz_id' => $quizId,
                    'question_id' => $questionId,
                    'option_name' => $option
                ];

                $questionOptionModel->insert($option);
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return ['status' => 401, 'message' => 'Failed to create quiz'];
        }

        return ['status' => 200, 'message' => 'Successfully created quiz'];
    }

    public function get($quizId)
    {
        $questionModel = new \App\Models\QuestionModel();
        $questionOptionModel = new \App\Models\QuestionOptionModel();

        $data = [];
        $quiz = $this->where('id', $quizId)->first();
        $getQuestion = $questionModel->where('quiz_id', $quizId)->findAll();

        if (!$quiz || count($getQuestion) == 0) {
            return ['status' => 401, 'message' => 'Failed to get quiz', 'data' => $data];
        }

        $questions = [];
        foreach ($getQuestion as $index => $question) {
            $options = [];
            $getOption = $questionOptionModel->where('quiz_id', $quizId)->where('question_id', $question['id'])->findAll();

            foreach ($getOption as $option) {
                $options[] = $option['option_name'];
            }

            $questions[$index]['id'] = $question['id'];
            $questions[$index]['question'] = $question['question'];
            $questions[$index]['answer'] = $question['answer'];
            $questions[$index]['options'] = $options;
        }

        $data = [
            'quiz' => $quiz,
            'questions' => $questions
        ];

        return ['status' => 200, 'message' => 'Successfully get quiz', 'data' => $data];
    }

    public function updateQuiz($quiz, $questions)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $quizUpdate = [
            'title' => $quiz['title'],
            'total_question' => $quiz['total_question'],
            'time' => $quiz['time'],
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->update($quiz['id'], $quizUpdate);

        $questionModel = new \App\Models\QuestionModel();
        $questionOptionModel = new \App\Models\QuestionOptionModel();
        
        foreach ($questions as $question) {
            $questionUpdate = [
                'question' => $question['question'],
                'answer' => $question['answer'],
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $questionModel->update($question['id'], $questionUpdate);

            $getQuestionOption = $questionOptionModel->where('quiz_id', $quiz['id'])
                                ->where('question_id', $question['id'])
                                ->findAll();

            foreach ($getQuestionOption as $index => $option) {
                $optionUpdate = [
                    'option_name' => $question['options'][$index]
                ];

                $questionOptionModel->update($option['id'], $optionUpdate);
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return ['status' => 401, 'message' => 'Failed to update quiz'];
        }

        return ['status' => 200, 'message' => 'Successfully updated quiz'];
    }

    public function deleteQuiz($quizId)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $questionModel = new \App\Models\QuestionModel();
        $questionOptionModel = new \App\Models\QuestionOptionModel();
        
        $questions = $questionModel->where('quiz_id', $quizId)->findAll();

        foreach ($questions as $question) {
            $questionOptions = $questionOptionModel->where('quiz_id', $quizId)->where('question_id', $question['id'])->findAll();

            foreach ($questionOptions as $option) {
                $questionOptionModel->where('id', $option['id'])->delete();
            }

            $questionModel->where('id', $question['id'])->delete();
        }

        $this->where('id', $quizId)->delete();

        $db->transComplete();

        if ($db->transStatus() === false) {
            return ['status' => 401, 'message' => 'Failed to delete quiz'];
        }

        return ['status' => 200, 'message' => 'Successfully deleted quiz'];
    }

    public function getQuestion($quizId, $questionNo)
    {
        $questionModel = new \App\Models\QuestionModel();
        $questionOptionModel = new \App\Models\QuestionOptionModel();

        $quiz = $this->where('id', $quizId)->first();
        $getQuestion = $questionModel->where('quiz_id', $quizId)->findAll();
        $question = isset($getQuestion[$questionNo - 1]) ? $getQuestion[$questionNo - 1] : null;

        if ($question) {
            $data = [
                'quiz_id' => $quizId,
                'quiz_title' => $quiz['title'],
                'question_id' => $question['id'],
                'question_no' => $questionNo,
                'question' => $question['question'],
                'total_question' => count($getQuestion),
                'options' => []
            ];
    
            $getOption = $questionOptionModel->where('quiz_id', $quizId)->where('question_id', $question['id'])->findAll();
    
            $answers = ['A', 'B', 'C', 'D'];
            foreach ($getOption as $index => $option) {
                $data['options'][] = [
                    'name' => $option['option_name'],
                    'value' => $answers[$index]
                ];
            }
    
            return ['status' => 200, 'message' => 'Successfully get question', 'data' => $data];
        } else {
            return ['status' => 401, 'message' => 'Failed to get question'];
        }
    }

    public function storeQuestion($data)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        $userAnswer = new \App\Models\UserAnswerModel();
        $getAnswer = $userAnswer->where(['user_id' => $data['user_id'], 'quiz_id' => $data['quiz_id'], 'question_id' => $data['question_id']])->first();

        if ($getAnswer) {
            $userAnswer->update($getAnswer['id'], $data);
        } else {
            $userAnswer->insert($data);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return ['status' => 401, 'message' => 'Failed to save answer'];
        }

        return ['status' => 200, 'message' => 'Successfully saved answer'];
    }

    public function getResult($userId, $quizId)
    {
        $questionModel = new \App\Models\QuestionModel();
        $userAnswerModel = new \App\Models\UserAnswerModel();
        $userRankingModel = new \App\Models\UserRankingModel();
        $userHistoryModel = new \App\Models\UserHistoryModel();

        $getQuestions =  $questionModel->where('quiz_id', $quizId)->findAll();
        $data = [
            'quiz_id' => $quizId,
            'total_question' => count($getQuestions),
            'total_correct' => 0,
            'total_wrong' => 0,
            'total_score' => 0
        ];

        foreach($getQuestions as $question) {
            $userAnswer =  $userAnswerModel->where(['user_id' => $userId, 'quiz_id' => $quizId, 'question_id' => $question['id']])->first();

            if ($userAnswer) {
                if ($question['answer'] == $userAnswer['answer']) {
                    $data['total_correct']++;
                } else {
                    $data['total_wrong']++;
                }
            } else {
                $data['total_wrong']++;
            }
        }

        $data['total_score'] = ($data['total_correct'] / $data['total_question']) * 100;
        $data['total_score'] = round($data['total_score']);

        // user history
        $userHistory = $userHistoryModel->where(['user_id' => $userId, 'quiz_id' => $quizId])->first();
        if ($userHistory) {
            $dataUpdate = [
                'right' => $data['total_correct'],
                'wrong' => $data['total_wrong'],
                'score' => $data['total_score']
            ];

            $userHistoryModel->update($userHistory['id'], $dataUpdate);
        } else {
            $dataInsert = [
                'user_id' => $userId,
                'quiz_id' => $quizId,
                'right' => $data['total_correct'],
                'wrong' => $data['total_wrong'],
                'score' => $data['total_score']
            ];

            $userHistoryModel->insert($dataInsert);
        }

        // user ranking
        $totalScore = 0;
        $userHistory = $userHistoryModel->where('user_id', $userId)->findAll();

        foreach ($userHistory as $history) {
            $totalScore += $history['score'];
        }

        $userRanking = $userRankingModel->where('user_id', $userId)->first();
        if ($userRanking) {
            $userRankingModel->update($userRanking['id'], ['total_score' => $totalScore]);
        } else {
            $userRankingModel->insert([
                'user_id' => $userId,
                'total_score' => $totalScore
            ]);
        }

        return ['status' => 200, 'message' => 'Successfully get result', 'data' => $data];
    }
}