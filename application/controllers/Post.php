<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends CI_Controller{

  public function __contruct(){
    parent::__construct();
    $this->load->model('AccessCredentials','manager');
    $this->load->model('PostModel','send');
    $this->load->helper('url');
    $this->load->library('session');
  }

  public function index(){
    $this->load->model('AccessCredentials','manager');
    $this->load->model('PostModel','send');
    $this->load->helper('url');
    $this->load->library('session');

  }

  public function displayResult(){
    $this->load->model('AccessCredentials','manager');
    $this->load->model('PostModel','send');
    $this->load->helper('url');
    $this->load->library('session');
    $title = $this->manager->sanitizeInput($this->input->post("title",true));
    $post = $this->manager->sanitizeInput($this->input->post("sms",true));

    if($this->session->has_userdata("sessionID")){
      $id = $this->session->userdata('sessionID');
      $isPosted = $this->send->sendPost($title,$post,$id);
      if($isPosted == true){
        echo "Posted Successfully";
      }else{
        echo "Post Falied";
      }
    }else{
      echo "<script>setTimeout(function(){window.location.href = '".site_url('Home/index')."/?error=Please Login To Make Post';},200);</script>";
    }
  }

  public function Likes(){
    date_default_timezone_set('Jamaica');
        $d = date('l jS \of F Y h:i:s A');
    $this->load->model('AccessCredentials','manager');
    $this->load->model('PostModel','send');
    $this->load->library('session');
    $this->load->helper('checker');
    $user = $this->manager->sanitizeInput($this->input->post("uid",true));
    $post = $this->manager->sanitizeInput($this->input->post("pid",true));
    if($this->session->has_userdata("sessionID")){
      $res = $this->manager->returnSessionResult($this->session->userdata('sessionID'));
      $usr = $this->manager->sanitizeInput(strtolower($res['thy_user_name']));
      $id = $this->session->userdata('sessionID');
        $isLiked = $this->send->updateLikes($id, $post);
        if($isLiked == "like"){
          $howmuch = $this->send->getUserData('thy_posts',$post);
          $much = $howmuch['likes'];
          $error = checkLikes($post, $user);
          echo json_encode(array($much, $error));
          $sms = $usr." likes your post: \"".substr($howmuch['title'],0,20).".....\"";
          $this->send->insertNotifications($id,$sms,$post,$howmuch['userID'],$d);
        }else{
          $howmuch = $this->send->getUserData('thy_posts',$post);
          $much = $howmuch['likes'];
          $error = checkLikes($post, $user);
          echo json_encode(array($much, $error));
          $sms = $this->manager->sanitizeInput("Someone unliked your post: \"".substr($howmuch['title'],0,20).".....\"");
          $this->send->insertNotifications($id,$sms,$post,$howmuch['userID'],$d);
        }
    }else{
      echo "<script>setTimeout(function(){window.location.href = '".site_url('Home/index')."/?error=Please Login To Make Post';},200);</script>";
    }
  }

  public function loadNote(){
    $this->load->model('PostModel','send');
    $this->load->library('session');
    $this->load->helper('checker');
    $id = $this->session->userdata('sessionID');
    //$howmuch = $this->send->countNote($id);
    echo loadNotifications($id);

  }

  public function loadNote1(){
    $this->load->model('PostModel','send');
    $this->load->library('session');
    $id = $this->session->userdata('sessionID');
    $howmuch = $this->send->countNote($id);
    echo $howmuch['total'];

  }
  public function Comments(){
    $this->load->model('AccessCredentials','manager');
    $this->load->model('PostModel','send');
    $this->load->library('session');
    $this->load->helper('checker');
    $post = $this->manager->sanitizeInput($this->input->post("post",true));
    $comment = $this->manager->sanitizeInput($this->input->post("comment",true));
    if($this->session->has_userdata("sessionID")){
      $res = $this->manager->returnSessionResult($this->session->userdata('sessionID'));
      $user = $this->manager->sanitizeInput(strtolower($res['thy_user_name']));
      $this->send->updateComments($post);
      $hasCommented = $this->send->insertComments($post,$comment,$user);
      if($hasCommented == true){
        $id = $this->session->userdata('sessionID');
        $howmuch = $this->send->getUserData('thy_posts',$post);
        $much = $howmuch['comments'];
        echo json_encode(array($much));
        $sms = $this->manager->sanitizeInput($user." commented on your post ".substr($howmuch['title'],0,20).": saying \"".substr($comment,0,20).".....\"");
        date_default_timezone_set('Jamaica');
        $d = date('l jS \of F Y h:i:s A');
        $this->send->insertNotifications($id,$sms,$post,$howmuch['userID'],$d);
        // $howm = $this->send->getUserData('thy_comments',$post);
        // $muc = $how['comments'];
        //
        // $sms = $user." commented your post: ".substr($howmuch['title'],0,20).".....";
        // $this->send->insertNotifications($id,$sms,$post,$howmuch['userID']);
      }
    }else{
      echo "<script>setTimeout(function(){window.location.href = '".site_url('Home/index')."/?error=Please Login To Make Post';},200);</script>";
    }
  }

  public function Lo(){
    $this->load->helper('checker');
    $this->load->library('session');
    $this->load->model('AccessCredentials','manager');
    $post = $this->manager->sanitizeInput($this->input->post("post",true));
    $user = $this->manager->sanitizeInput($this->input->post("user",true));
    echo loadComments($post, $this->session->userdata('sessionID'));
  }

  public function updNote(){
    $this->load->model('PostModel','send');
    $this->load->library('session');
    $this->send->updateNotifications($this->session->userdata('sessionID'));
  }
}
?>
