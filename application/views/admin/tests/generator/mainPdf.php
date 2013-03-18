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
        <h3>Test <?php echo Helper_Main::replaceCyrillicSymbolsForPdf($category->name)?> level <?php echo Helper_Main::replaceCyrillicSymbolsForPdf($level->name)?></h3>
        <?php if($questions): ?>
        <form name="form1">
            <div class="questions">
                <?php foreach ($questions as $key => $value): ?>
                    <?php $question = ORM::factory('Question', $value);?>
                    <div class="question" style="margin-bottom: 30px">
                        <div class="questiontext">
                            <div class="quest" style="margin-bottom: 10px">
                                <strong><?php echo '№'.($key+1) ?></strong>
                            </div>
                            <div class="quest text" style="width: 600px;">
                                <?php echo Helper_Main::convertStringForPdf($question->text);?>
                            </div>
                            <?php if($question->image): ?>
                                <div class="quest">
                                    <img width="378px" src="<?php echo $question->getImage() ?>">
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php $answers  = $question->qestion_answers->find_all()?>
                    <?php if(count($answers) > 0):?>
                        <ol class="answerss">
                            <?php foreach ($answers as $answer ): ?>
                                <li>
                                    <?php echo $question->type == 'radio' ? '&#9675;' : '&#9643;'?>
                                    <?php echo Helper_Main::convertStringForPdf($answer->text); ?>
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
        </form>
        <?php endif; ?> 
    </body>    
</html>