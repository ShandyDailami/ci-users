<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use CodeIgniter\HTTP\ResponseInterface;

class Users extends BaseController
{
    public function index()
    {
        return view('user/index', ['title' => 'Home']);
    }

    public function signinPage()
    {
        return view('user/signin', ['title' => 'Sign in Page']);
    }

    public function signin()
    {
        helper('form');

        if (
            $this->validate([
                'username' => [
                    'rules' => 'required|min_length[3]|max_length[255]',
                    'errors' => [
                        'required' => 'Username cannot be empty.',
                        'min_length' => 'Username must be at least 3 characters long.',
                        'max_length' => 'Username can be up to 255 characters long.',
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[8]|max_length[255]',
                    'errors' => [
                        'required' => 'Password cannot be empty.',
                        'min_length' => 'Password must be at least 8 characters long.',
                        'max_length' => 'Password cannot exceed 255 characters.',
                    ]
                ]
            ])
        ) {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $model = new User();
            $user = $model->where('username', $username)->orWhere('email', $username)->first();

            if ($user && password_verify($password, $user['password'])) {
                session()->set('id', $user['id']);
                session()->set('username', $user['username']);
                session()->set('path', $user['path']);
                session()->set('email', $user['email']);
                session()->setFlashdata('message', 'You have successfully signed in.');

                return redirect()->to('/profile');
            } else {
                session()->setFlashdata('error', 'Wrong username or password');
                return redirect()->to('/signin');
            }
        } else {
            return redirect()->to('/signin')->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function profile()
    {
        if (!session()->has('id')) {
            return redirect()->to('/signin');
        }

        $data = [
            'title' => 'Profile Page',
            'id' => session()->get('id'),
            'username' => session()->get('username'),
            'path' => session()->get('path'),
            'email' => session()->get('email'),
        ];

        return view('user/profile', $data);
    }

    public function logout()
    {

        session()->setFlashdata('message', 'You have been logged out successfully.');
        session()->destroy();

        return redirect()->to('/signin')->with('message', 'You have been logged out successfully.');
    }

    public function signupPage()
    {
        return view('user/signup', ['title' => 'Sign Up']);
    }

    public function signup()
    {
        helper('form');

        if (
            $this->validate([
                'path' => [
                    'rules' => 'uploaded[path]|is_image[path]|max_size[path,1024]',
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

            return redirect()->to('/signin')->with('message', 'Account successfully registered');
        } else {
            return redirect()->to('/signup')->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    public function forgotPasswordPage()
    {
        return view('user/forgotPassword', ['title' => 'Forgot Password Page']);
    }

    public function forgotPassword()
    {

    }

    public function update()
    {
        helper('form');
        $id = session()->get('id');
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');

        $model = new User();
        $user = $model->find($id);

        $usernameRules = 'required|min_length[3]|max_length[255]';
        if ($username !== $user['username']) {
            $usernameRules .= '|is_unique[users.username]';
        }

        if (
            $this->validate([
                'username' => [
                    'rules' => $usernameRules,
                    'errors' => [
                        'required' => 'Username cannot be empty.',
                        'min_length' => 'Username must be at least 3 characters long.',
                        'max_length' => 'Username can be up to 255 characters long.',
                        'is_unique' => 'This username is already taken. Please choose another one.',
                    ]
                ],
                'email' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'Email cannot be empty.',
                        'valid_email' => 'Please enter a valid email address.',
                    ]
                ]
            ])
        ) {
            $model->update($id, [
                'username' => $username,
                'email' => $email
            ]);
            session()->set('username', $username);
            session()->set('email', $email);
            session()->setFlashdata('message', 'Data updated successfully');
            return redirect()->to('/profile');
        } else {
            return redirect()->to('/profile')->withInput()->with('errors', $this->validator->getErrors());
        }
    }
}
