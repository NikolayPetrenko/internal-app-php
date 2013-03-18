<?php defined('SYSPATH') or die('No direct script access.');

class Model_Question_Answer extends ORM {
    
    protected $_belongs_to = array('qestion'   => array( 'model' => 'Qestion' ));
    
    
    public function saveAnswer($answer){
        return $this->values($answer)->save();
    }
    
}

?>