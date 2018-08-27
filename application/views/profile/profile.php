<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!$this->session->has_userdata("sessionID") && !$this->session->has_userdata("activation")){
  redirect(site_url("Home/index/?error=Please Login to continue"));
}else{
  if($this->session->userdata("activation") == "0"){
    redirect(site_url("Home/actView/?error=Please go to your email address to retreive the activation code."));
  }elseif ($this->session->userdata("activation") == "2") {
    redirect(site_url("Home/index/?error=Please Login To Email to reset password"));
  }else{

    if(!isset($_GET['error'])){
      $error = "";
    }else{
      $error = $_GET['error'];
    }

    $num = 0;
    $anon = "";

$title = "";

$sess = $this->session->userdata("sessionID");
?>

<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <script type="text/javascript" src="https://app.mailerlite.com/data/webforms/814390/z1f1n7.js?v1"></script>
</body>
</html>

<?php }}?>