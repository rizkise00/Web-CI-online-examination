<?php

namespace App\Controllers;

use App\Models\AuthModel;
use CodeIgniter\Controller;
use Config\Services;

class AuthController extends Controller
{
    protected $validation;
    protected $authModel;
    protected $session;

    public function __construct()
    {
        $this->validation = Services::validation();
        $this->authModel = new AuthModel();
        $this->session = session();
    }

    public function index()
    {
        return view('auth/login');
    }

    public function login()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required'
        ];

        $input = $this->request->getPost();

        if (!$this->validation->setRules($rules)->run($input)) {
            $this->session->setFlashdata('validation_errors', $this->validation->getErrors());
            return redirect()->back()->withInput();
        } else {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $response = $this->authModel->verifyLogin($email, $password);

            if ($response['status'] === 200) {
                $userData = [
                    'user_id' => $response['user']['uid'],
                    'full_name' => $response['user']['full_name'],
                    'role' => $response['user']['role']
                ];
                $this->session->set('user_data', json_encode($userData));

                return redirect()->to(base_url('home'));
            } else {
                $this->session->setFlashdata('error', $response['message']);
                return redirect()->back()->withInput();
            }
        }
    }

    public function register()
    {
        return view('auth/register');
    }

    public function registerUser()
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
            $response = $this->authModel->signUp($input);

            if ($response['status'] === 200) {
                $this->session->setFlashdata('success', $response['message']);
                return redirect()->to(base_url('/'));
            } else {
                $this->session->setFlashdata('error', $response['message']);
                return redirect()->back()->withInput();
            }        
        }
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url('/'));
    }
}