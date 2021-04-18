<?php
session_start();
require_once __DIR__.'/../config/app.php';
?>
<!DOCTYPE html>
<html lang="<?php echo $config['lang']?>" dir="<?php echo $config['dir']?>">
  <head>
    <title><?php echo $config['app_name'] .' | ' .$title ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <style >
      .custom-card-image{
        height: 200px;
        background-size: cover;
        background-position: center;
      }
    </style>
  </head>

  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="<?php echo $config['app_url'] ?>"><?php echo $config['app_name'] ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo $config['app_url'] ?>">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $config['app_url'] ?>contact.php">Contact</a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <?php if(!isset($_SESSION['logged_in'])): ?>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $config['app_url'] ?>/login.php">Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $config['app_url'] ?>/Register.php">Register</a>
      </li>
    <?php else: ?>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $config['app_url'] ?>/login.php"><?php echo $_SESSION['user_name'] ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $config['app_url'] ?>logout.php">Logout</a>
      </li>
    <?php endif; ?>

    </ul>
  </div>
</nav>
    <div class="container pt-5">
<?php include 'message.php' ?>
