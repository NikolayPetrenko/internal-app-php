<div class="question" data-id="<?php echo $question->id ?>">
        <div class="questiontext">
            <pre class="quest"><?php echo htmlspecialchars($question->text) ?></pre>
            <?php if($question->image): ?>
            <pre class="quest"><img width="20%" height="20%" src="<?php echo $question->getImage() ?>"></pre>
            <?php endif; ?>
        </div>
        <ol class="answers">
                <?php foreach ($question->qestion_answers->find_all() as $answer ): ?>
                <li>
                    <div>
                        <input disabled="disabled" <?php echo $answer->corrected ? "checked" : "" ?> type="<?php echo $question->type ?>">
                    </div>
                    <pre><?php echo htmlspecialchars($answer->text) ?></pre>
                </li>
                <?php endforeach; ?>
        </ol>
        <?php echo View::factory('admin/tests/partials/qestion_controls')->set('question', $question)->render() ?>
</div>