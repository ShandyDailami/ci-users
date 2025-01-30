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
                    session()->set('username', $admin['username']);
                    session()->set('email', $admin['email']);
                    session()->set('path', $admin['path']);
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

    public function panelPage()
    {
        if (!session()->has('id')) {
            return redirect()->to('admin/singin');
        }
        $modelUser = new User();
        $data = [
            'title' => 'Admin - Panel',
            'users' => $modelUser->select('id, username, email, role, path')->findAll(),
            'username' => session()->get('username'),
            'path' => session()->get('path'),
            'email' => session()->get('email'),
            'role' => session()->get('role'),
        ];
        return view('admin/panel', $data);
    }

    public function logout()
    {
        session()->setFlashdata('message', 'You have been logged out successfully.');
        session()->remove(['id', 'username', 'role', 'email', 'path']);
        session()->regenerate();

        return redirect()->to('/admin/signin');
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

    public function forgotPasswordAdminPage()
    {
        return view('admin/forgotPassword', ['title' => 'Admin - Forgot Password']);
    }

    public function delete($id)
    {
        $modelUser = new User();

        $user = $modelUser->find($id);
        if ($user) {
            $modelUser->delete($id);
            if ($user['path'] && file_exists('uploads/' . $user['path'])) {
                unlink('uploads/' . $user['path']);
            }
            return redirect()->to('admin/panel')->with('message', 'Data has been deleted');
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User not find');
        }
    }

    public function editPage($id)
    {
        if (!session()->has('id')) {
            return redirect()->to('/admin/panel');
        }
        $modelUser = new User();
        $data = [
            'title' => 'Admin - Edit Page',
            'user' => $modelUser->find($id),
        ];
        return view('admin/edit', $data);
    }

    public function update()
    {
        helper('form');
        $id = session()->get('id');

        $modelUser = new User();
        $user = $modelUser->find($id);

        $data = [
            'username' => $username = $this->request->getPost('username'),
            'email' => $email = $this->request->getPost('email'),
            'role' => $role = $this->request->getPost('role'),
            // 'path' => $path = $this->request->getFile('path'),
        ];

        $usernameRules = 'required|min_length[3]|max_length[255]';
        if ($username !== $user['username']) {
            $usernameRules .= '|is_unique[users.username]';
        }
        $emailRules = 'required|valid_email';
        if ($email !== $user['email']) {
            $emailRules .= '|is_unique[users.email]';
        }

        $rules = [
            // 'path' => [
            //     'rules' => 'permit_empty|is_image[path]|max_size[path,1024]',
            //     'errors' => [
            //         'is_image' => 'The file must be a valid image (jpg, png, gif).',
            //         'max_size' => 'The image size must not exceed 1MB.',
            //     ]
            // ],
            'username' => [
                'rules' => $usernameRules,
                'errors' => [
                    'required' => 'Username cannot be empty.',
                    'min_length' => 'Username must be at least 3 characters long.',
                    'max_length' => 'Username can be up to 255 characters long.',
                    'is_unique' => 'This username is already taken. Please choose another one.',
                ],
            ],
            'email' => [
                'rules' => $emailRules,
                'errors' => [
                    'required' => 'Email cannot be empty.',
                    'valid_email' => 'Please enter a valid email address.',
                    'is_unique' => 'This email is already registered. Please use a different email or log in instead.'
                ],
            ],
            'role' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Please select a role.',
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // $profile = $this->request->getFile('path');
        // if ($profile && $profile->isValid() && !$profile->hasMoved()) {
        //     if ($user['path'] && file_exists('uploads/' . $user['path'])) {
        //         unlink('uploads/' . $user['path']);
        //     }

        //     $filename = $profile->getRandomName();
        //     $profile->move('uploads', $filename);
        //     $data['path'] = $filename;
        // }
        if ($modelUser->update($id, $data)) {
            return redirect()->to('admin/panel')->with('message', 'Data updated successfully');
        }
    }
}
