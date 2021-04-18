<?php
$title = 'Create product';
$icon = 'cubes';
include __DIR__.'/../template/header.php';
require_once __DIR__.'/../../classes/Upload.php';


$errors = [];
$name = null;
$description = null;
$price = null;
// $image = null;


if($_SERVER['REQUEST_METHOD'] == 'POST'){


    $name = mysqli_real_escape_string($mysqli, $_POST['name']);
    $price = mysqli_real_escape_string($mysqli, $_POST['price']);
    $description = mysqli_real_escape_string($mysqli, $_POST['description']);

    if(empty($name)){array_push($errors, "Name is required");}
    if(empty($price)){array_push($errors, "Price is required");}
    if(empty($description)){array_push($errors, "Description is required");}
    if(empty($_FILES['image']['name'])){array_push($errors, "Image is required");}

    if(!count($errors)){
        $date = date('Ym');
        $upload = new Upload('uploads/products/'.$date);
        $upload->file = $_FILES['image'];
        $errors = $upload->upload();
    }


    if(!count($errors)){

        $query = "insert into products (name, description, price, image) values ('$name', '$description', '$price', '$upload->filePath')";
        $mysqli->query($query);

        if($mysqli->error){
            array_push($errors, $mysqli->error);
        }else{
            echo "<script>location.replace('index.php')</script>";
        }


    }
}
?>

<!--  -->
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


<!--  -->
<?php
include __DIR__.'/../template/footer.php';
?>
