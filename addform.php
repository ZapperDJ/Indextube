<?php require_once 'header.php'; ?>
    	<div id="contents">
		<div class="clearfix">
			<div>
				<h2>Add videos</h2>
				<p>Type the ID for the playlist you want to add. If you don't know how to get the playlist ID <a href="faq.php#playlistid">click here</a></p>
				<h3>LIMITATIONS:</h3>
				<ul>
				  <li>IndexTube doesn't work with private lists</li>
				  <li>IndexTube doesn't work with the "History" list, bacause it's private</li>
				</ul>
				<form name="addplaylist" action="addplaylist.php" method="get">
					Playlist ID  <input type="text" name="playlistId" />
					<a href="javascript: document.addplaylist.submit()" class="btn">Add</a>
				</form> 

			</div>
		</div>
	</div>	
<?php require_once 'footer.php'; ?>

