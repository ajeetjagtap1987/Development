<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Models\CommonModel;

class User extends Controller
{

    function __construct(){ 
        $user_id = session('user_id');
        if(!$user_id){
            header('Location: '.base_url().'/login');
            exit;
        }
    } 
    public function myChangePassword()
    {
        if (! is_file(APPPATH . 'Views/my_change_password.php')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
        $user_id=session('user_id');
        if(session('user_id')){
            $UserModel = new UserModel();
            $result =  $UserModel->getUserById($user_id);
            if(count($result) > 0){
              $data['user'] = $result;
              return view('includes/header').view('my_change_password',$data).view('includes/footer');
            }else{
            session()->setFlashdata("error", "Something went wrong, please try again!!"); 
            return redirect()->to(base_url());
            }  
        }else{
            session()->setFlashdata("error", "Something went wrong, please try again!!"); 
            return redirect()->to(base_url());
        }
    }

    public function myUpdatePassword()
    { 
        $user_id=session('user_id');
        if($user_id){
            $UserModel = new UserModel();
            $result =  $UserModel->getUserById($user_id);
            if(count($result) > 0){
                $old_password                   = md5($_POST['old_password']);
                if($old_password == $result[0]['pwd']){
                    if(trim($_POST['new_password']) == trim($_POST['confirm_password'])){
                        $data = array(
                            'pwd' => md5(trim($_POST['new_password'])),
                            'updated_by' => $result[0]['id'],
                            'updated_at' => date('Y-m-d H:i:s')
                        );
                        $last_id =  $UserModel->update_data($result[0]['id'],$data);
                        if($last_id){
                            session()->destroy();
                            $data['success']                  = "Password changed successfully!";
                            return view('login', $data );
                            // session()->setFlashdata("success", "Password changed successfully!");
                            // return redirect()->to(base_url().'/login');
                        }else{
                            session()->setFlashdata("error", "Something went wrong, please try again!!"); 
                            return redirect()->to(base_url().'/my-change-password');
                        }
                    }else{
                        session()->setFlashdata("error", "New password and confirm password does not match."); 
                        return redirect()->to(base_url().'/my-change-password');
                    }
                }else{
                    session()->setFlashdata("error", "Old password does not match."); 
                    return redirect()->to(base_url().'/my-change-password');
                }
            }else{
                session()->setFlashdata("error", "Something went wrong, please try again!!"); 
                return redirect()->to(base_url().'/my-change-password');
            }
        }else{
            session()->setFlashdata("error", "Only administrator has permission to perform this action"); 
            return redirect()->to(base_url());
        }
        
    }

}