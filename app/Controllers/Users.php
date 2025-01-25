<?php

namespace App\Controllers;

use App\Controllers\BaseController;
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

        // $data = $this->request->getPost([''])
        if (
            $this->validate([
                'profile' => [
                    'rules' => 'uploaded[profile]|is_image[profile]|max_size[profile, 1024]',
                    'errors' => [
                        'upload' => 'Image must be uploaded.',
                        'is_image' => 'The uploaded file must be a valid image (jpg, jpeg, png, gif).',
                        'max_size' => 'The image size must not exceed 1MB.',
                    ]
                ],
                'username' => [
                    'rules' => 'required|min_length[3]|max_length[255]|is_unique[users.username]',
                    'errors' => [
                        'required' => 'Username is required.',
                        'min_length' => 'Username must be at least 3 characters.',
                        'max_length' => 'Username must be at least 255 characters.',
                        'is_unique' => 'This username is already registered. Please use another one.'
                    ]
                ],
                'email' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'Email is required.',
                        'valid_email' => 'Please enter a valid email address',
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[8]|max_length[255]',
                    'errors' => [
                        'required' => 'Password is required.',
                        'min_length' => 'Password must be at least 8 characters.',
                        'max_length' => 'Password must be at least 255 characters.',
                    ]
                ],
            ])
        ) {
            $profile = $this->request->getFile('profile');
            $username = $this->request->getPost('username');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $profilePath = '';
            if ($profile->isValid() && !$profile->hasMoved()) {
                $profilePath = $profile->store('uploads');
            }
        }
    }

    public function forgotPasswordPage()
    {
        return view('user/forgotPassword', ['title' => 'Forgot Password Page']);
    }
}
