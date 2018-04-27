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

  $itemID = $_GET['itemID'];

	//if submit button is clicked
	if (isset($_POST["Submit"])) {

	  if ($_POST['newLocation'] === ""){
	  	$_SESSION['error'] = "There is no other location in the database to move this item! Item move cancelled!";
	  	header("Location: seniorProjectLanding.php");
	  	exit;
	  }

      //get info from item you are moving
      $infoQuery = "SELECT * FROM Inventory NATUAL JOIN Location WHERE InventoryNum = '".$itemID."'";
      $infoResult = $mysqli->query($infoQuery);
      $infoRow = $infoResult->fetch_assoc();

      $itemname = $infoRow["Name"];
      $location = $infoRow["LocationID"];
      $category = $infoRow["CategoryID"];
      $quantity = $infoRow["Quantity"];
      $newQuantity = ($quantity - $_POST["moveQuantity"]);
      $description = $infoRow["DescriptionInventory"];

			//query to decrease quantity in item selected
	  $itemUpdateQuery = "UPDATE Inventory SET ";
	  $itemUpdateQuery .= "Name = '".$itemname."', ";
	  $itemUpdateQuery .= "LocationID = ".$location.", ";
      $itemUpdateQuery .= "CategoryID = ".$category.", ";
      $itemUpdateQuery .= "Quantity = ".$newQuantity.", ";
      $itemUpdateQuery .= "LastQuantityUpdate = NOW(), ";
      $itemUpdateQuery .= "Username = '".$_SESSION["Username"]."', ";
      $itemUpdateQuery .= "DescriptionInventory = '".$description."' ";
      $itemUpdateQuery .= "WHERE InventoryNum = '".$_GET['itemID']."'";

      $itemUpdateResult = $mysqli->query($itemUpdateQuery);

      //get info from item you are moving to
      $movedItemQuery = "SELECT * FROM Inventory NATURAL JOIN Location WHERE Name = '".$itemname."' AND LocationID = ".$_POST['newLocation']."";
      $movedItemResult = $mysqli->query($movedItemQuery);
      $movedItemRow = $movedItemResult->fetch_assoc();

      $relocatedItemName = $movedItemRow["Name"];
      $relocatedLocation = $movedItemRow["LocationID"];
      $relocatedCategory = $movedItemRow["CategoryID"];
      $originalQuantity = $movedItemRow["Quantity"];
      $relocatedQuantity = ($originalQuantity + $_POST["moveQuantity"]);
      $relocatedDescription = $_POST["moveDescription"];

      //update seleted location/item with new quantity
      $relocatedUpdateQuery = "UPDATE Inventory SET ";
      $relocatedUpdateQuery .= "Name = '".$relocatedItemName."', ";
      $relocatedUpdateQuery .= "LocationID = ".$relocatedLocation.", ";
      $relocatedUpdateQuery .= "CategoryID = ".$relocatedCategory.", ";
      $relocatedUpdateQuery .= "Quantity = ".$relocatedQuantity.", ";
      $relocatedUpdateQuery .= "LastQuantityUpdate = NOW(), ";
      $relocatedUpdateQuery .= "Username = '".$_SESSION["Username"]."', ";
      $relocatedUpdateQuery .= "DescriptionInventory = '".$relocatedDescription."' ";
      $relocatedUpdateQuery .= "WHERE InventoryNum = '".$movedItemRow['InventoryNum']."'";

      $relocatedUpdateResult = $mysqli->query($relocatedUpdateQuery);

			if ($itemUpdateResult && $relocatedUpdateResult) {
				$_SESSION["alert"] = $itemname." of quantity ".$_POST['moveQuantity']." has been moved from ".$infoRow['LocationName']." to ".$movedItemRow['LocationName']."!";
				header("Location: seniorProjectLanding.php");
			}
			else {
        $_SESSION["error"] = "Could not discard item!";
        // $_SESSION["error"] = '<script>console.log("'.$itemUpdateQuery.'")</script>';
        // $_SESSION["error"] = '<script>console.log("'.$itemDiscardQuery.'")</script>';
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
	    padding-top: 100px;
	    position: absolute-center;
}

/*styling for search button*/
.btn-primary {
  color: #fff;
  background-color: #00336f;
  border-color: #00336f;
}

.btn-primary:hover {
  color: #fff;
  background-color: #00336f;
  border-color: #fff;
}

.btn-primary:focus, .btn-primary.focus {
  box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.5);
}

.btn-primary.disabled, .btn-primary:disabled {
  background-color: #007bff;
  border-color: #007bff;
}

.btn-primary:active, .btn-primary.active,
.show > .btn-primary.dropdown-toggle {
  background-color: #0069d9;
  background-image: none;
  border-color: #0062cc;
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
      <h1 style="font-size: 75px" align="center">Move Item</h1>
                &nbsp;
  			<div class="jumbotron">
  				<?php
              if (isset($_GET["itemID"]) && $_GET["itemID"] !== "") {
                $updateItemQuery = "SELECT * FROM Inventory WHERE InventoryNum = '".$_GET['itemID']."'";
                $updateItemResult = $mysqli->query($updateItemQuery);
                if ($updateItemResult && $updateItemResult->num_rows > 0) {
                    $row = $updateItemResult->fetch_assoc();

                    echo "<form action='seniorProjectMoveItem.php?itemID=".$_GET['itemID']."' method='POST' required>";
                    echo "<div class='form-group'>";
                    echo "<label for='movingItem'>Item Selected to Move (Item Name, Current Location):</label>";
                    echo "<select id='movingItem' name ='movingItem' class='form-control'>";
                    
                    $seletedItemQuery = "Select * FROM Location";
                    $seletedItemResult = $mysqli->query($seletedItemQuery);
                    if ($seletedItemResult && $seletedItemResult->num_rows >= 1) {
                        while ($seletedItemRow = $seletedItemResult->fetch_assoc()) {
                            if ($seletedItemRow['LocationID'] == $row["LocationID"]) {
                                echo "<option selected='selected' value = ".$seletedItemRow['LocationID'].">".$row['Name'].", ".$seletedItemRow['LocationName']."</option>";
                            }
                        }
                    }
                    else {
                        echo "<h3>Error</h3>";
                    }
                    echo  "</select>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                    echo "<label for='newLocation'>Location to Move Product:</label>";
                    echo "<select id='newLocation' name ='newLocation' class='form-control'>";
                    
                    $newLocationQuery = "Select * FROM Location NATURAL JOIN Inventory";
                    $newLocationResult = $mysqli->query($newLocationQuery);
                    if ($newLocationResult && $newLocationResult->num_rows >= 1) {
                        while ($newLocationRow = $newLocationResult->fetch_assoc()) {
                            if ($newLocationRow['LocationID'] !== $row["LocationID"] && $newLocationRow['Name'] === $row['Name']) {
                                echo "<option selected='selected' value = ".$newLocationRow['LocationID'].">".$newLocationRow['LocationName']."</option>";
                            }
                            else {
                            	echo "<option value=''></option>";
                            }
                        }
                    }
                    else {
                        echo "<h3>Error</h3>";
                    }
                    echo  "</select>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                      echo "<label for='moveQuantity'>Quantity to Relocate (No greater than ".$row["Quantity"]."):</label>";
                      echo "<input type='number' class='form-control' name='moveQuantity' id='moveQuantity' placeholder='Quantity to Relocate' max='".$row['Quantity']."' min='1' required>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                      echo "<label for='moveDescription'>Description/Details (optional):</label>";
                      echo "<input type='text' class='form-control' name='moveDescription' id='moveDescription' placeholder='Description/Details'>";
                    echo "</div>";
                    echo "<div class='form-group'>";
                      echo "<button type='submit' name='Submit' class='btn btn-primary'>Move Product</button>";
                    echo "</div>"; 
                    echo "</form>"; 

                }
              }
          ?>

  			</div>
  		</div>
</body>    