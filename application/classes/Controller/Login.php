<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Login extends My_Layout_User_Controller {

	public function action_index()
	{
                if (Auth::instance()->logged_in())
                    $this->redirect('admin/tests');
                $error = '';
                if ($this->request->post()) {
                        $user = Auth::instance()->login($this->request->post('username'), $this->request->post('password'));
                        if($user){
                            $this->redirect('admin/tests/index');
                        }else{
                            $error = 'Неправильный логин или пароль!';
                        }
                }
                $this->setTitle('Landing Page')
                     ->view('login/index', array('error' => $error))
                     ->render();
	}

	public function action_logout()
	{
                Auth::instance()->logout(TRUE);
                $this->redirect('/');
         }

//         public function action_register()
//        {
//            if ($this->request->post()) {
//                $model = ORM::factory('User');
//                $model->values(array(
//                    'username'         => $this->request->post('username'),
//                    'password'         => $this->request->post('password')
//                ));
//                try {
//                    $model->save();
//                    $model->add('roles', ORM::factory('Role')->where('name', '=', 'login')->find());
//                    $this->redirect('/');
//                }
//                catch (ORM_Validation_Exception $e) {
//                    echo $e;
//                }
//            }
//            $this->setTitle('Login')
//                    ->view('login/index')
//                    ->render();
//        }
}