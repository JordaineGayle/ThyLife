<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProfileSettings extends CI_Model{


  public function updateUserSettings($column, $data){
    $this->load->library('session');
    $sessionID = $this->session->userdata('sessionID');
    $updateSetting = $this->db->query("Update `thy_additional_user_info` set `$column`='$data' where `thy_user`='$sessionID'");
    if($updateSetting == true){
      return true;
    }else{
      return false;
    }
  }


  public function updateUserSettings1(){
    $this->load->library('session');
    $sessionID = $this->session->userdata('sessionID');
    $updateSetting = $this->db->query("Insert into `thy_additional_user_info` (`thy_user`) values('$sessionID')");
    if($updateSetting == true){
      return true;
    }else{
      return false;
    }
  }

  public function updateName($column, $data){
    $this->load->library('session');
    $sessionID = $this->session->userdata('sessionID');
    $updateSetting = $this->db->query("Update `thy_users` set `$column`='$data' where `thy_session_key`='$sessionID'");
    if($updateSetting == true){
      return true;
    }else{
      return false;
    }
  }

  public function updateMany($arry){

  }

  public function updateAll($cell,$homenum,$country,$region,$city,$zip){
    $this->load->library('session');
    $sessionID = $this->session->userdata('sessionID');
    //$updateSetting = $this->db->query("Update `thy_users` set `thy_fname`='$fname',`thy_lname`='$lname' where `thy_session_key`='$sessionID'");
    $updateSetting = $this->db->query("Update `thy_additional_user_info` set `thy_mobile`='$cell',`thy_homephone`='$homenum',`thy_country`='$country',`thy_region`='$region',`thy_city`='$city',`thy_zip`='$zip' where `thy_user`='$sessionID'");
    if($updateSetting == true){
      return true;
    }else{
      return false;
    }
  }

  public function insertAll($cell,$homenum,$country,$region,$city,$zip){
    $this->load->library('session');
    $sessionID = $this->session->userdata('sessionID');
    // $updateSetting = $this->db->query("Update `thy_users` set `thy_fname`='$fname',`thy_lname`='$lname' where `thy_session_key`='$sessionID'");
    $updateSetting = $this->db->query("Insert into `thy_additional_user_info` (`thy_user`,`thy_mobile`,`thy_homephone`,`thy_country`,`thy_region`,`thy_city`,`thy_zip`) values ('$sessionID','$cell','$homenum','$country','$region','$city','$zip')");
    if($updateSetting == true){
      return true;
    }else{
      return false;
    }
  }


  public function checkExist(){
    $this->load->library('session');
    $sessionID = $this->session->userdata('sessionID');
    $updateSetting = $this->db->query("Select * from `thy_additional_user_info` where `thy_user`='$sessionID'");
    if($updateSetting->num_rows() == 0){
      return true;
    }else{
      return false;
    }
  }

  public function checkPrivacy(){
    $this->load->library('session');
    $sessionID = $this->session->userdata('sessionID');
    $updateSetting = $this->db->query("Select * from `thy_privacy` where `user`='$sessionID'");
    if($updateSetting->num_rows() == 0){
      return true;
    }else{
      return false;
    }
  }

  public function updatePrivacy($var1,$var2,$var3){
    $this->load->library('session');
    $sess = $this->session->userdata("sessionID");
    
    if($this->checkPrivacy($sess) == true){
     $updatePrivacy = $this->db->query("Insert into `thy_privacy` (`user`,`thy_pri_books`,`thy_pri_post`,`thy_pri_comments`) values ('$sess','$var1','$var2','$var3')");
    }else{
     $updatePrivacy = $this->db->query("Update `thy_privacy` set `thy_pri_books`='$var1',`thy_pri_post`='$var2',`thy_pri_comments`='$var3' where `user`='$sess'"); 
    }

    if($updatePrivacy == true){
      return true;
    }else{
      return false;
    }
  
  }

  public function insertPrivacy($var1,$var2,$var3){
    $sess = $this->ses->userdata("sessioID");
    $updatePrivacy = $this->db->query("Update `thy_privacy` set `thy_pri_post`='$var1',`thy_pri_books`='$var2',`thy_pri_comments`='$var3' where `user`='$sess'");

    if($updatePrivacy == true){
      return true;
    }else{
      return false;
    }
  
  }

}
?>
