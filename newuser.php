<?php
session_start();
include("authconf.php");



/*** check the form token is valid ***/
if (isset($_SESSION['form_token']) && isset($_SESSION['sellerid']) && isset($_SESSION['password']) && isset($_SESSION['Email']) && isset($_SESSION['FirstName']) && isset($_SESSION['LastName']) && isset($_SESSION['Gender']))
{


    $sellerid = filter_var($_SESSION["sellerid"], FILTER_SANITIZE_STRING);
    $password = filter_var($_SESSION["password"], FILTER_SANITIZE_STRING);
    $Email = filter_var($_SESSION["Email"], FILTER_SANITIZE_STRING);
    $FirstName = filter_var($_SESSION["FirstName"], FILTER_SANITIZE_STRING);
    $LastName = filter_var($_SESSION["LastName"], FILTER_SANITIZE_STRING);
    $Gender = filter_var($_SESSION["Gender"], FILTER_SANITIZE_STRING);


     
     //Encrypt the passowrd
        $password = md5($password);

      try
      {
        
        $conn = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);

        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        
        // prepared statement for inserting the captured data
        $stmt = $conn->prepare("INSERT INTO user_authentication (sellerid, FirstName,  LastName, Email, Gender, password) VALUES (:sellerid, :FirstName, :LastName, :Email, :Gender, :password)");

        /*** bind the parameters ***/
        $stmt->bindParam(':sellerid', $sellerid, PDO::PARAM_STR);
        $stmt->bindParam(':FirstName', $FirstName, PDO::PARAM_STR);
        $stmt->bindParam(':LastName', $LastName, PDO::PARAM_STR);
        $stmt->bindParam(':Email', $Email, PDO::PARAM_STR);
        $stmt->bindParam(':Gender', $Gender, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR, 40);

        
        
        // execute the prepared statement
        $stmt->execute();

        // Close DB connection
        $conn = null;

        //Redirect to welcome page
        header("Location:welcome.php");

      }

      catch(Exception $e)
      {
        // check if the username already exists 
        if( $e->getCode() == 23000)
        {
              unset( $_SESSION['form_token'] );
              echo 'Sellerid already exists';
        }

      
       else
        {
            /*** if we are here, something has gone wrong with the database ***/
            echo "We are unable to process your request. Please try again later";
            //echo "Connection failed: " . $e->getMessage();
        }
      }
}

?>