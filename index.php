<?php
$titel = 'Home page';
require_once 'template/header.php';
require 'classes/Service.php';
require 'config/app.php';
require_once 'config/database.php';

$Service = new Service;



?>


<?php if($Service->available) { ?>
<h1>welcoooom</h1>
  <?php $products = $mysqli->query('select * from products')->fetch_all(MYSQLI_ASSOC) ?>
  <div class="row">
    <?php foreach($products as $product){ ?>
      <div class="col-md-4">
        <div class="card mb-3">
          <div class="custom-card-image" style="background-image: url('<?php echo $config['app_url']. $product['image'] ?>')"></div>
          <div class="card-body" >
            <div class="card-title"><?php echo $product['name'] ?></div>
            <div> <?php echo $product['description'] ?> </div>
            <div class="text-success"><?php echo $product['price'] ?> SAR </div>
          </div>
        </div>
      </div>
    <?php }?>
  </div>




<?php
$mysqli->close();
}
 require_once 'template/footer.php'?>
