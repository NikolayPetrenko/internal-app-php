<div class="controls">
    <span class="label">Category: <?php echo $questions = ORM::factory('Type', $question->qestion_answer_type_id)->name ?></span>
    <span class="label"><?php echo '#'.$question->id ?></span>
    <div class="btn-group">
        <button class="btn btn-small"  onclick="javascript:qestion.showModal(<?php echo $question->id ?>)">Edit</button>
        <button class="btn btn-small dropdown-toggle" data-toggle="dropdown">
        <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="javascript:void(0)" onclick="javascript:qestion.remove(<?php echo $question->id ?>, this)">Delete</a></li>
            <li class="divider"></li>
            <?php foreach ($question->getExclusionLevels() as $value): ?>
                <?php $level = ORM::factory('Level', $value->level_id)?>
                <li><a href="javascript:void(0)" onclick="javascript:qestion.move(<?php echo $question->id ?>, <?php echo $level->id ?>, this)" >Move to <?php echo $level->name ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>