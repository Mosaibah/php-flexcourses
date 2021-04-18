<?php
$title = 'Create user';
$icon = 'users';
include __DIR__.'/../template/header.php';


$errors = [];
$name = null;
$email = null;
$role = null;

if($_SERVER['REQUEST_METHOD'] == 'POST'){

  $email = mysqli_real_escape_string($mysqli, $_POST['email']);
  $name = mysqli_real_escape_string($mysqli, $_POST['name']);
  $password = mysqli_real_escape_string($mysqli, $_POST['password']);
  $role = mysqli_real_escape_string($mysqli, $_POST['role']);

  if(empty($email)){array_push($errors, 'Email is required');}
  if(empty($name)){array_push($errors, 'Name is required');}
  if(empty($password)){array_push($errors, 'Password is required');}
  if(empty($role)){array_push($errors, 'Role is required');}


  // create a new user

  if(!count($errors)){

    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "insert into users (email , name , password, role) values ('$email' , '$name' , '$password', '$role')";
    $mysqli->query($query);


    if($mysqli->error){
      array_push($errors, $mysqli->error);
    }else {
      echo "<script>location.href = 'index.php'</script>";
    }

  }

}

?>

<!--  -->
<div class="card">

  <div class="content">
    <?php include __DIR__.'/../template/errors.php' ?>

    <form action="" method="post">


      <!--email -->
      <div class="form-group">
        <label for="email">Your email</label>
        <input type="email" name="email" value='<?php echo $email ?>'   class="form-control" placeholder="Your Email" id="email">
      </div>

      <!--name -->
      <div class="form-group">
        <label for="name">Your name</label>
        <input type="text" name="name" value='<?php echo $name ?>' class="form-control" placeholder="Your Name" id="name">
      </div>

      <!--passowrd -->
      <div class="form-group">
        <label for="password">Your password</label>
        <input type="password" name="password" value="" class="form-control" placeholder="Your Password" id="passowrd">
      </div>

      <!-- role -->
      <div class="form-group">
        <label for="role">Role : </label>
        <select class="form-control" name="role" id="role">
          <option value="user"<?php if($role == 'user') echo "selected" ?>>User</option>
          <option value="admin" <?php if($role == 'admin') echo "selected" ?>>Admin</option>
        </select>
      </div>

      <!-- supmet -->
      <div class="form-group">
        <button class="btn btn-success">Create !</button>
      </div>


    </form>

  </div>

</div>


<!--  -->
<?php
include __DIR__.'/../template/footer.php';
?>
