<?php 
	require_once 'config.php'; 
	require_once 'functions.php';
	require_once 'header.php';

	if (isset($argv)) {
		$playlistId = $argv[1];
	}
	else {
		$playlistId = $_GET['playlistId'];
	}
 
	try {
		$stmt = $pdo->prepare('SELECT * FROM playlists WHERE id= :id'); //Search for the ID on DB
		$stmt->execute(array('id' => $playlistId));
	  
		$result = $stmt->fetchAll();
	  
		if ( count($result) ) { //If the ID exists on DB
			$message = "ERROR: The playlist already exists on the database";
		} 
		else { //If the ID doesn't exist on DB
			if (listheader($playlistId, $title, $author)) { //If URL is valid, process the list
				$missingArray=findMissingVideos($playlistId);
				getVideoInfo($missingArray);
				
				$stmt = $pdo->prepare('INSERT INTO playlists VALUES(:id, :author, :title)'); //And store the ID on DB
				$stmt->execute(array(':id' => $playlistId, ':author' => $author, ':title' => $title));
				$message = "Your playlist has been added to the database. Thanks!";
			}
		}
	} 
	catch(PDOException $e) {
		$message = 'ERROR: '.$e->getMessage();
	}
?>  
      	<div id="contents">
		<div class="clearfix">
			<div>
				<h2 style="text-align: center;"><?php  echo $message;?></h2>
			</div>
		</div>
	</div>
  
<?php  require_once 'footer.php';?>
