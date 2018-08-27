<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PostModel extends CI_Model{

  public function sendPost($title, $post, $id){
    $this->load->library('session');
    $this->load->model('AccessCredentials','manager');
    $res = $this->manager->returnSessionResult($id);
    $user = $this->manager->sanitizeInput(ucfirst($res['thy_fname'])." ".ucfirst($res['thy_lname']));
    $username = $this->manager->sanitizeInput(strtolower($res['thy_user_name']));
    date_default_timezone_set('Jamaica');
    $d = date('l jS \of F Y h:i:s A');
    $wasSussuful = $this->db->query("Insert into `thy_posts` (`title`,`post`,`userID`,`user`,`likes`,`comments`,`shares`,`time`) values ('$title','$post','$id','$username','0','0','0','$d')");
    if($wasSussuful){
      return true;
    }else{
      return false;
    }
  }

  public function getAllPost(){
    $postQuery = $this->db->query("Select * from `thy_posts` ORDER BY `postID` DESC");
    return $postQuery->result_array();
  }

  public function getUserPost($userID){

  }

  public function getComments($postID){

  }

  public function insertComments($postID,$comment, $user){
    $this->load->library('session');
    $this->load->model('AccessCredentials','manager');
    $id = $this->session->userdata('sessionID');
    $cleanComment = $this->manager->sanitizeInput($comment);

    $insComment = $this->db->query("Insert into `thy_comments` (`postID`,`comment`,`user`,`userID`) values ('$postID','$cleanComment','$user','$id')");
    if($insComment){
      return true;
    }else{
      return false;
    }
  }

  public function getUserData($column,$postID){
    $res = $this->db->query("Select * from `$column` where `postID`='$postID'");
    return $res->row_array();
  }

  public function updateLikes($userID,$postID){
    if($this->checkIfUserLiked($postID,$userID) == false){
    $wasSussuful = $this->db->query("Insert into `thy_likes` (`postID`,`userID`) values ('$postID','$userID')");
    $wasSussufulUpdate = $this->db->query("Update `thy_posts` set `likes`=`likes`+1 where `postID`='$postID'");
    if($wasSussuful and $wasSussufulUpdate){
      return "like";
    }else{
      return false;
    }
  }else{
    $wasSussuful = $this->db->query("Delete from `thy_likes` where `postID`='$postID' AND `userID`='$userID'");
    $wasSussufulUpdate = $this->db->query("Update `thy_posts` set `likes`=`likes`-1 where `postID`='$postID'");
    if($wasSussuful and $wasSussufulUpdate){
      return "unlike";
    }else{
      return false;
    }
  }
  }

  public function checkIfUserLiked($postID, $user){
    $check = $this->db->query("Select * from `thy_likes` where `postID`='$postID' AND `userID`='$user'");
    if($check->num_rows() > 0){
      return true;
    }else{
      return false;
    }
  }

  public function updateComments($postID){
    $wasSussufulUpdate = $this->db->query("Update `thy_posts` set `comments`=`comments`+1 where `postID`='$postID'");
    if($wasSussufulUpdate){
      return true;
    }else{
      return false;
    }
  }
  public function countlikes($postid){
    $postQuery = $this->db->query("Select COUNT(*) as total from `thy_likes` where `postID`='$postid'");
    return $postQuery->row_array();
  }

  public function countNote($userid){
    $postQuery = $this->db->query("Select COUNT(*) as total from `thy_notification` where `whos`='$userid' AND `view`='0'");
    return $postQuery->row_array();
  }

  public function insertNotifications($user, $message, $postID, $myID, $date){
    $intNote = $this->db->query("Insert into `thy_notification` (`user`,`message`,`contentID`,`whos`,`view`,`date`) values ('$user','$message','$postID','$myID','0','$date')");
    if($intNote){return true;}else{return false;}
  }

  public function updateNotifications($postID){
    $intNote = $this->db->query("Update `thy_notification` set `view`='1' where `whos`='$postID'");
    if($intNote){return true;}else{return false;}
  }

  public function Followers(){

  }

  public function Following(){


  }

}
?>
