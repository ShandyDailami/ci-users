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
            $admin = $model->where('username', $username)->orWhere('email', $username)->first();

            if ($admin && password_verify($password, $admin['password'])) {
                if ($admin['role'] === $role) {
                    session()->set('id', $admin['id']);
                    session()->set('role', $admin['role']);
                    session()->setFlashdata('message', 'You have successfully signed in');

                    return redirect()->to('/admin/panel');
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

    public function signupAdmin()
    {
        helper('form');
        if (
            $this->validate([
                'path' => [
                    'rules' => 'uploaded[path]|is_image[path]|max_Size[path, 1024]',
                    'errors' => [
                        'uploaded' => 'Please upload a profile picture.',
                        'is_image' => 'The file must be a valid image (jpg, png, gif).',
                        'max_size' => 'The image size must not exceed 1MB.',
                    ]
                ],
                'username' => [
                    'rules' => 'required|min_length[3]|max_length[255]|is_unique[users.username]',
                    'errors' => [
                        'required' => 'Username cannot be empty.',
                        'min_length' => 'Username must be at least 3 characters long.',
                        'max_length' => 'Username can be up to 255 characters long.',
                        'is_unique' => 'This username is already taken. Please choose another one.',
                    ]
                ],
                'email' => [
                    'rules' => 'required|valid_email|is_unique[users.email]',
                    'errors' => [
                        'required' => 'Email cannot be empty.',
                        'valid_email' => 'Please enter a valid email address.',
                        'is_unique' => 'This email is already registered. Please use a different email or log in instead.'
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[8]|max_length[255]',
                    'errors' => [
                        'required' => 'Password cannot be empty.',
                        'min_length' => 'Password must be at least 8 characters long.',
                        'max_length' => 'Password cannot exceed 255 characters.',
                    ]
                ],
                'role' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Please select a role.',
                    ]
                ],
            ])
        ) {
            $profile = $this->request->getFile('path');
            $filename = $profile->getRandomName();
            $profile->move(ROOTPATH . 'public/uploads', $filename);

            $model = new User();
            $model->save([
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role' => $this->request->getPost('role'),
                'path' => $filename,
            ]);

            return redirect()->to('admin/signin')->with('message', 'Account successfully registered');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function panelPage()
    {
        return view('admin/panel', ['title' => 'Admin - Panel']);
    }

    public function forgotPasswordAdminPage()
    {
        return view('admin/forgotPassword', ['title' => 'Admin - Forgot Password']);
    }
}
