<?php if(!empty($countQuestion)):?>
    <p>Результат: <strong><?php echo round($countCorrect * 100 / $countQuestion) . '%'?></strong> (<strong><?php echo $countCorrect?></strong> из <strong><?php echo $countQuestion?></strong>)</p>
<?php endif;?>
<?php if(!empty($texts)):?>
    <p>Письменные ответы: </p>
    <ul class="answersText">
    <?php foreach ($texts as $key => $answer):?>
        <li>
            <?php $question = ORM::factory('Question', $key);?>
            <p><strong><?php echo htmlspecialchars($question->text)?></strong></p>
            <?php echo !empty($answer) ? '<p>' . htmlspecialchars($answer) : '<p class="text-error">Нет ответа'?></p>
        </li>
    <?php endforeach;?>
    </ul>
<?php endif;?>