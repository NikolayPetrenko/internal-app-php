<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <script type="text/javascript">
      SYS = { baseUrl: '<?php echo URL::base(); ?>' };
    </script>
    
    <?php echo Helper_Output::renderCss(); ?>
    
    <!-- Le styles -->
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }
    </style>
    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>
    <?php echo View::factory('layouts/partials/admin/header')->render(); ?>
<!--      <div id="main-content" class="container-fluid"> <?php //echo Helper_Alert::render(); ?> <?php //echo  $content; ?> </div>-->
      <div class="main" >
          <?php echo Helper_Alert::render(); ?>
          <?php echo  $content; ?> 
      </div
      <hr/>
    <?php echo View::factory('layouts/partials/admin/footer')->render(); ?>
    <?php echo Helper_Output::renderJS()  ?>
  </body>
  
</html>
