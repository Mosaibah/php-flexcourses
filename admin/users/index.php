<?php
$title = 'Users';
$icon = 'users';
include __DIR__.'/../template/header.php';

$users = $mysqli->query('select * from users order by id')->fetch_all(MYSQLI_ASSOC);
?>

<!--  -->
<div class="card">

  <div class="content">

    <a href="create.php" class="btn btn-success">Create a new user</a>
    <p class="header">Users: <?php echo count($users)?></p>

  <div class="table-responsive">

      <table class="table tabel-striped">
          <thead>
            <tr>
              <th width='0'>#</th>
              <th>Email</th>
              <th>Name</th>
              <th>Role</th>
              <th width='250'>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($users as $user): ?>
                <tr>
                  <td><?php echo $user['id'] ?></td>
                  <td><?php echo $user['email'] ?></td>
                  <td><?php echo $user['name'] ?></td>
                  <td><?php echo $user['role'] ?></td>
                  <td>
                    <a href="edit.php?id=<?php echo $user['id'] ?>" class="btn btn-warning">Edit</a>
                    <form onsubmit="return confirm('Are you sure ?')"  action="" method="post" style="display: inline-block">
                      <input type="hidden" name="user_id" value="<?php echo $user['id'] ?>">
                      <button class="btn btn-md btn-danger" type="submit">Delete</button>
                    </form>
                  </td>
                </tr>
            <?php endforeach; ?>
          </tbody>
      </table>

  </div>

  </div>

</div>




<!--  -->
<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
  $mysqli->query('delete from users where id='.$_POST['user_id']);
  echo "<script>location.replace('index.php')</script>";
}


include __DIR__.'/../template/footer.php';
?>
