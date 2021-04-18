<?php
require_once __DIR__."/../config/database.php";
$uploadDir = 'uploads';

$fileName = null;

function filterString($field){

  $field = filter_var(trim($field), FILTER_SANITIZE_STRING);
    if (empty($field)) {
        return false;
    }else {
      return $field;
    }
}
function filterEmail($field){

  $field = filter_var(trim($field), FILTER_SANITIZE_STRING);

  if (filter_var($field, FILTER_VALIDATE_EMAIL)) {
      return $field;
    }else {
        return false;
      }
  }

  //------------------
  function canUpload($file){

    $allowed = [
      'jpg' => 'image/jpeg',
      'png' => 'image/png',
      'gif' => 'image/gif',
    ];

    $maxFileSize = 10 * 1024 * 1024;

    $fileMimeType = mime_content_type($file['tmp_name']);
    $fileSize = $file['size'];

    if (!in_array($fileMimeType, $allowed)){
      return 'File type is not allowed';
    }

    if($fileSize > $maxFileSize) {
      return 'File size is not allowed. Allowed size is: ' .$maxFileSize;
    }

    return true;

  }

  //--------------------
$nameError = $emailError = $documentError = $messageError = '';
$name = $email = $message = '';
//-------------------//--POST--//--------------------------------------------
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

  $name = filterString($_POST['name']);
  if (!$name){
    $_SESSION['contact_form']['name'] = null;
    $nameError = 'Your name is required';
  }else {
    $_SESSION['contact_form']['name'] = $name;
  }

  $email = filterEmail($_POST['email']);
  if (!$email){
    $_SESSION['contact_form']['email'] = null;
    $emailError = 'Your email is invalid';
  }else {
    $_SESSION['contact_form']['email'] = $email;
  }

  $message = filterString($_POST['message']);
  if (!$message){
    $_SESSION['contact_form']['message'] = null;
    $messageError = 'You must enter a message';
  }else {
    $_SESSION['contact_form']['message'] = $message;
  }

  if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {

    $canUpload = canUpload($_FILES['document']);

    if ($canUpload === true){


      if (! is_dir($uploadDir)) {
        umask(0);
        mkdir($uploadDir, 0775);
      }


      $fileName = time().$_FILES['document']['name'];

      if (file_exists( $uploadDir.'/'.$fileName)) {
        $documentError = 'Your file already exists';
      }else {
        move_uploaded_file($_FILES['document']['tmp_name'], $uploadDir.'/'.$fileName);
      }



    }else {
      $documentError =  $canUpload;
    }
  }


if(!$nameError && !$emailError && !$documentError && !$messageError ){

  $fileName ? $filePath = $uploadDir.'/'.$fileName : $filePath = null;

/***************prepare***************
*    $statement = $mysqli->prepare("insert into requests
*    (contact_name, email , document , message , service_id)
*    values(?, ?, ?, ?, ?) ");
*    // string s, integer i, double d, binery b
*    $statement->bind_param('ssssi', $dbContactName , $dbEmail , $dbDocument , $dbMessage , $dbServiceId);
*
*    $dbContactName = $name;
*    $dbEmail = $email;
*    $dbDocument = $fileName;
*    $dbMessage = $message;
*    $dbServiceId = $_POST['service_id'];
*
*    $statement->execute();
*////*************************************************////
  $insertRequest =
      "insert into requests (contact_name , email , document , message, service_id)".
      "values ('$name', '$email' , '$filePath', '$message', ".$_POST['service_id'].")";

      $mysqli->query($insertRequest);

//------------//-----------//------------//-------------------//----------//--
        // $headers  = 'MIME-Version: 1.0' . "\r\n";
        // $headers .= 'Content-type: text/html; charset=UFT-8' . "\r\n";
        // $headers .= 'From: '.$email."\r\n".
        // 'Reply-To: '.$email."\r\n" .
        // 'X-Mailer: PHP/' . phpversion();
        //
        // $htmlmessage = '<html><body>';
        // $htmlmessage .= '<p style="color:#ff0000;">'.$message '</p>';

      // if(mail($config['admin_email'], 'new nesssage', $htmlmessage)){
        session_destroy();
        header('Location: contact.php');
        die();
      // }else {
      //   echo "Error sending your email";
      // }
//------------//-------//-----//-----------//---------//----------------//---

    }
//-----///-------------//-------------//------------------//----------------//-------------//
  }


 ?>
