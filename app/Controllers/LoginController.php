<?php

namespace App\Controllers;

use App\Models\UsersModel;

class LoginController extends BaseController
{
    public function index()
    {
        $session = session();

        // Verifica si el usuario está logueado
        if ($session->get('logged_in')) {
            return redirect()->to(base_url('home'));
        }

       
        return view('user/login');
    }

    public function auth()
    {
        $rules = [
            'email' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {

            return redirect()->to(base_url())->withInput()->with('errors', $this->validator->listErrors());
        }

        $post = $this->request->getPost(['email', 'password']);
        $userModel = new UsersModel();

        $user = $userModel->validateUser($post['email'], $post['password']);

        if ($user) {
            $this->setSession($user);
            return redirect()->to(base_url('home'));
        }

        return redirect()->to(base_url())->withInput()->with('errors', 'Credenciales inválidas');
    }

    private function setSession($userData)
    {
        $data = [
            'logged_in' => true,
            'userId' => $userData['id'],
            'name' => $userData['name'],
            'email' => $userData['email'],
        ];

        $this->session->set($data);
    }

    public function logout(){
        if ($this->session->get('logged_in')) {
           $this->session->destroy();
        }

        return redirect()->to(base_url());
    }
}
