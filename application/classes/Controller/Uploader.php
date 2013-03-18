<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Uploader extends My_Layout_User_Controller
{

        public function action_temp(){
                if(exif_imagetype($_FILES['file']['tmp_name']) == '')
                    return false;
                if(!empty($_FILES)){
                        $uploaddir = Kohana::$config->load('config')->get('temp_dir');
                        
                        if(!is_dir($uploaddir))
                            mkdir($uploaddir, 0777);
                        
                        $file              = $_FILES['file'];
                        $info              = pathinfo($file['name']);
                        $name              = time() . '.' . strtolower($info['extension']);
                        $uploadfile = $uploaddir.$name;
//                        move_uploaded_file($file['tmp_name'], $uploadfile);
                        $image = Image::factory($file['tmp_name'])->resize('278')->save($uploadfile);
                        chmod($uploadfile, 0777);
                        
                        Helper_Json_Response::render_json('success', null, array('paste' => substr($uploadfile, 2), 'name' => $name));
                }
        }
}

?>