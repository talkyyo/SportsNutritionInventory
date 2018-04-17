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
    
  //create array to display Locations
  $locations = array();

  $locationQuery = "SELECT LocationName FROM Location";

  $locationResult = $mysqli->query($locationQuery);

  while(($row = mysqli_fetch_assoc($locationResult))) {
    $locations[] = $row['LocationName'];
  }

  //creates array to display Categories
  $categories = array();

  $categoryQuery = "SELECT CategoryName FROM Category";

  $categoryResult = $mysqli->query($categoryQuery);

  while(($row = mysqli_fetch_assoc($categoryResult))) {
    $categories[] = $row['CategoryName'];
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

  </style>

<body>


  <!-- Navbar -->
  <nav class="navbar navbar-inverse navbar-fixed-top" style="background-color: #00336f">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          </button>
          <a class="navbar-brand" href="seniorProjectLanding.php"><i class="glyphicon glyphicon-home" style="color: white"></i></a>

          <a class="navbar-brand" href="#menu-toggle"><i class="glyphicon glyphicon-menu-hamburger" id="menu-toggle" style="color: white"></i></a>
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

    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
          <ul class="sidebar-nav" id="sidebar">
          	<li class="sub-sidebar-brand"><a href="seniorProjectLanding.php">&middot;&nbsp;&nbsp;Inventory<i
                class="fa fa-caret-down" aria-hidden="true"></i></a>
            <li class="sub-sidebar-brand"><a href="seniorProjectLanding.php">&middot;&nbsp;&nbsp;Discarded Inventory<i
                class="fa fa-caret-down" aria-hidden="true"></i></a>
            <li class="sub-sidebar-brand"><a href="#/Category">&middot;&nbsp;&nbsp;Item<i
                class="fa fa-caret-down" aria-hidden="true"></i></a>
              <ul class="sub-menu">
                  <li class="sub-sidebar-brand"><a href="seniorProjectAddItem.php">&nbsp;&nbsp;&middot;&nbsp;&nbsp;<i>Add Item</i><span class="sub_icon fa fa-hdd-o"></span></a></li>
              </ul>
            </li>
            <li class="sub-sidebar-brand"><a href="#/Location">&middot;&nbsp;&nbsp;Location<i
                class="fa fa-caret-down" aria-hidden="true"></i></a>
              <ul class="sub-menu">
                  <script>
                  //loops for printing all locations in database in sidebar
                  var locationList = <?php echo json_encode($locations); ?>;

                  var html = '';
                  for (var i = 0; i < locationList.length; i++) {
                    html += "<li class='sub-sidebar-brand'><a href='" + locationList[i] + "'>&nbsp;&nbsp;&middot;&nbsp;&nbsp;" + locationList[i] + "<span class='sub_icon fa fa-hdd-o'></span></a></li>"
                  }
                  document.write(html);
                  </script>
                  <li class="sub-sidebar-brand"><a href="seniorProjectAddLocation.php">&nbsp;&nbsp;&middot;&nbsp;&nbsp;<i>Add Location</i><span class="sub_icon fa fa-hdd-o"></span></a></li>               
              </ul>
            </li>
            <li class="sub-sidebar-brand"><a href="#/Category">&middot;&nbsp;&nbsp;Category<i
                class="fa fa-caret-down" aria-hidden="true"></i></a>
              <ul class="sub-menu">
                  <script>
                  //loops for printing all locations in database in sidebar
                  var categoryList = <?php echo json_encode($categories); ?>;

                  var html = '';
                  for (var i = 0; i < categoryList.length; i++) {
                    html += "<li class='sub-sidebar-brand'><a href='" + categoryList[i] + "'>&nbsp;&nbsp;&middot;&nbsp;&nbsp;" + categoryList[i] + "<span class='sub_icon fa fa-hdd-o'></span></a></li>"
                  }
                  document.write(html);
                  </script>   
                  <li class="sub-sidebar-brand"><a href="seniorProjectAddCategory.php">&nbsp;&nbsp;&middot;&nbsp;&nbsp;<i>Add Category</i><span class="sub_icon fa fa-hdd-o"></span></a></li>
              </ul>
            </li>
          </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <h1 style="font-size: 75px" align="center">Inventory</h1>
                &nbsp;
                <div id="custom-search-input" align="center">
                            <div class="input-group" style="width: 80%">
                                <input type="text" class="search-query form-control" placeholder="Search" />
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <span class=" glyphicon glyphicon-search"></span>
                                    </button>
                                </span>
                            </div>
                </div>
                &nbsp;
                <h4 align="center">Sort by:</h4>

                <div class="row" align="center">
                    <div class="form-group" style="width: 50%" align="center">
                      <select id="sortDropdown" name ="sortDropdown" class ="form-control">
                          <option value = "Name" selected="selected">Item Name</option>;
                          <option value = "LocationID">Location</option>;
                          <option value = "CategoryID">Category</option>;
                          <option value = "Quantity">Quantity</option>;
                          <option value = "LastQuantityUpdate">Most Recently Updated</option>;
                      </select>
                    </div>
                </div>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <div class="container-fluid">
                  <div class="jumbotron">
                    <table class="table table-bordered">
                      <thead>
                        <th style="text-decoration: underline"><center>Item Name</center></th>
                        <th style="text-decoration: underline"><center>Location</center></th>
                        <th style="text-decoration: underline"><center>Category</center></th>
                        <th style="text-decoration: underline"><center>Quantity</center></th>
                        <th style="text-decoration: underline"><center>Last Update</center></th>
                        <th style="text-decoration: underline"><center>Last Updated By</center></th>
                        <th style="text-decoration: underline"><center>Description</center></th>
                        <th style="text-decoration: underline"><center>Options</center></th>
                      </thead>
                      <tbody>
                        <tr>
                          <?php
                              //query to show all items in inventory
                              $inventoryQuery = "SELECT * ";
                              $inventoryQuery .= "FROM Inventory NATURAL JOIN User NATURAL JOIN Location NATURAL JOIN Category";

                              $inventoryResult = $mysqli->query($inventoryQuery);

                              if($inventoryResult && $inventoryResult->num_rows >= 1) {
                                  while($row = $inventoryResult->fetch_assoc()) {
                                    echo "<tr>";
                                        echo "<th><center>".$row['Name']."</center></th>";
                                        echo "<th><center>".$row['LocationName']."</center></th>";
                                        echo "<th><center>".$row['CategoryName']."</center></th>";
                                        echo "<th><center>".$row['Quantity']."</center></th>";
                                        echo "<th><center>".$row['LastQuantityUpdate']."</center></th>";
                                        echo "<th><center>".$row['FirstName'].' '.$row['LastName']."</center></center></th>";
                                        echo "<th>".$row['DescriptionInventory']."</center></th>";
                                        echo "<td><center><div class='dropdown'>";
                                          echo "<button class='btn btn-danger dropdown-toggle' type='button' data-toggle='dropdown'>Select Option <span class ='caret'></span></button>";
                                          echo "<ul class='dropdown-menu'>";
                                            echo "<li><a href='seniorProjectEditUpdateItem.php?itemID=".$row['InventoryNum']."'>Update Item</a></li>";
                                            echo "<li><a href='seniorProjectEditUpdateItem.php?itemID=".$row['InventoryNum']."'>Move Item</a></li>";
                                            echo "<li><a href='seniorProjectEditUpdateItem.php?itemID=".$row['InventoryNum']."'>Discard Item</a></li>";
                                            echo "<li><a href='seniorProjectDeleteItem.php?itemID=".$row['InventoryNum']."'>Delete Item</a></li>";
                                          echo "</ul>";
                                        echo "</div></center></td>";
                                    echo "</tr>";



                                  }
                              }
                              else {

                                  echo "<th> </th>";
                                  echo "<th align='center'>No items found!</th>";
                              }
                          ?>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    $('.sidebar-nav li a').click(function(){
  $(this).parent().toggleClass('active')
});

    </script>


</body>