<?php
include_once 'template.php';
require_once 'classes/application_config.php';
?>

<div id="common-home" class="container">
  <p></p>
	<div class="row">
		<div id="content" class="col-sm-12">
		
		</div>
	</div>
</div>

<script>
    register('<?php echo $_SERVER['REQUEST_URI']; ?>');
</script>

<?php include_once 'footer.php'; ?>