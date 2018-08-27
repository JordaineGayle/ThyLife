<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
*{
  list-style: none;
}
.original_footer{
  display:flex;
  background-color: #37474F;
  width: 100%;
  margin: 0px;
  padding: 0px;
  flex-flow: row nowrap;
  font-family: "Ebrima", "Calibri", "Times New Roman", serif;
  box-shadow: 0px 0px 10px rgba(0,0,0,0.5);
  margin-top: auto;
}

.original_footer_header{
  color: white;
  width: 20%;
  font-size: 2em;
  text-align: center;
  align-self: center;
  text-shadow: 0px 0px 10px rgba(0,0,0,0.9);
}

.original_footer_header span{
  color: #03A9F4;
}

.original_footer_ul{
  width: 30%;
  text-align: center;
  color: white;
  font-size: 15px;
  height: auto;
  font-weight: 500;
}
.original_footer_ul li{
  cursor: pointer;
  align-self: center;
  padding: 0.5em;
}

.original_footer_ul li:hover{
  color:  #03A9F4;
  transition:color 0.2s;
}

.original_footer_ul li:active{
  color: #1976D2;
  transition:color 0.2s;
}


.footer_h3{
  color:#03A9F4;
  font-weight: bold;
}
</style>

<footer class="original_footer">
  <h1 class="original_footer_header">Copyright<span>2018</span><br/>Thy<span>Life</span></h1>
  <ul class="original_footer_ul">
    <h3 class="footer_h3">Social Networks</h3>
    <li>Facebook</li>
    <li>Instagram</li>
    <li>Twitter</li>
    <li>Snapchat</li>
    <li>Google+</li>
  </ul>

  <ul class="original_footer_ul">
    <h3 class="footer_h3">Pages</h3>
    <li>Home</li>
    <li>Login</li>
    <li>About</li>
    <li>Contact</li>
    <li>terms & Condition</li>
  </ul>

  <ul class="original_footer_ul">
    <h3 class="footer_h3">Contact</h3>
    <li>Address: Lot 116 Phase III, Pitfour</li>
    <li>Email: jordainegayle34@gmail.com</li>
    <li>Telephone: +1 - (876) - 557 - 8447</li>
    <li>Website: www.creativemechanicstudios.com</li>
    <li>"Life is essential, but death is inevitable"</li>
  </ul>
</footer>
