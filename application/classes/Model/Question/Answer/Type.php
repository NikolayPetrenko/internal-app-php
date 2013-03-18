<?php defined('SYSPATH') or die('No direct script access.');

class Model_Question_Answer_Type extends ORM {
    
    protected $_belongs_to   = array('category' => array( 'model' => 'Category' ));
    
}

?>