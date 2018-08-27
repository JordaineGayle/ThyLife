<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('AccessCredentials','manager');
    $this->load->helper('url');
    $this->load->helper('checker');
    $this->load->library('session');
    $this->load->model('PostModel','send');
  }

  public function index(){
    $this->load->view("home");
  }

  public function editProfile(){
    $this->load->view("profile/editprofile");
  }
  public function register(){
    $fname = $this->manager->sanitizeInput($this->input->post('firstname',true));
    $lname = $this->manager->sanitizeInput($this->input->post('lastname',true));
    $db = $this->manager->sanitizeInput($this->input->post('db',true));
    $gen = $this->manager->sanitizeInput($this->input->post('gen',true));
    $eml = $this->manager->sanitizeInput($this->input->post('eml',true));
    $pass = $this->manager->sanitizeInput($this->input->post('pass',true));
    $uname = $this->manager->sanitizeInput($this->input->post('uname',true));

    if(empty($fname) || empty($lname) || empty($db) || empty($gen) || empty($eml) || empty($pass)){
      echo "*All fields are required to be filled out*";
    }else{

    if($this->manager->validateEmail($eml) == false){
      echo "Please enter a valid Email example-> someone@mymail.com";
    }

    if($this->manager->isPasswordValid($pass) == false){
      echo "Please enter a valid password-> Must be alteast 8 characters in length have an upper case, lower case and number";
    }

    if($this->manager->validateEmail($eml) == true && $this->manager->isPasswordValid($pass) == true){
      $passwordHash = password_hash($pass,PASSWORD_DEFAULT);
      $sessionKey = '';
      if($this->manager->doesUserAlreadyExist($eml) == false && $this->manager->doesUsernameAlreadyExist($uname) == false){
        $returnValue = $this->manager->registerUser($fname,$lname,$db,$gen,$eml,$passwordHash,$uname);
        if($returnValue == "no session id"){
          echo "Falied to create account: Connection falied";
        }elseif ($returnValue == "failed to insert data") {
          echo "Falied to create account: Check all values before submit";
        }else{
          $result = $this->manager->returnResult($eml);
          $sessionID = $returnValue;
          $activation = $result['thy_user_activated'];
          $this->session->set_userdata("sessionID",$sessionID);
          if($activation == 0){
            $this->session->set_userdata("activation",$activation);
            $link = $this->manager->sendEmailToUser($eml);
            if($link != "Email Falied To send"){
              echo "Activation Successful: Please Go to your email to activate your account -> <a href='".$link."'>".$this->manager->emailLink($eml,"@")."</a>";

            }else{
              echo "Falied to create account: Email Address either doesn't exist or is on an intranet or not registered";
            }

          }else{
            echo "Activated";
          }

        }
      }else{
        echo "Falied to create account, email address or username is already taken";
      }

    }
  }
  }

  public function login(){
    $eml = $this->manager->sanitizeInput($this->input->post('email',true));
    $pass = $this->manager->sanitizeInput($this->input->post('password',true));
    $res = $this->manager->returnResult($eml);
    // if($res['thy_user_activated'] != 2){
    //   echo '<script>setTimeout(function(){window.location.href = '.site_url("Home/index/?error=Please Login To Email to reset password").'},200)</script>';
    // }
    if(empty($eml) || empty($pass)){
      echo "*All Fields Are Required To Be Filled Out*";
    }else{
    //$emailValid = $this->manager->validateEmail($eml);
      if($this->manager->doesUserAlreadyExist($eml) == true || $this->manager->doesUsernameAlreadyExist($eml) == true){
        $password = $this->manager->returnPassword($eml);
        if(password_verify($pass,$password)){
          $result = $this->manager->returnResult($eml);
          $sessionID = $result['thy_session_key'];
          $activation = $result['thy_user_activated'];
          $this->session->set_userdata("sessionID",$sessionID);

          if($activation == 0){
            $this->session->set_userdata("activation",$activation);
            $link = $this->manager->hashLink($eml,"actView");
            if($link != false){
              echo "<script> setTimeout(function(){window.location.href ='".$link."/?error=Please go to your email address to retreive the activation code.'},200) </script>";
            }else{
              echo "Cannot Find User";
            }

          }else{
            $this->session->set_userdata("activation",$activation);
            echo "<script>setTimeout(function(){window.location.href = '".site_url('Home/profile/?error=')."';},200);</script>";
          }
        }else{
          echo "Login Falied: Either username/email address or password is incorrect";
        }

      }else{
        echo "Login Falied: user doesn't exist";
      }

    }

  }

  public function actView(){
    if($this->session->has_userdata("sessionID")){
      $result = $this->manager->returnSessionResult($this->session->userdata("sessionID"));
      $data = array(
        'username' => ucfirst($result['thy_fname'])." ".ucfirst($result['thy_lname']),
        'date' => $result['date_user_signed']
    );
      $this->load->view('activation',$data);
    }else{
      $this->load->view('home');
    }

  }

  public function actView1(){
    if($this->session->has_userdata("sessionID")){
      $result = $this->manager->returnSessionResult($this->session->userdata("sessionID"));
      $data = array(
        'username' => ucfirst($result['thy_fname'])." ".ucfirst($result['thy_lname']),
        'date' => $result['date_user_signed']
    );
      $this->load->view('activation1',$data);
    }else{
      $this->load->view('home');
    }

  }

  public function profile(){
    if($this->session->has_userdata("sessionID")){
      $result = $this->manager->returnSessionResult($this->session->userdata("sessionID"));
      $res = $this->send->getAllPost();
      $data = array(
        'username' => ucfirst($result['thy_fname'])." ".ucfirst($result['thy_lname']),
        'date' => $result['date_user_signed'],
        'posts' => $res
    );
      $this->load->view('profile',$data);
    }else{
      $this->load->view('home');
    }
  }

  public function resetword(){
    $this->load->view("resetpassword");
  }

  public function hashCheck(){
    $hash = $this->manager->sanitizeInput($this->input->post('hash',true));
    $session = $this->manager->sanitizeInput($this->input->post('sess',true));

    if($this->session->has_userdata('sessionID') && $session == $this->session->userdata('sessionID')){
      $result = $this->manager->returnSessionResult($session);
      if($result['thy_user_temp_hash'] == $hash){
        $this->db->query("Update `thy_users` Set `thy_user_temp_hash`='', `thy_user_activated`='1' Where `thy_session_key`='$session'");
        $this->session->set_userdata("activation","1");
        echo "<script>setTimeout(function(){window.location.href = '".site_url('Home/profile')."/?error=Account Activated Successfully';},200);</script>";
      }else{
        echo "Activation Code Doesn't Exist";
      }
    }else{
      echo "Please Don't Modify Page Identity";
    }
  }

  public function reset(){
    if($this->manager->validateEmail($this->manager->sanitizeInput($this->input->post("email",true,true)))){
      $email = $this->manager->sanitizeInput($this->input->post("email",true,true));
      if($this->manager->doesUserAlreadyExist($email)){
        $result = $this->manager->returnResult($email);
        if($result['thy_user_activated'] == "0"){
          echo "Please Activate Your Account Before Resetting Password";
        }else{
          $hash = $this->manager->createSessionID();
          $this->db->query("Update `thy_users` set `thy_user_activated`='2', `thy_user_temp_hash`='$hash' where `thy_user_email`='$email'");
          $sessions = array(
            "sessionID" => $result['thy_session_key'],
            "activation" => $result['thy_user_activated']
          );
          $this->session->set_userdata($sessions);
          $yourDomain = $this->manager->sendResetEmailToUser($email);
          echo "Please go to your email address to reset your password: <a href='".$yourDomain."'>Access My Email</a>";
        }
        // elseif ($result['thy_user_activated'] == "1"){
        //   echo "You already requested to reset your passcode";
        // }
      }else{
        echo "User Doesn't Exist";
      }
    }else{
      echo "Please Enter a valid Email Address";
    }

  }

  public function resetPasscode(){
    $hash = $this->manager->sanitizeInput($this->input->post('hash',true,true,true));
    $session = $this->manager->sanitizeInput($this->input->post('sess',true,true,true));
    $pass = $this->manager->sanitizeInput($this->input->post('pass',true,true,true));
    $conpass = $this->manager->sanitizeInput($this->input->post('conpass',true,true,true));


    if($session == $this->session->userdata("sessionID")){
      $result = $this->manager->returnSessionResult($session);
      if($result['thy_user_temp_hash'] == $hash){
        if($pass != $conpass){
          echo "Passwords Doesn't Match";
        }else{
          if($this->manager->isPasswordValid($pass) == true){
            if(password_verify($pass,$result['thy_user_password'])){
              echo "Fail To Reset: Need a new password.";
            }else{
              $passwordHash = password_hash($pass,PASSWORD_DEFAULT);
              $udpPass = $this->db->query("Update `thy_users` set `thy_user_password`='$passwordHash', `thy_user_temp_hash`='', `thy_user_activated`='1' where `thy_session_key`='$session'");
              if($udpPass == true){
                echo "<script>setTimeout(function(){window.location.href = '".site_url('Home/index')."/?error=Password Reset Was Successful Please Login';},200);</script>";
              }else{
                echo "Password failed to change Please try again";
              }
            }

          }else{
            echo "Password Must be alpha-numeric with upper and lower case min 8 max 20";
          }
        }
      }else{
        echo "<script>setTimeout(function(){window.location.href = '".site_url('Home/index')."/?error=Link expired please reset password again';},200);</script>";
      }
    }else{
      echo "<script>setTimeout(function(){window.location.href = '".site_url('Home/index')."/?error=Damage link address please reset password again';},200);</script>";
    }

  }

  public function checkUsername(){
    $username = $this->manager->sanitizeInput($this->input->post('username',true));
    $saveBool = $this->manager->doesUsernameAlreadyExist($username);

    if($saveBool == true){
      echo "<img src='".base_url('asssets/incorrect.png')."' /><script>$('#regresult').html('Username Already Taken');</script>";
    }else{
      echo "<img src='".base_url('asssets/correct.png')."' /><script>$('#regresult').html('');</script>";
    }
  }


  public function logout(){
    $array_items = array('sessionID', 'activation');
    $this->session->unset_userdata($array_items);

    redirect(site_url("/?error=Thanks For Using Good Bye"));
  }

}

?>
