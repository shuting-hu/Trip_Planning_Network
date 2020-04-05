<?php

include 'connect.php';

$conn = OpenCon();

// FOR TESTING - replace with dynamic info later
$author = 'test';
$tripid = 1; // trip id to edit

// delete trip plan button
// delete media


/* POSSIBLY CHANGES
 * IncludesActivity
 * IncludesAttraction
 * IncludesRestaurant
 * Photo, Video, Text - deleting a post / changing content
 * x Posts - deleting a post, handled by on delete cascade
 * x Tags - deleting a post, handled by on delete cascade
 */

/* DOES NOT CHANGE
 * Plans
 * 
 * 
 */

$date = date("Y-m-d");

echo '<body>';
echo '<!-- <form id="form" action="form-process.php" method="post"></form> -->';
echo '<form id="form" action="process-plan-edits.php" method="post">';
echo '    <input name="foo" value="helloooo world foobar" placeholder="yaya">';
echo '    <input type="submit" disabled style="display: none" aria-hidden="true"></button>';
echo '    <button name="submit" type="submit">Submit</button>';
echo '</form>';
echo '</body>';
?>