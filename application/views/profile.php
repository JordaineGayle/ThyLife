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
    <title><?php echo $username;?></title>
    <script src="<?php echo base_url('js/jquery.min.js');?>"></script>
    <script src="<?php echo base_url('js/jquery-ui.js');?>"></script>
    <!-- <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/base/jquery-ui.css"></script> -->
    <!-- <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="<?php echo base_url('css/profile.css')?>"/>
    <style type="text/css">
      .note p{
  width: 90%;
  font-size: 10px!important;
  font-style: italic!important;
  font-weight: bold!important;
  color: transparent!important;
  text-shadow: 0px 0px 1px rgba(79,195,247 ,0.6)!important;
}
    </style>
  </head>

  <body>
    <?php echo $error;?>
    <nav class="pro_nav">
      <header class="pro_header">
        <img id="pro_img" src="<?php echo base_url('asssets/ic_account_circle_black_24dp_2x.png');?>" width='50px' height='50px'/>
        <p class="pro_user"><?php echo $username;?></p>
      </header>

      <div class="pro_search">
        <input type="search" placeholder="Search....."/>
        <!-- <img src="<?php //echo base_url('asssets/ic_search_white_24dp_1x.png');?>" width='30px' height='30px'/> -->
      </div>

      <ul class="pro_ul">
        <li title="Notifications" class="bell"><img src="<?php echo base_url('asssets/ic_notifications_black_24dp_2x.png');?>" width='30px' height='30px'/> <div class="alr" style="display:none;"></div></li>
        <li title="Settings" class="settings"><img src="<?php echo base_url('asssets/ic_settings_black_24dp_2x.png');?>" width='30px' height='30px'/></li>
        <li class="logout" title="Logout"><img src="<?php echo base_url('asssets/ic_exit_to_app_black_24dp_2x.png');?>" width='30px' height='30px'/></li>
        <a href="<?php echo site_url('Home/logout');?>" class="log" style="display:none;"></a>
      </ul>
    </nav>
    <div class="pro_notification_bar" style="display:none">
      <?php loadNotifications($this->session->userdata('sessionID')) ;?>
    </div>
    <div class="pro_settings_bar">
      <ul>
        <li><img src="<?php echo base_url('asssets/ic_settings_applications_black_24dp_2x.png');?>" width='30px' height='30px'/>Account Setting</li>
        <li><img src="<?php echo base_url('asssets/ic_settings_applications_black_24dp_2x.png');?>" width='30px' height='30px'/>Theme Settings</li>
      </ul>
    </div>
    <div class="pro_settings">
      <ul>
        <li><img src="<?php echo base_url('asssets/ic_settings_applications_black_24dp_2x.png');?>" width='30px' height='30px'/>View Profile</li>
        <li id="editprofile"><img src="<?php echo base_url('asssets/ic_settings_applications_black_24dp_2x.png');?>" width='30px' height='30px'/>Edit Profile</li>
        <!-- <li><img src="<?php //echo base_url('asssets/ic_settings_applications_black_24dp_2x.png');?>" width='30px' height='30px'/>Theme Settings</li> -->
      </ul>
    </div>

    <!-- <aside class="pro_left">
      <ul>
        <li><img src="<?php //echo base_url('asssets/ic_settings_applications_black_24dp_2x.png');?>" width='30px' height='30px'/>Archives</li>
        <li><img src="<?php //echo base_url('asssets/ic_settings_applications_black_24dp_2x.png');?>" width='30px' height='30px'/>Books</li>
        <li><img src="<?php //echo base_url('asssets/ic_settings_applications_black_24dp_2x.png');?>" width='30px' height='30px'/>Followers</li>
        <li><img src="<?php //echo base_url('asssets/ic_settings_applications_black_24dp_2x.png');?>" width='30px' height='30px'/>Following</li>
      </ul>
    </aside> -->
    <section class="pro_section">
      <article class="pro_sec_article">
        <div id="sms">
          <input placeholder="Title" type="text" id="tTitle" />
          <textarea placeholder="Please Say Something" id="info"></textarea>
        </div>
        <div id="controls">
          <button id="postBtn">Post</button>
        </div>
        <div id="results"><img src="<?php echo base_url('asssets/pleasewait6.gif');?>" width='30px' height='30px'/></div>
        <!-- <iframe src="https://www.facebook.com/plugins/share_button.php?href=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&layout=box_count&size=large&mobile_iframe=true&appId=1566627716728532&width=73&height=58" width="73" height="58" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe> -->
      </article>

      <?php
      $this->load->model('PostModel','send');

        foreach($posts as $post){

          if($this->session->userdata("sessionID") == $post['userID']){

          }else{
            $num++;
            $anon = "id".$num;

      ?>
      <article class="posts">
        <div class="userheading"><p class="username">Post By: <?php echo $post['user']?></p> <p class="posttitle">Title: <?php echo $post['title'];?></p></div>
        <div class="userpost">
          <p class="actualpost <?php echo $num;?>" id='<?php echo $post['postID']; ?>'><?php echo $post['post'];?></p>
          <p class="viewmore" onclick="viewMore(this,'<?php echo $post['postID']; ?>','<?php echo $num;?>')">view more</p>
          <p class="showless" onclick="viewLess(this,'<?php echo $post['postID']; ?>','<?php echo $num;?>')">show less</p>
        </div>
          <div class="interactpost"><p class="like"><span class="<?php echo $anon;?>"><?php echo $post['likes']?></span>
            <img class="<?php echo 'll'.$anon;?>" src="<?php echo checkLikes($post['postID'], $this->session->userdata('sessionID'));?>" width="24px" height="24px" onclick="like('<?php echo $post['postID'];?>','<?php echo $this->session->userdata("sessionID");?>','<?php echo $anon;?>','<?php echo "ll".$anon;?>')"/></p>
             <p class="comment"><span class="<?php echo "cl".$anon;?>"><?php echo $post['comments']?></span>
                <img src="<?php echo base_url('asssets/insert_comment_grey_24x24.png');?>" class="<?php echo "img".$anon;?>" onclick="com('<?php echo "com".$anon;?>')"/></p>
              <!-- <p class="share"><?php //echo $post['shares']?> <img src="<?php //echo base_url('asssets/share_grey_24x24.png');?>"/></p></div> -->
              <div class="commentWrapper" id="<?php echo "com".$anon;?>" style="display:none;">
              <div class="sendComment"><textarea class="<?php echo "cll".$anon;?>"></textarea> <p><button class="co">Comment</button></p></div>
              <script type="text/javascript">
              var interval = null;
                $(".co").eq(<?php echo $num?> - 1).click(function(){
                  comment('<?php echo $post['postID']; ?>','<?php echo "cll".$anon;?>','<?php echo "cl".$anon;?>','<?php echo 'cm'.$anon;?>');
                  var data = {post:'<?php echo $post['postID']?>', user:'<?php echo $username;?>'};
                  $('.<?php echo "cll".$anon;?>').val("");
                  interval = setInterval(function(){
                      jQuery.ajax({
                          type: 'POST',
                          url: "<?php echo site_url('Post/Lo')?>",
                          data: data,
                          dataType: 'text',
                          success: function(result) {
                            $("#cm<?php echo $anon;?>").fadeIn(1000).html(result);

                          }
                      });
                    },3000);
                  //$("#cm<?php //echo $anon;?>").html("<?php //loadComments($post['postID'], $username);?>");

                });
              </script>
              <div class="comments" id="<?php echo 'cm'.$anon;?>" >
                <?php loadComments($post['postID'], $this->session->userdata('sessionID'));?>
              </div>
              </div>
          <div class="datecreated"><p class="actualdate">Date Posted: <?php echo $post['time'];?></p></div>
      </article>
<?php
}}
?>

    </section>
    <!-- <aside class="pro_right">
      <ul>
        <li><img src="<?php //echo base_url('asssets/ic_settings_applications_black_24dp_2x.png');?>" width='30px' height='30px'/>Archives</li>
        <li><img src="<?php //echo base_url('asssets/ic_settings_applications_black_24dp_2x.png');?>" width='30px' height='30px'/>Books</li>
        <li><img src="<?php //echo base_url('asssets/ic_settings_applications_black_24dp_2x.png');?>" width='30px' height='30px'/>Followers</li>
        <li><img src="<?php //echo base_url('asssets/ic_settings_applications_black_24dp_2x.png');?>" width='30px' height='30px'/>Following</li>
      </ul>
    </aside> -->

  </body>

  <script>

  function com(where){
    clearInterval(interval);
    $("#"+where).slideToggle();
    // $("#"+where).
  }

  function viewMore(me,id,i){
      $("#"+id).css({"height":"auto"});
      $(me).hide();
      $(".showless").eq(i - 1).show();
  }

  function viewLess(me,id,i){
      $("#"+id).animate({"height":"50px"},1000);
      $(me).hide();
      $(".viewmore").eq(i - 1).show();
  }

  function like(post, user, where,l){
    var data = {pid:post, uid:user};
        jQuery.ajax({
            type: 'POST',
            url: "<?php echo site_url('Post/Likes')?>",
            data: data,
            dataType: 'json',
            success: function(result) {
              $("."+where).html(result[0]);
              $("."+l).attr("src",result[1]);
            }
        });
  }

  function comment(post, comment,where, yah){
    var  comments = $("."+comment).val();
    if(comments === ""){
      alert("Comment Cannot be empty")
    }else{

      var data = {post:post,comment:comments};
          jQuery.ajax({
              type: 'POST',
              url: "<?php echo site_url('Post/Comments')?>",
              data: data,
              dataType: 'json',
              success: function(result) {
                $("."+where).html(result[0]);
                //$("#"+yah).html("'"+result[1]+"'");
              }
          });
    }
  }

    $("document").ready(function(){

      $("#editprofile").click(function(){
        window.location.href = "<?php echo site_url('Home/editProfile');?>";
      });

      var lol = setInterval(function(){
            jQuery.ajax({
                type: 'POST',
                url: "<?php echo site_url('Post/loadNote')?>",
                dataType: 'text',
                success: function(data) {
                  //if(data[0] === "0"){
                  //  $(".alr").fadeOut(1000);
                    //clearInterval(lol);
                  //}else{
                    //$(".alr").html(data[0]).fadeIn(1000);

                    $(".pro_notification_bar").html(data);
                  //}

                }
            });


      },12000);
 var loll = setInterval(function(){
      jQuery.ajax({
                type: 'POST',
                url: "<?php echo site_url('Post/loadNote1')?>",
                dataType: 'text',
                success: function(data) {
                  if(data === "0"){
                   $(".alr").fadeOut(1000);
                  }else{
                    $(".alr").html(data).fadeIn(1000);
                  }

                }
            });
       },1000);

      $("#postBtn").click(function(){
        var title = $("#tTitle").val();
        var info = $("#info").val();
        if(title == "" || info == ""){
          setTimeout(function(){
            $("#results").html("Please Fill Out All Feilds");
          },300);
        }else{
          $.post("<?php echo site_url('Post/displayResult')?>", {title:title, sms:info},function(result){
            $("#tTtile").val("");
            $("#info").val("");
            setTimeout(function(){
              $("#results").html(result);

            },300);

            setTimeout(function(){
            //  reset("tTtile");
            //  reset("info");
              $("#results").html("<img src='<?php echo base_url('asssets/pleasewait6.gif');?>' width='30px' height='30px'/>");
            },1000);
          });
        }
      });

      $(".logout").click(function(){
        setTimeout(function(){$(".log")[0].click();},300);
      });

      $(".bell").click(function(){
        $(".pro_notification_bar").slideToggle( "slow" );
        $(".pro_settings_bar").slideUp( "slow" );
        $(".pro_settings").slideUp( "slow" );
        $.post("<?php echo site_url("Post/updNote")?>");
      });

      $(".settings").click(function(){
        $(".pro_settings_bar").slideToggle( "slow" );
        $(".pro_notification_bar").slideUp( "slow" );
        $(".pro_settings").slideUp( "slow" );
      });

      $(".pro_header").click(function(){
        $(".pro_settings").slideToggle( "slow" );
        $(".pro_notification_bar").slideUp( "slow" );
        $(".pro_settings_bar").slideUp( "slow" );
      });
    });
  </script>
</html>
<?php   }}?>
