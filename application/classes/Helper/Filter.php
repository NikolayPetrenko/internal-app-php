<?php

class Helper_Filter {
    
    
    public static function prepareQestionImage($file, $question){
        if (!$file || $file == $question->image){ 
            return $file;
        }else{
            $temp_folder         = Kohana::$config->load('config')->get('temp_dir');
            $file_in_temp_fodler = $temp_folder.$file;
            $question_folder     = Kohana::$config->load('config')->get('question_files');
            $file_in_need_folder = $question_folder.$file;
            
            if(!is_dir($question_folder))
                mkdir($question_folder, 0777, true);
            
            rename($file_in_temp_fodler, $file_in_need_folder);
            @unlink($file_in_temp_fodler); 
            
            
            return $file;
        }     
    }
    
    
    
}
?>
