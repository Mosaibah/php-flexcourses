<?php
$title = 'Create service';
$icon = 'cubes';
include __DIR__.'/../template/header.php';


$errors = [];
$service_name = null;
$description = null;
$price = null;

if($_SERVER['REQUEST_METHOD'] == 'POST'){

  $service_name = mysqli_real_escape_string($mysqli, $_POST['service_name']);
  $description = mysqli_real_escape_string($mysqli, $_POST['description']);
  $price = mysqli_real_escape_string($mysqli, $_POST['price']);

  if(empty($service_name)){array_push($errors, 'Name is required');}
  if(empty($description)){array_push($errors, 'description is required');}
  if(empty($price)){array_push($errors, 'price is required');}


  // create a new user

  if(!count($errors)){


    $query = "insert into services (service_name , description, price) values ('$service_name' , '$description', '$price')";
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


      <!--service_name -->
      <div class="form-group">
        <label for="service_name">Name service</label>
        <input type="text" name="service_name" value='<?php echo $service_name ?>' class="form-control" placeholder="service name" id="service_name">
      </div>

      <!--description -->
      <div class="form-group">
        <label for="description">service description</label>
        <textarea cols="30" rows="10" name="description" value='<?php echo $description ?>' class="form-control" placeholder="service description" id="description"></textarea>
      </div>

      <!--price -->
      <div class="form-group">
        <label for="price">service price</label>
        <input type="number" name="price" value="" class="form-control" placeholder="service price" id="price">
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
