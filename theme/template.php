<?php
if(isset($_POST['avail'])){
  
$_SESSION['from'] = $_POST['from'];
$_SESSION['to']  = $_POST['to'];

  redirect(WEB_ROOT. "index.php?page=5");
}

?>

 
 <!DOCTYPE html>
<html lang="en">
<head>
<title>RESORT</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="RESORT">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="/styles/bootstrap-4.1.2/bootstrap.min.css">
<link href="/plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="/plugins/OwlCarousel2-2.3.4/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="/plugins/OwlCarousel2-2.3.4/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="/plugins/OwlCarousel2-2.3.4/animate.css">
<link href="/plugins/jquery-datepicker/jquery-ui.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="/styles/main_styles.css">
<link rel="stylesheet" type="text/css" href="/styles/responsive.css">
<link rel="stylesheet" type="text/css" href="/styles/custom-navbar.css">
<link rel="stylesheet" type="text/css" href="/styles/bootstrap.css">
 <link href="/styles/ekko-lightbox.css" rel="stylesheet">

 <link href="/styles/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
 <link href="/styles/datepicker.css" rel="stylesheet" media="screen">

<?php
if (isset($_SESSION['dragonhouse_cart'])){
  if (count($_SESSION['dragonhouse_cart'])>0) {
    $cart =  count($_SESSION['dragonhouse_cart'])  ;
  } 
 
} 
if (isset($_SESSION['activity'])){
  if (is_array($_SESSION['activity']) && is_object($_SESSION['activity']) &&count($_SESSION['activity'])>0) {
    $activity = count($_SESSION['activity'])  ;
  } 
 
} 
 ?>
</head>
<style>
.centerText {
  margin: auto;
  width: 60%;
  /*border: 3px solid #73AD21;*/
  padding: 10px;
}  
</style>
<body>
 <?php include $small_nav; ?>  
 <br/>
<div class="super_container">
  <header class="header">
    <div class="header_content d-flex flex-column align-items-center justify-content-lg-end justify-content-center">
    <div class="home_title"><h1>Nixie's Mountain Resort</h1>
                            <center><h2 style="color:white;">Aritao, Nueva Vizcaya</h2></center>
    </div>
      <!-- Logo -->
      <div class="logo"><a href="#"><img class="logo_1" src="/images/logo.png" alt=""><img class="logo_2" src="/images/logo_2.png" alt=""><img class="logo_3" src="/images/logo_3.png" alt=""></a></div>

      <!-- Main Nav -->
      <nav class="main_nav">
        <ul class="d-flex flex-row align-items-center justify-content-start">
           <li><a href="/index.php">Home</a></li>
          <!-- <li><a href="/index.php?p=about">About us</a></li> -->
          <li><a href="/index.php?p=rooms">Services</a></li> 
          <!--li><a href="/index.php?p=contact">Contact</a></li> -->
        </ul>
      </nav>

      <!-- Social -->
      <div class="social header_social">
        <ul class="d-flex flex-row align-items-center justify-content-start">
  

          <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
          <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
          <li><a href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
          <li><a href="#"><i class="fa fa-behance" aria-hidden="true"></i></a></li>
        </ul>
      </div>

      <!-- Header Right -->
      <div class="header_right d-flex flex-row align-items-center justify-content-start">
        
        <!-- Search Activation Button -->
<!--         <div class="search_button">
          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 512 512" enable-background="new 0 0 512 512" width="512px" height="512px">
            <g>
              <path d="M495,466.2L377.2,348.4c29.2-35.6,46.8-81.2,46.8-130.9C424,103.5,331.5,11,217.5,11C103.4,11,11,103.5,11,217.5   S103.4,424,217.5,424c49.7,0,95.2-17.5,130.8-46.7L466.1,495c8,8,20.9,8,28.9,0C503,487.1,503,474.1,495,466.2z M217.5,382.9   C126.2,382.9,52,308.7,52,217.5S126.2,52,217.5,52C308.7,52,383,126.3,383,217.5S308.7,382.9,217.5,382.9z" fill="#FFFFFF"></path>
            </g>
          </svg>
        </div> -->

        <!-- Header Link -->
        <!--div class="header_link"><a href="#">Reserve Now</a></div>

        <!-- Hamburger Button -->
        <div class="hamburger"><i class="fa fa-bars" aria-hidden="true"></i></div>

      </div>

      <!-- Search Panel -->
      <div class="search_panel">
        <div class="search_panel_content d-flex flex-row align-items-center justify-content-start">
          <img src="/images/search.png" alt="">
          <form action="#" class="search_form">
            <input type="text" class="search_input" placeholder="Type your search here" required="required">
          </form>
          <div class="search_close ml-auto d-flex flex-column align-items-center justify-content-center"><div></div></div>
        </div>
      </div>
    </div>
      
  </header>

  <!-- Logo Overlay -->

  <!--div class="logo_overlay">
    <div class="logo_overlay_content d-flex flex-column align-items-center justify-content-center">
      <div class="logo"><a href="#"><img src="/images/logo_3.png" alt=""></a></div>
    </div>
  </div>

  <!-- Menu Overlay -->

  <!--div class="menu_overlay">
    <div class="menu_overlay_content d-flex flex-row align-items-center justify-content-center">
      
      <!-- Hamburger Button -->
      <!--div class="hamburger"><i class="fa fa-bars" aria-hidden="true"></i></div>

    </div>
  </div>

  <!-- Menu -->

  <div class="menu">
    <div class="menu_container d-flex flex-column align-items-center justify-content-center">

      <!-- Menu Navigation -->
      <nav class="menu_nav text-center">
        <ul>
          <li><a href="/index.php">Home</a></li>
          <li><a href="/index.php?p=about">About us</a></li>
          <li><a href="/index.php?p=rooms">Services</a></li> 
          <li><a href="/index.php?p=contact">Contact</a></li>
        </ul>
      </nav>
      <div class="button menu_button"><a href="#">Reserve Now</a></div>

      <!-- Menu Social -->
      <div class="social menu_social">
        <ul class="d-flex flex-row align-items-center justify-content-start">
          <li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
          <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
          <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
          <li><a href="#"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>
          <li><a href="#"><i class="fa fa-behance" aria-hidden="true"></i></a></li>
        </ul>
      </div>

    </div>
  </div>


  <!-- Home -->

  <div class="home">
    <div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="/images/home.jpg" data-speed="0.8"></div>
    <div class="home_container d-flex flex-column align-items-center justify-content-center">
      <div class="home_title"><h1>Welcome!</h1></div>
      <div class="home_text text-center"></div>
      <!--div class="button home_button"><a href="#">Reserve now</a></div-->
    </div>
  </div>

  <!-- Booking -->

  <div class="booking">
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="booking_container d-flex flex-row  justify-content-start"> 
            <form action="/index.php?p=booking" method="POST" class="booking_form" autocomplete="off">
              <div class="booking_form_container d-flex flex-lg-row flex-column align-items-start justify-content-start flex-wrap">
                <div class="booking_form_inputs d-flex flex-row align-items-start justify-content-between flex-wrap">
                  <!--<div hidden class="booking_dropdown"><input type="text" class="datepicker booking_input booking_input_a booking_in" placeholder="Check in" name="arrival" required="required" value="<?php echo isset($_POST['arrival']) ? $_POST['arrival'] :date('m/d/Y');?>"></div> -->
                  <div>
                    <input type="text" class="client" id="client_name" name="client_name" placeholder="Firstname" required="required">
                  </div>
                  <div>
                    <input type="text" class="client1" id="lname" name="lname" placeholder="Lastname" required="required">
                  </div>
                  
                  
                  
                  <div class="booking_dropdown"><input type="text" class="datepicker booking_input booking_input_a booking_out" placeholder="Select Date" name="departure" required="required" value="<?php echo isset($_POST['departure']) ? $_POST['departure'] : date('m/d/Y');?>" ></div>
                  <div class="custom-select">
                    <select name="person" id="person">
                      <option value="0">Person</option>
                      <?php $sql ="SELECT distinct(`NUMPERSON`) as 'NumberPerson' FROM `tblroom`";
                               $mydb->setQuery($sql);
                             $cur = $mydb->loadResultList(); 
                                foreach ($cur as $result) { 
                                  echo '<option value='.$result->NumberPerson.'>'.$result->NumberPerson.'</option>';
                                }

                            ?>
                    </select>
                  </div>
                  <div class="custom-select">
                          <?php
                         $accomodation = New Accomodation();
                         $cur = $accomodation->listOfaccomodation(); 
                          ?>
                    <select  name="accomodation" id="person">
                      <option value="0">Accomodation</option>
                      <?php  foreach ($cur as $result) { ?>
                          <option value="<?php echo $result->ACCOMODATION; ?>"><?php echo $result->ACCOMODATION; ?></option>
                          <?php  } ?>
                    </select>
                  </div>
                  <div>
                    <input type="number" class="client" id="contact_number" name="contact_number" placeholder="Mobile Number" required="required">
                  </div>
                  <div>
                    <input type="text" class="client" id="address" name="address" placeholder="Address" required="required">
                  </div>
                  <div>
                    
                  </div>
                </div>
                <button  class="booking_form_button ml-lg-auto">Reserve Now</button>
               
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
<div class="rooms">
  <div class="container">
    <?php 
     check_message();
     require_once $content;  
    ?> 
 
  </div>
</div>

 

 

 
  <footer class="footer">
    <div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="/images/footer.jpg" data-speed="0.8"></div>
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="footer_logo text-center">
            <a href="#"><img src="images/logo.png" alt=""></a>
          </div>
          <div class="footer_content">
            <div class="row">
              <div class="col-lg-4 footer_col">
                <div class="footer_info d-flex flex-column align-items-lg-end align-items-center justify-content-start">
                  <div class="text-center">
                    <div></div>
                    <div></div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 footer_col">
                <div class="footer_info d-flex flex-column align-items-center justify-content-start">
                  <div class="text-center">
                    <div></div>
                    <div></div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 footer_col">
                <div class="footer_info d-flex flex-column align-items-lg-start align-items-center justify-content-start">
                  <div class="text-center">
                    <div></div>
                    <div></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="footer_bar text-center"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
          <!-- add footer-->
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></div>
        </div>
      </div>
    </div>
  </footer>
</div>

<script src="/js/jquery-3.3.1.min.js"></script>
<script src="/styles/bootstrap-4.1.2/popper.js"></script>
<script src="/styles/bootstrap-4.1.2/bootstrap.min.js"></script>
<script src="/plugins/greensock/TweenMax.min.js"></script>
<script src="/plugins/greensock/TimelineMax.min.js"></script>
<script src="/plugins/scrollmagic/ScrollMagic.min.js"></script>
<script src="/plugins/greensock/animation.gsap.min.js"></script>
<script src="/plugins/greensock/ScrollToPlugin.min.js"></script>
<script src="/plugins/OwlCarousel2-2.3.4/owl.carousel.js"></script>
<script src="/plugins/easing/easing.js"></script>
<script src="/plugins/progressbar/progressbar.min.js"></script>
<script src="/plugins/parallax-js-master/parallax.min.js"></script>
<script src="/plugins/jquery-datepicker/jquery-ui.js"></script>
 <script src="/js/ekko-lightbox.js"></script> 
<script src="/js/custom.js"></script>



<script type="text/javascript" src="/js/bootstrap-datepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<!-- <script type="text/javascript" src="/js/bootstrap-datetimepicker.uk.js" charset="UTF-8"></script> -->
</body>
</html>
<!-- Modal photo -->
          <div class="modal fade" id="myModal" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button class="close" data-dismiss="modal" type=
                  "button">×</button>

                  <h4 class="modal-title" id="myModalLabel">Choose Image.</h4>
                </div>

                <form action="/guest/update.php" enctype="multipart/form-data" method=
                "post">
                  <div class="modal-body">
                    <div class="form-group">
                      <div class="rows">
                        <div class="col-md-12">
                          <div class="rows">
                            <div class="col-md-8">
                              <input name="MAX_FILE_SIZE" type=
                              "hidden" value="1000000"> <input id=
                              "image" name="image" type=
                              "file">
                            </div>

                            <div class="col-md-4"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type=
                    "button">Close</button> <button class="btn btn-primary"
                    name="savephoto" type="submit">Upload Photo</button>
                  </div>
                </form>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->

         

 

  <script>
    // tooltip demo
    $('.tooltip-demo').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })

    // popover demo
    $("[data-toggle=popover]")
        .popover() 
 





  //Validates Personal Info
        function personalInfo(){
        var a=document.forms["personal"]["name"].value;
        var b=document.forms["personal"]["last"].value;
        var c=document.forms["personal"]["city"].value;
        var d=document.forms["personal"]["address"].value;
        var e=document.forms["personal"]["dbirth"].value;  
        var f=document.forms["personal"]["zip"].value; 
        var g=document.forms["personal"]["phone"].value;
        var h=document.forms["personal"]["username"].value;
        var i=document.forms["personal"]["password"].value;


 
         if (document.personal.condition.checked == false)
        {
        alert ('pls. agree the term and condition of this hotel');
        return false;
        }
        if ((a=="Firstname" || a=="") || (b=="lastname" || b=="") || (c=="City" || c=="") || (d=="address" || d=="") || (e=="dateofbirth" || e=="") || (f=="Zip" || f=="") || (g=="Phone" || g=="")|| (h=="username" || h=="") || (j=="password" || j==""))
          {
          alert("all field are required!");
          return false;
          }

        }
</script>


<script type="text/javascript">
   
 $(document).ready(function(){

      $(".btnLoginModal").click(function(){

        var user_name = document.getElementById("U_USERNAME").value;
        var pass = document.getElementById("U_PASS").value;
      
      

       $.ajax({ 
          type:"POST",
          url: "checktoken.php",             
          dataType: "text",   //expect html to be returned  
          data:{username:user_name,password:pass},               
          success: function(data){ 
              $("#ErrorMessage").hide();
             $("#ErrorMessage").fadeIn("slow");                 
             $("#ErrorMessage").html(data);  
             // alert(data);
          } 

             
        });  
    });

    });

</script>
<!--/.container-->
<script language="javascript" type="text/javascript">
        function OpenPopupCenter(pageURL, title, w, h) {
            var left = (screen.width - w) / 2;
            var top = (screen.height - h) / 4;  // for 25% - devide by 4  |  for 33% - devide by 3
            var targetWin = window.open(pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
        } 
    </script>
</body>
</html>