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
?>
<!DOCTYPE html>

<html>

  <head>
    <meta charset="utf-8"/>
    <meta description="" text="" name=""/>
    <title><?php echo $title;?></title>
     <script src="<?php echo base_url('js/jquery.min.js');?>"></script>
    <script src="<?php echo base_url('js/jquery-ui.js');?>"></script>
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/base/jquery-ui.css"></script> -->
  </head>

  <body>
  </body>
</html>
