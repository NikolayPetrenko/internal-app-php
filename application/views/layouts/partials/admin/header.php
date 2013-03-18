<div id="nav-menu" class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container-fluid">
      <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>
        <a class="brand" href="<?php echo URL::site() ?>">Lodoss Tests</a>
      <div class="nav-collapse collapse">
        <p class="navbar-text pull-right" style="margin-left: 20px;">
            <a href="<?php echo URL::site() . 'login/logout'?>" class="navbar-link">Logout</a>
        </p>
        <p class="navbar-text pull-right">
            Logged in as <a href="#" class="navbar-link"><?php echo Auth::instance()->get_user()->username?></a>
        </p>
        <ul class="nav"> <?php echo Helper_Menu_Admin::render() ?>  </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>
</div>