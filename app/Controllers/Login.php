<?php

namespace App\Controllers;

use App\Models\User;

class Login extends BaseController
{
    public function index(): string
    {
        if (session()->get('isLogged') === true) {
            return redirect()->to(base_url('dashboard'));
        }

        $data = [
            'title' => 'Login - Puihaha Electric',
            'page'  => 'login'
        ];

        return view('login', $data);
    }

    public function authenticate()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Enter a valid email and password.');
        }

        $userModel = new User();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->findByEmail($email);

        if (!$user || !$userModel->verifyPassword($password, $user['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid email or password.');
        }

        session()->regenerate();

        session()->set([
            'isLogged' => true,
            'user_id'  => $user['id'],
            'email'    => $user['email'],
            'name'     => $user['first_name'] . ' ' . $user['last_name']
        ]);

        return redirect()->to(base_url('dashboard'));
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(base_url('login'))
            ->with('success', 'You have been logged out.');
    }
}


