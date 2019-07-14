<?php require_once 'header.php'; ?>
	<div id="contents">
		<div id="about">
			<h1>FAQ</h1>
			<h2>What's IndexTube?</h2>
			<p>
                If you are a YouTube user, I am sure that more than once you have found that when reviewing your video lists, your favorites or your "Liked videos", one of the videos had been deleted and instead of the list there was just one blank thumbnail together with the title [Video removed]. The most annoying of all this is that YouTube does not give you any information of what was the video in question, so in the end you are left wondering what is lost. IndexTube is an attempt to solve this problem.
			</p>
			<h2>How does IndexTube work?</h2>
			<p>
				IndexTube does not have a complete database of all YouTube videos and depends on the contributions of the users. IndexTube has a list of playlist IDs and reviews them each night for new videos to add to the database. If you want to make sure that the videos that you have in your playlists are indexed by IndexTube to be able to query the database when a video is deleted, you simply have to go to the "Add videos" section and fill in the form with the ID of the playlist you want IndexTube to watch. Once you do, IndexTube will add the list ID to the database and check every night to see if there are new videos.
			</p>
			<h2><a name="videoid">How do I get the video ID?</a></h2>
			<p>To find out the ID of a video, you simply need to have the URL of the video, which will be something like this:</p>
			<p>http://www.youtube.com/watch?v=QH2-TGUlwu4<br />
			http://www.youtube.com/watch?v=QH2-TGUlwu4&amp;feature=relmfu<br />
			http://www.youtube.com/v/QH2-TGUlwu4?version=3&amp;autohide=1<br />
			http://youtu.be/QH2-TGUlwu4</p>
			<p>Using the above URL as an example, in all of them the video ID is <strong>QH2-TGUlwu4</strong></p>
			<h2><a name="playlistid">How do I get the playlist ID?</a></h2>
			<p>To find out the ID of a playlist, open any video in the playlist you want to know the ID of and look at the URL of the video, which will look something like this:</p>
			<p>http://www.youtube.com/watch?v=q0sAL8oKPAc&amp;list=PLCFB812ECE4FAE364</p>
			<p>The ID of the list in this example is <strong>PLCFB812ECE4FAE364</strong></p>
		</div>
	</div>
<?php require_once 'footer.php'; ?>
