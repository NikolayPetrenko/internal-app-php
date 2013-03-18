<?php defined('SYSPATH') or die('No direct script access.');

class Model_Level extends ORM {
    
    protected $_has_many   = array('questions' => array( 'model' => 'Question' ));
    
}

?>