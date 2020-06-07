<?php

session_start();
$database_name=" hotel_details";
$con= mysqli_connect("localhost", "root", "","hotel_details");

if (isset($_POST["add"])) {
	# code...
	if (isset($_SESSION["cart"])) {
		# code...
		$hotel_array_id= array_column($_SESSION["cart"],  "Hotel_id");
		if (!in_array($_GET["id"], $hotel_array_id)) {
			$count = count($_SESSION["cart"]);
			$hotel_array = array(
				'Hotel_id'=> $_GET["id"],
				'hotel_name'=> $_POST["hidden_name"],
				'price'=> $_POST["hidden_price"],
				'number_of_rooms'=> $_POST["quantity"],		


			);
			$_SESSION["cart"][$count] = $hotel_array;
			echo "<script> window.location = 'home.php' </script>";
			# code...
		}else{
			echo "<script>alert (Room is Already Booked)</script>";
			echo '<script> window.location =" home.php"</script>';
			
		}
	}
	else{
		$hotel_array= array(
			'Hotel_id'=> $_GET["id"],
				'hotel_name'=> $_POST["hidden_name"],
				'price'=> $_POST["hidden_price"],
				'number_of_rooms'=> $_POST["quantity"],		

		);
		$_SESSION["cart"][0]= $hotel_array;
	}
}
if (isset($_GET["action"])) {
	# code...
	if ($_GET ["action"] =='delete' ) {
		foreach ($_SESSION["cart"] as $keys => $value) {
			# code...
			if ($value["id"] == $_GET["id"]) {
				# code...
				unset($_SESSION["cart"][$keys]);
				echo "<script> alert(Room Removed)</script>";
				echo "<script> window.location= home.php </script>";
			}
		}
		# code...
	}
}

?>


<!DOCTYPE html>
<html>
<head>
	<title> Hotel Booking System</title>

	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

	<style type="text/css">
		body{
			background-color: coral;
			color: black;
		}
		.hotel{
			border: 1px  #eaeaec;
			margin: -1px 19px 3px -1px;
			padding: 20px;
			text-align: center;
			background-color: coral;


		}
		table, th, tr{
			text-align: center;
		}
		.title2{
			text-align: center;
			color: #66afe9;
			background-color: #efefef;
			padding: 2%;			
		}
		h1{
			text-align: center;
			color: black;
			padding: none;
			font-variant: small-caps;
			font-size: 250%;
		}
		table th{
			background-color: #efefef;
		}
		.cont{
			width: 80%;
			margin: auto;
			overflow: hidden;
		}
		#nav-bar{
			background-color: #333;
			color: #fff;
		}
		#nav-bar ul{
			padding: 0;
			list-style: none;
		}
		#nav-bar li{
			display: inline;
		}
		#nav-bar a{
			color: #fff;
			text-decoration: none;
			font-size: 18px;
			padding-right: 30px;
		}
		#el{
			font-family: Lucida Console;
			text-align: center;
		}
		#main-footer{
			background-color: black;
			color: #fff;
			text-align: center;
			padding: 2px;
			margin-top: 40px; 
		}
		.text-info{
			color: black;
		}


	</style>
</head>
<body>
	 <div class="container" >
	 	<header id="main-header">
	 		<div class ="cont">
	 			<h1>Hotel Booking System</h1>	 			
	 		</div>
	 	</header>
	 		 		 			<p id="el">Book a Hotel in Nairobi City at the comfort of your home</p> 			

	 	<nav id="nav-bar">
	 		<div class="cont">
	 			<ul>
	 				<li> <a href="home.php">Home</a></li>
	 				<li> <a href="index.html">About</a></li>
	 				<li> <a href="#">Contact</a></li>
	 			</ul>
	 		</div>
	 	</nav>
	 	
	 	<aside id="sidebar">

	 		
	 	</aside>


	 	
	 	<?php
	 	 	$query= "SELECT * FROM hotel ORDER BY id ASC";	
	 	 	$result= mysqli_query($con, $query);
	 	 	if (mysqli_num_rows($result)>0 ) {

	 	 		while ($row= mysqli_fetch_array($result)) {
	 	 			# code...

	 	?>
	 	<div class = "col-md-3">
	 		<form method="post" action="home.php?action=add&id= <?php echo $row["id"];?>">
	 			<div class="hotel">
	 				<img src="<?php echo $row["image"]?>" class= "img-responsive " width= '530' height= " 250">
	 				<h5 class="text-info" > <?php echo $row["pname"]; ?></h5> 
	 				<h5 class="text-danger"> <?php echo $row["price"]; ?></h5> 
	 				<input type="text" name="quantity" class="form-control" value="1">
	 				<input type="hidden" name="hidden_name" value="<?php echo $row["pname"]; ?>">
	 				<input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>">
	 				<input type="submit" name="add" style="margin-top: 5px;" class="btn btn-success" value="Book Rooms">
				</div>
	 		</form>
	 	</div>

	 	<?php
	 }

}

	 	?>

	 	<div style="clear: both"></div>
	 	<h3 class="title2"> Hotel Details</h3>
	 	<div class=" table-responsive">
	 		<table class="table table-bordered">	 		
	 		<tr>
	 			<th width="30%"> Hotel Name</th>
	 			<th width="10%">Number of Rooms</th>
	 			<th width="13%">Price details</th>
	 			<th width="10%">Total Price</th>
	 			<th width="17%">Remove Room</th>
	 		</tr>

	 		<?php
	 		if (!empty($_SESSION["cart"])) {
	 			# code...
	 			$total= 0;
	 			foreach ($_SESSION["cart"] as $key => $value) {
	 				# code...
	 				?>

	 			<tr>
	 				<td><?php echo $value["hotel_name"]; ?></td>
	 				<td><?php echo $value["number_of_rooms"]; ?></td>
	 				<td> $ <?php echo $value["price"]; ?></td>
	 				<td> $ <?php echo number_format($value ["number_of_rooms"] * $value["price"],  2); ?></td >
	 				<td> <a href="home.php?action= delete&id=<?php echo $value["id"]; ?>"><span class="text_danger">Remove Booked Room</span></a></td>				

	 			</tr>
	 			<?php
	 			$total= $total + ($value ["number_of_rooms"] * $value["price"]);
	 		}
	 			?>

	 			<tr>
	 				<td colspan="3" align="right">Total</td>
	 				<th align="right"> $<?php echo number_format($total, 2); ?></th>
	 				<td></td>
	 			</tr>
	 			<?php
	 		}
	 		?>
	 		</table>
	 		
	 	</div>

	 </div>
	 <footer id="main-footer">
	 	<p>Copyright &copy; 2020</p>
	 </footer>

</body>
</html>