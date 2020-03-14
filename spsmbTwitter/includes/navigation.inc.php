<nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
	<a class="navbar-brand" href="."><?= getConfig('website_name') ?></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse"
	        data-target="#navbarSupportedContent"
	        aria-controls="navbarSupportedContent" aria-expanded="false"
	        aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
          <?php
          switch ($_SESSION['rank']) {
            case 'ADMINISTRATOR':
              echo '<li class="nav-item">
				<a class="nav-link'
                . (basename($_SERVER['SCRIPT_FILENAME']) == 'dashboard.php' ? ' active' : '')
                . '" href="dashboard.php">Dashboard</a>
			</li>';
              break;
            default:
              break;
          }
          ?>
		</ul>
		<form class="form-inline my-2 my-lg-0" action="logout.php" method="post">
			<span
				class="font-weight-light mr-2">Logged in as <?= $_SESSION['displayName'] ?></span>
			<button name="logout" class="btn btn-outline-danger my-2 my-sm-0"
			        type="submit">
				Log out
			</button>
		</form>
	</div>
</nav>