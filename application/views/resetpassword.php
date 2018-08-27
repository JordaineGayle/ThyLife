<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(!isset($_GET['uniquekey']) and !isset($_GET['secretHash'])){

}else{
  $unique = $_GET['uniquekey'];
  $hash = $_GET['secretHash'];
  $ary = array("sessionID","activation");
  if(!$this->session->has_userdata("sessionID") or !$this->session->has_userdata("activation")){
    echo "<script>setTimeout(function(){window.location.href = '".site_url('Home/index')."/?error=Login to Continue';},200);</script>";
  }else{
    if($this->session->userdata("sessionID") != $unique || $this->session->userdata("activation") != "2"){
      echo "<script>setTimeout(function(){window.location.href = '".site_url('Home/index')."/?error=Please Login To Continue';},200);</script>";
    }else{

      $error = "No Errors Proceed";
?>
<!DOCTYPE html>

<html>
  <head>
    <title>Activation</title>
    <meta charset="utf-8"/>
    <meta description="" text="" name=""/>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
    <style>
      *{
        padding:0px;
        margin:0px;
        list-style: none;
      }

      body{
        display: flex;
        justify-content: center;
        flex-flow: row wrap;
        background-color: #FAFAFA;
      }

      section{
        width: 40%;
        display: flex;
        flex-flow: row wrap;
        height: auto;
        font-family: "Ebrima", "Calibri", "Times New Roman", serif;
        justify-content: center;
        margin-top: 7%;
      }


      .home_login{
        display:flex;
        flex-flow: row wrap;
        width: 100%;
        justify-content: center;
        border: 1px solid #fff;
        background-color: #37474F;
        color: #03A9F4!important;
        padding: 2em;
        margin: 2em;
      }

      .home_login div{
        display:flex;
        flex-flow: row wrap;
        width: 90%;
        border: 0.5px solid #B0BEC5;
        margin: 2em;
        padding: 2em;
        justify-content: center;
        border-radius: 5px;
        box-shadow: inset 0px 0px 10px rgba(0,0,0,0.9);
      }
      .home_login label{
        display:flex;
        flex-flow: row wrap;
        width: 60%;
        padding:0.5em;
        margin: 0.5em;
        border-bottom: 0.5px solid #B0BEC5;
        border-radius: 5px;
        box-shadow: inset 0px 0px 4px rgba(0,0,0,0.9);
      }

      #result{
        width: 100%;
        font-style: italic;
        font-size: 12px;
        text-align: center;
        /* list-style: lower-latin!important; */
        /* display: none; */
        color: red!important;
      }

      label span{
        width: auto;
        font-style: italic;
        margin-top: 4px;
        margin-left: 5px;
        height: 100%;
        font-size: 13px;
        color: red!important;
      }

      .home_h3{
        width: 100%;
        font-size: 1.5em;
        text-align:center;
        margin-bottom: 0.5em;
        text-shadow: 0px 0px 5px rgba(0,0,0,0.9);
      }
      .home_other_opt{
        width: 100%;
        display: flex;
        justify-content: center;
      }

      .home_other_opt li {
        padding: 0.5em;
        cursor: pointer;
        text-shadow: 0px 0px 5px rgba(0,0,0,0.9);
      }

      .home_other_opt li:hover{
        color:  #fff;
        transition:color 0.2s;
      }

      input{
        border-bottom: 1px solid rgba(0,0,0,.2);
        border-top: none;
        border-left: none;
        border-right: none;
        background-color: rgba(0, 0, 0, 0.1);
        color:#03A9F4!important;
        width: 80%;
        height: 40px;
        margin: 1em;
      }
      input:focus {
        outline: none;
      }

      #login{
        background-color: #03A9F4;
        width: 30%;
        color: white!important;
        cursor: pointer;
        box-shadow: 0px 0px 3px rgba(0,0,0,0.9);
      }

      #login:hover{
        background-color: #1976D2;
        transition: background-color 0.2s;
      }

      .original_nav{
        display:flex;
        background-color: #37474F;
        width: 100%;
        margin: 0px;
        padding: 0px;
        flex-flow: row nowrap;
        font-family: "Ebrima", "Calibri", "Times New Roman", serif;
        box-shadow: 0px 0px 10px rgba(0,0,0,0.5);
      }

      .original_nav_header{
        color: white;
        width: 20%;
        font-size: 2.3em;
        display: flex;
        align-self: center;
        text-shadow: 0px 0px 10px rgba(0,0,0,0.9);
      }

      .original_nav_header span{
        color: #03A9F4;
      }

      .original_nav_ul{
        display: flex;
        width: 80%;
        justify-content: flex-end;
        color: white;
        font-size: 20px;
        height: auto;
        font-weight: 500;
      }
      .original_nav_ul li{
        cursor: pointer;
        align-self: center;
        padding: 1em;
      }

      .original_nav_ul li:hover{
        background-color: #03A9F4;
        color: #37474F;
        transition: background-color 0.2s, color 0.2s;
      }

      .original_nav_ul li:active{
        background-color: #1976D2;
        color: #37474F;
        transition: background-color 0.2s, color 0.2s;
      }
    </style>
  </head>
    <body>
      <!-- <nav class="original_nav">
        <h1 class="original_nav_header">Thy<span>Life</span></h1>
        <ul class="original_nav_ul">
          <li class="register_click">Logout</li>
          <a class="registerclick" href="<?php //echo site_url('Home/logout');?>" style="display:none;"></a>
        </ul>
      </nav> -->
      <section class=".home_section">
        <article class="home_login" id="hideMelog">
          <h3 class="home_h3">Reset Password</h3>
          <!-- <label>Name: <span><?php //echo $username; ?></span></label> <label>Date Registered: <span><?php //echo $date; ?></span></label> -->
          <div class="home_login_border">
            <input type="password" id="password" placeholder="new password" />
            <input type="password" id="conpassword" placeholder="confirm new password" />
            <input type="button" value="Reset" id="login"/>
            <li id="result"><?php echo $error;?></li>
          </div>
          <!-- <ul class="home_other_opt">
            <li class="register_click">Resend Activation</li>
          </ul> -->
        </article>
      </section>
    </body>
    <script>
      $("document").ready(function(){

        $("#login").on("click",function(){
          var userSession = "<?php echo $unique; ?>";
          var hash = "<?php echo $hash; ?>";
          var pass = $("#password").val();
          var conpass = $("#conpassword").val();

          if((pass != conpass) && pass != '' && conpass != ''){
            $("#result").html('<?php $error = "Password Mismatch"; echo $error;?>');
          }else if (pass == '' || conpass == '') {
            $("#result").html('<?php $error = "Both Fields Must Be Filled Out"; echo $error;?>');
          }else if (pass.length < 8 || conpass.length < 8) {
            $("#result").html('<?php $error = "Password Must Be atleast 8 characters minimum"; echo $error;?>');
          }else if (pass == '' && conpass != '') {
              $("#result").html('<?php $error = "Both Fields Must Be Filled Out"; echo $error;?>');
          }else if (pass != '' && conpass == '') {
            $("#result").html('<?php $error = "Both Fields Must Be Filled Out"; echo $error;?>');
          }else{
          $("#result").html('<img src="<?php echo base_url("asssets/pleasewait.gif");?>" width="30px" height="30px"/>');
          $.post("http://localhost/ThyLife/index.php/Home/resetPasscode",{hash:hash, sess:userSession,pass:pass,conpass:conpass},function(result){
            setTimeout(function(){
              $("#result").html(result);
            },3000);
          });
          }
        });
      });
    </script>
</html>
<?php     }
  }

}?>
