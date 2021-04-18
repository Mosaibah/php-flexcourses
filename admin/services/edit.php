<?php
$title = 'Edit service';
$icon = 'cubes';
include __DIR__.'/../template/header.php';



if(!isset($_GET['id']) || !$_GET['id']){
  die('Missing id parameter');
}

$st = $mysqli->prepare('select * from services where id = ? limit 1');
$st->bind_param('i' , $serviceId);
$serviceId = $_GET['id'];
$st->execute();

$service = $st->get_result()->fetch_assoc();

$service_name = $service['service_name'];
$description = $service['description'];
$price = $service['price'];
$errors= [];


if($_SERVER['REQUEST_METHOD'] == 'POST'){

  if(empty($_POST['service_name'])){array_push($errors, 'Name is required');}
  if(empty($_POST['description'])){array_push($errors, 'Description is required');}
  if(empty($_POST['price'])){array_push($errors, 'Price is required');}

  if(!count($errors)){

    $st = $mysqli->prepare('update services set service_name = ?, description = ?, price = ? where id = ?');
    $st->bind_param('ssdi' , $dbName , $dbDescription , $dbPrice , $dbId);
    $dbName = $_POST['service_name'];
    $dbDescription = $_POST['description'];
    $dbPrice = $_POST['price'];
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

    <form action="" method="post">


      <!--service_name -->
      <div class="form-group">
        <label for="service_name">Name service</label>
        <input type="text" name="service_name" value='<?php echo $service_name ?>' class="form-control" placeholder="service name" id="service_name">
      </div>

      <!--description -->
      <div class="form-group">
        <label for="description">service description</label>
        <textarea cols="30" rows="10" name="description" class="form-control"  id="description"><?php echo $description ?></textarea>
      </div>

      <!--price -->
      <div class="form-group">
        <label for="price">service price</label>
        <input type="number" name="price" value="<?php echo $price ?>" class="form-control" placeholder="service price" id="price">
      </div>



      <!-- supmet -->
      <div class="form-group">
        <button class="btn btn-success">Update !</button>
      </div>


    </form>


  </div>

</div>


<?php

include __DIR__.'/../template/footer.php';
