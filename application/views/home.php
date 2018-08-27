<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if(isset($_GET['error'])){
  $error = $_GET['error'];
}else{
  $error = "No Errors Found: Proceed";
}
?>
<!DOCTYPE html>

<html>

  <head>
    <meta charset="utf-8"/>
    <meta description="" text="" name=""/>
    <title><?php echo "Home";?></title>
    <script src="<?php echo base_url('js/jquery.min.js');?>"></script>
    <script src="<?php echo base_url('js/jquery-ui.js');?>"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>css/home.css"/>
    <style>
    *{
      margin: 0px;
      padding: 0px;
    }
    </style>
  </head>

  <body>
    <?php $this->load->view('nav')?>
      <section class="home_section">
        <article class="home_motivational_quote" id="hideMov">
          <h1>“The Way Get Started Is To Quit Talking And Begin Doing.” -Walt Disney</h1>
          <h1>“The Pessimist Sees Difficulty In Every Opportunity. The Optimist Sees Opportunity In Every Difficulty.” -Winston Churchill</h1>
          <h1>“Don’t Let Yesterday Take Up Too Much Of Today.” -Will Rogers</h1>
        </article>

        <article class="home_login" id="hideMelog">
          <h3 class="home_h3">Login</h3>
          <div class="home_login_border">
            <input type="email" id="emailAddress" placeholder="email address or username"/>
            <input type="password" id="password" placeholder="password" />
            <input type="button" value="Login" id="login"/>
            <li id="result"><?php echo $error; ?></li>
          </div>

          <ul class="home_other_opt">
            <li class="register_click">Create Account</li>
            <li>|</li>
            <li class="forget_click">Forget Password</li>
          </ul>
        </article>

        <article class="home_login" id="hideMeres">
          <h3 class="home_h3">Reset Password</h3>
          <div class="home_login_border">
            <input type="email" id="resetePassword" placeholder="email address"/>
            <input type="button" value="Reset" id="reset"/>
            <li id="resresult"><?php echo $error; ?></li>
          </div>

          <ul class="home_other_opt">
            <li title="Login" id="showLogin1">Back to login</li>
          </ul>
        </article>

        <article class="home_login" id="hideMereg">
          <h3 class="home_h3">Register</h3>
          <div class="home_login_border">
            <input type="text" id="uname" placeholder="Username"/>
            <div class="loader"></div>
            <input type="text" id="fname" placeholder="Firstname"/>
            <input type="text" id="lname" placeholder="Lastname"/>
            <label>Date Of Birth</label><input type="date" id="dob" placeholder="Date Of Birth"/>
            <select class="home_select">
              <option value="">Select Gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
            <input type="email" id="emailAddress1" placeholder="email address" />
            <input type="password" id="password1" placeholder="password" title="Password Must Contain atleast 1 upper case 1 Lower case and 1 number should be atleat 8 character in length"/>
            <input type="button" value="Register" id="register"/>
            <li id="regresult"><?php echo $error; ?></li>
          </div>

          <ul class="home_other_opt">
            <li title="Login" id="showLogin">Already Have An Account</li>

          </ul>
        </article>
      </section>
    <?php $this->load->view('footer')?>
  </body>

  <script type="text/javascript">

    $("document").ready(function(){

      $("#uname").keyup(function(){
        var username = $(this).val();
        $(".loader").html("<img src='<?php echo base_url('asssets/pleasewait1.gif');?>'/>");
        $.post("<?php echo site_url('Home/checkUsername');?>", {username:username}, function(data){
          setTimeout(function(){
            $(".loader").html(data);
          }, 3000);
        });
      });

      $("#hideMelog,#hideMov").fadeIn(1000);

      $(".register_click").click(function(){
        $("#hideMelog").fadeOut(1000);
        $("#hideMereg").delay(1000).fadeIn(3000);
      });

      $("#showLogin").click(function(){
        $("#hideMereg").fadeOut(1000);
        $("#hideMelog").delay(1000).fadeIn(1000);
      });

      $("#showLogin1").click(function(){
        $("#hideMeres").fadeOut(1000);
        $("#hideMelog").delay(1000).fadeIn(1000);
      });

      $(".forget_click").click(function(){
        $("#hideMelog").fadeOut(1000);
        $("#hideMeres").delay(1000).fadeIn(3000);
      });

      $(".home_click").click(function(){
        $("#home_link")[0].click();
      });

      $("#register").click(function(){
        var fname,lname,dob,gender,email,password,uname;
        fname = $('#fname').val();
        uname = $('#uname').val();
        lname = $('#lname').val();
        dob = $('#dob').val();
        gender = $('.home_select').val();
        email = $('#emailAddress1').val();
        password = $('#password1').val();

          $("#regresult").html('<img src="<?php echo base_url("asssets/pleasewait.gif");?>" width="30px" height="30px"/>');
        $.post("http://<?php echo $_SERVER['SERVER_NAME']?>/ThyLife/index.php/Home/register",{firstname:fname,lastname:lname,db:dob,gen:gender,eml:email,pass:password,uname:uname},function(data){
          setTimeout(function(){
            $("#regresult").html(data);
          },3000);
        });
      });

      $("#login").click(function(){
        var email = $("#emailAddress").val();
        var password = $("#password").val();
        $("#result").html('<img src="<?php echo base_url("asssets/pleasewait.gif");?>" width="30px" height="30px"/>');
        $.post("http://<?php echo $_SERVER['SERVER_NAME']?>/ThyLife/index.php/Home/login", {email:email, password:password}, function(result){
          // $("#result").fadeIn(1000).html(result);
          setTimeout(function(){
            $("#result").html(result);
          },3000);
        });
      });


      $("#reset").click(function(){
        var email = $("#resetePassword").val();
        $("#resresult").html('<img src="<?php echo base_url("asssets/pleasewait.gif");?>" width="30px" height="30px"/>');
        $.post("http://<?php echo $_SERVER['SERVER_NAME']?>/ThyLife/index.php/Home/reset", {email:email}, function(result){
          // $("#result").fadeIn(1000).html(result);
          setTimeout(function(){
            $("#resresult").html(result);
          },3000);
        });
      });

    });

  </script>
</html>
