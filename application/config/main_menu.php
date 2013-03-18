<?php defined('SYSPATH') OR die('No direct access allowed.');
return array(
                                      "home"   => array(
                                                      'title' 	=> 'Home',
                                                      'url'    	=> 'home',
                                                      'status'  => 1
                                                      ),
                                      "profile" => array(
                                                      'title' 	=> 'My Profile',
                                                      'url'    	=> 'user/profile',
                                                      'status'  => 0
                                                      ),
                                      "contact" => array(
                                                      'title' 	=> 'Contact',
                                                      'url'    	=> 'user/contact',
                                                      'status'  => 0
                                                      ),
                                      "logout" => array(
                                                      'title' 	=> 'Logout',
                                                      'url'    	=> 'session/logout',
                                                      'status'  => 0
                                                      )            
    );
?>
