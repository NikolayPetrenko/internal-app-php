<?php echo View::factory('admin/tests/partials/question_modal')->render() ?>
<ul class="pager">
  <li class="previous">
    <a href="<?php echo URL::site() . 'admin/tests/'?>">&larr;Back</a>
  </li>
</ul>
<h3><?php echo $level->name ?> <?php echo $category->name ?></h3>
<div class="edittest">
        <section class="add_q">
                <form action="#" id="question-form">
                        <input type="hidden" name="question[category_id]" value="<?php echo $category->id ?>">
                        <input type="hidden" name="question[level_id]" value="<?php echo $level->id ?>">
                        <input type="hidden" name="question[image]" value="">
                        
                        <div class="box">
                                <select name="question[type]" class="qestion-type">
                                        <option value="write">Письменный ответ</option>
                                        <optgroup label="Много вариантов">
                                            <option selected value="radio">Radio</option>    
                                            <option value="checkbox">Checkbox</option>
                                        </optgroup>
                                </select>
                        </div>
                        
                        <div class="row">
                                <div class="span8 control-group">
                                    <textarea class="question" name="question[text]" id="" cols="30" rows="10"></textarea>
                                </div>
                                <div class="span3">
                                    
                                        <div>
                                                <select name="question[qestion_answer_type_id]" id="">
                                                    <?php foreach ($types as $value): ?>
                                                        <?php $type = ORM::factory('Type', $value->type_id)?>
                                                        <option value="<?php echo $type->id ?>"><?php echo $type->name ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                        </div>

                                        <div>
                                                <input class="question-upload" type="file" name="file" value="Добавить картинку">
                                                <img class="question-img-container" width="185px" src="">
                                        </div>
                                </div>
                        </div>
                                <div class="ta_controls">
                                        <div class="box">
                                            <a class="add-answer btn">Добавить вариант ответа</a>
                                        </div>
                                </div>
                        <section class="testanswers">
                            
                                <div class="answers_container">
                                    <div class="row">
                                            <div class="span8 control-group"><textarea class="qopt" name="question[answers][0][text]" id="" cols="30" rows="10"></textarea></div>
                                            <div class="span3"><span class="btn btn-mini remove-answer">Удалить</span><label><input class="correct-answers" value="1"  type="radio"> Правильный ответ</label></div>
                                    </div>
                                    <div class="row">
                                            <div class="span8 control-group"><textarea class="qopt" name="question[answers][1][text]" id="" cols="30" rows="10"></textarea></div>
                                            <div class="span3"><span class="btn btn-mini remove-answer">Удалить</span><label><input class="correct-answers" value="1"  type="radio"> Правильный ответ</label></div>
                                    </div>
                                </div>    
                            
                        </section>
                                <div class="ta_controls" style="height: 40px">
                                        <div class="box">
                                            <input type="submit" style="margin-right: 265px" class="btn btn-success pull-right" value="Добавить вопрос">
                                        </div>
                                </div>
                </form>
        </section>
    
        <?php if($questions): ?>
            <section class="questions">
                    <?php foreach ($questions as $question): ?>
                        <?php echo View::factory('admin/tests/partials/qestion_item')->set('question', $question)->render() ?>
                    <?php endforeach; ?>
            </section>
       <?php endif; ?>     
</div>
