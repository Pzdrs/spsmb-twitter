<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
  <?php include 'includes/head.inc.php'; ?>
	<title>Registration</title>
</head>
<body class="text-center">
<div class="container">
	<div class="row mt-5">
		<div class="col-4"></div>
		<div class="col-4">
			<h1 class="h3 mb-3 font-weight-normal">Please sign up</h1>
          <?php
          if (!isLoggedIn()) {
            if (isset($_POST['username'])) {
              registerUser($_POST['username'], $_POST['fullName'],
                $_POST['email'], $_POST['password'],
                $_POST['passwordRepeat']);
              header('Location: login.php');
            }
          }
          else {
            header('Location: index.php');
          }

          ?>
			<form method="post" action="">
				<div class="form-group">
					<input value="<?= isset($_POST['username'])
                      ? $_POST['username'] : '' ?>" name="username" type="text"
					       class="form-control"
					       placeholder="Username" required>
					<small class="form-text text-muted">Do not include
						spaces.</small>
				</div>
				<div class="form-group">
					<input value="<?= isset($_POST['fullName'])
                      ? $_POST['fullName'] : '' ?>" name="fullName" type="text"
					       class="form-control"
					       placeholder="Full name" required>
				</div>
				<div class="form-group">
					<input value="<?= isset($_POST['email'])
                      ? $_POST['email'] : '' ?>" name="email" type="email"
					       class="form-control"
					       placeholder="Email" required>
				</div>
				<div class="form-group">
					<input name="password" type="password" class="form-control"
					       placeholder="Password" required>
				</div>
				<div class="form-group">
					<input name="passwordRepeat" type="password"
					       class="form-control"
					       placeholder="Repeat password" required>
				</div>
				<input class="btn btn-lg btn-primary btn-block" type="submit"
				       value="Sign up">
			</form>
		</div>
		<div class="col-4"></div>
	</div>
</div>
</body>
</html>