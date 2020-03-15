<?php
function getConfig($section) {
  $database  = Database::getInstance();
  $statement = $database->getConnection()
    ->prepare('SELECT content FROM general WHERE id = "' . $section . '"');
  $statement->execute();
  $result = $statement->fetch();
  return $result['content'];
}

function isLoggedIn() {
  return !empty($_SESSION);
}

function setAccessible($boolean) {
  if ($boolean) {
    ini_set('accessible', 'true');
  }
  else {
    ini_set('accessible', 'false');
  }
}

function registerUser(
  $username,
  $fullName,
  $email,
  $password,
  $repeatPassword
) {
  if ($password == $repeatPassword) {
    if (!strpos($username, ' ')) {
      $statement = Database::getInstance()
        ->getConnection()
        ->prepare('INSERT INTO users(username, password, displayName, email) VALUES ("'
          . $username . '", "'
          . password_hash($password,
            PASSWORD_DEFAULT) . '", "' . $fullName
          . '", "' . $email
          . '")');

      $statement->execute();
    }
    else {
      echo '<div class="alert alert-danger py-0">'
        . getConfig('register_space_in_username')
        . '</div>';
    }
  }
  else {
    echo '<div class="alert alert-danger py-0">'
      . getConfig('register_passwords_not_same')
      . '</div>';
  }
}

function postTweet($tweet) {
  $database  = Database::getInstance();
  $statement = $database->getConnection()
    ->prepare('INSERT INTO tweets (id, authorId, postedOn, content) VALUES (NULL, '
      . $_SESSION['userId'] . ',' . ' now(), "' . $tweet . '")');
  $statement->execute();
  refreshPage();
}

function refreshPage() {
  header('Location: ' . $_SERVER['HTTP_REFERER']);
}

function printTweets($tweets, $rank) {
  $database = Database::getInstance();

  switch ($rank) {
    case 'ADMINISTRATOR':
      foreach ($tweets as $tweet) {
        $statement = $database->getConnection()
          ->prepare('SELECT * FROM users WHERE id = ' . $tweet['authorId']);
        $statement->execute();
        $author = $statement->fetch();

        echo '<div class="card w-100 mb-3">'
          . '<div class="card-header bg-primary text-light">'
          . '<div class="container-fluid">'
          . '<div class="row">'
          . '<div class="col-10 p-0 my-auto">'
          . '<span class="font-weight-bold">#'
          . $tweet['id']
          . '</span>'
          . '&nbsp;&nbsp;'
          . $author['displayName']
          . ' <span class="font-weight-light">@'
          . $author['username']
          . ' &bull;</span> '
          . '<span class="font-weight-light">'
          . formatTime($tweet['postedOn'])
          . '</span>'
          . '</div>'
          . '<div class="col-2 p-0 text-right">'
          . '<span class="mr-3 font-weight-bold">'
          . $tweet['likes']
          . '</span>'
          . '<form action="likeTweet.php" method="post">'
          . '<input type="hidden" name="tweetId" value="' . $tweet['id'] . '">'
          . '<button class="btn btn-light" type="submit"'
          . (strpos($author['likedTweets'], $tweet['id']) == TRUE ? ' disabled'
            : '') . '><i class="far fa-thumbs-up"></i></button>'
          . '</form>'
          . '</div>'
          . '</div></div></div>'
          . '<div class="card-body">'
          . '<div class="card-text">'
          . $tweet['content']
          . '</div></div></div>';
      }
      break;
    default:
      foreach ($tweets as $tweet) {
        $statement = $database->getConnection()
          ->prepare('SELECT * FROM users WHERE id = ' . $tweet['authorId']);
        $statement->execute();
        $author = $statement->fetch();

        echo '<div class="card w-100 mb-3">'
          . '<div class="card-header bg-primary text-light">'
          . '<div class="container-fluid">'
          . '<div class="row">'
          . '<div class="col-10 p-0 my-auto">'
          . $author['displayName']
          . ' <span class="font-weight-light">@'
          . $author['username']
          . ' &bull;</span> '
          . '<span class="font-weight-light">'
          . formatTime($tweet['postedOn'])
          . '</span>'
          . '</div>'
          . '<div class="col-2 p-0 text-right">'
          . '<span class="mr-3 font-weight-bold">'
          . $tweet['likes']
          . '</span>'
          . '<form action="likeTweet.php" method="post">'
          . '<input type="hidden" name="tweetId" value="' . $tweet['id'] . '">'
          . '<button class="btn btn-light" type="submit"'
          . (strpos($author['likedTweets'], $tweet['id']) == TRUE ? ' disabled'
            : '') . '><i class="far fa-thumbs-up"></i></button>'
          . '</form>'
          . '</div>'
          . '</div></div></div>'
          . '<div class="card-body">'
          . '<div class="card-text">'
          . $tweet['content']
          . '</div></div></div>';
      }
      break;
  }
}

function formatTime($date) {
  return date('d M Y', strtotime($date)) . ' at ' . date('h:i',
      strtotime($date));
}
