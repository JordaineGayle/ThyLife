<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller{

  public function __contruct(){
    parent::__construct();
    $this->load->model('AccessCredentials','manager');
    $this->load->helper('url');
    $this->load->library('session');
  }

  public function index(){
    $this->load->view('profile/editprofile.php');
  }

  public function checkPass(){
    $this->load->model('AccessCredentials','manager');
    $this->load->model('ProfileSettings','set');
    $this->load->library('session');
    $this->load->helper('url');
    $pass = $this->manager->sanitizeInput($this->input->post('pass',true));
    $mypass = $this->manager->returnSessionResult($this->session->userdata("sessionID"));

    // WARNING: please not all variables collected from the view

    // $fname = $this->manager->sanitizeInput($this->input->post("fname",true));
    // $lname = $this->manager->sanitizeInput($this->input->post("lname",true));
    $cell = $this->manager->sanitizeInput($this->input->post("cell",true));
    $homenum = $this->manager->sanitizeInput($this->input->post("homenum",true));
    $country = $this->manager->sanitizeInput($this->input->post("country",true));
    $region = $this->manager->sanitizeInput($this->input->post("region",true));
    $city = $this->manager->sanitizeInput($this->input->post("city",true));
    $zip = $this->manager->sanitizeInput($this->input->post("zip",true));
    // $oemail = $this->manager->sanitizeInput($this->input->post("oemail",true));
    // $nemail = $this->manager->sanitizeInput($this->input->post("nemail",true));
    // $opass = $this->manager->sanitizeInput($this->input->post("opass",true));
    // $npass = $this->manager->sanitizeInput($this->input->post("npass",true));
    // $ouser = $this->manager->sanitizeInput($this->input->post("ouser",true));
    // $nuser = $this->manager->sanitizeInput($this->input->post("nuser",true));


    // if(empty($homenum)){
    //   echo "<script>$('.inpval').eq(3).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
    // }else{
    //   echo "<script>$('.inpval').eq(3).css('box-shadow','inset 0px 0px 0px rgba(255,0,0,0.5)');</script>";
    // }
    // if(empty($country)){
    //   echo "<script>$('.inpval').eq(4).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
    // }else{
    //   echo "<script>$('.inpval').eq(4).css('box-shadow','inset 0px 0px 0px rgba(255,0,0,0.5)');</script>";
    // }
    // if(empty($region)){
    //   echo "<script>$('.inpval').eq(5).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
    // }else{
    //   echo "<script>$('.inpval').eq(5).css('box-shadow','inset 0px 0px 0px rgba(255,0,0,0.5)');</script>";
    // }
    // if(empty($city)){
    //   echo "<script>$('.inpval').eq(6).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
    // }else{
    //   echo "<script>$('.inpval').eq(6).css('box-shadow','inset 0px 0px 0px rgba(255,0,0,0.5)');</script>";
    // }
    // if(empty($zip)){
    //   echo "<script>$('.inpval').eq(7).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
    // }else{
    //   echo "<script>$('.inpval').eq(7).css('box-shadow','inset 0px 0px 0px rgba(255,0,0,0.5)');</script>";
    // }

    if(!empty($pass) && strlen($pass) >= 8){
    if(password_verify($pass,$mypass['thy_user_password'])){
      $isthere = $this->set->checkExist();

      if($isthere == false){

        if(empty($cell)){
          echo "<script>$('.albox').fadeOut(500); $('.inpval').eq(0).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');$('.res').eq(0).css('color','#e57373');</script>";
          echo "<script>$('.res').eq(0).html('* Cell number cannot be empty *')</script>";
        }else{
          if(!(strlen($cell) >= 10 &&  strlen($cell) <= 15) || !ctype_digit($cell)){
            echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(0).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
            echo "<script>$('.res').eq(0).css('color','#e57373');</script>";
            echo "<script>$('.res').eq(0).html('Mobile Number must be 10 - 15 digits')</script>";
          }else{
            $bool = $this->set->updateUserSettings("thy_mobile","$cell");
            if($bool === true){
              echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(0).css('box-shadow','inset 0px 0px 0px rgba(255,0,0,0.5)');</script>";
              echo "<script>$('.res').eq(0).css('color','#81C784');</script>";
              echo "<script>$('.res').eq(0).html('* Saved Successfully *')</script>";
            }else{
              echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(0).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
              echo "<script>$('.res').eq(0).css('color','#e57373');</script>";
              echo "<script>$('.res').eq(0).html('* Falied to save *')</script>";
            }
          }
        }

        if(empty($homenum)){
          echo "<script>$('.albox').fadeOut(500); $('.inpval').eq(1).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');$('.res').eq(1).css('color','#e57373');</script>";
          echo "<script>$('.res').eq(1).html('* Home phone number cannot be empty *')</script>";
        }else{
          if(!(strlen($homenum) >= 10 &&  strlen($homenum) <= 15) || !ctype_digit($homenum)){
            echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(1).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
            echo "<script>$('.res').eq(1).css('color','#e57373');</script>";
            echo "<script>$('.res').eq(1).html('Home Number must be 10 - 15 digits')</script>";
          }else{
            $bool = $this->set->updateUserSettings("thy_homephone","$homenum");
            if($bool === true){
              echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(1).css('box-shadow','inset 0px 0px 0px rgba(255,0,0,0.5)');</script>";
              echo "<script>$('.res').eq(1).css('color','#81C784');</script>";
              echo "<script>$('.res').eq(1).html('* Saved Successfully *')</script>";
            }else{
              echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(1).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
              echo "<script>$('.res').eq(1).css('color','#e57373');</script>";
              echo "<script>$('.res').eq(1).html('* Falied to save *')</script>";
            }
          }
        }


        if(empty($country)){
          echo "<script>$('.albox').fadeOut(500); $('.inpval').eq(2).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');$('.res').eq(2).css('color','#e57373');</script>";
          echo "<script>$('.res').eq(2).html('* Country cannot be empty *')</script>";
        }else{
          if(!(strlen($country) > 2)){
            echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(2).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
            echo "<script>$('.res').eq(2).css('color','#e57373');</script>";
            echo "<script>$('.res').eq(2).html('Your country name is invalid')</script>";
          }else{
            $bool = $this->set->updateUserSettings("thy_country","$country");
            if($bool === true){
              echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(2).css('box-shadow','inset 0px 0px 0px rgba(255,0,0,0.5)');</script>";
              echo "<script>$('.res').eq(2).css('color','#81C784');</script>";
              echo "<script>$('.res').eq(2).html('* Saved Successfully *')</script>";
            }else{
              echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(0).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
              echo "<script>$('.res').eq(2).css('color','#e57373');</script>";
              echo "<script>$('.res').eq(2).html('* Falied to save *')</script>";
            }
          }
        }



        if(empty($region)){
          echo "<script>$('.albox').fadeOut(500); $('.inpval').eq(3).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');$('.res').eq(3).css('color','#e57373');</script>";
          echo "<script>$('.res').eq(3).html('* Region cannot be empty *')</script>";
        }else{
          if(!(strlen($region) > 2)){
          echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(3).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
          echo "<script>$('.res').eq(3).css('color','#e57373');</script>";
          echo "<script>$('.res').eq(3).html('Your region name is invalid')</script>";
        }else{
          $bool = $this->set->updateUserSettings("thy_region","$region");
          if($bool === true){
            echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(3).css('box-shadow','inset 0px 0px 0px rgba(255,0,0,0.5)');</script>";
            echo "<script>$('.res').eq(3).css('color','#81C784');</script>";
            echo "<script>$('.res').eq(3).html('* Saved Successfully *')</script>";
          }else{
            echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(3).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
            echo "<script>$('.res').eq(3).css('color','#e57373');</script>";
            echo "<script>$('.res').eq(3).html('* Falied to save *')</script>";
          }
        }
        }


        if(empty($city)){
          echo "<script>$('.albox').fadeOut(500); $('.inpval').eq(4).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');$('.res').eq(4).css('color','#e57373');</script>";
          echo "<script>$('.res').eq(4).html('** City cannot be empty *')</script>";
        }else{
          if(!(strlen($city) > 2)){
          echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(4).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
          echo "<script>$('.res').eq(4).css('color','#e57373');</script>";
          echo "<script>$('.res').eq(4).html('Your country city is invalid')</script>";
        }else{
          $bool = $this->set->updateUserSettings("thy_city","$city");
          if($bool === true){
            echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(4).css('box-shadow','inset 0px 0px 0px rgba(255,0,0,0.5)');</script>";
            echo "<script>$('.res').eq(4).css('color','#81C784');</script>";
            echo "<script>$('.res').eq(4).html('* Saved Successfully *')</script>";
          }else{
            echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(4).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
            echo "<script>$('.res').eq(4).css('color','#e57373');</script>";
            echo "<script>$('.res').eq(4).html('* Falied to save *')</script>";
          }
        }
        }

      if(empty($zip)){
        echo "<script>$('.albox').fadeOut(500); $('.inpval').eq(5).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');$('.res').eq(5).css('color','#e57373');</script>";
        echo "<script>$('.res').eq(5).html('* Postal code cannot be empty *')</script>";
      }else{
        if(!(strlen($zip) == 5) || !ctype_alnum($zip)){
          echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(5).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
          echo "<script>$('.res').eq(5).css('color','#e57373');</script>";
          echo "<script>$('.res').eq(5).html('Your postal code is invalid')</script>";
        }else{
          $bool = $this->set->updateUserSettings("thy_zip","$zip");
          if($bool === true){
            echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(5).css('box-shadow','inset 0px 0px 0px rgba(255,0,0,0.5)');</script>";
            echo "<script>$('.res').eq(5).css('color','#81C784');</script>";
            echo "<script>$('.res').eq(5).html('* Saved Successfully *')</script>";
          }else{
            echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(5).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
            echo "<script>$('.res').eq(5).css('color','#e57373');</script>";
            echo "<script>$('.res').eq(5).html('* Falied to save *')</script>";
          }
        }
      }

      }else{
        $bool1 = $this->set->updateUserSettings1();

        if($bool1 == true){
                if(empty($cell)){
                  echo "<script>$('.albox').fadeOut(500); $('.inpval').eq(0).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');$('.res').eq(0).css('color','#e57373');</script>";
                  echo "<script>$('.res').eq(0).html('* Cell number cannot be empty *')</script>";
                }else{
                  if(!(strlen($cell) >= 10 &&  strlen($cell) <= 15) || !ctype_digit($cell)){
                    echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(0).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
                    echo "<script>$('.res').eq(0).css('color','#e57373');</script>";
                    echo "<script>$('.res').eq(0).html('Mobile Number must be 10 - 15 digits')</script>";
                  }else{
                    $bool = $this->set->updateUserSettings("thy_mobile","$cell");
                    if($bool === true){
                      echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(0).css('box-shadow','inset 0px 0px 0px rgba(255,0,0,0.5)');</script>";
                      echo "<script>$('.res').eq(0).css('color','#81C784');</script>";
                      echo "<script>$('.res').eq(0).html('* Saved Successfully *')</script>";
                    }else{
                      echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(0).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
                      echo "<script>$('.res').eq(0).css('color','#e57373');</script>";
                      echo "<script>$('.res').eq(0).html('* Falied to save *')</script>";
                    }
                  }
                }

                if(empty($homenum)){
                  echo "<script>$('.albox').fadeOut(500); $('.inpval').eq(1).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');$('.res').eq(1).css('color','#e57373');</script>";
                  echo "<script>$('.res').eq(1).html('* Home phone number cannot be empty *')</script>";
                }else{
                  if(!(strlen($homenum) >= 10 &&  strlen($homenum) <= 15) || !ctype_digit($homenum)){
                    echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(1).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
                    echo "<script>$('.res').eq(1).css('color','#e57373');</script>";
                    echo "<script>$('.res').eq(1).html('Home Number must be 10 - 15 digits')</script>";
                  }else{
                    $bool = $this->set->updateUserSettings("thy_homephone","$homenum");
                    if($bool === true){
                      echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(1).css('box-shadow','inset 0px 0px 0px rgba(255,0,0,0.5)');</script>";
                      echo "<script>$('.res').eq(1).css('color','#81C784');</script>";
                      echo "<script>$('.res').eq(1).html('* Saved Successfully *')</script>";
                    }else{
                      echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(1).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
                      echo "<script>$('.res').eq(1).css('color','#e57373');</script>";
                      echo "<script>$('.res').eq(1).html('* Falied to save *')</script>";
                    }
                  }
                }


                if(empty($country)){
                  echo "<script>$('.albox').fadeOut(500); $('.inpval').eq(2).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');$('.res').eq(2).css('color','#e57373');</script>";
                  echo "<script>$('.res').eq(2).html('* Country cannot be empty *')</script>";
                }else{
                  if(!(strlen($country) > 2)){
                    echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(2).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
                    echo "<script>$('.res').eq(2).css('color','#e57373');</script>";
                    echo "<script>$('.res').eq(2).html('Your country name is invalid')</script>";
                  }else{
                    $bool = $this->set->updateUserSettings("thy_country","$country");
                    if($bool === true){
                      echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(2).css('box-shadow','inset 0px 0px 0px rgba(255,0,0,0.5)');</script>";
                      echo "<script>$('.res').eq(2).css('color','#81C784');</script>";
                      echo "<script>$('.res').eq(2).html('* Saved Successfully *')</script>";
                    }else{
                      echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(0).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
                      echo "<script>$('.res').eq(2).css('color','#e57373');</script>";
                      echo "<script>$('.res').eq(2).html('* Falied to save *')</script>";
                    }
                  }
                }



                if(empty($region)){
                  echo "<script>$('.albox').fadeOut(500); $('.inpval').eq(3).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');$('.res').eq(3).css('color','#e57373');</script>";
                  echo "<script>$('.res').eq(3).html('* Region cannot be empty *')</script>";
                }else{
                  if(!(strlen($region) > 2)){
                  echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(3).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
                  echo "<script>$('.res').eq(3).css('color','#e57373');</script>";
                  echo "<script>$('.res').eq(3).html('Your region name is invalid')</script>";
                }else{
                  $bool = $this->set->updateUserSettings("thy_region","$region");
                  if($bool === true){
                    echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(3).css('box-shadow','inset 0px 0px 0px rgba(255,0,0,0.5)');</script>";
                    echo "<script>$('.res').eq(3).css('color','#81C784');</script>";
                    echo "<script>$('.res').eq(3).html('* Saved Successfully *')</script>";
                  }else{
                    echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(3).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
                    echo "<script>$('.res').eq(3).css('color','#e57373');</script>";
                    echo "<script>$('.res').eq(3).html('* Falied to save *')</script>";
                  }
                }
                }


                if(empty($city)){
                  echo "<script>$('.albox').fadeOut(500); $('.inpval').eq(4).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');$('.res').eq(4).css('color','#e57373');</script>";
                  echo "<script>$('.res').eq(4).html('** City cannot be empty *')</script>";
                }else{
                  if(!(strlen($city) > 2)){
                  echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(4).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
                  echo "<script>$('.res').eq(4).css('color','#e57373');</script>";
                  echo "<script>$('.res').eq(4).html('Your country city is invalid')</script>";
                }else{
                  $bool = $this->set->updateUserSettings("thy_city","$city");
                  if($bool === true){
                    echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(4).css('box-shadow','inset 0px 0px 0px rgba(255,0,0,0.5)');</script>";
                    echo "<script>$('.res').eq(4).css('color','#81C784');</script>";
                    echo "<script>$('.res').eq(4).html('* Saved Successfully *')</script>";
                  }else{
                    echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(4).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
                    echo "<script>$('.res').eq(4).css('color','#e57373');</script>";
                    echo "<script>$('.res').eq(4).html('* Falied to save *')</script>";
                  }
                }
                }

              if(empty($zip)){
                echo "<script>$('.albox').fadeOut(500); $('.inpval').eq(5).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');$('.res').eq(5).css('color','#e57373');</script>";
                echo "<script>$('.res').eq(5).html('* Postal code cannot be empty *')</script>";
              }else{
                if(!(strlen($zip) == 5) || !ctype_alnum($zip)){
                  echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(5).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
                  echo "<script>$('.res').eq(5).css('color','#e57373');</script>";
                  echo "<script>$('.res').eq(5).html('Your postal code is invalid')</script>";
                }else{
                  $bool = $this->set->updateUserSettings("thy_zip","$zip");
                  if($bool === true){
                    echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(5).css('box-shadow','inset 0px 0px 0px rgba(255,0,0,0.5)');</script>";
                    echo "<script>$('.res').eq(5).css('color','#81C784');</script>";
                    echo "<script>$('.res').eq(5).html('* Saved Successfully *')</script>";
                  }else{
                    echo "<script>$('.albox').fadeOut(500);$('.inpval').eq(5).css('box-shadow','inset 0px 0px 10px rgba(255,0,0,0.5)');</script>";
                    echo "<script>$('.res').eq(5).css('color','#e57373');</script>";
                    echo "<script>$('.res').eq(5).html('* Falied to save *')</script>";
                  }
                }
              }
}else{
  echo "* Failed to save data *";
}
      }
    }else{
      $wasRetryUpdated = $this->manager->updateRetry($this->session->userdata("sessionID"));
      if($wasRetryUpdated == true){
      if($mypass['thy_attempt'] > 2 ){
        $this->manager->updateRetry1($this->session->userdata("sessionID"));
        $array_items = array('sessionID', 'activation');
        $this->session->unset_userdata($array_items);
        echo "<script>window.location.href = '".site_url("/?error=Attempts Exceeded: Please login to continue")."';</script>";
      }else{
        echo "* Authentication Failed *";
      }
    }else{
      echo "* Failed to connect *";
    }
      }
    }else{
      echo "* Failed to authenticate the account *";
    }
  }

  public function updateUserPrivacy(){
    $this->load->model('AccessCredentials','manager');
    $this->load->model('ProfileSettings','set');
    $this->load->library('session');
    $this->load->helper('url');

     $pass = $this->manager->sanitizeInput($this->input->post('pass',true));
     $bok = $this->manager->sanitizeInput($this->input->post('book',true));
     $pst = $this->manager->sanitizeInput($this->input->post('pst',true));
     $com = $this->manager->sanitizeInput($this->input->post('commt',true));
    $mypass = $this->manager->returnSessionResult($this->session->userdata("sessionID"));


    if(empty($pass) || (strlen($pass) < 8)){
      echo "* Authentication error *";
    }else{

      if(password_verify($pass,$mypass['thy_user_password'])){

    if(empty($bok) || empty($pst) || empty($com)){
      echo "* Please don't modify code *";
    }else{
      if(!ctype_digit($bok) || !ctype_digit($pst) || !ctype_digit($com)){
         echo "* Please don't modify code: only numbers are allowed *";
      }else{
        $cbok = (int)$bok;
        $cpst = (int)$pst;
        $ccom = (int)$com;

        if(!($cbok >= 1 && $cbok <=2) || !($cpst >= 1 && $cpst <=2) || !($ccom >= 1 && $ccom <=2)){
          echo "* Please don't modify code: invalid digit *";
        }else{
          $success = $this->set->updatePrivacy($cbok,$cpst,$ccom);

          if($success == true){
            echo "<script>$('.saved').fadeIn(1000).fadeOut(2000);$('.albox').fadeOut(1000)</script>";
          }else{
             echo "<script>$('.fail').fadeIn(1000).fadeOut(2000);$('.albox').fadeOut(1000)</script>";
          }
        }
      }
    }
  }else{
    $wasRetryUpdated = $this->manager->updateRetry($this->session->userdata("sessionID"));
      if($wasRetryUpdated == true){
      if($mypass['thy_attempt'] > 2 ){
        $this->manager->updateRetry1($this->session->userdata("sessionID"));
        $array_items = array('sessionID', 'activation');
        $this->session->unset_userdata($array_items);
        echo "<script>window.location.href = '".site_url("/?error=Attempts Exceeded: Please login to continue")."';</script>";
      }else{
        echo "* Authentication Failed *";
      }
    }else{
      echo "* Failed to connect *";
    }
  }

  }
  }

}
?>
