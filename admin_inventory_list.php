<?php
// Start the session
session_start();

//include the DB conf file
include("authconf.php");

	if (!isset($_SESSION['sellerid'])) 
	{
        header("location: ../../cartadmin.php"); 
    	exit();
	}

    else 
    {

	$sellerid = filter_var($_SESSION["sellerid"], FILTER_SANITIZE_STRING);
    $fullname = filter_var($_SESSION["fullname"], FILTER_SANITIZE_STRING);

    }
 
?>

<?php
//Grab whole list of the sellerid for viewing

    $product_list = $pagination = "";
    try
    {
        // Create the Database object
        $conn = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);

        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        /*** prepare the select statement ***/
        $stmt = $conn->prepare("SELECT * FROM product_list WHERE sellerid = :sellerid" );

        /*** bind the parameters ***/ 
        $stmt->bindParam(':sellerid', $sellerid,PDO::PARAM_STR);

        /*** execute the prepared statement ***/
        $stmt->execute();

        //Get the number of rows returned to check if there is any inventory for this sellerid
        $count = $stmt->rowCount();


        // Declare minimum items per page and maximum items per page

        $min_ipp = 10;
        $max_ipp = 50;


        //Get the number of items per page (ipp) or set it to a default value
        $items_per_page = isset($_GET['ipp']) ? $_GET['ipp'] : $min_ipp;

        if (isset($_GET['ipp']))
        {
            $ipp = $_GET['ipp'];
        }
        else
        {

            $ipp = $items_per_page;
        }



        $items_per_page = intval($items_per_page);
        $total_pages = $count/$items_per_page;
        $total_pages = ceil($total_pages);
        



            /** To display the page navigation with page numbers **/


        if ($count > 0)
        {
                $page_num = isset($_GET["page"]) ? $_GET["page"] : 1;

                $page_num = (int) $page_num;

                //$page_num = (int) $_GET['page'];

                if ($page_num > $total_pages)
                {
                    $page_num = $total_pages;
                }


                if ($page_num == "" || $page_num == "1" )
                {
                    $offset=0;

                }


                else
                {
                    $offset=($page_num*$items_per_page)-$items_per_page;

                }


                // Set the active page in the centre of the footer navigation 

                 if (($page_num - 3) <= 0)
                 {
                    $page_start = 1;

                    if (($page_start) + 6 > $total_pages)
                    {
                        $page_end = $total_pages;
                    }
                    else
                    {
                        $page_end = $page_start + 6;
                    }

                 }

                 else
                 {
                    $page_start = $page_num - 3;

                    if (($page_start) + 6 > $total_pages)
                    {
                        $page_end = $total_pages;
                    }
                    else
                    {
                        $page_end = $page_start + 6;
                    }  
                 }

                 /** To display the page navigation with page numbers  and highlight active page**/

                for($i=$page_start; $i<=$page_end; $i++)
                {
                    
                    if ($i == $page_num)
                    {
                        $pagination .= "<li class='active'> <a href='admin_inventory_list.php?page=$i&ipp=$ipp'> $i </a> </li>";   

                    }

                    else
                    {
                        $pagination .= "<li> <a href='admin_inventory_list.php?page=$i&ipp=$ipp'> $i </a> </li>";   
                    }
                    
                }
                   
            

                $stmt_page_list = $conn->prepare("SELECT * FROM product_list WHERE sellerid = :sellerid LIMIT :offset, :items_per_page" );
             
                $stmt_page_list->bindParam(':sellerid', $sellerid,PDO::PARAM_STR);
                $stmt_page_list->bindParam(':offset', $offset,PDO::PARAM_INT);
                $stmt_page_list->bindParam(':items_per_page', $items_per_page,PDO::PARAM_INT);

                $stmt_page_list->execute();

                while ($results = $stmt_page_list->fetchAll())
                {
                    foreach($results as $row)
                    {
                        $id = $row['id'];
                        $product_name = $row['product_name'];
                        $price = $row['price'];
                        $details = $row['details'];
                        $category = $row['category'];
                        $subcategory = $row['subcategory'];
                        $date_added = strftime("%b %d, %Y at %H:%M", strtotime($row["date_added"]));

                        $product_list .= "
                                            <div cass='row'>
                                            <div class='col-md-3 portfolio-item'> <h5 > <strong> $product_name </strong></h5>
                                            <a href='#'> 
                                            <img class='img-responsive' src='product_images/$id.png' alt='' >  <h4> <i class='fa fa-inr'></i>$price </h4> <h6> $details <br> ( Uploaded / edited on $date_added ) </h6>
                                            </a>
                                            </div>
                                            </div>";


                    }
                }
                
        }

        else
        {
            $product_list = "You have no products listed in your store yet";
        }
    }

    catch (Exception $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }



// Function to get the drop down values

function dropdown($name, array $options, $selected)
{
    /*** begin the select ***/
    $dropdown = '<select name="'.$name.'" id="'.$name.'">'."\n";

    /*** loop over the options ***/
    foreach( $options as $key=>$value )
    {
        /*** assign a selected value ***/
        $select = $selected==$key ? ' selected' : null;

        /*** add each option to the dropdown ***/
        $dropdown .= '<option value="'.$key.'"'.$select.'>'.$value.'</option>'."\n";
    }

    /*** close the select ***/
    $dropdown .= '</select>'."\n";

    /*** and return the completed dropdown ***/
    return $dropdown;
}


   

 ?>   

<!DOCTYPE html>
<html>
    <title>Cart Full</title>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="styles/4-col-portfolio.css">
        <link rel="stylesheet" href="styles/startbootstrap-creative/css/bootstrap.min.css">
        <link rel="stylesheet" href="styles/font-awesome/css/font-awesome.min.css" type="text/css" media="screen">

        <!-- Fav Icon -->
        <link rel="icon" href="styles/favicon.ico" type="image/x-icon">
    </head>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
          <div class="container">
            <div class="collapse navbar-collapse navbar-right w3-padding" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
            <li>
              <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
                <div class="container">
                  <!-- Brand and toggle get grouped for better mobile display -->
                  <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                    <a class="navbar-brand"> Cart Full <i class="fa fa-opencart w3-float-right" style="font-size:23px"></i></a> </div>

                  <!-- Collect the nav links, forms, and other content for toggling -->
                  <div class="collapse navbar-collapse navbar-right w3-padding" id="bs-example-navbar-collapse-2">
                    <ul class="nav navbar-nav">
                      <li> <a href="#">About</a> </li>
                      <li> <a href="#">Services</a> </li>
                      <li> <a href="#">Contact</a> </li>
                    </ul>
                  </div>
                  <!-- /.navbar-collapse -->
                </div>
                <!-- /.container -->
              </nav>
            </li>
            </ul>
            </div>
          </div>
        </nav>


<body class="4col-body">
        <!-- Page Content -->
        <div class="container">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-10">
                    <h3 class="page-header">Inventory List 
                        <small> (Total Items - <?php echo $count;?>) <small>
                    </h3>
                </div>
                <div class"col-log-2">

                    <form id="dropdown" name="dropdown" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="get">
                    
                        <label class="page-header"> Items per page
                        
                            <?php 
                                $name = 'ipp';
                                $options = array();

                                for ($ipp_track = $min_ipp; $ipp_track <= $max_ipp; $ipp_track = $ipp_track+10) 
                                { 
                                    
                                    $options[$ipp_track] = $ipp_track;

                                }
                        
                                $selected = isset($_GET['ipp']) ? $_GET['ipp'] : $items_per_page;
                                echo dropdown($name,$options,$selected);
                            ?>

                        <input class="btn-primary" type="submit" value="submit" />
                        </label>
                    </form>
                </div>

            </div>

            <!-- Top Pagination -->
            <div class="row text-center">
                <div class="col-lg-12">
                    <ul class="pagination">
                        <li>
                            <a href="admin_inventory_list.php?page=1&ipp=<?php if ($ipp < $min_ipp) {echo $min_ipp;} elseif($ipp > $max_ipp){echo $max_ipp;} else {echo $ipp;} ?>">&laquo&laquo;</a>
                        </li>

                        <li>
                            <a href="admin_inventory_list.php?page=<?php if (!isset($_GET['page'])) {echo 1;} elseif ($_GET['page'] <=1) { echo 1;} elseif ($_GET['page'] > $total_pages) { $page = $total_pages - 1; echo $page;} else { $page = $_GET['page']; $page = $page - 1; echo $page; } ?>&ipp=<?php if ($ipp < $min_ipp) {echo $min_ipp;} elseif($ipp > $max_ipp){echo $max_ipp;} else {echo $ipp;} ?>">&laquo;</a>
                        </li>

                            <?php echo "$pagination"; ?>

                        <li>
                            <a href="admin_inventory_list.php?page=<?php if (!isset($_GET['page'])) { $page=2; echo $page;} elseif ($_GET['page'] >= $total_pages) { echo $total_pages; }  else {$page = $_GET['page']; $page = $page + 1; echo $page;} ?>&ipp=<?php if ($ipp < $min_ipp) {echo $min_ipp;} elseif($ipp > $max_ipp){echo $max_ipp;} else {echo $ipp;} ?>">&raquo;</a>
                        </li>

                        <li>
                            <a href="admin_inventory_list.php?page=<?php echo $total_pages ?>&ipp=<?php if ($ipp < $min_ipp) {echo $min_ipp;} elseif($ipp > $max_ipp){echo $max_ipp;} else {echo $ipp;} ?>">&raquo&raquo;</a>
                        </li>
                    </ul>
                 </div>
            </div>

            <!-- Display product list -->

            <div class="text-center">
                <p > <?php echo "$product_list"; ?></p>
                <hr>
            </div>

            <!-- Bottom Pagination -->
            <div class="row text-center">
                <div class="col-lg-12">
                    <ul class="pagination">
                        <li>
                            <a href="admin_inventory_list.php?page=1&ipp=<?php echo $ipp; ?>">&laquo&laquo;</a>
                        </li>

                        <li>
                            <a href="admin_inventory_list.php?page=<?php if (!isset($_GET['page'])) {echo 1;} elseif ($_GET['page'] <=1) { echo 1;} elseif ($_GET['page'] > $total_pages) { $page = $total_pages - 1; echo $page;} else { $page = $_GET['page']; $page = $page - 1; echo $page; } ?>&ipp=<?php echo $ipp; ?>">&laquo;</a>
                        </li>

                            <?php echo "$pagination"; ?>

                        <li>
                            <a href="admin_inventory_list.php?page=<?php if (!isset($_GET['page'])) { $page=2; echo $page;} elseif ($_GET['page'] >= $total_pages) { echo $total_pages; }  else {$page = $_GET['page']; $page = $page + 1; echo $page;} ?>&ipp=<?php echo $ipp; ?>">&raquo;</a>
                        </li>

                        <li>
                            <a href="admin_inventory_list.php?page=<?php echo $total_pages ?>&ipp=<?php echo $ipp; ?>">&raquo&raquo;</a>
                        </li>
                    </ul>
                 </div>
            </div>

        </div>

    </body>

</html>
