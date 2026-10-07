<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\UserModel;
use RuntimeException;
use Throwable;

class Register extends BaseController
{
    public function index(): string
    {
        return view('public/register', [
            'title' => 'Register - Puihaha Electric',
            'page' => 'register',
        ]);
    }

    public function create()
    {
        $rules = [
            'first_name' => 'required|min_length[2]|max_length[100]',
            'last_name' => 'required|min_length[2]|max_length[100]',
            'email' => 'required|valid_email|max_length[255]|is_unique[users.email]',
            'phone' => 'required|min_length[7]|max_length[20]',
            'address' => 'required|min_length[5]|max_length[255]',
            'city' => 'required|min_length[2]|max_length[100]',
            'state' => 'required|min_length[2]|max_length[50]',
            'zip_code' => 'required|min_length[4]|max_length[10]',
            'username' => 'required|min_length[4]|max_length[100]|alpha_numeric_punct|is_unique[user_accounts.username]',
            'password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]',
            'terms' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator->getErrors());
        }

        $firstName = trim((string) $this->request->getPost('first_name'));
        $lastName = trim((string) $this->request->getPost('last_name'));
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');
        $db = db_connect();
        $db->transBegin();

        try {
            (new User($db))->insert([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => trim((string) $this->request->getPost('email')),
                'phone' => trim((string) $this->request->getPost('phone')),
                'address' => trim((string) $this->request->getPost('address')),
                'city' => trim((string) $this->request->getPost('city')),
                'state' => trim((string) $this->request->getPost('state')),
                'zip_code' => trim((string) $this->request->getPost('zip_code')),
                'password' => $password,
                'user_type' => 'customer',
                'is_active' => 1,
                'email_verified' => 0,
            ]);

            (new UserModel($db))->insert([
                'username' => $username,
                'full_name' => $firstName . ' ' . $lastName,
                'password' => password_hash($password, PASSWORD_DEFAULT),
            ]);

            if ($db->transStatus() === false) {
                throw new RuntimeException('Account registration transaction failed.');
            }

            $db->transCommit();
        } catch (Throwable $error) {
            $db->transRollback();
            log_message('error', 'Account registration failed: {message}', ['message' => $error->getMessage()]);

            return redirect()->back()->withInput()
                ->with('error', 'We could not create your account. Please try again.');
        }

        return redirect()->to(site_url('login'))
            ->with('success', 'Registration successful! You can now log in with your username and password.');
    }
}
