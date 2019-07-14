<?php
  require_once 'config.php'; 
  require_once 'functions.php';
  
  require_once 'header.php';
  
  $videoId = $_GET['videoId'];
  $title = NULL; 
  $description = NULL;
  $thumbnail = NULL;
?>  
      	<div id="contents">
		<div class="clearfix">
			<div>
<?php 
	videodetails($videoId, $title, $description, $thumbnail);
	if ($message == NULL) {
		echo "<h1>$title</h1>";
		echo '<img style="float: right; padding: 20px" src="'.$thumbnail.'" />';
		echo "<p>$description</p>";
	}
	else
	{
		echo '<h2 style="text-align: center;">'.$message.'</h2>';
	}
?> 
			</div>
		</div>
	</div>
  
<?php   require_once 'footer.php';?> 
