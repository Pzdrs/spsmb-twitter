<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
  <?php include 'includes/head.inc.php'; ?>
	<title>SPSMB Twitter knockoff</title>
</head>
<body>
<?php include 'includes/navigation.inc.php' ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-3"></div>
		<div class="col-6">
          <?php
          if (isset($_POST['tweet'])) {
            postTweet($_POST['tweet']);
          }
          ?>
			<form action="" class="mb-5" method="post">
				<div class="form-group">
					<div class="input-group mb-3">
						<input type="text" class="form-control"
						       placeholder="What's on your mind?" name="tweet"
						       required>
						<div class="input-group-append">
							<button
								class="btn btn-outline-primary <?= ($_SESSION['muted']
                                == 1 ? 'disabled' : '') ?>" type="submit">Submit
							</button>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="col-3"></div>
	</div>
	<div class="row mb-3">
		<div class="col-3"></div>
		<div class="col-6">
			<div class="container-fluid">
				<div class="row">
					<div class="col-8"></div>
					<div class="col-4 pr-0">
					</div>
				</div>
			</div>
		</div>
		<div class="col-3"></div>
	</div>
	<div class="row">
		<div class="col-3"></div>
		<div class="col-6">
          <?php
          if (isLoggedIn()) {
            $database  = Database::getInstance();
            $statement = $database->getConnection()
              ->prepare('SELECT * FROM tweets ORDER BY postedOn DESC');
            $statement->execute();
            $result = $statement->fetchAll();

            if (empty($result)) {
              echo '<div class="alert alert-info text-center">'
                . 'There are no tweets so far. Be the first one to tweet!'
                . '</div>';
            }

            printTweets($result, $_SESSION['rank']);
          }
          else {
            header('Location: login.php');
          }
          ?>
		</div>
		<div class="col-3"></div>
	</div>
</div>
<?php include 'includes/footer.php' ?>
</body>
</html>
