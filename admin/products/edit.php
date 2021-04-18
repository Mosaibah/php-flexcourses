<?php
$title = 'Edit product';
$icon = 'cubes';
include __DIR__.'/../template/header.php';
require_once __DIR__.'/../../classes/Upload.php';




if(!isset($_GET['id']) || !$_GET['id']){
  die('Missing id parameter');
}

$st = $mysqli->prepare('select * from products where id = ? limit 1');
$st->bind_param('i' , $productId);
$productId = $_GET['id'];
$st->execute();

$product = $st->get_result()->fetch_assoc();

$name = $product['name'];
$description = $product['description'];
$price = $product['price'];
$image = $product['image'];
$errors= [];


if($_SERVER['REQUEST_METHOD'] == 'POST'){

  if(empty($_POST['name'])){array_push($errors, 'Name is required');}
  if(empty($_POST['description'])){array_push($errors, 'Description is required');}
  if(empty($_POST['price'])){array_push($errors, 'Price is required');}

  if(isset($_FILES['image']) && $_FILES['image']['error'] == 0){


    if(!count($errors)){
        $date = date('Ym');
        $upload = new Upload('uploads/products/'.$date);
        $upload->file = $_FILES['image'];
        $errors = $upload->upload();
    }

    if(!count($errors)){

      //delete old imagear
      unlink($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . '/php/' . $image);

      $image = $upload->filePath;
    }
  }

  if(!count($errors)){

    $st = $mysqli->prepare('update products set name = ?, description = ?, price = ?, image = ? where id = ?');
    $st->bind_param('ssdsi' , $dbName , $dbDescription , $dbPrice, $dbImage , $dbId);
    $dbName = $_POST['name'];
    $dbDescription = $_POST['description'];
    $dbPrice = $_POST['price'];
    $dbImage = $image;
    $dbId = $_GET["id"];

    $st->execute();

    if($st->error){
        array_push($errors, $st->error);
    }else {
        echo "<script>location.href = 'index.php'</script>";
    }//end else

  }//end if


}//end post

?>

<div class="card">

  <div class="content">
    <?php include __DIR__.'/../template/errors.php' ?>

    <form action="" method="post" enctype="multipart/form-data">


      <!--name -->
      <div class="form-group">
        <label for="service_name">Name product</label>
        <input type="text" name="name" value='<?php echo $name ?>' class="form-control" placeholder="product name" id="name">
      </div>

      <!--description -->
      <div class="form-group">
        <label for="description">product description</label>
        <textarea cols="30" rows="10" name="description"  class="form-control" placeholder="service description" id="description"><?php echo $description ?></textarea>
      </div>


      <!--price -->
      <div class="form-group">
        <label for="price">service price</label>
        <input type="number" name="price" value="<?php echo $price?>" class="form-control" placeholder="service price" id="price">
      </div>

      <!-- file -->
      <div class="form-group">
        <img src="<?php echo $config['app_url'].'/'.$image ?>" width="150" alt="">
        <label for="image">Image</label>
        <input type="file" name="image">
      </div>

      <!-- supmet -->
      <div class="form-group">
        <button class="btn btn-success">Create !</button>
      </div>


    </form>

  </div>

</div>


<?php

include __DIR__.'/../template/footer.php';
