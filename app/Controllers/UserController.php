<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use Config\Services;

class UserController extends Controller
{
    protected $userModel;
    protected $session;
    protected $validation;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = session();
        $this->validation = Services::validation();
    }

    public function index()
    {
        $perPage = 10;
        $currentPage = $this->request->getVar('page') ?? 1;

        $data = [
            'user_list' => $this->userModel->getList($perPage, $currentPage),
            'pager' => $this->userModel->pager
        ];

        $content['content'] = view('user/index', $data);

		return view('layouts/master', $content);
    }

    public function add()
    {
        $content['content'] = view('user/add');

		return view('layouts/master', $content);
    }

    public function store()
    {
        $rules = [
            'full_name' => 'required|min_length[4]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]',
        ];                

        $input = $this->request->getPost();

        if (!$this->validation->setRules($rules)->run($input)) {
            $this->session->setFlashdata('validation_errors', $this->validation->getErrors());
            return redirect()->back()->withInput();
        } else {
            $input = $this->request->getPost();
            $response = $this->userModel->store($input);

            if ($response['status'] === 200) {
                $this->session->setFlashdata('success', $response['message']);
                return redirect()->to(base_url('users'));
            } else {
                $this->session->setFlashdata('error', $response['message']);
                return redirect()->back()->withInput();
            }        
        }
    }

    public function edit($userId)
    {
        $response = $this->userModel->get($userId);

        if ($response['status'] === 200) {
            $content['content'] = view('user/edit', ['user' => $response['data']]);
            return view('layouts/master', $content);
        } else {
            $this->session->setFlashdata('error', $response['message']);
            return redirect()->back()->withInput();
        }
    }

    public function update($userId)
    {
        $rules = [
            'full_name' => 'required|min_length[4]'
        ];                

        $input = $this->request->getPost();

        if (!$this->validation->setRules($rules)->run($input)) {
            $this->session->setFlashdata('validation_errors', $this->validation->getErrors());
            return redirect()->back()->withInput();
        } else {
            $input = $this->request->getPost();
            $response = $this->userModel->put($userId, $input);

            if ($response['status'] === 200) {
                $this->session->setFlashdata('success', $response['message']);
                return redirect()->to(base_url('users'));
            } else {
                $this->session->setFlashdata('error', $response['message']);
                return redirect()->back()->withInput();
            }        
        }
    }

    public function delete($userId)
    {
        $response = $this->userModel->destroy($userId);

        if ($response['status'] === 200) {
            $this->session->setFlashdata('success', $response['message']);
            return redirect()->to(base_url('users'));
        } else {
            $this->session->setFlashdata('error', $response['message']);
            return redirect()->back()->withInput();
        }
    }

    public function ranking()
    {
        $perPage = 10;
        $currentPage = $this->request->getVar('page') ?? 1;

        $data = $this->userModel->getListRanking($perPage, $currentPage);
        $content['content'] = view('user/ranking', $data);

		return view('layouts/master', $content);
    }

    public function feedback()
    {
        $perPage = 10;
        $currentPage = $this->request->getVar('page') ?? 1;

        $data = $this->userModel->getListFeedback($perPage, $currentPage);
        $content['content'] = view('user/feedback', $data);

		return view('layouts/master', $content);
    }
}