<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
  <?php include 'includes/head.inc.php'; ?>
	<title>Dashboard</title>
</head>
<body>
<?php include 'includes/navigation.inc.php' ?>
<div class="container-fluid">
  <?php
  if (!isLoggedIn()) {
    header('Location: login.php');
  }
  ?>
	<div class="row">
		<div class="col-1"></div>
		<div class="col-10">
			<div class="card mb-5">
              <?php
              $database = Database::getInstance();

              if (isset($_POST['accessibility'])) {
                $statement1 = $database->getConnection()
                  ->prepare('UPDATE general SET content = "'
                    . $_POST['accessibility']
                    . '" WHERE id = "website_accessible"');
                $statement1->execute();
                refreshPage();
              }
              ?>
				<div class="card-header h6">Website access</div>
				<div class="card-body">
					<div class="card-text">
						<form action="" method="post">
                          <?php
                          $statement = $database->getConnection()
                            ->prepare('SELECT content FROM general WHERE id = "website_accessible"');
                          $statement->execute();
                          $result = $statement->fetch()['content'];
                          ?>
							<span class="mr-3">
							<input value="true" name="accessibility"
							       class="mr-2"
							       type="radio" <?= $result == 'true'
                              ? 'checked'
                              : '' ?>>Public
							</span>
							<span>
							<input value="false" name="accessibility"
							       class="mr-2"
							       type="radio" <?= $result == 'false'
                              ? 'checked'
                              : '' ?> >Private
							</span>
							<input class="btn btn-outline-success ml-3"
							       type="submit">
						</form>
					</div>
				</div>
			</div>

			<div class="card mb-5">
				<div class="card-header h6">Remove a tweet</div>
				<div class="card-body">
                  <?php
                  if (isset($_POST['tweetIdToDelete'])) {
                    $statement2 = $database->getConnection()
                      ->prepare('DELETE FROM tweets WHERE id = '
                        . $_POST['tweetIdToDelete']);
                    $statement2->execute();
                  }
                  ?>
					<form action="" method="post">
						<div class="form-group mb-0">
							<div class="input-group">
								<input type="number" class="form-control"
								       placeholder="Tweet id"
								       name="tweetIdToDelete"
								       required>
								<div class="input-group-append">
									<button
										class="btn btn-outline-danger"
										type="submit">Delete
									</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>

			<div class="card mb-5">
				<div class="card-header h6">Change user's rank</div>
				<div class="card-body">
					<div class="card-text">
                      <?php
                      if (isset($_POST['username']) && isset($_POST['rank'])) {
                        $statement = $database->getConnection()
                          ->prepare('UPDATE users SET rank = "' . $_POST['rank']
                            . '" WHERE username = "' . $_POST['username']
                            . '"');
                        $statement->execute();
                      }
                      ?>
						<form action="" method="post">
							<div class="form-group">
								<input class="form-control" name="username"
								       type="text" placeholder="Username">
							</div>
							<div class="form-group">
								<select class="form-control" name="rank">
									<option name="rank" value="MEMBER">Member
									</option>
									<option name="rank" value="ADMINISTRATOR">
										Administrator
									</option>
								</select>
							</div>
							<input class="btn btn-outline-success"
							       type="submit" value="Change rank">
						</form>
					</div>
				</div>
			</div>

			<div class="card mb-5">
				<div class="card-header h6">Register a new user</div>
				<div class="card-body">
					<div class="card-text">
                      <?php
                      if (isset($_POST['username'])
                        && isset($_POST['password'])
                      ) {
                        registerUser($_POST['username'], $_POST['fullName'],
                          $_POST['email'], $_POST['password'],
                          $_POST['passwordRepeat']);
                      }
                      ?>
						<form method="post" action="">
							<div class="form-group">
								<input value="<?= isset($_POST['username'])
                                  ? $_POST['username'] : '' ?>" name="username"
								       type="text"
								       class="form-control"
								       placeholder="Username" required>
								<small class="form-text text-muted">Do not
									include
									spaces.</small>
							</div>
							<div class="form-group">
								<input value="<?= isset($_POST['fullName'])
                                  ? $_POST['fullName'] : '' ?>" name="fullName"
								       type="text"
								       class="form-control"
								       placeholder="Full name" required>
							</div>
							<div class="form-group">
								<input value="<?= isset($_POST['email'])
                                  ? $_POST['email'] : '' ?>" name="email"
								       type="email"
								       class="form-control"
								       placeholder="Email" required>
							</div>
							<div class="form-group">
								<input name="password" type="password"
								       class="form-control"
								       placeholder="Password" required>
							</div>
							<div class="form-group">
								<input name="passwordRepeat" type="password"
								       class="form-control"
								       placeholder="Repeat password" required>
							</div>
							<input class="btn btn-outline-success"
							       type="submit"
							       value="Sign them up">
						</form>
					</div>
				</div>
			</div>

			<div class="card mb-5">
				<div class="card-header h6">Ban/Unban an user</div>
				<div class="card-body">
					<div class="card-text">
                      <?php
                      if (isset($_POST['username'])
                        && isset($_POST['reason'])
                      ) {
                        $statement = $database->getConnection()
                          ->prepare('UPDATE users SET banned = 1, banReason = "'
                            . $_POST['reason'] . '" WHERE username = "'
                            . $_POST['username'] . '"');
                        $statement->execute();
                      }
                      ?>
						<form action="" method="post">
							<div class="form-group">
								<input class="form-control" name="username"
								       type="text" placeholder="Username">
							</div>
							<div class="form-group">
								<input class="form-control" name="reason"
								       type="text" placeholder="Reason">
							</div>
							<input class="btn btn-outline-danger"
							       type="submit" value="Ban user">
						</form>
						<hr>
                      <?php
                      if (isset($_POST['unbanUsername'])) {
                        $statement = $database->getConnection()
                          ->prepare('UPDATE users SET banned = 0, banReason = "" WHERE username = "'
                            . $_POST['unbanUsername'] . '"');
                        $statement->execute();
                      }
                      ?>
						<form action="" method="post">
							<div class="form-group">
								<input class="form-control" name="unbanUsername"
								       type="text" placeholder="Username">
							</div>
							<input class="btn btn-outline-success"
							       type="submit" value="Unban user">
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="col-1"></div>
	</div>
</div>
<?php include 'includes/footer.php' ?>
</body>
</html>

