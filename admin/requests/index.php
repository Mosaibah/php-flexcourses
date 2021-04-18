<?php
require_once __DIR__.'/../../template/header.php';
require_once __DIR__.'/../../config/database.php';
require_once __DIR__.'/../../config/app.php';

        $uploadDir = 'upload';

$query =
'select *, r.id as request_id, s.id as service_id from requests r
left join services s
on r.service_id = s.id';
$requests = $mysqli->query($query)
                  ->fetch_all( MYSQLI_ASSOC);

if(!isset($_GET['id'])){
?>

<h2>Receved Requests</h2>
<div class="table-responsive">
  <table class="table table-hover table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>contact_name</th>
        <th>email</th>
        <th>service</th>
        <th>document</th>
        <!-- <th>message</th> -->
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($requests as $request){
      ?>
      <tr>
        <td><?php echo $request['request_id'] ?></td>
        <td><?php echo $request['contact_name'] ?></td>
        <td><?php echo $request['email'] ?></td>
        <td><?php echo $request['service_name'] ?></td>
        <td><?php echo $request['document'] ?></td>
        <!-- <td><?php echo $request['message'] ?></td> -->
        <td>
            <a href="?id=<?php echo $request['request_id'] ?>" class="btn btn-sm btn-primary">View</a>
            <form onsubmit="return confirm('Are you sure ?')"  action="" method="post" style="display: inline-block">
              <input type="hidden" name="request_id" value="<?php echo $request['request_id'] ?>">
              <button class="btn btn-sm btn-danger">Delete</button>
            </form>
        </td>
      </tr>



      <?php } ?>
    </tbody>
  </table>
</div>






<?php
}else {
  $requestQuery = 'select * from requests r
  left join services s
  on r.service_id = s.id
   where r.id='.$_GET['id']." limit 1";
  $request = $mysqli->query($requestQuery)->fetch_array(MYSQLI_ASSOC);
  ?>

  <div class="card">
    <h5 class="card-header">
      Request from: <?php echo $request['contact_name'] ?>
      <div class="small"><?php echo $request['email'] ?></div>
    </h5>
    <div class="card-body">
      <div>Service: <?php if($request["service_name"]){echo $request['service_name'];}else{echo 'No service';} ?></div>
      <?php echo $request['message'] ?>
    </div>
    <?php if($request['document']){ ?>
      <div class="card-footer">
        Attachment: <a href="<?php echo $config["app_url"].$request['document'] ?>">Download Attachment</a>
      </div>

    <?php } ?>
  </div>
  <?php
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $mysqli->query('delete from requests where id='.$_POST['request_id']);
  echo "<script>location.replace('index.php')</script>";
}


require_once __DIR__.'/../../template/footer.php';
 ?>
