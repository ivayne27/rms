<!DOCTYPE html>
<?php require_once("../includes/initialize.php"); ?>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
   
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 <link rel="stylesheet" type="text/css" href="style.css">  
<link rel="stylesheet" type="text/css" href="css/responsive.css">    

<link rel="stylesheet" type="text/css" href="css/bootstrap.css">  

<link rel="stylesheet" type="text/css" href="fonts/css/font-awesome.min.css"> 


<!-- DataTables CSS -->
<!-- <link href="css/dataTables.bootstrap.css" rel="stylesheet"> -->
 
 <link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
 <link href="css/datepicker.css" rel="stylesheet" media="screen">

 <link href="css/galery.css" rel="stylesheet" media="screen">
</head>
<body onload="window.print();">


<?php

if (!isset($_SESSION['dragonhouse_cart'])) {
  # code...
  redirect('/index.php');
}


if (isset($_POST['profileCheck'])) {
  # code...
    unset($_SESSION['pay']);
   unset($_SESSION['dragonhouse_cart']);
}

/*$guestid =$_GET['guestid'];
$guest = new Guest();
$result=$guest->single_guest($guestid);*/

  $name = $_SESSION['name']; 
  $last = $_SESSION['last'];
  // $country =$_SESSION['country'];
  $city = $_SESSION['city'] ;
  $address = $_SESSION['address'];
  $zip =  $_SESSION['zip'] ;
  $phone = $_SESSION['phone'];
  // $email = $_SESSION['email'];
  // $password =$_SESSION['pass'];
  $stat = $_SESSION['pending'];

?>


<div id="accom-title"  > 
    <div  class="pagetitle">   
            <h1  >Reservation Details
                 
            </h1> 
       </div> 
  </div>

    <form action="index.php?view=payment" method="post"  name="" >
         
            
           <p>
            <? print(Date("l F d, Y")); ?>
            <br/><br/>
           Sir/Madam <?php echo $name.' '.$last;?> <br/>
           <?php echo $address;?><br/>
           <?php echo $phone;?> <br/>
           <!-- <?php echo $email;?><br/><br/> -->
           Dear Sir/Madam. <?php echo $last;?>,<br/><br/>
           Greetings from dragonhouse Beach Resorts!<br/><br/>
           Please check the details of your reservation:<br/><br/>
           <strong>GUEST NAME(S):</strong> <?php echo $name.' '.$last;?>


          </p>

        <table class="table table-hover" style="font-size:11px">
                  <thead>
              <tr  bgcolor="#999999">
              <!-- <th width="10">#</th> -->
              <th align="center" width="120">Item Type</th>
               <th align="center" width="120">Check In</th>
                <th align="center" width="120">Check Out</th>
                 <th align="center" width="120">Days</th>
              <th  width="120">Price</th>
               <th align="center" width="120">Item</th>
              <th align="center" width="90">Amount</th>
           
              
         
            </tr> 
          </thead>
          <tbody>
          
            <?php




             $arival   = $_SESSION['from']; 
              $departure = $_SESSION['to']; 
              $days = dateDiff($arival,$departure);
              $count_cart = count($_SESSION['dragonhouse_cart']);

                for ($i=0; $i < $count_cart  ; $i++) {    
              $mydb->setQuery("SELECT * FROM `tblroom` r, `tblaccomodation` a WHERE  r.`ACCOMID`=a.`ACCOMID` AND `ROOMID` =". $_SESSION['dragonhouse_cart'][$i]['dragonhouseroomid']);
              $cur = $mydb->loadResultList();

            foreach ($cur as $result) {
              echo '<tr>'; 
              // echo '<td></td>';
              echo '<td>'. $result->ROOM.' '. $result->ACCOMODATION.'</td>';
              echo '<td>'.$_SESSION['dragonhouse_cart'][$i]['dragonhousecheckin'].'</td>';
              echo '<td>'.$_SESSION['dragonhouse_cart'][$i]['dragonhousecheckout'].'</td>';
              echo '<td>'.$_SESSION['dragonhouse_cart'][$i]['dragonhouseday'].'</td>';
              echo '<td> ₱'. $result->PRICE.'</td>';
               echo '<td >1</td>';
                echo '<td >₱'. $_SESSION['dragonhouse_cart'][$i]['dragonhouseroomprice'].'</td>';
        

              
              echo '</tr>';
            } 


          }
           $payable= $result->PRICE *$days;
           $_SESSION['pay']= $payable;
            ?>
          </tbody>
          <tfoot>
               <tr>
                   <td colspan="5"></td><td align="right"><h5><b>Order Total: </b></h5>
                   <td align="left">
                  <h5><b> <?php echo '₱' . $payable= $days*$result->PRICE; ?></b></h5>
                                   
                  </td>
          </tr>
      
         
          </tfoot>  
        </table>

    
<p>We are eagerly anticipating your arrival and would like to advise you of the following in order to help you with your trip planning.Your reservation number is <b><?php echo $_SESSION['confirmation']?>:</b><br/><br/>Should there be a concern with your reservation, a customer service representative will contact you. Otherwise, consider your reservation confirmed.</p>
<ul>
 <li>Function Room rate is ₱ 500.00 for first four hours and ₱ 100.00 for each succeeding hours.</li>
 <li>No pets allowed.</li>
 <li>Outside foods are allowed inside the guest house.</li>
 <li>Check in time is 1pm and Check out time is 12 noon.</li>
 <li>Guest arriving before 1 pm shall be accommodated if rooms are vacant and ready.</li>
 <li>Free WIFI access.</li>
 <li>Room rates inclusive of government tax and service charge.</li>
 <li>Rates are subject to change without prior notice.</li>
 <li>Cancellation notification must be made at least 10 days prior to arrival for refund of deposits. Cancellation received within the 10 days period will result to forfeiture of full deposits.</li>
 <li>We serve Breakfast, Lunch and Dinner upon request with 2 hours notice.</li><br>
<strong>I have agreed that I will present the following documents upon check in:</strong><br/>
 <li>Copy of BDO Payment.</li>
 <li>Authorization letter issued by BDO payer for guest/s whose transactions were paid for in his/ her behalf.</li>
 </ul>
If you have any questions, please email at dragonhouse.com or call (034) 4713 – 135
<br/><br/>
Thank you for choosingSAMPLE RESORT
<br/><br/>
Respectfully your,<br/><br/>


 
</form>
</body>
</html>