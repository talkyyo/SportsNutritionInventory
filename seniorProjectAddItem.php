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

  //makes sure sesssion variable is set, if not, logs out
  verifyLogin();

	//if submit button is clicked
	if (isset($_POST["Submit"])) {

      $itemname = $_POST["Name"];
      $location = $_POST["LocationID"];
      $category = $_POST["CategoryID"];
      $quantity = $_POST["Quantity"];

      //checks if item/location combination already exists
			$itemCheck = "SELECT * FROM Inventory WHERE Name = '".$itemname."' AND LocationID = '".$location."'";
      $itemCheckResult = $mysqli->query($itemCheck);
			if(mysqli_num_rows($itemCheckResult) >= 1) {
				$_SESSION["error"] = "Item/Location combination already exists!";
				header("Location: seniorProjectLanding.php");
        exit;
			}
			else {
				//pass
			}

			//query to insert into inventory table
			$itemQuery = "INSERT INTO Inventory ";
			$itemQuery .= "(Name, LocationID, CategoryID, Quantity, LastQuantityUpdate, Username) ";
			$itemQuery .= "VALUES (";
			$itemQuery .= "'".$itemname."', ";
      $itemQuery .= "".$location.", ";
      $itemQuery .= "".$category.", ";
      $itemQuery .= "".$quantity.", ";
      $itemQuery .= "NOW(), ";
      $itemQuery .= "'".$_SESSION["Username"]."')";

      $itemResult = $mysqli->query($itemQuery);

			if ($itemResult) {
				$_SESSION["alert"] = $itemname." has been added to Inventory!";
				header("Location: seniorProjectLanding.php");
			}
			else {
        		$_SESSION["error"] = "Could not add item!";
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
	    padding-top: 100px;
	    position: absolute-center;
}

/*styling for submit button*/
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
      <h1 style="font-size: 75px" align="center">Add Item</h1>
                &nbsp;
  			<div class="jumbotron">
  				<form action="seniorProjectAddItem.php" method="POST">
  					<div class="form-group">
  					<label for="Name">Item Name:</label>
  					<input type="text" class="form-control" name="Name" id="Name" placeholder="Item Name" required>
  			</div>
        <div class="form-group">
            <label for="LocationID">Location:</label>
            <select id="LocationID" name = "LocationID" class = "form-control">
              <option required>Select Location</option>
              <?php
                $query = "SELECT * FROM Location";
                $result = $mysqli->query($query);
                if($result && $result->num_rows >= 1) {
                  while($row = $result->fetch_assoc()) {
                    echo "<option value = ".$row['LocationID'].">".$row['LocationName']."</option>";
                  }
                } else {
                  echo "<h3>Error</h3>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="CategoryID">Category:</label>
            <select id="CategoryID" name = "CategoryID" class = "form-control">
              <option required>Select Category</option>
              <?php
                $query = "SELECT * FROM Category";
                $result = $mysqli->query($query);
                if($result && $result->num_rows >= 1) {
                  while($row = $result->fetch_assoc()) {
                    echo "<option value = ".$row['CategoryID'].">".$row['CategoryName']."</option>";
                  }
                } else {
                  echo "<h3>Error</h3>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="Name">Quantity:</label>
            <input type="text" class="form-control" name="Quantity" id="Quantity" placeholder="Quantity" required>
        </div>
  				<div class="form-group">
						<button type="submit" name="Submit" class="btn btn-primary">Add Item</button>
					</div>
  				</form>
  			</div>
  		</div>
</body>    