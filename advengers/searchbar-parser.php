<?php
$query = $_POST['query'];
$query = str_replace(',', ' ', $query);
$words = explode(' ', $query);

$users = array();
$places = array();
foreach ($words as $word) {
    //echo nl2br("$word\n");
    if (substr($word, 0, 1) === '@') {
        //echo nl2br("added to users\n");
        array_push($users, substr($word, 1));
    } else if (substr($word, 0, 1) === '#') {
        //echo nl2br("added to places\n");
        array_push($places, substr($word, 1));
    }
}

if (count($users) === 0) {
    echo nl2br("No usernames given.\n");
} else {
    $user_query = 'username = '.$users[0].'';
    for ($i = 1; $i < count($users); $i++) {
        $user_query = $user_query . ' OR username = '.$users[$i].'';
    }
    echo nl2br("$user_query\n");
}

if (count($places) === 0) {
    echo nl2br("No places given.\n");
} else {
    $place_query = 'location = '.$places[0].'';
    for ($i = 1; $i < count($places); $i++) {
        $place_query = $place_query . ' OR location = '.$places[$i].'';
    }
    echo nl2br("$place_query\n");
}

// print_r($users);
// print_r($places);

?>