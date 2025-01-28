<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use CodeIgniter\HTTP\ResponseInterface;

class Admins extends BaseController
{
    public function index()
    {
        return view('admin/signin', ['title' => 'Admin - Sign In']);
    }

    public function signinAdmin()
    {
        helper('form');

        if (
            $this->validate([
                'username' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Username cannot be empty.'
                    ]
                ],
                'password' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Passsword cannot be empty',
                    ]
                ],
                'role' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Role cannot be empty.',
                    ]
                ]
            ])
        ) {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $role = $this->request->getPost('role');

            $model = new User();
            $admin = $model->where($username)->orWhere('email', $username)->first();

            if ($admin && password_verify($password, $admin['password'])) {
                if ($admin['role'] === $role) {
                    session()->set('id', $admin['id']);
                    session()->set('role', $admin['role']);
                    session()->setFlashdata('message', 'You have successfully signed in');

                    return redirect()->to('/adminPanel');
                } else {
                    session()->setFlashdata('error', 'Unauthorized role.');
                    return redirect()->to('admin/signin');
                }
            } else {
                session()->setFlashdata('error', 'Invalid Credential');
                return redirect()->to('admin/signin');
            }
        } else {
            return redirect()->to('/admin/signin')->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function signupAdminPage()
    {
        return view('admin/signup', ['title' => 'Admin - Sign Up']);
    }

    public function forgotPasswordAdminPage()
    {
        return view('admin/forgotPassword', ['title' => 'Admin - Forgot Password']);
    }
}
