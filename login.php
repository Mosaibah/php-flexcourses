<?php
$titel = 'Login';
require_once 'template/header.php';
require 'config/app.php';
require_once 'config/database.php';

if(isset($_SESSION['logged_in'])){
    header('location: index.php');
}

$errors = [];
$email = null;
if($_SERVER['REQUEST_METHOD'] == 'POST'){

  $email = mysqli_real_escape_string($mysqli, $_POST['email']);
  $password = mysqli_real_escape_string($mysqli, $_POST['password']);

  if(empty($email)){array_push($errors, 'Email is required');}
  if(empty($password)){array_push($errors, 'Password is required');}


  if(!count($errors)){
    $userExists = $mysqli->query("select id, email, password, name, role from users where email='$email' limit 1");

      if(!$userExists->num_rows){
          array_push($errors, "Your email, '$email' dose not exist in our records");
      }else {

          $foundUser = $userExists->fetch_assoc();

          if(password_verify($password, $foundUser['password'])){

            //login
              $_SESSION['logged_in'] = true;
              $_SESSION['user_id'] = $foundUser['id'];
              $_SESSION['user_name'] = $foundUser['name'];
              $_SESSION['user_role'] = $foundUser['role'];
              $_SESSION['success_message'] = "Welcome back, $foundUser[name]";

              if($foundUser['role'] == 'admin'){
                header('location: admin');
                die();
              }else {

                header('location: index.php');
                die();
              }


          }else {

            array_push($errors, 'wrong password');

          }

      }

  }

  // create a new user

  // if(!count($errors)){
  //
  //   $password = password_hash($password, PASSWORD_DEFAULT);
  //
  //   $query = "insert into users (email , name , password) values ('$email' , '$name' , '$password')";
  //   $mysqli->query($query);
  //
  //   $_SESSION['logged_in'] = true;
  //   $_SESSION['user_id'] = $mysqli->insert_id;
  //   $_SESSION['user_name'] = $name;
  //   $_SESSION['success_message'] = "Welcome back, $name";
  //
  //   header('location: index.php');
  //   die();
  // }

}

?>

<div id="register">
  <h4>Welcome back</h4>
  <h5 class="text-info">please fill in the form below to login</h5>
  <hr>
  <?php include 'template/errors.php' ?>
  <form class="" action="" method="post">


    <!--email -->
    <div class="form-group">
      <label for="email">Your email</label>
      <input type="email" name="email" value="<?php echo $email?> " class="form-control" placeholder="Your Email" id="email">
    </div>



    <!--passowrd -->
    <div class="form-group">
      <label for="password">Your password</label>
      <input type="password" name="password" value="" class="form-control" placeholder="Your Password" id="passowrd">
    </div>



    <!-- supmet -->
    <div class="form-group">
      <button class="btn btn-success">Login !</button>
      <a href="password_reset.php">Forgot your password?</a>
    </div>


  </form>
</div>




<?php
require_once 'template/footer.php';
?>
