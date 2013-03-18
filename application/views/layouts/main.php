<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<title><?php echo $title ?></title>
	<meta charset="UTF-8">
	<script type="text/javascript">
		var SYS = {
			baseUrl : '<?php echo URL::base() ?>'
		}
	</script>
	<?php echo Helper_Output::renderCss(); ?>
</head>
<body style="width: 500px; margin: 0 auto; padding-top: 20px;">
       <?php echo View::factory('layouts/partials/header')->render(); ?>
    <div class="container-fluid">
        <div class="row-fluid">
          <?php echo Helper_Alert::render(); ?>
          <?php echo  $content; ?> 
        </div>    
      </div
       <?php echo View::factory('layouts/partials/footer')->render(); ?>
       <?php echo Helper_Output::renderJs(); ?>
</body>
</html>