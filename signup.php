<?php
// Start the session
session_start();

/*** set a form token ***/
$form_token = md5( uniqid('auth', true) );

/*** set the session form token ***/
$_SESSION['form_token'] = $form_token;

?>


<!DOCTYPE html>
<html>
<title>W3.CSS</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="styles/w3.css">
<link rel="stylesheet" href="styles/font-awesome/css/font-awesome.min.css">
<body>

  <!-- PHP code to validate form -->

    <?php
  // define variables and set to empty values
  $selleridErr = $emailErr = $passwordErr = $nameErr = "";



  if ($_SERVER["REQUEST_METHOD"] == "POST") 
  {

      $_SESSION["sellerid"] = $_POST["sellerid"];
      $_SESSION["Email"] = $_POST["Email"];
      $_SESSION["FirstName"] = $_POST["FirstName"];
      $_SESSION["LastName"] = $_POST["LastName"];
      $_SESSION["Gender"] = $_POST["Gender"];



     // check if name only contains letters and whitespace
      if (!ctype_alnum($_SESSION["sellerid"])) 
      {
       $selleridErr = "* Only alphanumeric characters allowed";
      }

      elseif ((!ctype_alpha($_SESSION["FirstName"])) || (!ctype_alpha($_SESSION["LastName"])))
      {
        $nameErr = "* Name should only contain alphabets";
      }

      elseif (!filter_var($_SESSION["Email"], FILTER_VALIDATE_EMAIL))
      { 

        $emailErr = "* Invalid email address";
      }

      elseif ($_POST["password"] != $_POST["repassword"])
      { 

        $passwordErr = "* Password did not match";
      }


      else 
      {

        $_SESSION["password"] = $_POST["password"];
        
        header("Location:newuser.php");
        exit();
      }
  }
?>


<header class="w3-container w3-center w3-padding w3-black">
  
  <h1> Cart Full <i class="fa fa-opencart w3-float-right" style="font-size:60px"></i> </h1>

</header>

<div class="w3-row-padding ">

<div class="w3-container w3-half w3-margin-top">

	<form class="w3-container w3-card-4" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<h2 class="w3-text-theme">Sign Up</h2>
		<hr>

		<div class="w3-group">      
    		<input class="w3-input" type="text" name="sellerid" value="<?php if(isset($_POST['sellerid'])){ echo htmlentities($_POST['sellerid']);}?>" maxlength="20" required>
    		<label class="w3-label">User id</label>
        <span class="w3-text-red"> <?php echo $selleridErr ;?></span>
    	</div>

 		<div class="w3-group">      
    		<input class="w3-input" type="text" name="FirstName" value="<?php if(isset($_POST['FirstName'])){ echo htmlentities($_POST['FirstName']);}?>" maxlength="50" required>
    		<label class="w3-label">First Name</label>
        <span class="w3-text-red"> <?php echo $nameErr ;?></span>
  		</div>

  		<div class="w3-group">      
    		<input class="w3-input" type="text" name="LastName" value="<?php if(isset($_POST['LastName'])){ echo htmlentities($_POST['LastName']);}?>" maxlength="50" required>
    		<label class="w3-label">Last Name</label>
        <span class="w3-text-red"> <?php echo $nameErr ;?></span>
  		</div>

  		<div class="w3-group">      
    		<input class="w3-input" type="text" name="Email" value="<?php if(isset($_POST['Email'])){ echo htmlentities($_POST['Email']);}?>" maxlength="50" required>
    		<label class="w3-label">E-mail</label>
        <span class="w3-text-red"> <?php echo $emailErr ;?></span>
  		</div>


  		<div class="w3-group">      
    		<input class="w3-input" type="password" name="password" value="<?php if(isset($_POST['password'])){ echo htmlentities($_POST['password']);}?>" maxlength="20" required>
    		<label class="w3-label">Password</label>
        <span class="w3-text-red"> <?php echo $passwordErr ;?></span>
  		</div>

  		<div class="w3-group">      
    		<input class="w3-input" type="password" name="repassword" value="<?php if(isset($_POST['repassword'])){ echo htmlentities($_POST['repassword']);}?>" maxlength="20" required>
    		<label class="w3-label">Retype-Password</label>
  		</div>

  		<label class="w3-checkbox">
    		<input type="radio" name="Gender" value="M" checked>
    		<div class="w3-checkmark"></div> Male
  		</label><br>

  		<label class="w3-checkbox">
    		<input type="radio" name="Gender" value="F">
    		<div class="w3-checkmark"></div> Female
  		</label>

  		<br><br>
  		<button class="w3-btn w3-indigo"> Sign Up </button>
  		<br><br>
  	</form>

</div>

<div class="w3-half w3-margin-top w3-card-4"> 
	<header class="w3-container ">
		<h3 >You'll Like Us!!</h3>
		
	</header>
	<hr>
	
	<p> <ul class="w3-ul w3-white">
			<li> <i class="fa fa-cloud w3-spin w3-text-purple" style="font-size:10px"></i> We are here to make sure to provide you with the right product which is in your mind.</li> <br>
			<li> <i class="fa fa-cloud w3-spin w3-text-orange" style="font-size:10px"></i> Our promise on gurarantee will not make you disappointed if you are not satisfied with the product </li><br>
			<li> <i class="fa fa-cloud w3-spin w3-text-yellow" style="font-size:10px"></i> Faster delivery will ensure that there will not be delay in your happiness  </li><br>
			<li> <i class="fa fa-cloud w3-spin w3-text-green" style="font-size:10px"></i> There is no day and night for us. We will open the door whenever you knock. Our quality Customer Service personnel are always there to help you :-) <br>
		</ul>
		<hr>
	</p>
	
	<footer class="w3-container w3-deep-orange">
		<h4> www.cartfull.com </h4>
  	</footer>
</div>

</body>
</html>