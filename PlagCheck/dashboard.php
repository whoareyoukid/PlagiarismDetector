<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dashboard</title>
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<style>
		body {
		  margin: 0;
		  font-family: Arial, Helvetica, sans-serif;
		}

		.topnav {
		  overflow: hidden;
		  background-color: rgb(157, 3, 252);
		  //position: fixed;
		}

		.topnav a {
		  float: left;
		  color: #f2f2f2;
		  text-align: center;
		  padding: 14px 16px;
		  text-decoration: none;
		  font-size: 17px;
		}

		.topnav a:hover {
		  background-color: #ddd;
		  color: black;
		}

		.topnav a.active {
		  background-color: rgb(238, 235, 240);
		  color: white;
		}
		.container{
			overflow: hidden;
			background-color: rgb(157, 3, 252);
			position: fixed;
		  left: 0;
		  bottom: 0;
		  width: 100%;
		}    
		.area{
			border-style:ridge;
			font-size: large;
			//font-family: Trattatello, fantasy;
			color: rgb(26, 1, 31);
			text-align: center;
			height:400px;
			width: 25%;
			margin-left: 600px;
			margin-top: 100px;
		}    

		ul {
		  list-style-type: none;
		  margin: 0;
		  padding: 0;
		  width: 22%;
		  background-color: rgb(31, 7, 38);
		  color: white;
		  position: fixed;
		  height: 100%;
		  overflow: auto;
		  text-align: center;
		}

		li a {
		  display: block;
		  color: silver;
		  padding: 8px 16px;
		  text-decoration: none;
		}

		li a.active {
		  background-color: rgb(238, 235, 240);
		  color: white;
		}

		li a:hover:not(.active) {
		  background-color: #555;
		  color: white;
		}

			#dp{
				padding-top: 10px;
				border-radius: 50%;
			}
			.row {
		  display: flex;
		}

		/* Create five equal columns that sits next to each other */
		.column {
		  flex: 20%;
		  padding: 5px;
		}
		
		input{
			visibility: hidden;
		}
		figure{
			text-align: center;
		}
		/* CHECKED STYLES */
		[type=radio]:checked + figure {
		  outline: 2px solid purple;
		}
		a {
			text-decoration: none;
			color: black;
		}
		</style>
	</head>
	
    <body>
        <div class="topnav">
			<img src="images/logo2.jpg" style="float:right">
			<a href="index.php">Home</a>
			<a href="about.php">About</a>
			<a href="contact.php">Contact</a>
			<a class="active" href="dashboard.php">Dashboard</a>
			<a href="logout.php">Log-out</a>
		</div>

	<ul>
		<li><img id="dp" src="images/dp.jpg"></li>
	  <li><a  href="aboutme.php">About Me</a></li>
	  <li><a class="active" href="dashboard.php">Upload and Check</a></li>
	  <li><a href="myreports.php">My Reports</a></li>
	</ul>

	<div style="margin-left:25%;padding:1px 16px;height:1000px;">
	  <div class="row"><a href="help.php"><div class="col"><figure><img src="images/help.jpg"><figcaption>Help</figcaption></figure></a></div>
	  <div class="col"><a href="uploading.php"><figure><img src="images/up.png"><figcaption>Upload</figcaption></figure></a></div> 
	
	<form action="view.php" method="POST">
	  <div class="col"><button type=submit name='view' style="background: url(images/view.jpg) no-repeat; padding: .5em .5em; margin: 25px; height:70px; width: 55px; border:none">View</button></div></div>
	  <hr>
	  
	  <div class="row">
	  <?php
		$con = mysqli_connect("localhost", "root", "", "plagiarism")or die(mysqli_error($con));	
		session_start();
		$query="Select * from documents where userid=".$_SESSION['userid'];
		$result=mysqli_query($con, $query);

		$ct=1;
		
		while($row = mysqli_fetch_array($result)) {
			if ($ct%7==0 and $ct>0)
				echo '</div><div class="row">';
			else
				echo "<div class='col'>
				<label>
				  <input type='radio' name='filename' value=".$row['file_loc'].">
				  <figure><img src='images/file.jpg'><figcaption>".$row['filename']."</figcaption></figure>
				</label></div>";
			$ct++;
		}
	?>
	  </div>
	</form>
	</div>
	  
	
	<div class="container" >
        <center>
            <p style="color: silver"> NOPlagueiarism &copy; All Rights Reserved  |  Contact Us: admin@noplagueiarism.edu</p>	
        </center>
    </div>
    </body>
</html>