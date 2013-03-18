                <section class="add_q">
                        <input type="hidden" name="question[category_id]" value="<?php  echo $question->category_id ?>">
                        <input type="hidden" name="question[level_id]" value="<?php  echo $question->level_id ?>">
                        <input type="hidden" name="question[image]" value="<?php echo $question->image?>">
                        <input type="hidden" name="question[id]" value="<?php echo $question->id?>">
                        
                        <div class="box">
                                <select name="question[type]" class="qestion-type">
                                        <option <?php echo $question->type == 'write' ? 'selected ' : ''?> value="write">Письменный ответ</option>
                                        <optgroup label="Много вариантов">
                                            <option <?php echo $question->type == 'radio' ? 'selected ' : ''?> value="radio">Radio</option>    
                                            <option <?php echo $question->type == 'checkbox' ? 'selected ' : ''?> value="checkbox">Checkbox</option>
                                        </optgroup>
                                </select>
                        </div>

                        <div class="row">
                                <div class="span8 control-group">
                                    <textarea class="question" name="question[text]" id="" cols="30" rows="10"><?php echo !empty($question->text) ? $question->text : ''?></textarea>
                                </div>
                                <div class="span3">

                                        <div>
                                            <select name="question[qestion_answer_type_id]" id="">
                                                <?php foreach ($types as $value): ?>
                                                    <?php $type = ORM::factory('Type', $value->type_id)?>
                                                    <option <?php echo $type->id == $question->qestion_answer_type_id ? 'selected' : ''?> value="<?php echo $type->id ?>"><?php echo $type->name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div>
                                                <input class="question-upload" type="file" name="file" value="Добавить картинку">
                                                <img class="question-img-container" width="185px" src="<?php echo !empty($question->image) ? $question->getImage() : ''?>">
                                                <?php if(!empty($question->image)):?>
                                                    <button type="button" class="close delete-image" aria-hidden="true">×</button>
                                                <?php endif;?>
                                        </div>
                                </div>
                        </div>

                        <section class="testanswers"  style="<?php echo $question->type == 'write' ? 'display: none' : ''?>">
                                <div class="ta_controls">
                                        <div class="box"><a class="add-answer btn">Добавить вариант ответа</a></div>
                                </div>
                            <?php if($question->type == 'write'):?>
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
                            <?php else:?>
                                <div class="answers_container">
                                    <?php foreach ($question->qestion_answers->find_all() as $key => $answer ): ?>
                                        <div class="row">
                                            <div class="span8 control-group"><textarea class="qopt" name="question[answers][<?php echo $key ?>][text]" id="" cols="30" rows="10"><?php echo $answer->text?></textarea></div>
                                            <div class="span3"><span class="btn btn-mini remove-answer">Удалить</span><label><input class="correct-answers" value="1"  <?php echo $answer->corrected == 1 ? 'checked' : ''?> type="<?php echo $question->type?>"> Правильный ответ</label></div>
                                        </div>
                                    <?php endforeach;?>
                                </div>    
                            <?php endif;?>
                        </section>
        </section>