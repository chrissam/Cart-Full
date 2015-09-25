
<!DOCTYPE html>
<html>
<title>Cart Full</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="styles/w3.css">
<link rel="stylesheet" href="styles/font-awesome/css/font-awesome.min.css" type="text/css" media="screen">

 <!-- Fav Icon -->
    <link rel="icon" href="styles/favicon.ico" type="image/x-icon">


  <?php

  $LoginErr="";

//Autenticate user upon submitting the form

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

        include("authconf.php");
    

        $sellerid = filter_var($_POST["sellerid"], FILTER_SANITIZE_STRING);
        $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);

        $password = md5($password);

        try
      {
        $conn = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);

        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        /*** prepare the select statement ***/
        $stmt = $conn->prepare("SELECT sellerid, FirstName, LastName, password FROM user_authentication WHERE sellerid = :sellerid AND password = :password");

    
        /*** bind the parameters ***/ 
        $stmt->bindParam(':sellerid', $sellerid,PDO::PARAM_STR);
        $stmt->bindParam(':password',$password,PDO::PARAM_STR, 40);


        /*** execute the prepared statement ***/
        $stmt->execute();

        /*** check for a result ***/
        // $user_id = $stmt->fetchColumn();
     
        $result = $stmt->fetch();
        $sellerid = $result["sellerid"];
        $firstname = $result["FirstName"];
        $lastname = $result["LastName"];
        $fullname = "$firstname" . " " . "$lastname";


      
       //Check if user is valid by checking the user id. (if not correct, it'll return nothing)
       if (!$sellerid)
        {
        
             $LoginErr = "Login Failed. Either your userid or password is incorrect"; 
             
             $conn = null;
        }

        else
        { 
            
          session_start();
          $_SESSION['sellerid'] = $sellerid;
          $_SESSION['firstname'] = $firstname;
          $_SESSION['lastname'] = $lastname;
          $_SESSION['fullname'] = $fullname;


          header("Location:admin_inventory_list.php");
          
          //session_destroy();
          $conn = null;
        }

      }

      catch(Exception $e)
      {
        echo "Connection failed: " . $e->getMessage();
       // header("Location:/docs/problem.php");
      }

     }
   
?>

<header class="w3-container w3-center w3-padding w3-black">
  
  <h1> Cart Full <i class="fa fa-opencart w3-float-right" style="font-size:60px"></i> </h1>

</header>


<div class="w3-container w3-half w3-margin-top">

  <form class="w3-container w3-card-4"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <h2 class="w3-text-theme">Cart Admin Login <br> <span class="w3-text-red"> <h6> <?php echo $LoginErr ;?> </h6> </span> </h2>
    <div class="w3-group">      
      <input class="w3-input" type="text" name="sellerid" maxlength="20" required>
      <label class="w3-label">User id</label><br>
    </div>

    <div class="w3-group">      
      <input class="w3-input" type="password" name="password" maxlength="20" required>
      <label class="w3-label">Password</label>
    </div>

    <label class="w3-checkbox">
      <input type="checkbox" checked="checked">
      <div class="w3-checkmark"></div> Stay Logged In
    </label>

    <br><br>
    
    <div class="w3-row">
      <div class="w3-quarter" >
        <button class="w3-btn w3-green" >Log in </button>
      </div>
      <div class="w3-quarter">
        <a class="w3-btn w3-indigo" href="docs/cartadmin/signup.php">  Sign Up  </a> 
      </div>
    </div>
        <br><hr>
  </form>
</div>

<div class="w3-container1 w3-half w3-margin-top">
  <header class="w3-container w3-white"> <h4> Welcome to Cart Full!!</h4></header>

  <div class="w3-container w3-white"> <p> This is the login page for Cart Administrators..
    <br>
    Cart Administrators can manage their inventories through this site. If you want to sell your products through us, register yourself by signing up with us!!.
    <br>
    Happy Selling!!
  </div> 

  <hr>
  <footer class="w3-container w3-deep-orange">
    <h4> www.cartfull.com </h4>
  </footer>
</div>

</div>

</body>
</html> 