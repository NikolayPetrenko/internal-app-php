<?php defined('SYSPATH') or die('No direct script access.');

class Model_Question extends ORM {
    
    protected $_has_many   = array('qestion_answers' => array( 'model' => 'Question_Answer' ));
    
    protected $_belongs_to = array('category'               => array( 'model' => 'Category' ),
                                   'level'                  => array( 'model' => 'Level' ),
                                   'qestion_answer_type'    => array( 'model' => 'Question_Answer_Type' ) 
                                  );

    
    public function filters(){
            return array(
                'image' => array( array('Helper_Filter::prepareQestionImage', array(':value', ':model')) )
            );
    }

    public function getImage(){
        return URL::site(substr(Kohana::$config->load('config')->get('question_files').$this->image, 2));    
    }

    public function getExclusionCategories(){
        return ORM::factory('Category')->where('id', '!=', $this->category_id)->find_all();
    }
    
    public function getExclusionLevels(){
        return ORM::factory('Level_Type')->where('level_id', '!=', $this->level_id)->where('category_id', '=', $this->category_id)->group_by('level_id')->find_all();
    }

    public function saveQuestion($question){
        
        $question['date_created']   = time();
        if(!empty($question['id'])){
            $saved_question = ORM::factory('Question', $question['id'])->values($question)->update();
            $answers = ORM::factory('Question_Answer')->where('question_id', '=', $question['id'])->find_all();
            foreach ($answers as $answer) {
                $answer->delete();
            }
        }else{
            $saved_question = $this->values($question)->create();
        }
//        $question['answers']['text'] = array_unique($question['answers']['text']);
        #select correct if radio
        if($question['type'] == 'radio'){
            $previousValue = null;    
            foreach ($question['answers'] as $key => $answer){
                if($key === 'radio'){
                    $question['answers'][$previousValue]['corrected'] = 1;
                    unset($question['answers']['radio']);
                }
                $previousValue = $key;
            }
        }
        
        #save answers
        if(!empty($question['answers']) && $question['type'] != 'write'){
            foreach ($question['answers'] as $answer){
                if(!empty($answer['text'])){
                    $answer['question_id'] = $saved_question->id;
                    ORM::factory('Question_Answer')->saveAnswer($answer);
                }
            }
        }
        return $saved_question;
    }
    
    
    
    public function generateTestByCategoryAndLevel($category_id, $level_id, $questions_count = 10){

        $res1 = array();
        if(empty($questions_count) || $questions_count == 0) return $res1;
        $types = DB::select('qestion_answer_type_id')
                    ->distinct(true)
                    ->from('questions')
                    ->where('category_id', '=', $category_id)
                    ->where('level_id', '=', $level_id)
                    ->group_by('qestion_answer_type_id')
                    ->limit($questions_count)
                    ->execute()->as_array();

        $count_types    = count($types);
        $limit_for_type = floor($questions_count / $count_types);
        $residue_limit  = $questions_count - $limit_for_type * $count_types;
        foreach($types as $key => $type){
            $limit = $key == 0 ? $limit_for_type + $residue_limit : $limit_for_type;
            array_push($res1, DB::select('id')
                                    ->distinct(true)
                                    ->from('questions')
                                    ->where('category_id', '=', $category_id)
                                    ->where('level_id', '=', $level_id)
                                    ->where('qestion_answer_type_id', '=', $type['qestion_answer_type_id'])
                                    ->order_by(DB::expr('RAND()'))
                                    ->limit($limit)
                                    ->execute()->as_array());
        }
        $res = array();
        foreach($res1 as $value1){
            foreach($value1 as $value){
                array_push($res, $value['id']);
            }
        }
        $count = $questions_count - count($res);
        if($count > 0){
            $res1 = array();
            array_push($res1, DB::select('id')
                                    ->distinct(true)
                                    ->from('questions')
                                    ->where('category_id', '=', $category_id)
                                    ->where('level_id', '=', $level_id)
                                    ->where('id', 'NOT IN', $res)
                                    ->order_by(DB::expr('RAND()'))
                                    ->limit($count)
                                    ->execute()->as_array())
                                    ;
            foreach($res1 as $value1){
                foreach($value1 as $value){
                    array_push($res, $value['id']);
                }
            }
        }
        shuffle($res);
        return $res;
    }
}
?>