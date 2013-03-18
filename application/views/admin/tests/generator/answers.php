<h3>Ответы</h3>
<ul style="list-style-type: none">
    <?php foreach($questions as $key => $question_id):?>
        <?php $question = ORM::factory('Question', $question_id)?>
        <?php if($question->type != 'write'):?>
            <li>
                <?php $number = $key + 1?>
                <div style="margin-left: 20px; margin-bottom: 5px;">
                    <div><strong>№<?php echo $number ?></strong></div>
                    <div>
                        <?php echo Helper_Main::convertStringForPdf($question->text);?>
                    </div>
                </div>
                <?php $answers  = $question->qestion_answers->where('corrected', '=', 1)->find_all()?>
                <?php if(count($answers) > 0):?>
                    <?php foreach($answers as $answer):?>
                        <div style="margin-left: 30px">
                            <?php echo $question->type == 'radio' ? '&#9679;' : '&#9642;'?> <?php echo htmlspecialchars(Helper_Main::replaceCyrillicSymbolsForPdf($answer->text))?>
                        </div>
                    <?php endforeach;?>
                <?php endif;?>
                <div style="margin-bottom: 20px"></div>
            </li>
        <?php endif;?>
    <?php endforeach; ?>
</ul>