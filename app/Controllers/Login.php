<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\LoginModel;
use App\Models\CommonModel;

class Login extends Controller
{

    public function login()
    {
        return view('login');
    }

    public function userLogin()
    {


        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Form validation failed, display errors or redirect back to the login page
            //return redirect()->to('/login')->withInput()->with('validation', $validation);
            $data['error'] = $validation;
            return view('login?error?csrf', $data);
        }
        // Load the model
        if ($email != '' && $password != '') {
            $LoginModel = new LoginModel();
            $result = $LoginModel->userCheck($email);
            if (count($result) > 0) {
                if ($result[0]['status'] == INACTIVE) {
                    $data['error'] = "Your account is Inactive!!";
                    return view('login', $data);
                } elseif ($result[0]['password'] == md5($password)) {
                    $user_access = array();
                    $CommonModel = new CommonModel();
                    if ($result[0]['user_type'] == ADMIN) {
                        $accesses = $CommonModel->getAllData($table_name = 'accesses');

                        $i = 0;
                        foreach ($accesses as $access) {
                            $user_access[] = $access['id'];
                        }


                    } else {
                        $accesses = $CommonModel->getAllDataByColumnName($table_name = 'user_accesses', 'user_id', $result[0]['id']);


                        $i = 0;
                        if (count($accesses) > 0) {
                            foreach ($accesses as $access) {
                                $user_access[] = $access['access_id'];

                            }
                        }
                    }
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $ipInfo = file_get_contents('http://ip-api.com/json/' . $ip);
                    $ipInfo = json_decode($ipInfo);
                    if ($ipInfo->status != 'fail') {
                        $timezone = $ipInfo->timezone;
                    } else {
                        $timezone = 'Asia/Kolkata';
                    }
                    $data = array(
                        'user_id' => $result[0]['id'],
                        'first_name' => $result[0]['first_name'],
                        'last_name' => $result[0]['last_name'],
                        'full_name' => $result[0]['first_name'] . ' ' . $result[0]['last_name'],
                        'email' => $result[0]['email'],
                        'user_type' => $result[0]['user_type'],
                        'job_title' => $result[0]['job_title'],
                        'parent_id' => $result[0]['id'],
                        'user_access' => $user_access,
                        'user_timezone' => $timezone,
                        'validated' => true
                    );
                    session()->set($data);
                    if (session('user_type') != ADMIN) {
                        $log = $CommonModel->logCreate('LOGIN', 'user logged in-' . session('full_name'));
                    }
                    return redirect()->to(base_url());
                } else {
                    $data['error'] = "Incorrect Password!!";
                    return view('login', $data);
                }
            } else {
                $data['error'] = "Incorrect Username";
                return view('login', $data);
            }
        } else {
            $data['error'] = "Incorrect Username and Password!!";
            return view('login', $data);
        }

    }

    public function logout()
    {
        $CommonModel = new CommonModel();
        if (session('user_type') != ADMIN) {
            $log = $CommonModel->logCreate('LOGOUT', 'user logged out-' . session('full_name'));
        }
        session()->destroy();
        return redirect()->to(base_url() . '/login');
    }

}