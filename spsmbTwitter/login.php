<?php
session_start();
require 'includes/Database.class.php';
require 'includes/functions.inc.php';
$database = Database::getInstance();

if (isset($_POST['username']) && isset($_POST['password'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $users = $database->getConnection()
    ->prepare('SELECT * FROM users WHERE username = "' . $username . '"');
  $users->execute();
  $usersResult = $users->fetch();

  if (!empty($usersResult)) {
    if (password_verify($password, $usersResult['password'])) {
      if (getConfig('website_accessible') == 'false'
        && $usersResult['rank'] != 'ADMINISTRATOR'
      ) {
        echo 'private';
      }
      else {
        $_SESSION['userId']       = $usersResult['id'];
        $_SESSION['rank']         = $usersResult['rank'];
        $_SESSION['username']     = $username;
        $_SESSION['password']     = $password;
        $_SESSION['displayName']  = $usersResult['displayName'];
        $_SESSION['banned']       = $usersResult['banned'];
        $_SESSION['muted']        = $usersResult['muted'];
        $_SESSION['sortTweetsBy'] = $usersResult['sortTweetsBy'];
        header('Location: index.php');
      }
    }
    else {
      echo 'Wrong password';
    }
  }
  else {
    echo 'This user does not exist!';
  }
}
?>

<form name="loginForm" action="" method="post">
	<input type="text" name="username" required>
	<input type="password" name="password" required>
	<input type="submit" value="Log in">
</form>
