<?php defined('SYSPATH') OR die('No direct access allowed.');

class Helper_Alert {
        static $status = 'success';
        static $strong = 'Well done!';
          
        static function setStatus($status)
        {
            self::$status = $status;
            
            switch ($status){
              case ('success'):
                self::$strong = 'Well done!'; break;
              case ('error'):
                self::$strong = 'Oh snap!'; break;
              case ('info'):
                self::$strong = 'Heads up!'; break;
              default :
                self::$strong = 'Well done!'; break;
            }
        }
        
        static function render()
        {         
                 $message = Session::instance()->get_once('message');
                  if(!empty($message))
                    echo '<div class="alert alert-'.self::$status.'"><button type="button" class="close" data-dismiss="alert">×</button><strong>'.self::$strong.'</strong> '.$message.'</div>';
        }

        static function set_flash($message)
        {
            Session::instance()->set('message', $message);
        }
}
?>
