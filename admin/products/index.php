<?php
$title = 'Products';
$icon = 'cubes';
include __DIR__.'/../template/header.php';


$products = $mysqli->query('select * from products ')->fetch_all(MYSQLI_ASSOC);
print_r($products);
?>

<!--  -->
<div class="card">

  <div class="content">

    <a href="create.php" class="btn btn-success">Create a new product</a>
    <p class="header">products: <?php echo count($products)?></p>

  <div class="table-responsive">

      <table class="table tabel-striped">
          <thead>
            <tr>
              <th width='0'>#</th>
              <th>Name</th>
              <th>Description</th>
              <th>Price</th>
              <th>Image</th>
              <th width='250'>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($products as $product): ?>
                <tr>
                  <td><?php echo $product['id'] ?></td>
                  <td><?php echo $product['name'] ?></td>
                  <td><?php echo $product['description'] ?></td>
                  <td><?php echo $product['price'] ?></td>
                  <td><img src="<?php echo $config['app_url'].$product['image'] ?>" width="50"></td>
                  <td>
                    <a href="edit.php?id=<?php echo $product['id'] ?>" class="btn btn-warning">Edit</a>
                    <form onsubmit="return confirm('Are you sure ?')"  action="" method="post" style="display: inline-block">
                      <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                      <input type="hidden" name="image" value="<?php echo $product['image'] ?>">
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
  $mysqli->query('delete from products where id='.$_POST['id']);

  if($_POST['image']){
  unlink($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . '/php/' . $_POST['image']);
  }

  ;
}


include __DIR__.'/../template/footer.php';
?>
