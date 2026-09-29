<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Login - Puihaha Electric',
            'page' => 'login'
        ];

        return view('login', $data);
    }

    public function authenticate()
    {
        // Temporary login: no credential checking yet
        session()->set('logged_in', true);

        return redirect()->to(base_url('dashboard'));
    }
}
