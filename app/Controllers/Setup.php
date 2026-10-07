<?php

namespace App\Controllers;

class Setup extends BaseController
{
    public function index()
    {
        return redirect()->to(site_url('register'))
            ->with('success', 'Create your account here, then use the same username and password to log in.');
    }
}
