<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AccessCredentials extends CI_Model{

  public function registerUser($firstname, $lastname, $dob, $gender, $email, $password,$uname){
    $sessionID = $this->createSessionID();
    $hash = $this->returnRandomString(100);
    $insertQuery = $this->db->query("Insert into `thy_users` (`thy_session_key`, `thy_fname`, `thy_lname`, `thy_date_of_birth`, `thy_gender`, `thy_user_email`,`thy_user_password`, `thy_user_activated`,`thy_user_temp_hash`,`thy_user_name`) values ('$sessionID','$firstname','$lastname','$dob','$gender','$email','$password','0','$hash','$uname')");
    if($insertQuery == true){
      $selectQuery = $this->db->query("Select * from `thy_users` where `thy_session_key`='$sessionID'");
      if($selectQuery->num_rows() > 0){
        return $sessionID;
      }else{
        return "no session id";
      }
    }else{
      return "failed to insert data";
    }
  }

  public function doesUserAlreadyExist($email){
    $selectQuery = $this->db->query("Select * from `thy_users` where `thy_user_email`='$email'");
    if($selectQuery->num_rows() > 0){
      return true;
    }else{
      return false;
    }
  }

  public function doesUsernameAlreadyExist($username){
    $selectQuery = $this->db->query("Select * from `thy_users` where `thy_user_name`='$username'");
    if($selectQuery->num_rows() > 0){
      return true;
    }else{
      return false;
    }
  }

  public function LoginUser(){

  }

  public function isUserActivated(){

  }

  public function ActivationEmailLink(){

  }

  public function isUserLoggedIn(){

  }

  public function userClickForgetPassword(){

  }

  public function createForgetPasswordConfirmationLink(){

  }

  public function updateNewPassword($password){

  }

  public function isThePasswordTheSame($password){

  }

  public function isPasswordValid($password){
    return $this->checkPasswordAlgorithm($password);
  }

  public function createSessionID(){
    return $this->returnRandomString(50);
  }

  public function returnPassword($email){
    $checkPass = $this->db->query("Select * from `thy_users` where `thy_user_email`='$email' OR `thy_user_name`='$email'");
    $password= $checkPass->row_array();
    return $password['thy_user_password'];
  }

  public function returnResult($email){
    $checkPass = $this->db->query("Select * from `thy_users` where `thy_user_email`='$email' OR `thy_user_name`='$email'");
    $password= $checkPass->row_array();
    return $password;
  }

  public function returnSessionResult($key){
    $checkPass = $this->db->query("Select * from `thy_users` where `thy_session_key`='$key'");
    $password = $checkPass->row_array();
    return $password;
  }

  public function returnResultByColumn($key,$column){
    $checkPass = $this->db->query("Select * from `thy_users` where `$column`='$key'");
    $password = $checkPass->row_array();
    return $password;
  }

  public function doesHashExist($hash){
    $hashQuery = $this->db->query("Select * from `thy_users` where `thy_user_temp_hash`='$hash'");
    if($hashQuery->num_rows() > 0){
      return true;
    }else{
      return false;
    }
  }

  public function updateRetry($sess){
    $updr = $this->db->query("Update `thy_users` set `thy_attempt`= `thy_attempt`+1 where `thy_session_key`='$sess'");
    if($updr == true){
      return true;
    }else{
      return false;
    }
  }

  public function updateRetry1($sess){
    $updr = $this->db->query("Update `thy_users` set `thy_attempt`= 0 where `thy_session_key`='$sess'");
    if($updr == true){
      return true;
    }else{
      return false;
    }
  }

  public function sendEmailToUser($email){
    $this->load->library('email');
		//SMTP & mail configuration
    $config = array(
    'protocol'  => 'smtp',
    'smtp_host' => 'ssl://smtp.googlemail.com',
    'smtp_port' => 465,
    'smtp_user' => 'freshcode9@gmail.com',
    'smtp_pass' => 'Love123456789',
    'mailtype'  => 'html',
    'charset'   => 'utf-8'
    );
    $this->email->initialize($config);
    $this->email->set_mailtype("html");
    $this->email->set_newline("\r\n");
    $link = $this->hashLink($email,"actView1");
    $result = $this->returnResult($email);
    $hash = $result['thy_user_temp_hash'];
    if($link == false){
      return "Email Falied To send";
    }
		$this->email->from('freshcode9@gmail.com', 'Thy Support');
		$this->email->to($email);
		$this->email->subject('Account Activation');
		$this->email->message('<strong>Please click the link to activate your account:</strong> <a href="'.$link.'">Activate Account</a><br/><br/><strong>Your Activation Code is: '.$hash.'</strong>');
		$this->email->send();

		return "https://www.".$this->emailLink($email,"@");

}


public function sendResetEmailToUser($email){
  $this->load->library('email');
  //SMTP & mail configuration
  $config = array(
  'protocol'  => 'smtp',
  'smtp_host' => 'ssl://smtp.googlemail.com',
  'smtp_port' => 465,
  'smtp_user' => 'freshcode9@gmail.com',
  'smtp_pass' => 'Love123456789',
  'mailtype'  => 'html',
  'charset'   => 'utf-8'
  );
  $this->email->initialize($config);
  $this->email->set_mailtype("html");
  $this->email->set_newline("\r\n");
  $link = $this->hashLink($email,"resetword");
  //$result = $this->returnResult($email);
  //$hash = $result['thy_user_temp_hash'];
  if($link == false){
    return "Email Falied To send";
  }
  $this->email->from('freshcode9@gmail.com', 'Thy Support');
  $this->email->to($email);
  $this->email->subject('Reset Password');
  $this->email->message('<strong>Please click the link to reset your password:</strong> <a href="'.$link.'">Reset Password</a>');
  $this->email->send();

  return "https://www.".$this->emailLink($email,"@");

}


  //tools functions
  public function checkPasswordAlgorithm($password){
    if(preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}$/",$password)){
      return true;
    }else{
      return false;
    }
  }

  public function hashLink($email,$opt){
    $result = $this->returnResult($email);
    if($this->doesHashExist($result['thy_user_temp_hash']) == true){
      $hash = $result['thy_user_temp_hash'];
      $sessionID = $result['thy_session_key'];
      if($opt == "actView1"){
        $link = site_url("/"."Home/".$opt."?user=".$email."&uniquekey=".$sessionID."&secretHash=".$hash);
        return $link;
      }elseif($opt == "actView"){
        $link = site_url("/"."Home/".$opt);
        return $link;
      }else{
        $link = site_url("/"."Home/".$opt."?user=".$email."&uniquekey=".$sessionID."&secretHash=".$hash);
        return $link;
      }

    }else{
      return false;
    }

  }


  public function validateEmail($email){
    $validEmail = $this->sanitizeInput($email);
    if(filter_var($validEmail,FILTER_VALIDATE_EMAIL)){
      return true;
    }else{
      return false;
    }
  }

  public function sanitizeInput($input){
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    $input = $this->db->escape_str($input);
    return $input;
  }

  function crypto_rand_secure($min, $max)
{
    $range = $max - $min;
    if ($range < 1) return $min; // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd > $range);
    return $min + $rnd;
}

function returnRandomString($length)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet.= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max-1)];
    }

    return $token;
}

public function emailLink($word, $section){
  $pos = strpos($word, $section);
  $new = substr($word,$pos+1,strlen($word) - 1);
  return $new;
}
}
?>
