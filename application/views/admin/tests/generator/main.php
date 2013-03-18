<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="<?php echo URL::site() ?>css/test-style.css" media="all" />
    <meta charset="utf-8">
    <title><?php echo $category->name?> <?php echo $level->name?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
  </head>
    <body>
        <?php if($questions): ?>
            <h3>Test <?php echo $category->name?> level <?php echo $level->name?></h3>
            <div class="questions">
                    <?php foreach ($questions as $key => $question): ?>
                        <div class="question">
                            <div class="questiontext">
                                <span class="quest"><?php echo '№'.($key+1) ?></span>    
                                <span class="quest text"><pre><?php echo htmlspecialchars($question->text) ?></pre></span>
                                <?php if($question->image): ?>
                                    <span class="quest"><img width="378px" src="<?php echo $question->getImage() ?>"></span>
                                <?php endif; ?>
                            </div>
                        <?php $answers  = $question->qestion_answers->find_all()?>
                        <?php if(count($answers) > 0):?>
                            <ol class="answers">
                                <?php foreach ($answers as $answer ): ?>
                                    <li>
                                        <pre><input disabled="disabled" type="<?php echo $question->type ?>"><?php echo htmlspecialchars($answer->text) ?></pre>
                                    </li>
                                <?php endforeach; ?>
                            </ol>
                        <?php else:?>
                            <div class="stripe">
                                <hr noshade size="0.1px">
                                <hr noshade size="0.1px">
                                <hr noshade size="0.1px">
                                <hr noshade size="0.1px">
                                <hr noshade size="0.1px">
                            </div>
                        <?php endif;?>
                        </div>
                    <?php endforeach; ?>
            </div>
        <?php endif; ?> 
    </body>    
</html>