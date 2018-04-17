<?php
	//require session and required functions
	require_once('seniorProjectSession_Functions.php');
	require_once('seniorProjectRequiredFunctions.php');

	//if error or alert is found, print it
	if (($message = message()) !== null) {
		echo $message;
	}

	//calls method to establish connection to server
	$mysqli = databaseConnection();

	//if submit button is clicked
	if (isset($_POST["Submit"])) {

      $itemname = $_POST["Name"];
      $location = $_POST["LocationID"];
      $category = $_POST["CategoryID"];
      $quantity = $_POST["Quantity"];
      $description = $_POST["DescriptionInventory"];

			//query to update inventory table
			$itemQuery = "UPDATE Inventory SET ";
			$itemQuery .= "Name = '".$itemname."', ";
			$itemQuery .= "LocationID = ".$location.", ";
      $itemQuery .= "CategoryID = ".$category.", ";
      $itemQuery .= "Quantity = ".$quantity.", ";
      $itemQuery .= "LastQuantityUpdate = NOW(), ";
      $itemQuery .= "Username = '".$_SESSION["Username"]."', ";
      $itemQuery .= "DescriptionInventory = '".$description."' ";
      $itemQuery .= "WHERE InventoryNum = '".$_GET['itemID']."'";

      $itemResult = $mysqli->query($itemQuery);

			if ($itemResult) {
				$_SESSION["alert"] = $itemname." has been updated in Inventory!";
				header("Location: seniorProjectLanding.php");
			}
			else {
        $_SESSION["error"] = "Could not update item!";
        // $_SESSION["error"] = '<script>console.log("'.$itemQuery.'")</script>';
				header("Location: seniorProjectLanding.php");
			}
	}

?>

<!DOCTYPE html>
<html lang = "en">
  <head>
  	<title>Sports Nutrition Inventory System</title>

  	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	  <script src="assets/js/jquery.min.js"></script>
	  <script src="bootstrap/js/bootstrap.min.js"></script>
  </head>

  <style>
    body {
  overflow-x: hidden;
}

#wrapper {
  padding-top: 20px;
  padding-left: 0;
  -webkit-transition: all 0.5s ease;
  -moz-transition: all 0.5s ease;
  -o-transition: all 0.5s ease;
  transition: all 0.5s ease;
}

#wrapper.toggled {
  padding-left: 250px;
}

#sidebar-wrapper {
  z-index: 1000;
  position: fixed;
  left: 250px;
  width: 0;
  height: 100%;
  margin-left: -250px;
  overflow-y: auto;
  background: #00336f;
  -webkit-transition: all 0.5s ease;
  -moz-transition: all 0.5s ease;
  -o-transition: all 0.5s ease;
  transition: all 0.5s ease;
}

#wrapper.toggled #sidebar-wrapper {
  width: 250px;
}

#page-content-wrapper {
  width: 100%;
  position: absolute;
  padding: 15px;
  padding-top: 30;
}

#wrapper.toggled #page-content-wrapper {
  padding-top: 20px;
  position: absolute;
  padding-bottom: 15px;
  margin-right: -250px;
}


/* Sidebar Styles */

.sidebar-nav {
  position: absolute;
  top: 50px;
  width: 250px;
  margin: 0;
  padding: 0;
  list-style: none;
}

.sidebar-nav li {
  text-indent: 20px;
  line-height: 40px;
}

.sidebar-nav li a {
  display: block;
  text-decoration: none;
  color: white;
}

.sidebar-nav li a:hover {
  text-decoration: none;
  color: #fff;
  background: rgba(255, 255, 255, 0.2);
}

.sidebar-nav li a:active, .sidebar-nav li a:focus {
  text-decoration: none;
}

.sidebar-nav>.sidebar-brand {
  height: 65px;
  font-size: 18px;
  line-height: 60px;
}

.sidebar-nav>.sidebar-brand a {
  color: #999999;
}

.sidebar-nav>.sidebar-brand a:hover {
  color: #fff;
  background: none;
}

@media(min-width:768px) {
  #wrapper {
    padding-left: 0;
  }
  #wrapper.toggled {
    padding-left: 250px;
  }
  #sidebar-wrapper {
    width: 0;
  }
  #wrapper.toggled #sidebar-wrapper {
    width: 250px;
  }
  #page-content-wrapper {
    padding: 20px;
    position: relative;
  }
  #wrapper.toggled #page-content-wrapper {
    position: relative;
    margin-right: 0;
  }
}

.sub-menu {
  padding: 0;
  display: none;
  list-style: none;
}

.sidebar-nav li.active ul{
  display: block;
}

.container {
	    width: 90%;
	    padding-top: 200px;
	    position: absolute-center;
}

  </style>

<body>  

<!-- Navbar -->
  <nav class="navbar navbar-inverse navbar-fixed-top" style="background-color: #00336f">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          </button>
          <a class="navbar-brand" href="seniorProjectLanding.php"><i class="glyphicon glyphicon-home" style="color: white"></i></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
        	<ul class="nav navbar-nav navbar-right">
        		<li><a href="#" style="color: white"><?php $firstName = "SELECT FirstName FROM User WHERE Username = '".$_SESSION["Username"]."' LIMIT 1"; $result = $mysqli->query($firstName); $row = $result->fetch_assoc(); echo $row["FirstName"]; 
        		echo " "; $lastName = "SELECT LastName FROM User WHERE Username = '".$_SESSION["Username"]."' LIMIT 1"; $result2 = $mysqli->query($lastName); $row = $result2->fetch_assoc(); echo $row["LastName"]; echo " "; ?> 
        		<i class="glyphicon glyphicon-user" style="color: white"></i></a></li>
        		<li><a href="seniorProjectLogout.php" style="color: white">Logout</a></li>
        	</ul>
        </div>
       </div>
    </nav>

    <div class="container">
  			<div class="jumbotron">
  				<?php
              if (isset($_GET["itemID"]) && $_GET["itemID"] !== "") {
                $updateItemQuery = "SELECT * FROM Inventory WHERE InventoryNum = '".$_GET['itemID']."'";
                $updateItemResult = $mysqli->query($updateItemQuery);
                if ($updateItemResult && $updateItemResult->num_rows > 0) {
                    $row = $updateItemResult->fetch_assoc();

                    echo "<form action='seniorProjectEditUpdateItem.php?itemID=".$_GET['itemID']."' method='POST' required>";
                    echo "<div class='form-group'>";
                      echo "<label for='Name'>Item Name:</label>";
                      echo "<input type='text' class='form-control' name='Name' id='Name' value='".$row["Name"]."' required>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label for='LocationID'>Location:</label>";
                    echo "<select id='LocationID' name ='LocationID' class='form-control'>";
                    
                    $locationQuery = "Select * FROM Location";
                    $locationResult = $mysqli->query($locationQuery);
                    if ($locationResult && $locationResult->num_rows >= 1) {
                        while ($locationRow = $locationResult->fetch_assoc()) {
                            if ($locationRow['LocationID'] == $row["LocationID"]) {
                                echo "<option selected='selected' value = ".$locationRow['LocationID'].">".$locationRow['LocationName']."</option>";
                            }
                            else {
                                echo "<option value = ".$locationRow['LocationID'].">".$locationRow['LocationName']."</option>";
                            }
                        }
                    }
                    else {
                        echo "<h3>Error</h3>";
                    }
                    echo  "</select>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label for='CategoryID'>Category:</label>";
                    echo "<select id='CategoryID' name ='CategoryID' class='form-control'>";
                    
                    $categoryQuery = "Select * FROM Category";
                    $categoryResult = $mysqli->query($categoryQuery);
                    if ($categoryResult && $categoryResult->num_rows >= 1) {
                        while ($categoryRow = $categoryResult->fetch_assoc()) {
                            if ($categoryRow['CategoryID'] == $row["CategoryID"]) {
                                echo "<option selected='selected' value = ".$categoryRow['CategoryID'].">".$categoryRow['CategoryName']."</option>";
                            }
                            else {
                                echo "<option value = ".$categoryRow['CategoryID'].">".$categoryRow['CategoryName']."</option>";
                            }
                        }
                    }
                    else {
                        echo "<h3>Error</h3>";
                    }
                    echo  "</select>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                      echo "<label for='Quantity'>Quantity:</label>";
                      echo "<input type='text' class='form-control' name='Quantity' id='Quantity' value='".$row["Quantity"]."' required>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                      echo "<label for='DescriptionInventory'>Reason for Update (optional):</label>";
                      echo "<input type='text' class='form-control' name='DescriptionInventory' id='DescriptionInventory' value='".$row["DescriptionInventory"]."'>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                      echo "<button type='submit' name='Submit' class='btn btn-primary'>Update Item</button>";
                    echo "</div>"; 
                    echo "</form>"; 

                }
              }
          ?>

  			</div>
  		</div>
</body>    