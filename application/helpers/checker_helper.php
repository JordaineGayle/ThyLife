<?php
defined('BASEPATH') OR exit('No direct script access allowed');

  function checkLikes($postID, $userID){
    //get main CodeIgniter object
       $ci =& get_instance();

       $chCheck = $ci->db->query("Select * from `thy_likes` where `postID`='$postID' AND `userID`='$userID'");
       if($chCheck->num_rows() > 0){
         return base_url('asssets/likes.png');
       }else{
         return base_url('asssets/favorite_grey_24x24.png');
       }
  }

  function loadComments($postID, $user){
    $ci =& get_instance();
    $checkComments = $ci->db->query("Select * from `thy_comments` where `postID`='$postID' ORDER by `commentID` DESC");
    $result = $checkComments->result_array();
    if($checkComments->num_rows() > 0){
      foreach($result as $res){
        if($res['userID'] == $user){
          $usr = "Me";
        }else{
          $username = $res['userID'];
          $co = $ci->db->query("Select * from `thy_users` where `thy_session_key`='$username'");
          $resu = $co->result_array();
          foreach($resu as $r){
            $usr = $r['thy_user_name'];
          }

        }
        $com = $res['comment'];
        echo "<div class='eone'>
        <div class='com_user'>
        <p class='com_user_detail'>
        <img src='".base_url('asssets/comava4.ico')."' width='40px' height='40px'/>
         <span> <em>{$usr}</em> </span>
         <p>
         </div>
         <div class='actcom' style='height:auto'> {$com} </div>
         </div><br/>";
      }
    }else{
      echo "<div class='com_user'><p class='com_user_detail'><span><em>No Comments</em></span><p></div>";
    }

  }

  function loadNotifications($who){
    $ci =& get_instance();
    $checkComments = $ci->db->query("Select * from `thy_notification` where `whos`='$who' ORDER BY `noteID` DESC");
    $result = $checkComments->result_array();
    if($checkComments->num_rows() > 0){
      foreach($result as $res){
        $view = $res['view'];
        if($view == "0"){
          echo "<div style=\"background-color: #03A9F4!important; color: #263238!important; \" class=\"note\">{$res['message']}</div>";
        }else{
          echo "<div class=\"note\">{$res['message']}<p> ON <br/> {$res['date']}</p></div>";
        }

      }
    }else{
      echo "<div class=\"note\"><em>No New Notification</em></div>";
    }
  }


  function loadSettings($who){
    $ci =& get_instance();
    $holdInfo =  $ci->db->query("SELECT * FROM `thy_additional_user_info` where `thy_user`='$who'");
    $data = $holdInfo->row_array();
    return $data;
  }

   function loadPSettings($who){
    $ci =& get_instance();
    $holdInfo =  $ci->db->query("SELECT * FROM `thy_users` where `thy_session_key`='$who'");
    $data = $holdInfo->row_array();
    return $data;
  }

  function checkPr($column,$who){
     $ci =& get_instance();
     $holdInfo = $ci->db->query("Select `user`,`$column` from `thy_privacy` where `user`='$who'");
     $data = $holdInfo->row_array();

     if($data[$column] == 1){
        echo base_url('asssets/toff.png');
     }else if ($data[$column] == 2) {
        echo base_url('asssets/ton.png');
     }
  }

  function checkPr1($column,$who){
     $ci =& get_instance();
     $holdInfo = $ci->db->query("Select `user`,`$column` from `thy_privacy` where `user`='$who'");
     $data = $holdInfo->row_array();

     if($data[$column] == 1){
        return 1;
     }else if ($data[$column] == 2) {
        return 2;
     }
  }

  function book(){
    return true;
  }

?>
