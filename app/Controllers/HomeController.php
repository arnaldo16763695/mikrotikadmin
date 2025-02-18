<?php

namespace App\Controllers;

use App\Libraries\RouterosAPI;

class HomeController extends BaseController
{

    public function  index()
    {
        $API = new RouterosAPI();
        $mkconnec = []; // Inicializamos la variable con un array vacío

        // Intentamos conectar al MikroTik
        if ($API->connect(env('ip'), env('username'), env('password'))) {
            // Si la conexión es exitosa, obtenemos los datos
            $mkconnec = $API->comm('/ip/hotspot/user/print');
            $API->disconnect(); // Desconectar de la API
        } else {
            // Si no se pudo conectar, guardamos un mensaje de error en la sesión
            session()->setFlashdata('errors', 'No se pudo conectar al MikroTik. Verifique la configuración de conexión.');
        }

        // Pasamos los datos a la vista, si no se pudo conectar, $mkconnec será un array vacío
        $data['mkconnec'] = $mkconnec;
        return view('home/home', $data);
    }

    public function addUser()
    {
        return view('home/users/add');
    }

    public function saveUser()
    {

        $rules = [
            'rut' => 'required|max_length[40]',
            'password' => 'required|max_length[50]|min_length[8]',
            'email' => 'required|max_length[50]|valid_email',
            'repassword' => 'matches[password]'
        ];

        if (!$this->validate($rules)) {

            return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
        }

        $post = $this->request->getPost(['user', 'password', 'rut', 'email']);

        $API = new RouterosAPI();

        if ($API->connect(env('ip'), env('username'), env('password'))) {
            $response = $API->comm('/ip/hotspot/user/add', [
                'name' => $post['rut'],
                'password' => $post['password'],
                'email' => $post['email'],
            ]);
            $API->disconnect(); // Desconectar de la API
        } else {
            // Si no se pudo conectar, guardamos un mensaje de error en la sesión
            session()->setFlashdata('errors', 'No se pudo conectar al MikroTik. Verifique la configuración de conexión.');
            return redirect()->to(base_url('home/users/add'));
        }

        if (isset($response['!trap'])) {
            // echo 'Error: ' . $response['!trap'][0]['message'];exit;
            return redirect()->back()->withInput()->with('errors', $response['!trap'][0]['message']);
        }

        return redirect()->to(base_url('home'));
    }

    public function editUser($id)
    {


        $API = new RouterosAPI();
        if ($API->connect(env('ip'), env('username'), env('password'))) {
            $usuario = $API->comm('/ip/hotspot/user/print', [
                "?.id" => '*' . $id,
                // '=.proplist' => '', // Obtener todos los campos
            ]);
            $API->disconnect(); // Desconectar de la API
            if ($usuario === []) {
                session()->setFlashdata('errors', 'No se encontró registro');
                return redirect()->to(base_url('home'));
            }
        } else {
            // Si no se pudo conectar, guardamos un mensaje de error en la sesión
            session()->setFlashdata('errors', 'No se pudo conectar al MikroTik. Verifique la configuración de conexión.');
            return redirect()->to(base_url('home'));
        }

        // echo json_encode($usuario);
        // exit;
        $data['usuario'] = $usuario;
        return view('/home/users/edit', $data);
    }

    public function patchUser()
    {
        $post = $this->request->getPost(['repassword', 'password', 'name', 'email', 'id', 'disabled']);
        // print_r($_POST);exit;
        if ($post['password']  || $post['repassword']) {
            $rules = [
                'name' => 'required|max_length[40]',
                'password' => 'required|max_length[50]|min_length[8]',
                'email' => 'required|max_length[50]|valid_email',
                'repassword' => 'matches[password]'
            ];
        } else {

            $rules = [
                'name' => 'required|max_length[40]',
                'email' => 'required|max_length[50]|valid_email',
            ];
        }

        if (!$this->validate($rules)) {

            return redirect()->to('home/users/edit/' . str_replace('*', '', $post['id']))->withInput()->with('errors', $this->validator->listErrors());
        }

        $API = new RouterosAPI();
        $toupdate = [];
        foreach ($post as $key => $val) {
            if ($val && $key != 'id' && $key != 'repassword') {
                $toupdate[$key] = $val;
            }
        }
        $toupdate['numbers'] = $post['id'];
        //  print_r($toupdate);
        //  exit;
        if ($API->connect(env('ip'), env('username'), env('password'))) {
            $response = $API->comm('/ip/hotspot/user/set', $toupdate);
            $API->disconnect(); // Desconectar de la API
        } else {
            // Si no se pudo conectar, guardamos un mensaje de error en la sesión
            session()->setFlashdata('errors', 'No se pudo conectar al MikroTik. Verifique la configuración de conexión.');
            return redirect()->to(base_url('home/users/add'));
        }
        if (isset($response['!trap'])) {
            // echo 'Error: ' . $response['!trap'][0]['message'];exit;
            session()->setFlashdata('errors', $response['!trap'][0]['message']);
            return redirect()->to(base_url('home/users/edit/' . str_replace('*', '', $post['id'])));
        }

        return redirect()->to(base_url('home'));
    }

    public function deleteUser($id)
    {
        // echo $id;exit;

        $API = new RouterosAPI();
        if ($API->connect(env('ip'), env('username'), env('password'))) {
            $response = $API->comm('/ip/hotspot/user/remove', [
                "numbers" => '*' . $id,
                // '=.proplist' => '', // Obtener todos los campos
            ]);
            $API->disconnect(); // Desconectar de la API
          
            if (isset($response['!trap'])) {
                // echo 'Error: ' . $response['!trap'][0]['message'];exit;
                session()->setFlashdata('errors', $response['!trap'][0]['message']);
                return redirect()->to(base_url('home'));
            }
        } else {
            // Si no se pudo conectar, guardamos un mensaje de error en la sesión
            session()->setFlashdata('errors', 'No se pudo conectar al MikroTik. Verifique la configuración de conexión.');
            return redirect()->to(base_url('home'));
        }

        // echo json_encode($usuario);
        // exit;
        return redirect()->to(base_url('home'));
    }
}
