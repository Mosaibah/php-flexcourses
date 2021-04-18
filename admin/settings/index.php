<?php
$title = 'Settings';
$icon = 'cubes';
include __DIR__.'/../template/header.php';


if($_SERVER['REQUEST_METHOD'] == 'POST'){

  $st = $mysqli->prepare('update settings set app_name = ?, admin_email = ? ');
  $st->bind_param('ss' , $dbAppName , $dbAdminEmail);
  $dbAppName = $_POST['app_name'];
  $dbAdminEmail = $_POST['admin_email'];
  $st->execute();

  echo "<script>location.replace('index.php')</script>";

}
?>

<div class="card">

    <div class="content">

      <h3>Update settings</h3>

      <form action="" method="post">

        <div class="form-group">
          <label for="app_name">App name</label>
          <input type="text" name="app_name" value="<?php echo $config['app_name'] ?>" id="app_name" class="form-control">
        </div>

        <div class="form-group">
          <label for="admin_email">Email admin</label>
          <input type="email" name="admin_email" value="<?php echo $config['admin_email'] ?>" id="admin_email" class="form-control">
        </div>

        <!-- supmet -->
        <div class="form-group">
          <button class="btn btn-success">Update settings !</button>
        </div>

      </form>

    </div>

</div>


<?php
include __DIR__.'/../template/footer.php';
?>
