<?php
class Helper_Main
{
    static function print_flex($data = ''){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

    static function replaceCyrillicSymbolsForPdf($string)
    {
        $string = str_replace('х', 'x', $string);
        $string = str_replace('Р', 'P', $string);
        return $string;
    }

    static function convertStringForPdf($string)
    {
        $string = Helper_Main::replaceCyrillicSymbolsForPdf($string);
        $string = htmlspecialchars($string);
        if(strlen($string) > 90) $string = wordwrap($string, 90);
        $string = str_replace(' ', '&nbsp;', $string);
        return nl2br($string);
    }

    static function hightLight($what, $where) {
            return str_replace($what, "<b>" . $what . "</b>", $where);
    }
    
    static function changeDateFormat($date){
      $newDate = date_parse_from_format(Kohana::$config->load('config')->get('date.format'), $date);
      return $newDate['year'].'-'.$newDate['month'].'-'.$newDate['day'];
    }
    
    static function checkExistsAndRemoveFile($file){
        if(file_exists($file)){
            @unlink ($file);
        }
    }

    static function unlinkRecursive($dir, $deleteRootToo) 
    { 
        if(!$dh = @opendir($dir)) 
            return;
        
        while (false !== ($obj = readdir($dh))) 
        { 
            if($obj == '.' || $obj == '..') 
            { 
                continue; 
            } 

            if (!@unlink($dir . '/' . $obj)) 
            { 
                self::unlinkRecursive($dir.'/'.$obj, true); 
            } 
        } 

        closedir($dh); 

        if ($deleteRootToo) 
        { 
            @rmdir($dir); 
        } 

        return; 
      }  
}
