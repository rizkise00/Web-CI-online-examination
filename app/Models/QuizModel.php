<?php 

namespace App\Models;

use CodeIgniter\Model;

class QuizModel extends Model
{
    protected $table = 'quizzes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'total_question', 'time', 'created_at', 'updated_at'];
    protected $useTimestamps = true;

    public function getList($perPage, $page)
    {
        return $this->orderBy('id', 'DESC')->paginate($perPage, 'default', $page);
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
}