<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
  <?php
  include 'includes/head.inc.php';
  ?>
	<title>Login</title>
</head>
<body class="text-center">
<div class="container">
	<div class="row mt-5">
		<div class="col-4"></div>
		<div class="col-4">
			<h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
          <?php
          $database = Database::getInstance();

          if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $users = $database->getConnection()
              ->prepare('SELECT * FROM users WHERE username = "' . $username
                . '"');
            $users->execute();
            $usersResult = $users->fetch();

            if (!empty($usersResult)) {
              if (password_verify($password, $usersResult['password'])) {
                if (getConfig('website_accessible') == 'false'
                  && $usersResult['rank'] != 'ADMINISTRATOR'
                ) {
                  echo '<div class="alert alert-danger py-0">'
                    . getConfig('website_notAccessible')
                    . '</div>';
                }
                else {
                  if ($usersResult['banned'] == FALSE) {
                    $_SESSION['userId']       = $usersResult['id'];
                    $_SESSION['rank']         = $usersResult['rank'];
                    $_SESSION['username']     = $username;
                    $_SESSION['password']     = $password;
                    $_SESSION['displayName']  = $usersResult['displayName'];
                    $_SESSION['banned']       = $usersResult['banned'];
                    $_SESSION['sortTweetsBy'] = $usersResult['sortTweetsBy'];
                    header('Location: index.php');
                  }
                  else {
                    echo '<div class="alert alert-danger py-0">'
                      . str_replace('$banReason',
                        $usersResult['banReason'] == "" ? 'Not specified'
                          : $usersResult['banReason'],
                        getConfig('login_banned'))
                      . '</div>';
                  }
                }
              }
              else {
                echo '<div class="alert alert-danger py-0">'
                  . getConfig('login_wrong_password')
                  . '</div>';
              }
            }
            else {
              echo '<div class="alert alert-danger py-0">'
                . getConfig('login_invalid_user')
                . '</div>';
            }
          }
          ?>
			<form class="form-signin" method="post" action="">
				<div class="form-group">
					<input name="username" type="text" class="form-control"
					       placeholder="Username" required>
				</div>
				<div class="form-group">
					<input name="password" type="password"
					       class="form-control"
					       placeholder="Password" required>
				</div>
				<div class="my-2">Not registered? <a href="register.php">Sign
						up</a></div>
				<input class="btn btn-lg btn-primary btn-block" type="submit"
				       value="Sign in">
			</form>
		</div>
		<div class="col-4"></div>
	</div>
</div>
</body>
</html>

