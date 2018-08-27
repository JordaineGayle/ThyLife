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

$sess = $this->session->userdata("sessionID");
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
    <style type="text/css">
    ::-webkit-scrollbar {
    width: 0.5em;
    border-radius: 5px;
    z-index: 100;
}

::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    border-radius: 5px;
    z-index: 100;
}

::-webkit-scrollbar-thumb {
  background-color: #37474F;
  outline: 1px solid #03A9F4;
  border-radius: 5px;
  z-index: 100;
}

      *{
        font-family: "Ebrima", "Calibri", "Times New Roman", serif;
        list-style: none;
        padding: 0px;
        margin: 0px;
      }

      #back{
        cursor: pointer;
      }


      body{

        /*flex-flow: row wrap;*/
      }

      nav{
        display: flex;
        align-content: center;
        width: 100%;
        background-color: #37474F;
      }

      nav img{
        padding: 1em;
      }

       nav img:hover{
         background-color: #546E7A;
  transition: background-color 0.4s;
       }

      section{
        width: 40%;
        height: auto;
        background-color: #37474F;
        display: flex;
        flex-flow: row wrap;
         margin-left: 30%;
         /*margin-top: 5%;*/
         box-shadow: inset 0px 0px 10px rgba(5,5,5,0.6);
         justify-content: center;

      }

      section ul li{
        font-weight: bolder;
      }

      .links{
        width: 40%;
        background-color: #03A9F4;
        display: flex;
        flex-flow: row wrap;
        height: auto;
        margin-top: 2%;
        margin-left: 30%;
      }

      .links ul{
        display: flex;
        width: 100%;
        background-color: #03A9F4;
        align-items: center;
        justify-content: space-between;
      }

      .links ul li{
        color: rgba(55,71,79 ,1);
        padding: 1em;
        font-weight: bolder;
      }

      .links ul li:hover{
        background-color: #4FC3F7;
        transition: background-color 0.4s;
        cursor: pointer;
      }
      .content{
        width: 90%;
        display: flex;
        flex-flow: row wrap;
        background-color: rgba(69,90,100 ,0.6);

      }

      .content div{
        display: flex;
        flex-flow: row wrap;
        width: 100%;
        justify-content: center;
        align-content: center;
      }

      #pset p{
        display: flex;
        align-content: center;
        flex-flow: row wrap;
        width: 40%;
        padding: 1em;
        height: auto;
        font-weight: bolder;
        color: rgba(176,190,197 ,1);
         text-shadow: 0px 0px 6px rgba(19,19,19,0.9);
      }

      #pset p input{
        width: 100%;

        background-color: rgba(84,110,122 ,0.3);
        border: none;
        border-bottom: 2px solid rgba(38,50,56 ,1);
        color: white;
        font-weight: bold;
        padding: 1em;
        cursor: pointer;
      }
      input:focus{
        border:none;
      }
      .heading{
        align-content: center;
        width: 100%!important;
        border-top: 2px solid rgba(38,50,56 ,1)!important;
        border-bottom: 2px solid rgba(38,50,56 ,1)!important;
        /*padding: 0.5px!important;*/
      }
      #savebtn{
        background-color: #03A9F4!important;
        color: rgba(55,71,79 ,1)!important;
        /*width: 30%!important;*/
        border: none!important;
        cursor: pointer;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(19,19,19,0.6);
        outline: none;
      }

      #savebtn:hover , #savebtn1:hover, .alert button:hover{
        background-color: rgba(0,188,212,1)!important;
        transition: background-color 0.4s;
      }

      #ppri, #paut{
        display: flex;
        flex-flow: row wrap;
        align-items: center;
      }

      #ppri p{
        width: 100%;
        padding: 1em;
        display: flex;
        flex-flow: row wrap;
        align-items: center;
        padding: 1em;
        height: 40px;
        font-weight: bolder;
        color: rgba(176,190,197 ,1);
        justify-content: space-between;
        text-shadow: 0px 0px 10px rgba(19,19,19,0.9);
      }

      #paut p{
        width: 100%;
        padding: 1em;
        display: flex;
        flex-flow: row wrap;
        align-items: center;
        padding: 1em;
        height: 40px;
        font-weight: bolder;
        color: rgba(176,190,197 ,1);
      }

      #paut .allEditors{
        width: 100%;
        display: flex;
        flex-flow: row wrap;
        height: 400px;
        font-weight: bolder;
        color: rgba(176,190,197 ,1);
        overflow-y: scroll;
        justify-content: center;
        margin-top: 2em;
      }

      #paut .editarea{
        width: 90%;
        display: flex;
        flex-flow: row wrap;
        height: auto;
        font-weight: bolder;
        color: rgba(176,190,197 ,1);
        /* background-color: #263238; */
        padding: 1em;

      }

      .editarea input, .editarea select,.editarea select option{
        width: 100%;
        background-color: rgba(84,110,122 ,0.3);
        border: none;
        border-bottom: 2px solid rgba(38,50,56 ,1);
        color: white;
        font-weight: bold;
        padding: 1em;
        cursor: pointer;
        margin-top:1em;
      }

      .editarea button{
        background-color: #03A9F4!important;
        color: rgba(55,71,79 ,1)!important;
        width: 20%;
        border: none!important;
        cursor: pointer;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(19,19,19,0.6);
        padding: 1em;
        margin-top: 1em;
        margin-bottom:2em;
      }

      .editarea button:focus,input:focus, .editarea select:focus{
        outline: none;
      }
      .editarea button:hover{
        background-color: rgba(0,188,212,1)!important;
        transition: background-color 0.4s;
      }

      #paut table{
        text-align: center;
        color: #FAFAFA;
        display: flex;
        border-collapse: collapse;
        width: 100%;
        justify-content: center;
      }

      #paut table tr:nth-child(even){
        background-color: #29B6F6;

      }

      #paut table tr:first-child{
        background-color: #039BE5!important;
        width: 100%;
        color: rgba(55,71,79 ,1)!important;
      }

      #paut table tr:nth-child(odd){
        background-color: #607D8B;

      }

      #paut table tr:not(:nth-child(2)):nth-child(even):hover{
        background-color: #0277BD;
        transition: background-color 0.4s;
        cursor: pointer;
      }

      #paut table tr:not(:nth-child(2)):nth-child(odd):hover{
        background-color: #263238;
        transition: background-color 0.4s;
        cursor: pointer;
      }
      /* .even:nth-child(even){
        background-color: #607D8B;
      }

      .odd:nth-child(odd){
        background-color: #29B6F6;
      } */

      #paut table tr th{
        padding: 0.5em;
      }

      #paut table tr td{
        padding: 0.5em;
      }

      #paut table tr td img{
        cursor: pointer;
      }


      #paut p span{
       margin-right: 1em;
      }

      #ppri p img{

      }

      #lp{
        justify-content: center!important;
      }

      #lp input{
         font-weight: bolder;
        color: rgba(176,190,197 ,1);
        background-color: #03A9F4!important;
        color: rgba(55,71,79 ,1)!important;
        width: 30%!important;
        border: none!important;
        padding: 1em;
        cursor: pointer;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(19,19,19,0.6);
      }

      .adda{
        background-color: #03A9F4;
        border-radius: 100%;
        box-shadow: 0px 0px 10px rgba(19,19,19,0.8);
        padding: 0.3em;
        cursor: pointer;
      }

      .adda:hover{
        background-color: #29B6F6;
        transition: background-color 0.4s;
      }

      .albox{
        position: absolute;
        width: 100%;
        /* height: 100%; */
        background-color: rgba(19, 19, 19, 0.9);
        z-index: 999;
        display: flex;
        flex-flow: row wrap;
        justify-content: center;
        align-items: center;
      }

      .alert{
        position: absolute;
        box-shadow: 0px 0px 8px rgba(255,255,255,0.5);
        background-color: #E0E0E0;
        z-index: 1000;
        display: flex;
        flex-flow: row wrap;
        width: 300px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;

        justify-content: center;
      }

      .alert h3{
        width: 100%;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        background-color: #29B6F6;
        color: #37474F;
        text-align: center;
        vertical-align: center;
        padding: 1em;
        font-size: 15px;
      }

      .alert div{
        width: 90%;
        display: flex;
        flex-flow: row wrap;
        justify-content: center;
        margin: 1em;
      }

      .alert input{
        width: 100%;
        background-color: transparent;
        border: none;
        /* border-bottom: 2px solid rgba(38,50,56 ,1); */
        color: #37474F;
        font-weight: bold;
        padding: 1em;
        cursor: pointer;
        margin: 1em;
        box-shadow: inset 0px 0px 10px rgba(19, 19, 19, 0.5);
      }


      .alert button{
        background-color: #03A9F4!important;
        color: rgba(55,71,79 ,1)!important;
        border: none!important;
        cursor: pointer;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(19,19,19,0.6);
        outline: none;
        padding: 1em;
        /* margin: 1em; */
      }

      .alert .result{
        width: 100%;
        background-color: transparent;
        border: none;
        /* text-align: center; */
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 2px solid rgba(38,50,56 ,1);
        color: red;
        font-weight: bold;
        font-size: 10px;
        font-style: italic;
        padding: 1em;
        cursor: pointer;
        /* margin: 1em; */
        box-shadow: inset 0px 0px 10px rgba(19, 19, 19, 0.5);
      }
      .ext{
        position: absolute;
        top: 1px!important;
        right: 1px!important;
        cursor: pointer;
      }

      .res{
        width: 100%;
        background-color: transparent;
        border: none;
        /* text-align: center; */
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 2px solid rgba(38,50,56 ,1);
        font-weight: bold;
        font-size: 10px;
        font-style: italic;
        padding: 1em;
        cursor: pointer;
        text-align: center;
        /* margin: 1em; */
        box-shadow: inset 0px 0px 10px rgba(19, 19, 19, 0.5);
      }

      .saved{
        display: flex;
        color: white;
        background-color: #81C784;
        padding: 1em;
        justify-content: center;
        border-radius: 10px;
        position: absolute;
        /*border: 2px solid #4CAF50;*/
        font-weight: bolder;
        box-shadow: 0px 0px 10px rgba(19, 19, 19, 0.5);
        top: 90%;
        left: 5%;
      }

      .fail{
        display: flex;
        color: white;
        background-color: #e57373;
        padding: 1em;
        justify-content: center;
        border-radius: 10px;
        position: absolute;
        font-weight: bolder;
        box-shadow: 0px 0px 10px rgba(19, 19, 19, 0.5);
        top: 90%;
        left: 5%;
      } 

    </style>
  </head>

  <body>
    <div class="saved" style="display:none">Saved Successfully!</div>
    <div class="fail" style="display:none">Failed to Save</div>
    <div class="albox" style="display:none">
      <div class="alert">
        <h3>Authentication Required <img class="ext" src="<?php echo base_url('asssets/ext.png');?>" width="30px" height="30px"/></h3>
        <div>
          <input class="pass" type="password" placeholder="(please enter account password)" autofocus=true />
          <button class="auth">Autenticate</button>
          <button class="auth" style="display:none">Autenticate</button>
          <button class="auth" style="display:none">Autenticate</button>
        </div>
        <p class="result"></p>
      </div>
    </div>


    <nav>

      <img id="back" src="<?php echo base_url('asssets/blleft.png');?>"/>

    </nav>
<article class="links">

        <ul>
          <li class="pset">Edit Personal Settings</li>
          <li class="ppri">Edit Privacy</li>
          <li class="paut">Edit Editors</li>
        </ul>

      </article>
    <section>

      <article class="content">

        <?php
          $myarr = loadSettings($this->session->userdata("sessionID"));
          //$myparr = loadPSettings($this->session->userdata("sessionID"));
        ?>

        <div id="pset" class="hidden">
          <p class="heading">Contact Info</p>

           <p onclick="release(this);" onmouseleave="greyout(this);">
             Cell Number
             <input type="text" value="<?php echo $myarr['thy_mobile']?>"  disabled="disabled" title="click to edit value" class="inpval" />
             <op class="res"></op>
           </p>
           <p onclick="release(this);" onmouseleave="greyout(this);">
             Home Number<input type="text"  value="<?php echo $myarr['thy_homephone']?>"  disabled="disabled" title="click to edit value" class="inpval" />
             <op class="res"></op>
           </p>

          <p class="heading">Address</p>
           <p onclick="release(this);" onmouseleave="greyout(this);">
             Country<input type="text"  value="<?php echo $myarr['thy_country']?>" disabled="disabled" title="click to edit value" class="inpval" />
             <op class="res"></op>
           </p>

           <p onclick="release(this);" onmouseleave="greyout(this);">
             Region<input type="text"  value="<?php echo $myarr['thy_region']?>" disabled="disabled" title="click to edit value" class="inpval" />
             <op class="res"></op>
           </p>

           <p onclick="release(this);" onmouseleave="greyout(this);">
             City<input type="text"  value="<?php echo $myarr['thy_city']?>" disabled="disabled" title="click to edit value" class="inpval" />
             <op class="res"></op>
           </p>

           <p onclick="release(this);" onmouseleave="greyout(this);">
             Zip Code<input type="text"  value="<?php echo $myarr['thy_zip']?>" disabled="disabled" title="click to edit value" class="inpval" />
             <op class="res"></op>
           </p>
          <!-- <p class="heading">Account Changes</p> -->
           <!-- <p onclick="release(this);" onmouseleave="greyout(this);">New Email<input type="text"  value="" disabled="disabled" title="click to edit value" class="inpval" /></p>
           <p onclick="release(this);" onmouseleave="greyout(this);">Confirm New Email<input type="text"  value="" disabled="disabled" title="click to edit value" class="inpval" /></p> -->
           <!-- <p onclick="release(this);" onmouseleave="greyout(this);">New Password<input type="text"  value="" disabled="disabled" title="click to edit value" class="inpval" /></p> -->
           <!-- <p onclick="release(this);" onmouseleave="greyout(this);">Confirm New Password<input type="text"  value="" disabled="disabled" title="click to edit value" class="inpval" /></p> -->
           <!-- <p onclick="release(this);" onmouseleave="greyout(this);">New Username<input type="text" value=""  disabled="disabled" title="click to edit value" class="inpval" /></p> -->
           <!-- <p onclick="release(this);" onmouseleave="greyout(this);">New Username<input type="text"  value=""  disabled="disabled" title="click to edit value" class="inpval" /></p> -->
           <!-- <p onclick="release(this);" onmouseleave="greyout(this);">Securty Question<input type="text"  value="<?php //echo $myarr['thy_sec_quest']?>" disabled="disabled" title="click to edit value" class="inpval" /></p> -->
           <!-- <p onclick="release(this);" onmouseleave="greyout(this);">Security Answer<input type="password"  value="<?php //echo $myarr['thy_sec_ans']?>" disabled="disabled" title="click to edit value" class="inpval" /></p> -->

           <p><input type="button" value="Save" id="savebtn" onclick="saveData();"/></p>
<!-- <p class="result"></p> -->
        </div>

        <div id="ppri" class="hidden" style="display: none;">

          <p ><span>Private Books</span> <img class="back" src="<?php checkPr('thy_pri_books',$sess); ?>" onclick="tswitch(0)" /></p>
          <p ><span>Private Posts</span> <img class="back" src="<?php checkPr('thy_pri_post',$sess); ?>" onclick="tswitch(1)" /></p>
          <p ><span>Disable Comments</span> <img class="back" src="<?php checkPr('thy_pri_comments',$sess); ?>" onclick="tswitch(2)" /></p>
          <p id="lp"><input type="button" value="Save" id="savebtn1" onclick="saveData1();"/></p>


        </div>

        <div id="paut" class="hidden" style="display: none;">

          <p ><span>Add Editor</span> <img src="<?php echo base_url('asssets/add.png');?>" onclick="com();" width="24px" height="24px" class="adda"/></p>

          <div class="editarea" style="display:none;">
            <input type="text" placeholder="editor secret key"/>
            <!-- <input type="text" placeholder="editor Last Name"/>
            <input type="email" placeholder="editor email"/> -->
            <select>
              <option value="123">Please Select a book</option>
              <option value="123">123 John Brom</option>
            </select>

            <button>Add</button>
          </div>

          <div class="allEditors">

            <table>
              <tr ><th colspan="4">View All Editors</th></tr>
              <tr>
                <th>Name</th>
                <th>Book ID</th>
                <!-- <th>Email</th> -->
                <th>ID</th>
                <th>Remove</th>
              </tr>

              <tr>
                <td>Jordaine H, Gayle</td>
                <td>Jm2230</td>
                <!-- <td>jordainegayle34@gmail.com</td> -->
                <td>120001111</td>
                <td><img class="de" src="<?php echo base_url('asssets/del.png');?>" width="24px" height="24px"/></td>
              </tr>

              <tr>
                <td>Jordaine H, Gayle</td>
                <td>Jm2230</td>
                <!-- <td>jordainegayle34@gmail.com</td> -->
                <td>120001111</td>
                <td><img class="de" src="<?php echo base_url('asssets/del.png');?>" width="24px" height="24px"/></td>
              </tr>


              <tr>
                <td>Jordaine H, Gayle</td>
                <td>Jm2230</td>
                <!-- <td>jordainegayle34@gmail.com</td> -->
                <td>120001111</td>
                <td><img class="de" src="<?php echo base_url('asssets/del.png');?>" width="24px" height="24px"/></td>
              </tr>

              <tr>
                <td>Jordaine H, Gayle</td>
                <td>Jm2230</td>
                <!-- <td>jordainegayle34@gmail.com</td> -->
                <td>120001111</td>
                <td><img class="de" src="<?php echo base_url('asssets/del.png');?>" width="24px" height="24px"/></td>
              </tr>
            </table>
          </div>


        </div>

      </article>

    </section>
  </body>
</html>

<script type="text/javascript">

  var t1 = "<?php echo checkPr1('thy_pri_books',$sess); ?>";
  var t2 = "<?php echo checkPr1('thy_pri_post',$sess); ?>";
  var t3 = "<?php echo checkPr1('thy_pri_comments',$sess); ?>";

  function saveData(){
    $(".res").css("color","rgba(176,190,197 ,1)");
    $(".res").html("Processing...<img src='<?php echo base_url('asssets/pleasewait.gif');?>' width='24px' height='24px'/>");
    $(".albox").css("height",$(window).height()+"px");
    $(".albox").fadeIn(1000);
    $(".auth").eq(0).fadeIn(200);
    $(".auth").eq(1).fadeOut(200);
    $(".auth").eq(2).fadeOut(200);
    $("html").css("overflow","hidden");
    $(".result").html("");
    $(".pass").val("");
    $(".pass").focus();
  }

  function saveData1(){
    //$(".res").css("color","rgba(176,190,197 ,1)");
    //$(".res").html("Processing...<img src='<?php echo base_url('asssets/pleasewait.gif');?>' width='24px' height='24px'/>");
    $(".albox").css("height",$(window).height()+"px");
    $(".albox").fadeIn(1000);
     $(".auth").eq(0).fadeOut(200);
    $(".auth").eq(1).fadeIn(200);
    $(".auth").eq(2).fadeOut(200);
    $("html").css("overflow","hidden");
    $(".result").html("");
    $(".pass").val("");
    $(".pass").focus();
  }

  function com(){
    $(".editarea").slideToggle(1000);
  }

  function tswitch(which){

    if( $(".back").eq(which).attr("src") === "<?php echo base_url('asssets/ton.png');?>"){
      $(".back").eq(which).attr("src","<?php echo base_url('asssets/toff.png');?>");
      if(which === 0){
        t1 = 1;
      }else if(which === 1){
        t2= 1;
      }else if(which === 2){
        t3 = 1;
      }
    }else{
      $(".back").eq(which).attr("src","<?php echo base_url('asssets/ton.png');?>");
      if(which === 0){
        t1 = 2;
      }else if(which === 1){
        t2= 2;
      }else if(which === 2){
        t3= 2;
      }
    }


  }

  function release(me){
      $(me).children("input").removeAttr('disabled');
      $(me).children("input").css("cursor","auto");
      $(me).children("input").focus();
  }

  function greyout(me){
      $(me).children("input").attr('disabled','disabled');
      $(me).children("input").css("cursor","pointer");
  }

  $('document').ready(function(){
     
    $(".ext").click(function(){
      $(".albox").fadeOut(1000);
      $("html").css("overflow-y","scroll");
      $(".res").css("color","rgba(176,190,197 ,1)");
        $(".res").html("Please Recheck Before you save");
    }).hover(function(){
      $(this).attr("src","<?php echo base_url('asssets/extg.png');?>").fadeIn(1000);
    }).mouseleave(function(){
      $(this).attr("src","<?php echo base_url('asssets/ext.png');?>").fadeIn(1000);
    });
    $(".de").hover(function(){
      $(this).attr("src","<?php echo base_url('asssets/delg.png');?>").fadeIn(1000);
    }).mouseleave(function(){
      $(this).attr("src","<?php echo base_url('asssets/del.png');?>").fadeIn(1000);
    }).click(function(){
      $(this).parent().parent().fadeOut(1000);
      // $('tr').addClass('odd');
    });

    $(".auth").eq(0).click(function(){
      $(".result").html("Authenticating please wait...<img src='<?php echo base_url('asssets/pleasewait.gif');?>' width='24px' height='24px'/>");
      var pass = $(".pass").val();

      var fname,lname,cell,homenum,country,region,city,zip,oemail,nemail,opass,npass,ouser,nuser,osec,oans;

      // fname = $(".inpval").eq(0).val();
      // lname = $(".inpval").eq(1).val();
      cell = $(".inpval").eq(0).val();
      homenum = $(".inpval").eq(1).val();
      country = $(".inpval").eq(2).val();
      region = $(".inpval").eq(3).val();
      city = $(".inpval").eq(4).val();
      zip = $(".inpval").eq(5).val();
      // oemail = $(".inpval").eq(8).val();
      // nemail = $(".inpval").eq(9).val();
      // opass = $(".inpval").eq(10).val();
      // npass = $(".inpval").eq(11).val();
      // ouser = $(".inpval").eq(12).val();
      // nuser = $(".inpval").eq(13).val();
      // osec = $(".inpval").eq(14).val();
      // oans = $(".inpval").eq(15).val();


      setTimeout(function(){
        $.post("<?php echo site_url('Profile/checkPass');?>",{
        pass:pass,
        cell:cell,
        homenum:homenum,
        country:country,
        region:region,
        city:city,
        zip:zip
        },function(result){
          $(".result").html(result);
        });
      },1000);
    });
//  

  $(".auth").eq(1).click(function(){

     $(".result").html("Authenticating please wait...<img src='<?php echo base_url('asssets/pleasewait.gif');?>' width='24px' height='24px'/>");
      var pass = $(".pass").val();

      setTimeout(function(){
      $.post("<?php echo site_url('Profile/updateUserPrivacy')?>", {pass:pass,book:t1,pst:t2,commt:t3} , function(result){
          $(".result").html(result);
      });    
      },1000);
  });
    $("#back").click(function(){
      window.location.href = "<?php echo site_url('Home/profile');?>";
    });

    $(".pset").click(function(){
      $("#pset").fadeIn(1000);
      $("#ppri").fadeOut(1000);
      $("#paut").fadeOut(1000);
    });

    $(".ppri").click(function(){
      $("#ppri").fadeIn(1000);
      $("#pset").fadeOut(1000);
      $("#paut").fadeOut(1000);
    });

    $(".paut").click(function(){
      $("#paut").fadeIn(1000);
      $("#ppri").fadeOut(1000);
      $("#pset").fadeOut(1000);
    });

     $(".alert").keyup(function(event){
      if(event.keyCode === 13){
        if($(".auth").eq(0).css("display") != "none"){
          $(".auth").eq(0).click();
        }

        if($(".auth").eq(1).css("display") != "none"){
          $(".auth").eq(1).click();
        }
      }else if(event.keyCode === 27){
        $(".ext").click();
      }
    });




  });

</script>
<?php }}?>
