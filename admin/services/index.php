<?php
$title = 'Services';
$icon = 'cubes';
include __DIR__.'/../template/header.php';

$services = $mysqli->query('select * from services order by id')->fetch_all(MYSQLI_ASSOC);
?>

<!--  -->
<div class="card">

  <div class="content">

    <a href="create.php" class="btn btn-success">Create a new service</a>
    <p class="header">Services: <?php echo count($services)?></p>

  <div class="table-responsive">

      <table class="table tabel-striped">
          <thead>
            <tr>
              <th width='0'>#</th>
              <th>Name</th>
              <th>Description</th>
              <th>Price</th>
              <th width='250'>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($services as $service): ?>
                <tr>
                  <td><?php echo $service['id'] ?></td>
                  <td><?php echo $service['service_name'] ?></td>
                  <td><?php echo $service['description'] ?></td>
                  <td><?php echo $service['price'] ?></td>
                  <td>
                    <a href="edit.php?id=<?php echo $service['id'] ?>" class="btn btn-warning">Edit</a>
                    <form onsubmit="return confirm('Are you sure ?')"  action="" method="post" style="display: inline-block">
                      <input type="hidden" name="service_id" value="<?php echo $service['id'] ?>">
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
  $mysqli->query('delete from services where id='.$_POST['service_id']);
  echo "<script>location.replace('index.php')</script>";
}


include __DIR__.'/../template/footer.php';
?>
