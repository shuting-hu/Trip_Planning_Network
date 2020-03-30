<?php
$url = $_POST['yturl'];

// SOURCE: https://gist.github.com/ghalusa/6c7f3a00fd2383e5ef33
// regex code 
preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
$youtube_id = $match[1];


echo '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$youtube_id.'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>';
echo '</iframe>';
?>