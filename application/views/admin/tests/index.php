<script type="text/template" id="subtest-template">
    <tr data-level="<%= level.id %>" class="subTest">
        <td>
            <div><%= level.name %></div>
            <br>
            <form action="#">
                <fieldset>
                    <div class="clearfix">
                        <label>Categories:</label>
                        <div class="input">
                            <ul class="categories-select" class="fake-input" tabindex="1">
                                <li class="old general">General</li>
                            </ul>
                        </div>
                    </div>
                </fieldset>
            </form>
        </td>
        <td class="editcolumn">
            <a href="<?php echo URL::site()?>admin/tests/add/<%= category_id %>/<%= level.id %>" class="btn btn-mini">edit test</a>
        </td>
        <td class="editcolumn">
            <form class="deleteSubTest" action="<?php echo URL::site()?>admin/tests/deletesub/<%= category_id %>/<%= level.id %>">
                <input type="submit" value="remove" onclick="javascript: return confirm('Удалить подтест?')" class="btn btn-mini delete-subtest">
            </form>
        </td>
        <td class="generatecolumn">
            <form action="<?php echo URL::site()?>admin/tests/generate/<%= category_id %>/<%= level.id %>" method="GET" target="_blank">
                <input type="text" class="input-small" name="question_count" value="0">
            </form>
        </td>
    </tr>
</script>

<script type="text/template" id="edit-name-test">
    <form style="margin-top:10px; margin-bottom:10px" class="form-inline editNameTest" action="<?php echo URL::site()?>admin/tests/editNameTest" method="POST">
        <input type="text" name="name" class="input-medium edit-name" value="<%= el.text %>">
        <input type="hidden" name="id" value="<%= el.id %>">
        <button type="submit" class="btn btn-primary">Edit</button>
    </form>
</script>

<script type="text/template" id="edit-name-subtest">
    <form style="margin-top:10px; margin-bottom:10px" class="form-inline editNameSubtest" action="<?php echo URL::site()?>admin/tests/editNameSubtest" method="POST">
        <input type="text" name="name" class="input-medium edit-name" value="<%= text %>">
        <input type="hidden" name="level" value="<%= level %>">
        <input type="hidden" name="category" value="<%= category %>">
        <button type="submit" class="btn btn-primary">Edit</button>
    </form>
</script>

<form class="form-inline newTest" action="<?php echo URL::site() . 'admin/tests/new'?>" method="POST">
  <input type="text" name="name" class="input-medium" placeholder="Название нового теста">
  <button type="submit" class="btn btn-primary" disabled>Add New Test</button>
</form>
<?php foreach ($categories as $category): ?>
    <h3 data-id="<?php echo $category->id?>"><?php echo $category->name ?></h3>
    <form action="<?php echo URL::site() . 'admin/tests/delete/' . $category->id?>" class="deleteTest">
        <input value="×" type="submit" class="close"  onclick="javascript: return confirm('Удалить тест?')" style="margin-top: -34px; margin-left: 880px"data-dismiss="modal" aria-hidden="true">
    </form>
    <table class="table table-bordered table-striped" data-category="<?php echo $category->id?>">
        <tbody>
            <?php if(count($category->getLevels()) != 0):?>
                <?php foreach ($category->getLevels() as $key => $level): ?>
                    <tr data-level="<?php echo $level->id?>" class="subTest">
                        <td>
                            <div data-category="<?php echo $category->id ?>" class="subtest-name"><?php echo $level->name ?></div>
                            <br>
                            <form action="#">
                                <fieldset>
                                    <div class="clearfix">
                                        <label>Categories:</label>
                                        <div class="input">
                                            <ul class="categories-select" class="fake-input" tabindex="1">
                                                <?php $typesCateg = ORM::factory('Level_Type')->where('level_id', '=', $level->id)->where('category_id', '=', $category->id)?>
                                                <?php foreach($typesCateg->find_all() as $value):?>
                                                    <?php $type = ORM::factory('Type', $value->type_id)?>
                                                    <li class="old <?php echo $type->name == 'General' ? 'general' : ''?>"><?php echo $type->name?></li>
                                                <?php endforeach;?>
                                            </ul>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </td>
                        <td class="editcolumn"><a href="<?php echo URL::site('admin/tests/add/'.$category->id.'/'.$level->id) ?>" class="btn btn-mini link-url">edit test</a></td>
                        <td class="editcolumn">
                            <form class="deleteSubTest" action="<?php echo URL::site('admin/tests/deletesub/'.$category->id.'/'.$level->id) ?>">
                                <input type="submit" value="remove" onclick="javascript: return confirm('Удалить подтест?')" class="btn btn-mini delete-subtest">
                            </form>
                        </td>
                        <td class="generatecolumn">
                            <form class="generateSubTest" action="<?php echo URL::site('admin/tests/generate/'.$category->id.'/'.$level->id) ?>" method="GET" target="_blank">
                                <?php $questions = ORM::factory('Question')->where('category_id', '=', $category->id)->where('level_id', '=', $level->id)->count_all()?>
                                <input type="text" class="input-small" name="question_count" value="<?php echo $questions?>">
                                <?php if($questions != 0):?>
                                <input type="hidden" name="take" value="1">
                                <input type="button" class="btn take generate" value="Generate Test">
                                <input type="button" class="btn take" value="Take Test">
                                <?php endif;?>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else:?>
                <tr>
                    <td>No Subtests</td>
                    <td style="border-left: #f9f9f9"></td>
                    <td style="border-left: #f9f9f9"></td>
                    <td style="border-left: #f9f9f9"></td>
                </tr>
            <?php endif;?>
            <tr>
                <td>
                    <form class="form-inline newSubTest" action="<?php echo URL::site() . 'admin/tests/newSubtest'?>" method="POST">
                        <input type="text" name="name" class="input-big" placeholder="Название нового подтеста">
                        <button type="submit" class="btn btn-primary" disabled>Add New Subtest</button>
                        <input type="hidden" name="category" value="<?php echo $category->id?>">
                    </form>
                </td>
                <td style="border-left: none"></td>
                <td style="border-left: none"></td>
                <td style="border-left: none"></td>
            </tr>
        </tbody>
    </table>
<?php endforeach; ?>