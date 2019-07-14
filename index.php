<?php require_once 'header.php'; ?>
    	<div id="contents">
		<div class="clearfix">
			<div>
				<h2>Video search</h2>
				<p>Type the video ID on the search box. If you don't know the video ID, <a href="faq.php#videoid">click here</a></p>	
				<form name="searchForm" action="showvideo.php" method="get">
					Vídeo ID<input type="text" name="videoId" />
					<a href="javascript: document.searchForm.submit()" class="btn">Search</a>
				</form> 

			</div>
		</div>
	</div>
	
<?php require_once 'footer.php'; ?>

