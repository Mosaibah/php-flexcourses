<?php
$title = 'Cantact page';
require_once 'template/header.php';
include_once 'includes/uploader.php';
require 'classes/Service.php';
//------------------VALITDATE-----FUNCTION---------------------------------------

if (isset($_SESSION['contact_form']))
print_r($_SESSION['contact_form']);

if(isset($_COOKIE['username']))
  echo "ولكمممم". $_COOKIE['username'] ;

$s = new Service;
$s->taxRate = .15;

$services = $mysqli->query("select id, service_name , price from services order by service_name")->fetch_all(MYSQLI_ASSOC);

?>
<!-- ////////CONTACT///////// -->

<?php if($s->available){ ?>
<br><br><br>
<a href="<?php echo $uploadDir ?>/name of file">download you file</a>

<h1>Conatact us</h1>
<form action="<?php echo $_SERVER['PHP_SELF']?>"  method="post" enctype="multipart/form-data">

  <!-- Name  -->
  <div class="form-group">
    <label for="name">your Name</label>
    <input type="text" name="name" value="<?php if (isset($_SESSION['contact_form']['name'])) echo $_SESSION['contact_form']['name'] ?>" class="form-control" placeholder="Your Name">
    <span class="text-danger"><?php echo $nameError ?></span>
  </div>

  <!--  Email -->
  <div class="form-group">
    <label for="email">your Email</label>
    <input type="email" name="email" value="<?php if (isset($_SESSION['contact_form']['email'])) echo $_SESSION['contact_form']['email'] ?>" class="form-control" placeholder="Your email">
    <span class="text-danger"><?php echo $emailError ?></span>
  </div>

  <!-- File  -->
  <div class="form-group">
    <label for="document">your File</label>
    <input type="file" name="document" value="<?php echo $document ?>">
    <span class="text-danger"><?php echo $documentError ?></span>
  </div>

  <!-- Services -->
  <div class="form-group">
    <label for="services">Services</label>
    <select class="form-control" name="service_id" id="services">
      <?php foreach($services as $service) { ?>
        <option value="<?php echo $service['id'] ?>">
          <?php echo $service['service_name'] ?>
          (<?php echo $s->totalPrice($service['price']) ?>) SAR

        </option>

      <?php } ?>
    </select>

  </div>

  <!-- Message  -->
  <div class="form-group">
    <label for="message">your Message</label>
    <textarea name="message" class="form-control" placeholder="Your message"><?php if (isset($_SESSION['contact_form']['message'])) echo $_SESSION['contact_form']['message'] ?></textarea>
    <span class="text-danger"><?php echo $messageError ?></span>
  </div>

  <!-- Subment  -->
  <button class="btn btn-primary">send</button>
</form><!--end form -->

<?php } ?>


<?php require_once 'template/footer.php';?>
