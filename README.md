# Indextube #

## What's IndexTube? ##

If you are a YouTube user, I am sure that more than once you have found that when reviewing your video lists, your favorites or your "Liked videos", one of the videos had been deleted and instead of the list there was just one blank thumbnail together with the title [Video removed]. The most annoying of all this is that YouTube does not give you any information of what was the video in question, so in the end you are left wondering what is lost. IndexTube is an attempt to solve this problem.

## How does IndexTube work? ##

IndexTube does not have a complete database of all YouTube videos and depends on the contributions of the users. IndexTube has a list of playlist IDs and reviews them each night for new videos to add to the database. If you want to make sure that the videos that you have in your playlists are indexed by IndexTube to be able to query the database when a video is deleted, you simply have to go to the "Add videos" section and fill in the form with the ID of the playlist you want IndexTube to watch. Once you do, IndexTube will add the list ID to the database and check every night to see if there are new videos.

## Installation ##

Create a database and import indextube.sql to reate de database structure
Fill config.php with database connection details and YouTube API Key
Edit crontask.sh and change /path/to/crontask.php with the actual path to the crontask.php file on your server
Create a crontask entry to run crontask.sh once a day
