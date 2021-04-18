<?php
$title = 'Password reset';
require_once 'template/header.php';
require 'config/app.php';
require_once 'config/database.php';

if(isset($_SESSION['logged_in'])){
    header('location: index.php');
}

$errors = [];
$email=null;
if($_SERVER['REQUEST_METHOD'] == 'POST'){

  $email = mysqli_real_escape_string($mysqli, $_POST['email']);

  if(empty($email)){array_push($errors, 'Email is required');}


  if(!count($errors)){
      $userExists = $mysqli->query("select id, email, name from users where email='$email' limit 1");

      if($userExists->num_rows){

        $userId = $userExists->fetch_assoc()['id'];

        $tokenExists = $mysqli->query("delete from password_resets where user_id='$userId'");

        $token = bin2hex(random_bytes(16));

        $expires_at = date('Y-m-d H:i:s' , strtotime('+1 day'));

        $mysqli->query("insert into password_resets (user_id , token , expires_at)
        values('$userId' , '$token' , '$expires_at');");

        //------------------------
        //$changePasswordUrl = $cofig['app_url'].'change_password.php?token='.$token;
        // $headers  = 'MIME-Version: 1.0' . "\r\n";
        // $headers .= 'Content-type: text/html; charset=UFT-8' . "\r\n";
        // $headers .= 'From: '.$config['admin_email']."\r\n".
        // 'Reply-To: '.$config['admin_email']."\r\n" .
        // 'X-Mailer: PHP/' . phpversion();
        //
        // $htmlmessage = '<html><body>';
        // $htmlmessage .= '<p style="color:#ff0000;">'.$changePasswordUrl '</p>';

      // (mail($email, 'Password reset link', $htmlmessage))



        //------------------------
      }

      $_SESSION['success_message'] = 'please check you email for password reset link';
      header('location: password_reset.php');

  }

}



?>

<div id="register">
  <h4>Reset your password</h4>
  <h5 class="text-info">please fill in the form below to reset password</h5>
  <hr>
  <?php include 'template/errors.php' ?>
  <form class="" action="" method="post">


    <!--email -->
    <div class="form-group">
      <label for="email">Your email</label>
      <input type="email" name="email" value="<?php echo $email?> " class="form-control" placeholder="Your Email" id="email">
    </div>






    <!-- supmet -->
    <div class="form-group">
      <button class="btn btn-primary">Reset !</button>
    </div>


  </form>
</div>




<?php
require_once 'template/footer.php';
?>
