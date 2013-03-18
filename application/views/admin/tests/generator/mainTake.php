<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" type="text/css" href="<?php echo URL::site() ?>css/test-style.css" media="all" />
    <meta charset="utf-8">
    <title><?php echo $category->name?> <?php echo $level->name?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <script type="text/javascript">
        SYS = { baseUrl: '<?php echo URL::base(); ?>'};
    </script>
    <style>
        .text-error {
            color: #B94A48;
        }
    </style>
  </head>
    <body>
        <?php if($questions): ?>
        <form name="takeTest" id="takeTest" action="<?php echo URL::site('admin/tests/resultsTest')?>" method="POST">
            <input type="hidden" name="count_questions" value="<?php echo count($questions)?>">
            <h3>Test <?php echo $category->name?> level <?php echo $level->name?></h3>
            <div class="questions">
                <?php foreach ($questions as $key => $value): ?>
                    <?php $question = ORM::factory('Question', $value);?>
                    <div class="question">
                        <div class="questiontext">
                            <span class="quest"><?php echo '№'.($key+1) ?></span>    
                            <div class="quest text" style="width: 500px">
                                <pre><?php echo htmlspecialchars($question->text) ?></pre>
                            </div>
                            <?php if($question->image): ?>
                                <div class="quest"><img width="378px" src="<?php echo $question->getImage() ?>"></div>
                            <?php endif; ?>
                        </div>
                    <?php $answers  = $question->qestion_answers->find_all()?>
                    <?php if(count($answers) > 0):?>
                        <ol class="answers">
                            <?php foreach ($answers as $answer ): ?>
                                <li>
                                    <pre><input type="<?php echo $question->type ?>" name="<?php echo $question->type.'['.$question->id.']'?><?php echo $question->type == 'checkbox' ? '[]' : ''?>" value="<?php echo $answer->id ?>"><?php echo htmlspecialchars($answer->text) ?></pre>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    <?php else:?>
                        <li style="list-style-type: none;">
                            <textarea style="margin: 2px; width: 502px; height: 115px" name="<?php echo $question->type.'['.$question->id.']'?>"></textarea>
                        </li>
                    <?php endif;?>
                    </div>
                <?php endforeach; ?>
                <input type="submit" value="View Result">
            </div>
        </form>
        <?php endif; ?>
        <script type="text/javascript" src="<?php echo URL::site() ?>js/libs/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" src="<?php echo URL::site() ?>js/libs/jquery.form.js"></script>
        <script>
            $('#takeTest').on('submit', function(e) {
                  e.preventDefault(); 
                  $(this).ajaxSubmit({
                      target: 'body'
                  })
            });
        </script>
    </body>
</html>