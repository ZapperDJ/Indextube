<?php
	require_once 'config.php'; 
	require_once 'functions.php'; 
	set_time_limit(0);
  
	try {
		$stmt = $pdo->prepare('SELECT * FROM playlists');
		$stmt->execute();
  
		$result = $stmt->fetchAll();
  
		if ( count($result) ) {
			foreach($result as $row) {
				$missingArray=findMissingVideos($row['id']);
				if (count($missingArray)) {
					getVideoInfo($missingArray);
					echo "Feed parsed: $title by $author\n";
				}
				else 
				{
					//echo "Up to date";
				}
			}  
		} 
		else {
			echo "No rows returned.";
		}
	} 
	catch(PDOException $e) {
		echo 'ERROR: ' . $e->getMessage();
	}
?>
