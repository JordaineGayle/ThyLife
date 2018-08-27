<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
*{
  list-style: none;
}
.original_nav{
  display:flex;
  background-color: #37474F;
  width: 100%;
  margin: 0px;
  padding: 0px;
  flex-flow: row nowrap;
  font-family: "Ebrima", "Calibri", "Times New Roman", serif;
  box-shadow: 0px 0px 10px rgba(0,0,0,0.5);
}

.original_nav_header{
  color: white;
  width: 20%;
  font-size: 2.3em;
  display: flex;
  align-self: center;
  text-shadow: 0px 0px 10px rgba(0,0,0,0.9);
}

.original_nav_header span{
  color: #03A9F4;
}

.original_nav_ul{
  display: flex;
  width: 80%;
  justify-content: flex-end;
  color: white;
  font-size: 20px;
  height: auto;
  font-weight: 500;
}
.original_nav_ul li{
  cursor: pointer;
  align-self: center;
  padding: 1em;
}

.original_nav_ul li:hover{
  background-color: #03A9F4;
  color: #37474F;
  transition: background-color 0.2s, color 0.2s;
}

.original_nav_ul li:active{
  background-color: #1976D2;
  color: #37474F;
  transition: background-color 0.2s, color 0.2s;
}
</style>
<nav class="original_nav">
  <h1 class="original_nav_header">Thy<span>Life</span></h1>
  <ul class="original_nav_ul">
    <li class="home_click">Home</li>
    <a href="<?php echo site_url();?>/Home" id="home_link" style="display:none;"></a>
    <li class="about_click">About</li>
    <li class="register_click">Register</li>
  </ul>
</nav>

<script>

</script>
