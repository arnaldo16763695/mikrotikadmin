<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use CodeIgniter\HTTP\ResponseInterface;

class UsersController extends BaseController
{
    protected $userModel;
    public function __construct()
    {
        // Cargar el modelo
        $this->userModel = new UsersModel();
    }

    public function index()
    {
        // Obtener los datos
        $data['users'] = $this->userModel->findAll();

        // Pasar los datos a la vista
        return view('user/list', $data);
    }
    public function addUser()
    {
        return view('user/add');
    }

    public function saveUser()
    {

        $post = $this->request->getPost(['name', 'email', 'password', 'repassword']);

        $rules = [
            'name' => 'required|max_length[40]',
            'password' => 'required|max_length[50]|min_length[8]',
            'email' => 'required|max_length[50]|valid_email|is_unique[users.email]',
            'repassword' => 'matches[password]'
        ];

        if (!$this->validate($rules)) {

            return redirect()->to(base_url('users/add'))->withInput()->with('errors', $this->validator->listErrors());
        }


        // $userExist = $this->userModel->where('email', $post['email'])->first();

        // if ($userExist) return redirect()->to(base_url('users/add'))->withInput()->with('errors', 'Usuario ya existe');

        $this->userModel->insert([
            'name' => $post['name'],
            'password' => password_hash($post['password'], PASSWORD_DEFAULT),
            'email' => $post['email'],
        ]);

        return redirect()->to(base_url('users'));
    }

    public function editUser($id)
    {
        $user = $this->userModel->where('id', $id)->first();
        if ($user['email'] === 'admin@movinet.cl') return redirect()->to(base_url('users'));
        $data['user'] = $this->userModel->where('id', $id)->first();

        if (!$data['user']) return redirect()->to(base_url('users/add'))->withInput()->with('errors', 'Usuario no existe');



        return view('user/edit', $data);
    }

    public function patchUser()
    {
        $post = $this->request->getPost(['name', 'email', 'password', 'repassword', 'id', 'active']);

        // print_r($_POST);
        // exit;
        if ($post['password'] || $post['repassword']) {
            $rules = [
                'id' => 'required',
                'active' => 'required',
                'name' => 'required|max_length[40]',
                'password' => 'required|max_length[50]|min_length[8]',
                'email' => 'required|max_length[50]|valid_email|is_unique[users.email,id,{id}]',
                'repassword' => 'matches[password]'
            ];
        } else {
            $rules = [
                'id' => 'required',
                'active' => 'required',
                'name' => 'required|max_length[40]',
                'email' => 'required|max_length[50]|valid_email|is_unique[users.email,id,{id}]',
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->to(base_url('users/edit/') . $post['id'])->withInput()->with('errors', $this->validator->listErrors());
        }

        $toupdate = [];
        foreach ($post as $key => $val) {
            if ($val !== '' && $key !== 'repassword') {
                $toupdate[$key] = $val;
            }
        }
        //  print_r($toupdate);
        //  exit;
        $this->userModel->save($toupdate);

        return redirect()->to(base_url('users'));
    }



    public function deleteUser($id)
    {

        $user = $this->userModel->where('id', $id)->first();

        if ($user['email'] !== 'admin@movinet.cl') {
            $this->userModel->where('id', $id)->delete();
        }


        // echo json_encode($usuario);
        // exit;
        return redirect()->to(base_url('users'));
    }
}
