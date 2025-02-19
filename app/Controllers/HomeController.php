<?php

namespace App\Controllers;

use App\Models\QuizModel;
use CodeIgniter\Controller;

class HomeController extends Controller
{
    protected $quizModel;
    protected $session;

    public function __construct()
    {
        $this->quizModel = new QuizModel();
        $this->session = session();
    }

    public function index()
    {
        $perPage = 10;
        $currentPage = $this->request->getVar('page') ?? 1;
        $user = json_decode($this->session->get('user_data'), true);

        $data = [
            'quiz_list' => $this->quizModel->getList($perPage, $currentPage, ($user['role'] == 'user' ? $user['user_id'] : null)),
            'pager' => $this->quizModel->pager
        ];

        $content['content'] = view('home/index', $data);

		return view('layouts/master', $content);
    }

    public function addQuiz()
    {
        $content['content'] = view('home/add');

		return view('layouts/master', $content);
    }

    public function storeQuiz()
    {
        $input = $this->request->getPost();
        $quiz = [
            'title' => $input['title'],
            'total_question' => $input['total_question'],
            'time' => $input['time']
        ];
        $questions = $input['questions'];

        $response = $this->quizModel->storeQuiz($quiz, $questions);

        if ($response['status'] === 200) {
            $this->session->setFlashdata('success', $response['message']);
            return redirect()->to(base_url('home'));
        } else {
            $this->session->setFlashdata('error', $response['message']);
            return redirect()->back()->withInput();
        }  
    }

    public function editQuiz($quizId)
    {
        $response = $this->quizModel->get($quizId);

        if ($response['status'] === 200) {
            $content['content'] = view('home/edit', $response['data']);
            return view('layouts/master', $content);
        } else {
            $this->session->setFlashdata('error', $response['message']);
            return redirect()->back()->withInput();
        }
    }

    public function updateQuiz($quizId)
    {
        $input = $this->request->getPost();
        $quiz = [
            'id' => $quizId,
            'title' => $input['title'],
            'total_question' => $input['total_question'],
            'time' => $input['time']
        ];
        $questions = $input['questions'];

        $response = $this->quizModel->updateQuiz($quiz, $questions);

        if ($response['status'] === 200) {
            $this->session->setFlashdata('success', $response['message']);
            return redirect()->to(base_url('home'));
        } else {
            $this->session->setFlashdata('error', $response['message']);
            return redirect()->back()->withInput();
        }
    }

    public function deleteQuiz($quizId)
    {
        $response = $this->quizModel->deleteQuiz($quizId);

        if ($response['status'] === 200) {
            $this->session->setFlashdata('success', $response['message']);
            return redirect()->to(base_url('home'));
        } else {
            $this->session->setFlashdata('error', $response['message']);
            return redirect()->back()->withInput();
        }
    }

    public function startQuiz($quizId, $questionNo = 1)
    {
        $response = $this->quizModel->getQuestion($quizId, $questionNo);

        if ($response['status'] === 200) {
            $content['content'] = view('home/quiz', ['quiz' => $response['data']]);
            return view('layouts/master', $content);
        } else {
            $this->session->setFlashdata('error', $response['message']);
            return redirect()->back()->withInput();
        }
    }

    public function storeQuestion()
    {
        $user = json_decode($this->session->get('user_data'), true);

        $input = $this->request->getPost();
        $input['user_id'] = $user['user_id'];

        $response = $this->quizModel->storeQuestion($input);

        if ($response['status'] === 200) {
            $quizId = (int) $input['quiz_id'];
            $question = (int) $input['current_question'];
            $total = (int) $input['total_question'];

            if ($question < $total) {
                return redirect()->to(base_url('home/start-quiz/' . $quizId . '/' . ($question + 1)));
            } else {
                return redirect()->to(base_url('home/result-quiz/' . $quizId));
            }
        } else {
            $this->session->setFlashdata('error', $response['message']);
            return redirect()->back()->withInput();
        }
    }

    public function resultQuiz($quizId)
    {
        $user = json_decode($this->session->get('user_data'), true);
        $response = $this->quizModel->getResult($user['user_id'], $quizId);

        if ($response['status'] === 200) {
            $content['content'] = view('home/result', ['result' => $response['data']]);
            return view('layouts/master', $content);
        } else {
            $this->session->setFlashdata('error', $response['message']);
            return redirect()->back()->withInput();
        }
    }
}