<?php
$title = 'Change passowrd';
require_once 'template/header.php';
require 'config/app.php';
require_once 'config/database.php';

if(isset($_SESSION['logged_in'])){
    header('location: index.php');
}

if(!isset($_GET['token']) || !$_GET['token']){
    die('Token parameter is missing');
}

$now = date('Y-m-d H:i:s');

$stmt = $mysqli->prepare("select * from password_resets where token= ? and expires_at > '$now' ");
$stmt->bind_param('s', $token);
$token = $_GET['token'];

$stmt->execute();

$result = $stmt->get_result();

if(!$result->num_rows){
  die('Token is not valid');
}

$errors = [];


if($_SERVER['REQUEST_METHOD'] == 'POST'){

  $password = mysqli_real_escape_string($mysqli, $_POST['password']);
  $password_confirmation = mysqli_real_escape_string($mysqli, $_POST['password_confirmation']);

  if(empty($password)){array_push($errors, 'Password is required');}
  if(empty($password_confirmation)){array_push($errors, 'password confirmation is required'); }
  if($password != $password_confirmation){
    array_push($errors, 'passwords don`t match');
  };

  if(!count($errors)){

      $hashed_password = password_hash($password , PASSWORD_DEFAULT);
      $userId = $result->fetch_assoc()['user_id'];

      $mysqli->query("update users set password = '$hashed_password' where id='$userId'");

      $mysqli->query("delete form password_resets where user_id= '$userId'");

      $_SESSION['success_message'] = 'Your password has been changed, please login';

      header('location: login.php');
      die();

      }


}



?>

<div id="register">
  <h4>Create a new password</h4>
  <hr>
  <?php include 'template/errors.php' ?>
  <form class="" action="" method="post">


    <!--password -->
    <div class="form-group">
      <label for="password">New password: </label>
      <input type="password" name="password"  class="form-control" placeholder="Your new password: " id="password">
    </div>

    <!--password confirmation -->
    <div class="form-group">
      <label for="password_confirmation">Confirmatio New password: </label>
      <input type="password" name="password_confirmation"  class="form-control" placeholder="Confirm password: " id="password_confirmation">
    </div>






    <!-- supmet -->
    <div class="form-group">
      <button class="btn btn-primary">Change password !</button>
    </div>


  </form>
</div>




<?php
require_once 'template/footer.php';
?>
