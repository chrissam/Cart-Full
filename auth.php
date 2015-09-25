<?php
session_start();
include("authconf.php");



/*** check the form token is valid ***/
if (isset($_SESSION['form_token']) && ($_SESSION['sellerid']) && ($_SESSION['password'])) 
{


    $sellerid = filter_var($_SESSION["sellerid"], FILTER_SANITIZE_STRING);
    $password = filter_var($_SESSION["password"], FILTER_SANITIZE_STRING);
    //$password = $_SESSION["password"];

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
        $seller_id = $result["sellerid"];
        $firstname = $result["FirstName"];
        $lastname = $result["LastName"];
        $_SESSION['fullname'] = "$firstname" . " " . "$lastname";


      
       //Check if user is validated by checking the user id. (if not correct, it'll return nothing)
       if (!$seller_id)
        {
             echo "Login Failed"; 
             $conn = null;
        }

        else
     	{	
     		//$_SESSION["firstname"] = $firstname;
     		header("Location:inverntory_list.php");
            $conn = null;
    	}

    }

    catch(Exception $e)
    {
        echo "Connection failed: " . $e->getMessage();
       // header("Location:/docs/problem.php");
    }

}

else {

        header("location:/cartadmin.php");
        exit();
        
    
}
?> 

