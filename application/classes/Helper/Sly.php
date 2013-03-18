<?php
class Helper_Sly
{
        
    public static function createFilesFolderIFNotExist(){
         $dir = Kohana::$config->load('config')->get('files_dir');
        if(!is_dir($dir))
            mkdir($dir, 0777);
    }
    
}