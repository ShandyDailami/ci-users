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

    public function signupPage()
    {
        return view('user/signup', ['title' => 'Sign up Page']);
    }

    public function signup()
    {
        helper('form');

        if (
            $this->validate([
                'profile' => [
                    'rules' => 'uploaded[profile]|is_image[profile]|max_size[profile,1024]',
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
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'Email cannot be empty.',
                        'valid_email' => 'Please enter a valid email address.',
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
            $profile = $this->request->getFile('profile');
            $filename = $profile->getRandomName();
            $profile->move(ROOTPATH . 'public/uploads', $filename);

            $model = new User();
            $model->save([
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role' => $this->request->getPost('role'),
                'profile' => $filename,
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
}
