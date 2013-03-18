<?php defined('SYSPATH') or die('No direct script access.');

class Model_Category extends ORM {
    protected $_has_many = array('questions' => array( 'model' => 'Question' ),
//                                   'answer_types' => array( 'model' => 'Question_Answer_Type'),
                                   'levels' => array( 'model' => 'Level' ,  'through' => 'levels_categories'),
                                   'types' => array( 'model' => 'Type' ,  'through' => 'categories_types')
                                  );

    public function getLevels(){
        return $this->levels->find_all();
    }
}

?>