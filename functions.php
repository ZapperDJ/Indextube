<?php

	function urlExists($url=NULL)  {  
        if($url == NULL) return false;  
        $ch = curl_init($url);  
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);  
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
        $data = curl_exec($ch);  
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
        curl_close($ch);   
        if($httpcode>=200 && $httpcode<300){  
            return true;  
        } else {  
            return false;  
        }  
	} 
  
	function videodetails($videoId, &$title, &$description, &$thumbnail) {
		global $pdo;
		global $message;

		try {
			$stmt = $pdo->prepare('SELECT * FROM videos WHERE id= :id');
			$stmt->execute(array('id' => $videoId));
			  
			$result = $stmt->fetchAll();
			  
			if ( count($result) ) {
				foreach($result as $row) {
					$title=$row[title];
					$description=nl2br($row[description]);
					$thumbnail = "thumbs/".$videoId.".jpg";
				}  
			} 
			else {
				$message = "The video doesn't exist on the database.";
			}
		} 
		catch(PDOException $e) {
		  $message = 'ERROR: '.$e->getMessage();
		}
	}
  
  
	function findMissingVideos($playlistId) {
		global $pdo;
		global $message;
		global $youtubeapikey;
		
		
		try {
			$stmt = $pdo->prepare('SELECT id FROM videos');
			$stmt->execute();
			$result = $stmt->fetchAll();
  
			$maxResults = 50;
			$jsonUrl = 'https://www.googleapis.com/youtube/v3/playlistItems?part=contentDetails&playlistId='.$playlistId.'&maxResults='.$maxResults.'&fields=items%2FcontentDetails%2CnextPageToken%2CpageInfo&key='.$youtubeapikey;  
			set_time_limit(0);
			
			
			if (urlExists($jsonUrl)) {
				$str_obj_json = file_get_contents($jsonUrl); //Load first results page
				$obj_php = json_decode($str_obj_json);
				$nextPageToken = $obj_php->nextPageToken; //Get total number of videos on the playlist			

				do { //While last playlist item is not reached...
					foreach ($obj_php->items as $item) { //Loop items array
						$videoId = $item->contentDetails->videoId;
		  
						if (!in_array($videoId, $result)) { //If the video thumbnail doesn't exist on the server   
							$missingIds[] = $videoId; //Add video ID to the array of IDs not present on the DB
						}
						echo "p";
					}
					$jsonUrl = 'https://www.googleapis.com/youtube/v3/playlistItems?part=contentDetails&playlistId='.$playlistId.'&maxResults='.$maxResults.'&fields=items%2FcontentDetails%2CnextPageToken%2CpageInfo&key='.$youtubeapikey.'&pageToken='.$nextPageToken;
					if (urlExists($jsonUrl)){
						$str_obj_json = file_get_contents($jsonUrl); //Load next results page
						$obj_php = json_decode($str_obj_json);
						$nextPageToken = $obj_php->nextPageToken;
					}
					else
					{
						$nextPageToken = NULL;
					}
					echo "o";
				} while ($nextPageToken != NULL);
				return $missingIds;
			}
			else {
				$message = 'El ID de lista de reproducción no es válido';
				return false;
			}
		} 
		catch(PDOException $e) {
			$message = 'ERROR: ' . $e->getMessage();
		}

		
	   

	}
  

	function listheader($playlistId, &$title, &$author) {
		global $pdo;
		global $message;
		global $youtubeapikey;

		$jsonUrl = 'https://www.googleapis.com/youtube/v3/playlists?part=snippet&id='.$playlistId.'&fields=items%2Fsnippet(title%2CchannelTitle)&key='.$youtubeapikey;
		$str_obj_json = file_get_contents($jsonUrl);
		$obj_php = json_decode($str_obj_json);

		if (count($obj_php->items)) {
			$title = $obj_php->items[0]->snippet->title;
			$author = $obj_php->items[0]->snippet->channelTitle;
			return true;
		}
		else {
			$message = 'The playlist ID is not valid, or the list is private';
			return false;
		}
    }
  
  
	function getVideoInfo($idArray) {
		global $pdo;
		global $message;
		global $youtubeapikey;
		

		
	   
		$currentdir = dirname(__FILE__);
		$maxResults = 50;
		$videoPosition = 1;
		$jsonUrl = 'https://www.googleapis.com/youtube/v3/playlistItems?part=contentDetails&playlistId='.$playlistId.'&maxResults='.$maxResults.'&fields=items%2FcontentDetails%2CnextPageToken%2CpageInfo&key='.$youtubeapikey;  
	   
		
		set_time_limit(0);
		
		if (urlExists($jsonUrl)) {
			$str_obj_json = file_get_contents($jsonUrl); //Load the first results page
			$obj_php = json_decode($str_obj_json);
			$itemCount = (int) $obj_php->pageInfo->totalResults; //Get total number of videos on the playlist     

			$log = fopen($currentdir."/logs/log".date("Y-m-d").".txt","a+"); //Open log file
			fwrite($log,"Playlist: ".$playlistId."\n");

			while ($videoPosition < $itemCount) { //While last playlist item is not reached...
				foreach ($obj_php->items as $item) { //Loop items array
					$title = $item->snippet->title;
					$description = $item->snippet->description;
					$videoId = $item->snippet->resourceId->videoId;
					$videoPosition = (int) $item->snippet->position + 1;
					$thumbnail = "http://img.youtube.com/vi/".$videoId."/0.jpg";

					fwrite($log, $videoPosition." ---> ".$title."\n");    
					if (!file_exists($currentdir."/thumbs/".$videoId.".jpg")) { //If the video thumbnail doesn't exist on the server  
						try {
							//Store info on DB
							$stmt = $pdo->prepare('INSERT INTO videos VALUES(:id, :title, :description)');
							$stmt->execute(array(':id' => $videoId, ':title' => $title, ':description' => $description));

							//Save thumbnail to server
							//Start connection
							$conexion = curl_init ($thumbnail);
							//Set cURL options
							curl_setopt($conexion, CURLOPT_HEADER, 0);
							curl_setopt($conexion, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($conexion, CURLOPT_BINARYTRANSFER, 1);
							//Execute and finish connection
							$rawdata=curl_exec ($conexion);
							curl_close ($conexion);
							//Save connection result to file
							$archivo = fopen($currentdir."/thumbs/".$videoId.".jpg",'w');
							fwrite($archivo, $rawdata);
							fclose($archivo);    
						} 
						catch(PDOException $e) {
							$message = 'ERROR: '.$e->getMessage();
						}
					}
				}
				$nextPageToken = $obj_php->nextPageToken;
				$jsonUrl = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId='.$playlistId.'&maxResults='.$maxResults.'&key='.$youtubeapikey.'&pageToken='.$nextPageToken;
				if (urlExists($jsonUrl)){
					$str_obj_json = file_get_contents($jsonUrl); //Load next results page
					$obj_php = json_decode($str_obj_json);
				}
				else
				{
					$videoPosition = $itemCount;
				}
			}
			fclose($log);
			return true;
		}
		else {
			$message = 'The playlist ID is not valid';
		return false;
		}
	}
?>
  
