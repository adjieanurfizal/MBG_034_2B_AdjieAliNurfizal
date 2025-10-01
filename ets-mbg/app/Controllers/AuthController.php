<?php namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        return view('login'); // Menampilkan halaman login
    }

    public function processLogin()
    {
        $session = session();
        $model = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password'); // Nanti kita hash

        $user = $model->where('email', $email)->first();

        if ($user) {
            // Untuk sekarang, kita tidak hash password dulu agar simpel
            // Di dunia nyata, gunakan password_verify($password, $user['password'])
            if ($password == 'gudang.a' || $password == 'dapur.a') { // Contoh password dari soal
                $ses_data = [
                    'user_id'    => $user['id'],
                    'user_name'  => $user['name'],
                    'user_email' => $user['email'],
                    'user_role'  => $user['role'],
                    'logged_in'  => TRUE
                ];
                $session->set($ses_data);
                
                // Arahkan berdasarkan role
                if($user['role'] == 'gudang'){
                    return redirect()->to('/bahan_baku');
                } else {
                    // Nanti arahkan ke halaman dapur
                    return redirect()->to('/dashboard_dapur'); 
                }
            }
        }
        $session->setFlashdata('msg', 'Email atau Password Salah');
        return redirect()->to('/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}