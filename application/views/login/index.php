<?php if(!empty($error)):?>
<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>Ошибка!</strong> <?php echo $error?>
</div>
<?php endif;?>
<div class="login">
        <form action="" method="POST">
                <div><input type="text" name="username" id="login" placeholder="Login"></div>
                <div><input type="password" name="password" id="password" placeholder="Password"></div>
                <div><input class="btn" type="submit" value="Login"></div>
        </form>
</div>