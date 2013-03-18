<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Dashboard extends My_Layout_Admin_Controller {

    public function before() {
        parent::before();
        Helper_Menu_Admin::setActiveItem('dashboard');
    }

    public function action_index()
    {
        $this->setTitle('Tests managment')
             ->view('admin/dashboard/index')
             ->render();
    }
}