<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Tests extends My_Layout_Admin_Controller {

    public function before() {
        parent::before();
        Helper_Menu_Admin::setActiveItem('tests');
    }

    public function action_index()
    {
        Helper_Output::factory()->link_js('libs/jquery.numberMask')
                                ->link_js('libs/jquery.form')
                                ->link_js('tagits')
                                ->link_css('jquery-ui-1.9.2.custom')
                                ->link_css('jquery.tagit')
                                ->link_css('tagit.ui-zendesk')
                                ;

        $data['categories'] = ORM::factory('Category')->find_all();
        $this->setTitle('Tests managment')
             ->view('admin/tests/index', $data)
             ->render();
    }

    public function action_ajaxActionType()
    {
        if($this->request->headers("x-requested-with")){
            $name = $this->request->post('name');
            $type = ORM::factory('Type')->where('name', '=', $name)->find();
            if($this->request->post('action') == 'added'){
                if(empty($type->name)){
                    $type->name   = $name;
                    $type->alias = URL::title($name);
                    $type->save();
                }
                $level_type = ORM::factory('Level_Type');
                $level_type->type_id          = $type->id;
                $level_type->level_id        = $this->request->post('level');
                $level_type->category_id = $this->request->post('category');
                $level_type->save();
            }else{
                $level_type = ORM::factory('Level_Type')
                                                ->where('type_id', '=', $type->id)
                                                ->where('level_id', '=', $this->request->post('level'))
                                                ->where('category_id', '=', $this->request->post('category'))
                                                ->find()
                                                ;

                $level_type->delete();
                $questions_types = ORM::factory('Question')->where('qestion_answer_type_id', '=', $type->id)->find_all();
                foreach($questions_types as $question_type){
                    $question_type->qestion_answer_type_id = 1;
                    $question_type->save();
                }
            }
            Helper_Json_Response::render_json('success', null);
        }else{
            $this->response->status(404);
        }
    }

    public function action_deleteSub()
    {
        $category = ORM::factory('Category', $this->request->param('id'));
        $category->remove('levels', $this->request->param('id2'));
        $level_type = ORM::factory('Level_Type')
                                                ->where('category_id', '=', $this->request->param('id'))
                                                ->where('level_id', '=', $this->request->param('id2'))
                                                ->find()
                                                ;
        $level_type->delete();
        Helper_Alert::setStatus('success');
        Helper_Alert::set_flash('Подтест успешно удален');
        $this->redirect('admin/tests');
    }

    public function action_new()
    {
        if(!$this->request->post() || trim($this->request->post('name')) == '') $this->redirect('admin/tests');
        $category                = ORM::factory('Category');
        $category->name   =  $this->request->post('name');
        $category->alias =  URL::title($this->request->post('name'));
        $category->save();
        Helper_Alert::setStatus('success');
        Helper_Alert::set_flash('Тест ' . $this->request->post('name') . ' успешно добавлен');
        $this->redirect('admin/tests');
    }

    public function action_newSubtest()
    {
        if(!$this->request->post() || trim($this->request->post('name')) == '') $this->redirect('admin/tests');
        $category               = ORM::factory('Category', $this->request->post('category'));
        $alias = URL::title($this->request->post('name'));
        $level = ORM::factory('Level')->where('alias', '=', $alias)->find();
        if(!empty($level->name)){
            $level_id = $level->id;
        }else{
            $level->name   = $this->request->post('name');
            $level->alias = $alias;
            $level->save();
            $level_id = $level->id;
        }
        $category->add('levels', $level_id);
        $level_type               = ORM::factory('Level_Type');
        $level_type->category_id  = $category->id;
        $level_type->type_id      = 1;
        $level_type->level_id     = $level_id;
        $level_type->save();
        $category->save();
        Helper_Json_Response::render_json('success', null, array('level' => array('id' => $level->id, 'name' => $level->name), 'category_id' => $category->id));

    }

    public function action_editNameTest()
    {
        $category = ORM::factory('Category', $this->request->post('id'));
        if($category->name != $this->request->post('name')){
            $category->name = $this->request->post('name');
            $category->save();
        }else{
            Helper_Json_Response::addError('error');
        }
        Helper_Json_Response::render();
    }

    public function action_editNameSubtest()
    {
        $category = ORM::factory('Category', $this->request->post('category'));
        $alias    = URL::title($this->request->post('name'));
        $level    = ORM::factory('Level')->where('alias', '=', $alias)->find();
        if(empty($level->name)){
            $level->name  = $this->request->post('name');
            $level->alias = $alias;
            $level->save();
        }
        if($level->id != $this->request->post('level')){
            $levels_types = ORM::factory('Level_Type')->where('level_id', '=', $this->request->post('level'))->where('category_id', '=', $category->id)->find_all();
            foreach($levels_types as $level_type){
                $level_type->level_id = $level->id;
                $level_type->save();
            }
            $questions = ORM::factory('Question')->where('level_id', '=', $this->request->post('level'))->where('category_id', '=', $category->id)->find_all();
            foreach($questions as $question){
                $question->level_id = $level->id;
                $question->save();
            }
            $category->remove('levels', $this->request->post('level'));
            $category->add('levels', $level->id);
        }else{
            Helper_Json_Response::addError('error');
        }
        Helper_Json_Response::addData(array('name' => $level->name, 'level' => $level->id, 'category' => $category->id));
        Helper_Json_Response::render();
    }
    
    public function action_delete()
    {
        $category = ORM::factory('Category', $this->request->param('id'));
        $category->delete();
        Helper_Alert::setStatus('success');
        Helper_Alert::set_flash('Тест успешно удален');
        $this->redirect('admin/tests');
    }    

    public function action_add()
    {
        Helper_Output::factory()->link_js('public/assets/workspace')
                                ->link_js('admin/tests/question_builder')
                                ->link_js('libs/jquery.validate.min')
                                ->link_js('libs/jquery.ui.widget')
                                ->link_js('libs/jquery.fileupload')
                                ->link_js('libs/jquery.fileupload-ui')
                                ->link_js('libs/jquery.fileupload-fp')
                                ->link_js('libs/bootstrap-modal')
                                ->link_js('libs/popup')
                                ->link_js('admin/tests/add')
                                ;

        $category_id       = $this->request->param('id');
        $level_id          = $this->request->param('id2');
        $data['category']  = ORM::factory('Category', $category_id);
        $data['types']     = ORM::factory('Level_Type')->where('level_id', '=', $level_id)->where('category_id', '=', $category_id)->group_by('type_id')->find_all();
        $data['level']     = ORM::factory('Level', $level_id);
        $data['questions'] = ORM::factory('Question')->where('category_id', '=', $category_id)->where('level_id', '=', $level_id)->order_by('date_created', 'DESC')->find_all();

        $this->setTitle('Tests managment')
             ->view('admin/tests/add', $data)
             ->render()
             ;
    }

    public function action_save_qestion()
    {
        $saved_question   = ORM::factory('Question')->saveQuestion($this->request->post('question'));
        $data['question'] = View::factory('admin/tests/partials/qestion_item')->set('question', $saved_question)->render();
        Helper_Json_Response::render_json('success', null, $data);
    }

    public function action_remove_qestion(){
        if($this->request->headers("x-requested-with")){
            ORM::factory('Question', $this->request->post('question_id'))->delete();
            Helper_Json_Response::render_json('success', null);
        }else{
            $this->response->status(404);
        }
    }

    public function action_get_type_category()
    {
        $categories = ORM::factory('Type')->where('name', 'like', $this->request->post('term').'%')->find_all();
        $result = array();
        foreach ($categories as $key => $category) {
            array_push($result, array('id' => $category->id, 'label' => $key+1, 'value' => $category->name));
        }
        Helper_Json_Response::render_json('success', null, $result);
    }

    public function action_get_form_question()
    {
        if($this->request->headers("x-requested-with")){
            $question = ORM::factory('Question', $this->request->post('question_id'));
            $data['form_question'] = View::factory('admin/tests/partials/question_form')
                                            ->set('category', ORM::factory('Category', $question->category_id))
                                            ->set('types', ORM::factory('Level_Type')->where('level_id', '=', $question->level_id)->where('category_id', '=', $question->category_id)->group_by('type_id')->find_all())
                                            ->set('question', $question)
                                            ->render();
            Helper_Json_Response::render_json('success', null, $data);
        }else{
            $this->response->status(404);
        }
    }

    public function action_move_qestion(){
        if($this->request->headers("x-requested-with")){
            ORM::factory('Question', $this->request->post('question_id'))->set('level_id', $this->request->post('level_id'))->update();
            Helper_Json_Response::render_json('success', null);
        }else{
            $this->response->status(404);
        }
    }

    public function action_errorTestPage()
    {
        die(iconv('utf-8', 'windows-1251', 'Тест можно проходить только один раз'));
    }

    public function action_errorPage()
    {
        die(iconv('utf-8', 'windows-1251', 'Не получится!'));
    }
    
    public function action_generate(){
        $category_id    = $this->request->param('id');
        $level_id       = $this->request->param('id2');
        $question_count = $this->request->query('question_count');
        $category       = ORM::factory('Category', $category_id);
        $level          = ORM::factory('Level', $level_id);
        $questions      = ORM::factory('Question')->generateTestByCategoryAndLevel($category_id, $level_id, $question_count);
        
        if($this->request->query('take') == '1'){
            echo View::factory('admin/tests/generator/mainTake')
                        ->set('category', $category)
                        ->set('count_question', $question_count)
                        ->set('level', $level)
                        ->set('questions', $questions)
                        ->render();
        }else{
            $config = array( 'author'   => 'Lodoss',
                         'title'    => $category->name,
                         'subject'  => $category->name,
                         'name'     => $category->alias.'.pdf',
                       );
            echo View_PDF::factory('admin/tests/generator/mainPdf', $config)
                            ->set('questions', $questions)
                            ->set('category', $category)
                            ->set('level', $level)
                            ->render(NULL, 'admin/tests/generator/answers', $questions)
                            ;
        }
    }
    
    
    
    public function action_resultsTest()
    {
        if($this->request->headers("x-requested-with")){
            $countCorrect = 0;
            if($this->request->post('radio')){
                foreach($this->request->post('radio') as $answer){
                    $correctAnswer = ORM::factory('Question_Answer', $answer);
                    if($correctAnswer->corrected == 1) $countCorrect++;
                }
            }
            if($this->request->post('checkbox')){
                foreach($this->request->post('checkbox') as $key => $checkbox){
                    $countCorrectAnswers = ORM::factory('Question_Answer')->where('question_id', '=', $key)->where('corrected', '=', 1)->count_all();
                    $countAnwers = 0;
                    if(count($checkbox) == $countCorrectAnswers){
                        foreach($checkbox as $answer){
                            $correctAnswer = ORM::factory('Question_Answer', $answer);
                            if($correctAnswer->corrected == 1) $countAnwers++;
                        }
                    }
                    if($countCorrectAnswers == $countAnwers) $countCorrect++;
                }
            }
            $countWrite = 0;
            $texts = '';
            if($this->request->post('write')){
                $countWrite = count($this->request->post('write'));
                $texts = $this->request->post('write');
            }
            echo View::factory('admin/tests/viewResult')
                    ->set('countQuestion', $this->request->post('count_questions') - $countWrite)
                    ->set('countCorrect', $countCorrect)
                    ->set('texts', $texts)
                    ->render()
                    ;
        }else{
            $this->response->status(404);
        }
    }
}