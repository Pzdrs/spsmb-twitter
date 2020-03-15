<?php
session_start();
include 'includes/Database.class.php';
include 'includes/functions.inc.php';
$database = Database::getInstance();

$statement = $database->getConnection()
  ->prepare('UPDATE tweets SET likes = likes + 1 WHERE id = '
    . $_POST['tweetId']);
$statement->execute();
$statement = $database->getConnection()
  ->prepare('UPDATE users SET likedTweets = concat(likedTweets, ", ", "'
    . $_POST['tweetId'] . '")  WHERE id = '
    . $_SESSION['userId']);
$statement->execute();
refreshPage();