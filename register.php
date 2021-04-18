<?php
$titel = 'Register';
require_once 'template/header.php';
require 'config/app.php';
require_once 'config/database.php';

if(isset($_SESSION['logged_in'])){
    header('location: index.php');
}

$errors = [];
$name = null;
$email = null;
if($_SERVER['REQUEST_METHOD'] == 'POST'){

  $email = mysqli_real_escape_string($mysqli, $_POST['email']);
  $name = mysqli_real_escape_string($mysqli, $_POST['name']);
  $password = mysqli_real_escape_string($mysqli, $_POST['password']);
  $password_confirmation = mysqli_real_escape_string($mysqli, $_POST['password_confirmation']);

  if(empty($email)){array_push($errors, 'Email is required');}
  if(empty($name)){array_push($errors, 'Name is required');}
  if(empty($password)){array_push($errors, 'Password is required');}
  if(empty($password_confirmation)){array_push($errors, 'password confirmation is required'); }
  if($password != $password_confirmation){
    array_push($errors, 'passwords don`t match');
  };

  if(!count($errors)){
      $userExists = $mysqli->query("select id, email from users where email='$email' limit 1");

      if($userExists->num_rows){
          array_push($errors, 'Email already registered');
      }

  }

  // create a new user

  if(!count($errors)){

    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "insert into users (email , name , password) values ('$email' , '$name' , '$password')";
    $mysqli->query($query);

    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = $mysqli->insert_id;
    $_SESSION['user_name'] = $name;
    $_SESSION['success_message'] = "Welcome back, $name";

    header('location: index.php');
    die();
  }

}

?>

<div id="register">
  <h4>Welcome to our website</h4>
  <h5 class="text-info">please fill in the form below to register a new accout</h5>
  <hr>
  <?php include 'template/errors.php' ?>
  <form class="" action="" method="post">


    <!--email -->
    <div class="form-group">
      <label for="email">Your email</label>
      <input type="email" name="email" value="<?php echo $email?> " class="form-control" placeholder="Your Email" id="email">
    </div>

    <!--name -->
    <div class="form-group">
      <label for="name">Your name</label>
      <input type="text" name="name" value="<?php echo $name?>" class="form-control" placeholder="Your Name" id="name">
    </div>

    <!--passowrd -->
    <div class="form-group">
      <label for="password">Your password</label>
      <input type="password" name="password" value="" class="form-control" placeholder="Your Password" id="passowrd">
    </div>

    <!--confimation-passowrd -->
    <div class="form-group">
      <label for="password_confirmation">cofirm password</label>
      <input type="password" name="password_confirmation" value="" class="form-control" placeholder="confirm Your passowrd" id="password_confirmation">
    </div>

    <!-- supmet -->
    <div class="form-group">
      <button class="btn btn-success">Register !</button>
      <a href="login.php">Already have an account? login here</a>
    </div>


  </form>
</div>




<?php
require_once 'template/footer.php';
?>
